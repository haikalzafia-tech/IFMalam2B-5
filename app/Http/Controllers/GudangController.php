<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{

    public function index(Request $request)
    {
        $gudangs = Gudang::withCount(['zonas', 'transaksis'])
            ->when($request->search, fn($q) => $q->where('nama_gudang', 'like', '%' . $request->search . '%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();

        return view('gudang.index', compact('gudangs'));
    }

    public function create()
    {
        return view('gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang'  => 'required|string|max:255',
            'alamat'       => 'required|string',
            'kota'         => 'required|string|max:100',
            'provinsi'     => 'required|string|max:100',
            'pic_nama'     => 'required|string|max:255',
            'pic_telepon'  => 'nullable|string|max:20',
            'keterangan'   => 'nullable|string',
        ]);

        $data = $request->all();
        $data['kode_gudang'] = $this->generateKode();

        Gudang::create($data);

        return redirect()->route('master-data.gudang.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function show(Gudang $gudang)
    {
        $gudang->load('zonas.raks');
        $totalKapasitas = $gudang->raks()->sum('kapasitas_total');
        $totalTerpakai  = $gudang->raks()->sum('kapasitas_terpakai');
        $persentase     = $totalKapasitas > 0 ? round(($totalTerpakai / $totalKapasitas) * 100, 1) : 0;

        return view('gudang.show', compact('gudang', 'totalKapasitas', 'totalTerpakai', 'persentase'));
    }

    public function edit(Gudang $gudang)
    {
        return view('gudang.edit', compact('gudang'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $request->validate([
            'nama_gudang'  => 'required|string|max:255',
            'alamat'       => 'required|string',
            'kota'         => 'required|string|max:100',
            'provinsi'     => 'required|string|max:100',
            'pic_nama'     => 'required|string|max:255',
            'pic_telepon'  => 'nullable|string|max:20',
            'status'       => 'required|in:aktif,nonaktif',
            'keterangan'   => 'nullable|string',
        ]);

        $gudang->update($request->all());

            return redirect()->route('master-data.gudang.index')->with('success', 'Gudang berhasil diperbarui.');
        }

        public function destroy(Gudang $gudang)
        {
        if ($gudang->zonas()->exists()) {
            return back()->with('error', 'Gudang tidak bisa dihapus karena masih memiliki zona.');
        }

        $gudang->delete();
        return redirect()->route('master-data.gudang.index')->with('success', 'Gudang berhasil dihapus.');
    }

    private function generateKode(): string
    {
        $last = Gudang::latest()->first();
        $num = $last ? (int) substr($last->kode_gudang, 4) + 1 : 1;
        return 'GDG-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
