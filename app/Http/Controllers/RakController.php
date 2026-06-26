<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Rak;
use App\Models\Zona;
use Illuminate\Http\Request;

class RakController extends Controller
{

    public function index(Request $request)
    {
        $raks = Rak::with('zona.gudang')
            ->when($request->zona_id, fn($q) => $q->where('zona_id', $request->zona_id))
            ->when($request->gudang_id, fn($q) => $q->whereHas('zona', fn($q2) => $q2->where('gudang_id', $request->gudang_id)))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();

        $gudangs = Gudang::where('status', 'aktif')->get();
        $zonas   = Zona::where('status', 'aktif')->with('gudang')->get();

        return view('rak.index', compact('raks', 'gudangs', 'zonas'));
    }

    public function create()
    {
        $zonas = Zona::where('status', 'aktif')->with('gudang')->get();
        return view('rak.create', compact('zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zona_id'          => 'required|exists:zonas,id',
            'nama_rak'         => 'required|string|max:255',
            'jumlah_baris'     => 'required|integer|min:1',
            'jumlah_kolom'     => 'required|integer|min:1',
            'kapasitas_total'  => 'required|integer|min:1',
            'keterangan'       => 'nullable|string',
        ]);

        $kode = $this->generateKode($request->zona_id);

        Rak::create([...$request->all(), 'kode_rak' => $kode]);

        return redirect()->route('master-data.rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function show(Rak $rak)
    {
        $rak->load('zona.gudang', 'varianProduks.produk');
        return view('rak.show', compact('rak'));
    }

    public function edit(Rak $rak)
    {
        $zonas = Zona::where('status', 'aktif')->with('gudang')->get();
        return view('rak.edit', compact('rak', 'zonas'));
    }

    public function update(Request $request, Rak $rak)
    {
        $request->validate([
            'nama_rak'         => 'required|string|max:255',
            'jumlah_baris'     => 'required|integer|min:1',
            'jumlah_kolom'     => 'required|integer|min:1',
            'kapasitas_total'  => 'required|integer|min:1',
            'status'           => 'required|in:aktif,penuh,nonaktif',
            'keterangan'       => 'nullable|string',
        ]);

        $rak->update($request->all());

        return redirect()->route('master-data.rak.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        if ($rak->varianProduks()->exists()) {
            return back()->with('error', 'Rak tidak bisa dihapus karena masih ada barang di dalamnya.');
        }

        $rak->delete();
        return redirect()->route('master-data.rak.index')->with('success', 'Rak berhasil dihapus.');
    }

    private function generateKode(int $zonaId): string
    {
        $count = Rak::where('zona_id', $zonaId)->count() + 1;
        return 'R' . str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    // API untuk dropdown dinamis
    public function getRakByZona(Request $request)
    {
        $raks = Rak::where('zona_id', $request->zona_id)
            ->where('status', '!=', 'nonaktif')
            ->select('id', 'kode_rak', 'nama_rak', 'kapasitas_total', 'kapasitas_terpakai')
            ->get()
            ->map(fn($r) => [...$r->toArray(), 'sisa_kapasitas' => $r->sisa_kapasitas]);

        return response()->json($raks);
    }

    // API: ambil semua rak aktif dalam satu gudang (lintas zona), untuk form transaksi
    public function getRakByGudang(Request $request)
    {
        $raks = Rak::whereHas('zona', fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->where('status', '!=', 'nonaktif')
            ->with('zona')
            ->select('id', 'zona_id', 'kode_rak', 'nama_rak', 'kapasitas_total', 'kapasitas_terpakai')
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'kode_rak' => $r->kode_rak,
                'nama_rak' => $r->nama_rak . ' (' . $r->zona->nama_zona . ')',
                'sisa_kapasitas' => $r->sisa_kapasitas,
            ]);

        return response()->json($raks);
    }
}
