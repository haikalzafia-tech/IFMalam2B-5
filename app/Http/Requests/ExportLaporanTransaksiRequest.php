<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExportLaporanTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'tanggal_awal'      => 'required|date',
            'tanggal_akhir'      => 'required|date|after_or_equal:tanggal_awal',
        ];
    }

    public function messages(): array
    {
        return [
                'jenis_transaksi.required' => 'Jenis transaksi wajib diisi.',
                'jenis_transaksi.in'       => 'Jenis transaksi yang dipilih tidak valid (harus pemasukan atau pengeluaran).',
                'tanggal_awal.date'        => 'Format tanggal awal tidak valid.',
                'tanggal_akhir.required'   => 'Tanggal akhir wajib diisi.',
                'tanggal_akhir.date'       => 'Format tanggal akhir tidak valid.',
                'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
                'tanggal_awal.required'    => 'Tanggal awal wajib diisi.',
        ];
    } 
}