<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeTransaksiMasukRequest;
use App\Models\KartuStok;
use App\Models\LaporanKenaikanHarga;
use App\Models\Transaksi;
use App\Models\VarianProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk database transaction
use Illuminate\Support\Facades\Validator;

class TransaksiMasukController extends Controller
{
    public $pageTitle = 'Transaksi Masuk';
    public $jenisTransaksi = 'pemasukan';


    public function index()
    {


        $pengirim = request()->query('pengirim');
        $tanggalAwal = request()->query('tanggal_awal');
        $tanggalAkhir = request()->query('tanggal_akhir');
        $perPage = request()->query('perPage',10);

        $query = Transaksi::query();
        $query->orderBy('created_at','DESC');
        $query->where('jenis_transaksi',$this->jenisTransaksi);

        if($pengirim){
            $query->where('pengirim','like','%'.$pengirim.'%');
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
        return view('transaksi-masuk.index', compact('pageTitle', 'transaksi'));
    }

    public function create()
    {
        $pageTitle = $this->pageTitle;
        return view('transaksi-masuk.create', compact('pageTitle'));
    }

    public function show($nomor_transaksi)
    {
        $pageTitle = "Detail " . $this->pageTitle;
        $transaksi = Transaksi::with('items')->where('nomor_transaksi', $nomor_transaksi)->first();
        $transaksi->formated_date = Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('l, d F Y ');
        return view('transaksi-masuk.show', compact('transaksi', 'pageTitle'));
    }

    public function store(storeTransaksiMasukRequest $request)
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
                'total_harga'      => array_sum(array_column($items, 'subTotal')),
                'keterangan'       => $request->keterangan,
                'petugas'          => Auth::user()->name,
                'pengirim'         => $request->pengirim,
                'kontak'           => $request->kontak
            ]);

            foreach ($items as $item) {
                $query = explode('-', $item['text']);
                // Cek apakah produk & varian ada di string (mencegah error index 1)
                $namaProduk = trim($query[0]);
                $namaVarian = isset($query[1]) ? trim($query[1]) : '-';

                $varian = VarianProduk::where('nomor_sku', $item['nomor_sku'])->first();

                if($item['harga'] > $varian->harga_varian) {
                    LaporanKenaikanHarga::create([
                        'nomor_transaksi' => $nomorTransaksi,
                        'nomor_batch'     => $item['nomor_batch'],
                        'nomor_sku'       => $item['nomor_sku'],
                        'harga_lama'      => $varian->harga_varian,
                        'harga_beli'      => $item['harga'],
                        'kenaikan_harga'  => $item['harga'] - $varian->harga_varian,
                        'jumlah_barang'   => $item['qty']
                    ]);
                }

                if (!$varian) {
                    throw new \Exception("Produk dengan SKU " . $item['nomor_sku'] . " tidak ditemukan.");
                }

                $transaksi->items()->create([
                    'produk'      => $namaProduk,
                    'varian'      => $namaVarian,
                    'nomor_batch' => $item['nomor_batch'],
                    'qty'         => $item['qty'],
                    'harga'       => $item['harga'],
                    'subTotal'    => $item['subTotal'],
                    'nomor_sku'   => $item['nomor_sku']
                ]);

                // Update Stok
                $varian->increment('stok_varian', $item['qty']);

                // Catat di Kartu Stok
                KartuStok::create([
                    'nomor_transaksi' => $transaksi->nomor_transaksi,
                    'jenis_transaksi' => 'in',
                    'nomor_sku'       => $item['nomor_sku'],
                    'jumlah_masuk'    => $item['qty'],
                    'stok_akhir'      => $varian->stok_varian,
                    'petugas'         => Auth::user()->name
                ]);
            }

            DB::commit();

            toast()->success('Transaksi Masuk berhasil ditambahkan');
            return response()->json([
                'success'      => true,
                'redirect_url' => route('transaksi-masuk.index') // Arahkan ke index setelah sukses
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}