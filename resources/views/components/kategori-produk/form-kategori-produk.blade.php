<div>
    {{-- 1. Pengecekan Role Admin --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="d-flex align-items-center justify-content-center gap-2">

            <!-- TOMBOL EDIT / TAMBAH -->
            <button type="button" class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}"
                data-bs-toggle="modal"
                data-bs-target="#formKategori{{ $id ?? '' }}">
                @if ($id)
                    <i class="fas fa-edit"></i>
                @else
                    <i class="fas fa-plus me-1"></i>
                    <span>Buat Baru</span>
                @endif
            </button>

            <!-- TOMBOL HAPUS (Hanya muncul jika di dalam tabel/ada ID) -->
            @if ($id)
                <form action="{{ route('master-data.kategori-produk.destroy', $id) }}" method="POST" id="delete-form-{{ $id }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-icon btn-round" onclick="confirmDelete('{{ $id }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>


        <div class="modal fade" id="formKategori{{ $id ?? '' }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="formKategori" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if ($id)
                            @method('PUT')
                        @endif
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formKategoriLabel">
                                {{ $id ? 'Edit Kategori barang' : 'Tambah Kategori Barang' }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="form-group">
                                <label for="nama_kategori" class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                    value="{{ old('nama_kategori', $nama_kategori ?? '') }}" placeholder="Masukkan nama kategori" required>
                                @error('nama_kategori')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

   @else
        {{-- Pesan untuk Staff/User Biasa: Hanya bisa melihat data --}}
        <span class="badge bg-info text-white"><i class="fas fa-lock me-1"></i> Khusus (Admin)</span>
    @endif
</div>

{{-- SCRIPT SWEETALERT (Taruh di bawah atau di file master layout) --}}
@push('script')
<script>
    function confirmDelete(id) {
        swal({
            title: "Hapus Data?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Batal",
                    className: "btn btn-secondary",
                },
                confirm: {
                    text: "Ya, Hapus!",
                    className: "btn btn-danger",
                },
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
