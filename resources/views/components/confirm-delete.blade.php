{{--
    Komponen tombol hapus dengan konfirmasi 3D.
    Penggunaan: <x-confirm-delete route="master-data.produk.destroy" :id="$item->id" />
--}}
<form id="delete-form-{{ $id }}" action="{{ route($route, $id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
</form>
<button type="button" class="btn btn-danger btn-icon btn-round btn-xs"
    onclick="SigmaNotif.konfirmasiHapus('delete-form-{{ $id }}')" title="Hapus">
    <i class="fas fa-trash"></i>
</button>
