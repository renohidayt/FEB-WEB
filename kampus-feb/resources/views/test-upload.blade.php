<!DOCTYPE html>
<html>
<head>
    <title>Test Multiple Upload</title>
</head>
<body>
    <h1>Test Multiple File Upload</h1>
    
    <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" value="Test Facility" required><br><br>
        
        <select name="category" required>
            <option value="Laboratorium">Laboratorium</option>
        </select><br><br>
        
        <input type="text" name="capacity" value="50"><br><br>
        
        <textarea name="description">Test description</textarea><br><br>
        
        <input type="checkbox" name="is_active" value="1" checked><br><br>
        
        <!-- Input file yang VISIBLE untuk test -->
        <input type="file" name="photos[]" accept="image/*" multiple><br><br>
        
        <button type="submit">Upload</button>
    </form>
    
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            console.log('Files selected:', e.target.files.length);
            alert('Files selected: ' + e.target.files.length);
        });
    </script>
</body>
</html>