<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{

    public function index(Request $request)
    {
        $zonas = Zona::with('gudang')
            ->withCount('raks')
            ->when($request->gudang_id, fn($q) => $q->where('gudang_id', $request->gudang_id))
            ->when($request->search, fn($q) => $q->where('nama_zona', 'like', '%' . $request->search . '%'))
            ->latest()->paginate(10)->withQueryString();

        $gudangs = Gudang::where('status', 'aktif')->get();

        return view('zona.index', compact('zonas', 'gudangs'));
    }

    public function create()
    {
        $gudangs = Gudang::where('status', 'aktif')->get();
        return view('zona.create', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gudang_id'   => 'required|exists:gudangs,id',
            'nama_zona'   => 'required|string|max:255',
            'jenis_zona'  => 'required|in:reguler,dingin,berbahaya,karantina,ekspedisi',
            'keterangan'  => 'nullable|string',
        ]);

        $kode = $this->generateKode($request->gudang_id);

        Zona::create([...$request->all(), 'kode_zona' => $kode]);

        return redirect()->route('master-data.zona.index')->with('success', 'Zona berhasil ditambahkan.');
    }

    public function edit(Zona $zona)
    {
        $gudangs = Gudang::where('status', 'aktif')->get();
        return view('zona.edit', compact('zona', 'gudangs'));
    }

    public function update(Request $request, Zona $zona)
    {
        $request->validate([
            'nama_zona'   => 'required|string|max:255',
            'jenis_zona'  => 'required|in:reguler,dingin,berbahaya,karantina,ekspedisi',
            'status'      => 'required|in:aktif,nonaktif',
            'keterangan'  => 'nullable|string',
        ]);

        $zona->update($request->all());

        return redirect()->route('master-data.zona.index')->with('success', 'Zona berhasil diperbarui.');
    }

    public function destroy(Zona $zona)
    {
        if ($zona->raks()->exists()) {
            return back()->with('error', 'Zona tidak bisa dihapus karena masih memiliki rak.');
        }

        $zona->delete();
        return redirect()->route('master-data.zona.index')->with('success', 'Zona berhasil dihapus.');
    }

    private function generateKode(int $gudangId): string
    {
        $count = Zona::where('gudang_id', $gudangId)->count() + 1;
        return 'Z' . str_pad($count, 2, '0', STR_PAD_LEFT);
    }
}
