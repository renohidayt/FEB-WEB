<!-- Manage Media -->
<a href="{{ route('admin.albums.media.index', $album) }}" 
   class="btn btn-sm btn-success" 
   data-bs-toggle="tooltip" 
   title="Kelola Media">
    <i class="fas fa-folder-open"></i>
</a>

<!-- Edit -->
<a href="{{ route('admin.albums.edit', $album) }}" 
   class="btn btn-sm btn-warning" 
   data-bs-toggle="tooltip" 
   title="Edit Album">
    <i class="fas fa-edit"></i>
</a>

<!-- Toggle Publish -->
<form action="{{ route('admin.albums.toggle-publish', $album) }}" 
      method="POST" 
      class="d-inline"
      onsubmit="return confirm('Yakin ingin {{ $album->is_published ? 'unpublish' : 'publish' }} album ini?')">
    @csrf
    @method('PATCH')
    <button type="submit" 
            class="btn btn-sm btn-{{ $album->is_published ? 'secondary' : 'info' }}"
            data-bs-toggle="tooltip" 
            title="{{ $album->is_published ? 'Unpublish' : 'Publish' }}">
        <i class="fas fa-{{ $album->is_published ? 'eye-slash' : 'eye' }}"></i>
    </button>
</form>

<!-- Delete -->
<form action="{{ route('admin.albums.destroy', $album) }}" 
      method="POST" 
      class="d-inline"
      onsubmit="return confirm('Yakin ingin menghapus album {{ $album->name }}? Semua media di dalamnya akan ikut terhapus!')">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="btn btn-sm btn-danger"
            data-bs-toggle="tooltip" 
            title="Hapus Album">
        <i class="fas fa-trash"></i>
    </button>
</form>