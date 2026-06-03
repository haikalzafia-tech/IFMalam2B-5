<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class storeVarianProdukRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'produk_id' => 'required|exists:produks,id',
            'nama_varian' => 'required',
            'harga_varian' => 'required|numeric|min:0',
            'stok_varian' => 'required|numeric|min:0',
            'gambar_varian' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    
    public function messages(): array
    {
        return [
            'produk_id.required' => 'Produk harus dipilih',
            'produk_id.exists' => 'Produk tidak ditemukan',
            'nama_varian.required' => 'Nama varian harus diisi',
            'harga_varian.required' => 'Harga varian harus diisi',
            'harga_varian.numeric' => 'Harga varian harus berupa angka',
            'harga_varian.min' => 'Harga varian tidak boleh negatif',
            'stok_varian.required' => 'Stok varian harus diisi',
            'stok_varian.numeric' => 'Stok varian harus berupa angka',
            'stok_varian.min' => 'Stok varian tidak boleh negatif',
            'gambar_varian.required' => 'Gambar varian harus diunggah',
            'gambar_varian.image' => 'File yang diunggah harus berupa gambar',
            'gambar_varian.mimes' => 'Gambar varian harus berformat jpeg, png, jpg, atau gif',
            'gambar_varian.max' => 'Ukuran gambar varian tidak boleh lebih dari 2MB',
        ];
    }
}