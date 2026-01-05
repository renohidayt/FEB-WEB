<?php
/**
 * File: public/test-video-upload.php
 * Test Video Upload tanpa Laravel
 * Akses: http://yoursite.local/test-video-upload.php
 */

// Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Video Upload</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        .info-box { 
            background: #e3f2fd; 
            padding: 15px; 
            border-left: 4px solid #2196f3; 
            margin: 20px 0;
            border-radius: 4px;
        }
        .success { 
            background: #d4edda; 
            border-left-color: #28a745; 
            color: #155724;
        }
        .error { 
            background: #f8d7da; 
            border-left-color: #dc3545; 
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        input[type="file"] { 
            padding: 10px; 
            border: 2px solid #ddd; 
            border-radius: 5px;
            width: 100%;
            margin: 10px 0;
        }
        button { 
            background: #2196f3; 
            color: white; 
            padding: 12px 30px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #1976d2; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0;
        }
        table td { 
            padding: 10px; 
            border-bottom: 1px solid #ddd;
        }
        table td:first-child { 
            font-weight: bold; 
            width: 200px;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Test Video Upload</h1>
        
        <div class="info-box">
            <strong>📋 Current PHP Settings:</strong>
        </div>
        
        <table>
            <tr>
                <td>upload_max_filesize</td>
                <td><code><?= ini_get('upload_max_filesize') ?></code></td>
            </tr>
            <tr>
                <td>post_max_size</td>
                <td><code><?= ini_get('post_max_size') ?></code></td>
            </tr>
            <tr>
                <td>max_execution_time</td>
                <td><code><?= ini_get('max_execution_time') ?> seconds</code></td>
            </tr>
            <tr>
                <td>memory_limit</td>
                <td><code><?= ini_get('memory_limit') ?></code></td>
            </tr>
            <tr>
                <td>max_file_uploads</td>
                <td><code><?= ini_get('max_file_uploads') ?></code></td>
            </tr>
            <tr>
                <td>file_uploads</td>
                <td><code><?= ini_get('file_uploads') ? 'Enabled' : 'Disabled' ?></code></td>
            </tr>
        </table>

        <?php
        // Konversi ke bytes untuk comparison
        function convertToBytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            $val = (int) $val;
            switch($last) {
                case 'g': $val *= 1024;
                case 'm': $val *= 1024;
                case 'k': $val *= 1024;
            }
            return $val;
        }

        $uploadMax = convertToBytes(ini_get('upload_max_filesize'));
        $postMax = convertToBytes(ini_get('post_max_size'));

        if ($uploadMax < 50 * 1024 * 1024 || $postMax < 50 * 1024 * 1024) {
            echo '<div class="info-box warning">';
            echo '<strong>⚠️ Warning:</strong> Upload limits are below 50MB. ';
            echo 'Recommended: upload_max_filesize = 100M, post_max_size = 100M';
            echo '</div>';
        } else {
            echo '<div class="info-box success">';
            echo '<strong>✅ Good:</strong> Upload limits are sufficient for video uploads.';
            echo '</div>';
        }
        ?>

        <hr style="margin: 30px 0;">

        <h2>Upload Test Video</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="test_video" accept="video/*" required>
            <button type="submit" name="upload">Upload Video</button>
        </form>

        <?php
        if (isset($_POST['upload']) && isset($_FILES['test_video'])) {
            echo '<div class="info-box">';
            echo '<strong>🔍 Upload Debug Information:</strong>';
            echo '</div>';
            
            echo '<table>';
            echo '<tr><td>File Name</td><td>' . htmlspecialchars($_FILES['test_video']['name']) . '</td></tr>';
            echo '<tr><td>File Type</td><td>' . htmlspecialchars($_FILES['test_video']['type']) . '</td></tr>';
            echo '<tr><td>File Size</td><td>' . round($_FILES['test_video']['size'] / 1024 / 1024, 2) . ' MB</td></tr>';
            echo '<tr><td>Temp Location</td><td>' . htmlspecialchars($_FILES['test_video']['tmp_name']) . '</td></tr>';
            echo '<tr><td>Error Code</td><td>' . $_FILES['test_video']['error'] . '</td></tr>';
            echo '</table>';

            $error = $_FILES['test_video']['error'];
            
            if ($error === UPLOAD_ERR_OK) {
                echo '<div class="info-box success">';
                echo '<strong>✅ SUCCESS!</strong><br>';
                echo 'Video uploaded successfully to temporary location.<br>';
                echo 'File exists: ' . (file_exists($_FILES['test_video']['tmp_name']) ? 'YES' : 'NO');
                echo '</div>';
                
                // Coba pindahkan file
                $uploadDir = __DIR__ . '/test-uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $destination = $uploadDir . basename($_FILES['test_video']['name']);
                
                if (move_uploaded_file($_FILES['test_video']['tmp_name'], $destination)) {
                    echo '<div class="info-box success">';
                    echo '<strong>🎉 FULLY SUCCESSFUL!</strong><br>';
                    echo 'File moved to: <code>' . $destination . '</code><br>';
                    echo 'File size: ' . round(filesize($destination) / 1024 / 1024, 2) . ' MB';
                    echo '</div>';
                } else {
                    echo '<div class="info-box error">';
                    echo '<strong>❌ ERROR:</strong> Could not move uploaded file.<br>';
                    echo 'Check folder permissions: <code>' . $uploadDir . '</code>';
                    echo '</div>';
                }
                
            } else {
                $errors = [
                    UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini',
                    UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in HTML form',
                    UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                    UPLOAD_ERR_EXTENSION => 'Upload stopped by PHP extension',
                ];
                
                echo '<div class="info-box error">';
                echo '<strong>❌ UPLOAD FAILED</strong><br>';
                echo 'Error Code: ' . $error . '<br>';
                echo 'Error: ' . ($errors[$error] ?? 'Unknown error') . '<br><br>';
                
                if ($error === UPLOAD_ERR_INI_SIZE) {
                    echo '<strong>Solution:</strong><br>';
                    echo '1. Edit php.ini: <code>upload_max_filesize = 100M</code><br>';
                    echo '2. Edit php.ini: <code>post_max_size = 100M</code><br>';
                    echo '3. Restart PHP-FPM or Apache<br>';
                }
                
                echo '</div>';
            }
        }
        ?>

        <hr style="margin: 30px 0;">

        <div class="info-box">
            <strong>📝 How to Fix Upload Limits:</strong><br><br>
            <strong>1. Find php.ini location:</strong><br>
            <code>php --ini</code><br><br>
            
            <strong>2. Edit php.ini and change:</strong><br>
            <code>upload_max_filesize = 100M</code><br>
            <code>post_max_size = 100M</code><br>
            <code>max_execution_time = 300</code><br>
            <code>memory_limit = 256M</code><br><br>
            
            <strong>3. Restart PHP:</strong><br>
            <code>sudo systemctl restart php8.1-fpm</code> (for PHP 8.1)<br>
            <code>sudo systemctl restart php8.2-fpm</code> (for PHP 8.2)<br>
            <code>sudo systemctl restart apache2</code> (if using Apache)<br><br>
            
            <strong>4. If using Nginx, also edit nginx.conf:</strong><br>
            <code>client_max_body_size 100M;</code><br>
            <code>sudo systemctl restart nginx</code>
        </div>
    </div>
</body>
</html>