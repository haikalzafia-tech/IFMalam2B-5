<?php

namespace App\Http\Controllers;

use App\Models\LokasiStok;
use App\Models\Rak;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiStokController extends Controller
{

    // Daftar semua lokasi stok, dikelompokkan per varian
    public function index(Request $request)
    {
        $varianProduks = VarianProduk::with('produk', 'lokasiStoks.rak.zona.gudang')
            ->when($request->search, fn($q) => $q->where('nomor_sku', 'like', '%' . $request->search . '%')
                ->orWhereHas('produk', fn($q2) => $q2->where('nama_produk', 'like', '%' . $request->search . '%')))
            ->paginate(10)
            ->withQueryString();

        return view('lokasi-stok.index', compact('varianProduks'));
    }

    // Tampilkan form untuk kelola lokasi satu varian tertentu
    public function edit(VarianProduk $varianProduk)
    {
        $varianProduk->load('produk', 'lokasiStoks.rak.zona.gudang');
        $raks = Rak::with('zona.gudang')->where('status', '!=', 'nonaktif')->get();

        $totalDiLokasi = $varianProduk->lokasiStoks->sum('qty');

        return view('lokasi-stok.edit', compact('varianProduk', 'raks', 'totalDiLokasi'));
    }

    // Simpan/update distribusi lokasi untuk satu varian (replace semua baris sekaligus)
    public function update(Request $request, VarianProduk $varianProduk)
    {
        $request->validate([
            'lokasi'             => 'required|array|min:1',
            'lokasi.*.rak_id'    => 'required|exists:raks,id',
            'lokasi.*.qty'       => 'required|integer|min:0',
        ]);

        // Pastikan tidak ada rak yang dipilih dobel
        $rakIds = collect($request->lokasi)->pluck('rak_id');
        if ($rakIds->count() !== $rakIds->unique()->count()) {
            return back()->with('error', 'Tidak boleh memilih rak yang sama lebih dari sekali. Gabungkan qty-nya pada satu baris.');
        }

        DB::transaction(function () use ($request, $varianProduk) {
            $lokasiLama = $varianProduk->lokasiStoks()->get()->keyBy('rak_id');
            $rakIdBaru = collect($request->lokasi)->pluck('rak_id')->map(fn($id) => (int) $id);

            // Kembalikan kapasitas_terpakai rak lama yang tidak lagi dipakai / berubah
            foreach ($lokasiLama as $rakId => $lokasi) {
                if (!$rakIdBaru->contains($rakId)) {
                    Rak::find($rakId)?->decrement('kapasitas_terpakai', $lokasi->qty);
                }
            }

            $totalBaru = 0;

            foreach ($request->lokasi as $item) {
                if ($item['qty'] <= 0) continue;

                $rakId = (int) $item['rak_id'];
                $qtyBaru = (int) $item['qty'];
                $totalBaru += $qtyBaru;

                $lokasiSebelumnya = $lokasiLama->get($rakId);
                $qtyLama = $lokasiSebelumnya->qty ?? 0;
                $selisih = $qtyBaru - $qtyLama;

                LokasiStok::updateOrCreate(
                    ['varian_produk_id' => $varianProduk->id, 'rak_id' => $rakId],
                    ['qty' => $qtyBaru]
                );

                // Sesuaikan kapasitas_terpakai rak sesuai selisih
                if ($selisih != 0) {
                    Rak::find($rakId)?->increment('kapasitas_terpakai', $selisih);
                }
            }

            // Hapus baris lokasi yang qty-nya dikosongkan/dihapus dari form
            $varianProduk->lokasiStoks()->whereNotIn('rak_id', $rakIdBaru)->delete();

            // Update total stok varian agar selalu sinkron dengan jumlah semua lokasi
            $varianProduk->update([
                'stok_varian' => $totalBaru,
                'rak_id' => $request->lokasi[0]['rak_id'] ?? $varianProduk->rak_id, // rak utama = lokasi pertama
            ]);
        });

        return redirect()->route('lokasi-stok.index')->with('success', 'Distribusi lokasi stok berhasil diperbarui.');
    }
}
