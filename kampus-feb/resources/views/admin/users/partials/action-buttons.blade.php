<!-- Toggle Status -->
@if($user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || !$user->isAdmin()))
<form action="{{ route('admin.users.toggle-status', $user) }}" 
      method="POST" 
      class="d-inline"
      onsubmit="return confirmToggleStatus(event, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})">
    @csrf
    @method('PATCH')

</form>
@endif

<!-- Edit -->
@if(auth()->user()->isSuperAdmin() || (!$user->isAdmin() && $user->id !== auth()->id()))
<a href="{{ route('admin.users.edit', $user) }}" 
   class="btn btn-sm btn-warning" 
   data-bs-toggle="tooltip" 
   title="Edit User">
    <i class="fas fa-edit"></i>
</a>
@endif

<!-- Delete -->
@if($user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || !$user->isAdmin()))
<button type="button"
        class="btn btn-sm btn-danger"
        data-bs-toggle="tooltip" 
        title="Hapus User"
        onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
    <i class="fas fa-trash"></i>
</button>

<!-- Hidden Delete Form -->
<form id="deleteForm{{ $user->id }}" 
      action="{{ route('admin.users.destroy', $user) }}" 
      method="POST" 
      class="d-none">
    @csrf
    @method('DELETE')
</form>
@endif

<script>
// Confirm toggle status
function confirmToggleStatus(event, userName, isActive) {
    event.preventDefault();
    const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
    const message = `Yakin ingin ${action} user "${userName}"?`;
    
    if (confirm(message)) {
        event.target.submit();
    }
    return false;
}

// Confirm delete with modal-like alert
function confirmDelete(userId, userName) {
    const message = `Yakin ingin menghapus user "${userName}"?\n\nTindakan ini tidak dapat dibatalkan!\nSemua data yang terkait dengan user ini akan ikut terhapus.`;
    
    if (confirm(message)) {
        document.getElementById('deleteForm' + userId).submit();
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>