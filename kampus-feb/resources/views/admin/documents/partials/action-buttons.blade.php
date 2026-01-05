<!-- Download Button -->
@if($document->file_path)
<a href="{{ asset('storage/' . $document->file_path) }}" 
   target="_blank"
   download
   class="btn btn-sm btn-success" 
   data-bs-toggle="tooltip" 
   title="Download Dokumen"
   onclick="trackDownload({{ $document->id }})">
    <i class="fas fa-download"></i>
</a>
@endif

<!-- Preview Button -->
@if($document->file_path && in_array($document->file_type, ['pdf']))
<button type="button"
        class="btn btn-sm btn-info text-white" 
        data-bs-toggle="modal"
        data-bs-target="#previewModal{{ $document->id }}"
        title="Preview">
    <i class="fas fa-eye"></i>
</button>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal{{ $document->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-pdf text-danger me-2"></i>{{ $document->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe src="{{ asset('storage/' . $document->file_path) }}" 
                        class="w-100" 
                        style="height: 80vh; border: none;">
                </iframe>
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . $document->file_path) }}" 
                   target="_blank"
                   download
                   class="btn btn-success"
                   onclick="trackDownload({{ $document->id }})">
                    <i class="fas fa-download me-2"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Delete Button -->
<form action="{{ route('admin.documents.destroy', $document) }}" 
      method="POST" 
      class="d-inline"
      onsubmit="return confirmDelete(event, '{{ $document->name }}')">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="btn btn-sm btn-danger"
            data-bs-toggle="tooltip" 
            title="Hapus Dokumen">
        <i class="fas fa-trash"></i>
    </button>
</form>

<script>
// Track download (optional - send AJAX to increment counter)
function trackDownload(documentId) {
    // Optional: Send AJAX request to track download
    console.log('Download tracked for document ID:', documentId);
}

// Confirm delete with custom modal
function confirmDelete(event, documentName) {
    event.preventDefault();
    
    if (confirm(`Yakin ingin menghapus dokumen "${documentName}"?\n\nFile akan dihapus secara permanen dan tidak dapat dikembalikan!`)) {
        event.target.submit();
    }
    
    return false;
}
</script>