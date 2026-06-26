<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Rak;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VarianProdukController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produk_id'    => 'required|exists:produks,id',
            'nama_varian'  => 'required|string|max:255',
            'rak_id'       => 'nullable|exists:raks,id',
            'stok_varian'  => 'required|integer|min:0',
            'berat'        => 'nullable|string|max:50',
            'dimensi'      => 'nullable|string|max:100',
            'gambar_varian' => 'nullable|image|max:2048',
        ]);

        $varian = DB::transaction(function () use ($request) {
            $data = $request->only(['produk_id', 'nama_varian', 'rak_id', 'stok_varian', 'berat', 'dimensi']);
            $data['nomor_sku'] = $this->generateSku($request->produk_id);

            if ($request->hasFile('gambar_varian')) {
                $path = $request->file('gambar_varian')->store('varian-produk', 'public');
                $data['gambar_varian'] = basename($path);
            }

            $varian = VarianProduk::create($data);

            // Sinkronkan kapasitas rak dengan stok awal
            if ($request->rak_id && $request->stok_varian > 0) {
                Rak::find($request->rak_id)->increment('kapasitas_terpakai', $request->stok_varian);
            }

            return $varian;
        });

        return response()->json(['message' => 'Varian berhasil ditambahkan.', 'data' => $varian]);
    }

    public function update(Request $request, VarianProduk $varianProduk)
    {
        $request->validate([
            'nama_varian'  => 'required|string|max:255',
            'rak_id'       => 'nullable|exists:raks,id',
            'stok_varian'  => 'required|integer|min:0',
            'berat'        => 'nullable|string|max:50',
            'dimensi'      => 'nullable|string|max:100',
            'gambar_varian' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $varianProduk) {
            // Simpan nilai lama sebelum diubah, untuk sinkronisasi kapasitas rak
            $rakLamaId   = $varianProduk->rak_id;
            $stokLama    = $varianProduk->stok_varian;

            $rakBaruId = $request->rak_id;
            $stokBaru  = (int) $request->stok_varian;

            $data = $request->only(['nama_varian', 'rak_id', 'stok_varian', 'berat', 'dimensi']);

            if ($request->hasFile('gambar_varian')) {
                $path = $request->file('gambar_varian')->store('varian-produk', 'public');
                $data['gambar_varian'] = basename($path);
            }

            $varianProduk->update($data);

            // --- Sinkronisasi kapasitas rak ---
            if ($rakLamaId == $rakBaruId) {
                // Rak sama, hanya selisih stok yang disesuaikan
                $selisih = $stokBaru - $stokLama;
                if ($rakBaruId && $selisih != 0) {
                    Rak::find($rakBaruId)->increment('kapasitas_terpakai', $selisih);
                }
            } else {
                // Rak berubah: kurangi rak lama, tambah rak baru
                if ($rakLamaId) {
                    Rak::find($rakLamaId)?->decrement('kapasitas_terpakai', $stokLama);
                }
                if ($rakBaruId) {
                    Rak::find($rakBaruId)?->increment('kapasitas_terpakai', $stokBaru);
                }
            }
        });

        return response()->json(['message' => 'Varian berhasil diperbarui.', 'data' => $varianProduk->fresh()]);
    }

    public function destroy(VarianProduk $varianProduk)
    {
        if ($varianProduk->transaksiItems()->exists()) {
            return back()->with('error', 'Varian tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        DB::transaction(function () use ($varianProduk) {
            // Lepaskan kapasitas rak sebelum menghapus
            if ($varianProduk->rak_id && $varianProduk->stok_varian > 0) {
                Rak::find($varianProduk->rak_id)?->decrement('kapasitas_terpakai', $varianProduk->stok_varian);
            }
            $varianProduk->delete();
        });

        return redirect()->back()->with('success', 'Varian berhasil dihapus.');
    }

    // API untuk dropdown di form transaksi
    public function getAllVarianJson(Request $request)
    {
        $varianProduks = VarianProduk::with('produk', 'rak.zona.gudang')
            ->when($request->search, fn($q) => $q->where('nomor_sku', 'like', '%' . $request->search . '%')
                ->orWhereHas('produk', fn($q2) => $q2->where('nama_produk', 'like', '%' . $request->search . '%')))
            ->get();

        return response()->json($varianProduks);
    }

    private function generateSku(int $produkId): string
    {
        $produk = Produk::find($produkId);
        $prefix = Str::upper(Str::substr(Str::slug($produk->nama_produk), 0, 3));
        $count = VarianProduk::where('produk_id', $produkId)->count() + 1;
        return $prefix . '-' . $produk->id . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
