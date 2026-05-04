<form action="{{ route($route, $id) }}" method="POST" id="delete-form-{{ $id }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-icon btn-round" onclick="confirmDelete('{{ $id }}')">
        <i class="fas fa-trash"></i>
    </button>
</form>
