<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTransaksiKeluarRequest;
use App\Models\KartuStok;
use App\Models\Transaksi;
use App\Models\VarianProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiKeluarController extends Controller
{
     public $pageTitle = 'Transaksi keluar';
    public $jenisTransaksi = 'pengeluaran';


    public function index()
    {


        $penerima = request()->query('penerima');
        $tanggalAwal = request()->query('tanggal_awal');
        $tanggalAkhir = request()->query('tanggal_akhir');
        $perPage = request()->query('perPage',10);

        $query = Transaksi::query();
        $query->orderBy('created_at','DESC');
        $query->where('jenis_transaksi',$this->jenisTransaksi);

        if($penerima){
            $query->where('penerima','like','%'.$penerima.'%');
        }

        if($tanggalAwal && $tanggalAkhir){
        $tanggalAwal = Carbon::parse($tanggalAwal)->startOfDay();
        $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
        $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        $transaksi = $query->paginate($perPage)->appends(request()->query());


        $pageTitle = $this->pageTitle;
        // // Opsional: Ambil data untuk ditampilkan di halaman index
        // $transaksi = Transaksi::where('jenis_transaksi', $this->jenisTransaksi)->latest()->get();
        return view('transaksi-keluar.index', compact('pageTitle', 'transaksi'));
    }

    public function create()
    {
        $pageTitle = $this->pageTitle;
        return view('transaksi-keluar.create', compact('pageTitle'));
    }

    public function show($nomor_transaksi)
    {
        $pageTitle = "Detail " . $this->pageTitle;
        $transaksi = Transaksi::with('items')->where('nomor_transaksi', $nomor_transaksi)->first();
        $transaksi->formated_date = Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('l, d F Y ');
        return view('transaksi-keluar.show', compact('transaksi', 'pageTitle'));
    }

    public function store(storeTransaksiKeluarRequest $request)
    {
        // Validasi manual jika FormRequest tidak otomatis menghandle AJAX
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if($validator->fails()){
            return response()->json([
                'success'  => false,
                'errors'   => $validator->errors()
            ], 422);
        }

        $nomorTransaksi = Transaksi::generateNomorTransaksi($this->jenisTransaksi);
        $items = $request->items;

        // Gunakan Transaction agar jika satu item gagal, semua dibatalkan (keamanan data)
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'nomor_transaksi'  => $nomorTransaksi,
                'jenis_transaksi'  => $this->jenisTransaksi,
                'jumlah_barang'    => count($items),
                'total_harga'      => 0,
                'keterangan'       => $request->keterangan,
                'petugas'          => Auth::user()->name,
                'penerima'         => $request->penerima,
                'kontak'           => $request->kontak
            ]);

            foreach ($items as $item) {
                $query = explode('-', $item['text']);
                // Cek apakah produk & varian ada di string (mencegah error index 1)
                $namaProduk = trim($query[0]);
                $namaVarian = isset($query[1]) ? trim($query[1]) : '-';

                $varian = VarianProduk::where('nomor_sku', $item['nomor_sku'])->first();

                if (!$varian) {
                    throw new \Exception("Produk dengan SKU " . $item['nomor_sku'] . " tidak ditemukan.");
                }

                $transaksi->items()->create([
                    'produk'      => $namaProduk,
                    'varian'      => $namaVarian,
                    'qty'         => $item['qty'],
                    'harga'       => $varian->harga_varian, // Ambil harga dari varian untuk memastikan konsistensi
                    'sub_total'    => $varian->harga_varian * $item['qty'], // Hitung subTotal berdasarkan harga varian
                    'nomor_sku'   => $item['nomor_sku']
                ]);

                // Update Stok
                $varian->decrement('stok_varian', $item['qty']);

                // Catat di Kartu Stok
                KartuStok::create([
                    'nomor_transaksi' => $transaksi->nomor_transaksi,
                    'jenis_transaksi' => 'out',
                    'nomor_sku'       => $item['nomor_sku'],
                    'jumlah_keluar'    => $item['qty'],
                    'stok_akhir'      => $varian->stok_varian,
                    'petugas'         => Auth::user()->name
                ]);

                $transaksi->total_harga += $varian->harga_varian * $item['qty']; // Update total harga
                $transaksi->save();
            }

            DB::commit();

            toast()->success('Transaksi Keluar berhasil ditambahkan');
            return response()->json([
                'success'      => true,
                'redirect_url' => route('transaksi-keluar.create') // Arahkan ke index setelah sukses
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTransaksiKeluar(){
        $search = request()->query('search');
        $transaksi = Transaksi::where('jenis_transaksi', 'pemasukan')
            ->where('nomor_transaksi', 'like', '%' . $search . '%')
            ->get()->map(function ($q){
                return [
                    'id' => $q->id,
                    'text' => $q->nomor_transaksi
                ];
            });
        return response()->json($transaksi);
    }

    public function getTransaksiKeluarItems($nomor_transaksi)
    {
        $transaksi = Transaksi::with('items', 'items.varian')->where('nomor_transaksi', $nomor_transaksi)->first();
        $transaksi->tanggal = Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('l, d F Y ');
        return response()->json($transaksi);
    }

}