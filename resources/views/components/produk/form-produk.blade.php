<div>
    {{-- CEK AKSES: Hanya Admin yang bisa melihat tombol Tambah, Edit, dan Modal --}}
    @if(Auth::check() && Auth::user()->role == 'admin')

        {{-- 1. TOMBOL AKSI (TAMBAH / EDIT) --}}
        <button type="button" class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}"
            data-bs-toggle="modal"
            data-bs-target="#formProduk{{ $id ?? '' }}">
            @if($id)
                {{-- Ini tombol Edit --}}
                <i class="fas fa-edit"></i>
            @else
                {{-- Ini tombol Barang Baru --}}
                <i class="fas fa-plus me-1"></i>
                <span>Barang Baru</span>
            @endif
        </button>

        {{-- 2. MODAL FORM (Hanya dirender untuk Admin) --}}
        <div class="modal fade" id="formProduk{{ $id ?? '' }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="formProdukLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if($id)
                            @method('PUT')
                        @endif

                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formProdukLabel">
                                {{ $id ? 'Edit Barang' : 'Form Tambah Barang' }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-start">
                            {{-- Pilih Kategori --}}
                            <div class="form-group mb-3">
                                <label for="kategori_produk_id" class="form-label fw-bold">Kategori Barang</label>
                                <select name="kategori_produk_id" id="kategori_produk_id" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('kategori_produk_id', $kategori_produk_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nama Produk --}}
                            <div class="form-group mb-3">
                                <label for="nama_produk" class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                    value="{{ old('nama_produk', $nama_produk ?? '') }}" required>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="form-group mb-3">
                                <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi</label>
                                <textarea name="deskripsi_produk" id="deskripsi_produk" cols="30" rows="5"
                                    class="form-control">{{ old('deskripsi_produk', $deskripsi_produk ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 3. TOMBOL HAPUS (Hanya Admin yang punya akses) --}}
        @if($id)
            <x-confirm-delete
                route="master-data.kategori-produk.destroy"
                :id="$id"
            />
        @endif

    @else
        {{-- Pesan untuk Staff/User Biasa: Hanya bisa melihat data --}}
        <span class="badge bg-info text-white"><i class="fas fa-lock me-1"></i> Khusus (Admin)</span>
    @endif
</div>
