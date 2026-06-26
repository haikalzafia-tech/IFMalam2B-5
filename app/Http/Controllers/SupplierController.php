<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->search) {
            $query->where('nama_supplier', 'like', '%' . $request->search . '%')
                ->orWhere('kode_supplier', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->jenis) {
            $query->where('jenis_supplier', $request->jenis);
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier'   => 'required|string|max:255',
            'jenis_supplier'  => 'required|in:produsen,distributor,agen,retailer',
            'pic_nama'        => 'required|string|max:255',
            'pic_jabatan'     => 'nullable|string|max:255',
            'telepon'         => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'alamat'          => 'required|string',
            'kota'            => 'required|string|max:100',
            'provinsi'        => 'required|string|max:100',
            'kode_pos'        => 'nullable|string|max:10',
            'npwp'            => 'nullable|string|max:30',
            'keterangan'      => 'nullable|string',
        ]);

        $data = $request->all();
        $data['kode_supplier'] = $this->generateKode();

        Supplier::create($data);

        return redirect()->route('master-data.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['transaksis' => fn($q) => $q->latest()->limit(10), 'transaksiReturs' => fn($q) => $q->latest()->limit(5)]);
        return view('supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier'   => 'required|string|max:255',
            'jenis_supplier'  => 'required|in:produsen,distributor,agen,retailer',
            'pic_nama'        => 'required|string|max:255',
            'pic_jabatan'     => 'nullable|string|max:255',
            'telepon'         => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'alamat'          => 'required|string',
            'kota'            => 'required|string|max:100',
            'provinsi'        => 'required|string|max:100',
            'kode_pos'        => 'nullable|string|max:10',
            'npwp'            => 'nullable|string|max:30',
            'status'          => 'required|in:aktif,nonaktif',
            'keterangan'      => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('master-data.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->transaksis()->exists()) {
            return back()->with('error', 'Supplier tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        $supplier->delete();
        return redirect()->route('master-data.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

    private function generateKode(): string
    {
        $last = Supplier::latest()->first();
        $num = $last ? (int) substr($last->kode_supplier, 4) + 1 : 1;
        return 'SUP-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    // API untuk dropdown
    public function getSupplierJson(Request $request)
    {
        $suppliers = Supplier::where('status', 'aktif')
            ->when($request->search, fn($q) => $q->where('nama_supplier', 'like', '%' . $request->search . '%'))
            ->select('id', 'kode_supplier', 'nama_supplier', 'telepon', 'pic_nama')
            ->get();

        return response()->json($suppliers);
    }
}
