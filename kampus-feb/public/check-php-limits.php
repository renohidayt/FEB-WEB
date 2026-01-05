<?php
/**
 * Simpan di: public/check-php-limits.php
 * Akses: http://yoursite.local/check-php-limits.php
 */

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

$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');
$memoryLimit = ini_get('memory_limit');
$maxExecution = ini_get('max_execution_time');
$maxInputTime = ini_get('max_input_time');
$fileUploads = ini_get('file_uploads');

$uploadMaxBytes = convertToBytes($uploadMax);
$postMaxBytes = convertToBytes($postMax);
$targetSize = 50 * 1024 * 1024; // 50MB

$phpIniPath = php_ini_loaded_file();
$scanDir = php_ini_scanned_files();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Upload Diagnostic</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { font-size: 2em; margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 30px; }
        .status-box {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 5px solid;
        }
        .status-ok { background: #d4edda; border-color: #28a745; color: #155724; }
        .status-warning { background: #fff3cd; border-color: #ffc107; color: #856404; }
        .status-error { background: #f8d7da; border-color: #dc3545; color: #721c24; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th { 
            background: #667eea; 
            color: white; 
            padding: 15px; 
            text-align: left;
            font-weight: 600;
        }
        td { 
            padding: 15px; 
            border-bottom: 1px solid #eee;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f8f9fa; }
        .value { 
            font-weight: bold; 
            color: #667eea;
            font-family: 'Courier New', monospace;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .section-title {
            font-size: 1.3em;
            color: #333;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .code-box {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            line-height: 1.6;
            overflow-x: auto;
            margin: 20px 0;
        }
        .code-box .comment { color: #75715e; }
        .code-box .setting { color: #66d9ef; }
        .code-box .value { color: #a6e22e; }
        .test-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        button:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .progress-bar {
            width: 100%;
            height: 30px;
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            margin: 10px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 PHP Upload Configuration Diagnostic</h1>
            <p>Check your server's upload capabilities</p>
        </div>

        <div class="content">
            <?php if ($uploadMaxBytes >= $targetSize && $postMaxBytes >= $targetSize): ?>
                <div class="status-box status-ok">
                    <h3>✅ Configuration OK</h3>
                    <p>Your server is properly configured to handle 50MB+ video uploads!</p>
                </div>
            <?php elseif ($uploadMaxBytes < $targetSize || $postMaxBytes < $targetSize): ?>
                <div class="status-box status-error">
                    <h3>❌ Configuration Issue Detected</h3>
                    <p><strong>Your upload limits are TOO LOW for video uploads.</strong></p>
                    <p>Required: <strong>50MB</strong> | Current upload_max_filesize: <strong><?= $uploadMax ?></strong> | post_max_size: <strong><?= $postMax ?></strong></p>
                </div>
            <?php else: ?>
                <div class="status-box status-warning">
                    <h3>⚠️ Configuration Warning</h3>
                    <p>Some settings may need adjustment for optimal performance.</p>
                </div>
            <?php endif; ?>

            <h2 class="section-title">📊 Current PHP Configuration</h2>
            <table>
                <thead>
                    <tr>
                        <th>Setting</th>
                        <th>Current Value</th>
                        <th>Status</th>
                        <th>Recommended</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>upload_max_filesize</td>
                        <td class="value"><?= $uploadMax ?></td>
                        <td>
                            <?php if ($uploadMaxBytes >= $targetSize): ?>
                                <span class="badge badge-success">OK</span>
                            <?php else: ?>
                                <span class="badge badge-danger">TOO LOW</span>
                            <?php endif; ?>
                        </td>
                        <td>100M</td>
                    </tr>
                    <tr>
                        <td>post_max_size</td>
                        <td class="value"><?= $postMax ?></td>
                        <td>
                            <?php if ($postMaxBytes >= $targetSize): ?>
                                <span class="badge badge-success">OK</span>
                            <?php else: ?>
                                <span class="badge badge-danger">TOO LOW</span>
                            <?php endif; ?>
                        </td>
                        <td>100M</td>
                    </tr>
                    <tr>
                        <td>memory_limit</td>
                        <td class="value"><?= $memoryLimit ?></td>
                        <td>
                            <?php if (convertToBytes($memoryLimit) >= 256 * 1024 * 1024): ?>
                                <span class="badge badge-success">OK</span>
                            <?php else: ?>
                                <span class="badge badge-warning">LOW</span>
                            <?php endif; ?>
                        </td>
                        <td>256M</td>
                    </tr>
                    <tr>
                        <td>max_execution_time</td>
                        <td class="value"><?= $maxExecution ?> seconds</td>
                        <td>
                            <?php if ($maxExecution >= 300): ?>
                                <span class="badge badge-success">OK</span>
                            <?php else: ?>
                                <span class="badge badge-warning">LOW</span>
                            <?php endif; ?>
                        </td>
                        <td>300</td>
                    </tr>
                    <tr>
                        <td>max_input_time</td>
                        <td class="value"><?= $maxInputTime ?> seconds</td>
                        <td>
                            <?php if ($maxInputTime >= 300 || $maxInputTime == -1): ?>
                                <span class="badge badge-success">OK</span>
                            <?php else: ?>
                                <span class="badge badge-warning">LOW</span>
                            <?php endif; ?>
                        </td>
                        <td>300</td>
                    </tr>
                    <tr>
                        <td>file_uploads</td>
                        <td class="value"><?= $fileUploads ? 'Enabled' : 'Disabled' ?></td>
                        <td>
                            <?php if ($fileUploads): ?>
                                <span class="badge badge-success">ON</span>
                            <?php else: ?>
                                <span class="badge badge-danger">OFF</span>
                            <?php endif; ?>
                        </td>
                        <td>On</td>
                    </tr>
                </tbody>
            </table>

            <h2 class="section-title">📁 Configuration Files</h2>
            <table>
                <tr>
                    <td><strong>Loaded php.ini:</strong></td>
                    <td class="value"><?= $phpIniPath ?: 'None' ?></td>
                </tr>
                <?php if ($scanDir): ?>
                <tr>
                    <td><strong>Additional .ini files:</strong></td>
                    <td class="value" style="font-size: 0.85em;"><?= nl2br($scanDir) ?></td>
                </tr>
                <?php endif; ?>
            </table>

            <?php if ($uploadMaxBytes < $targetSize || $postMaxBytes < $targetSize): ?>
                <h2 class="section-title">🔧 How to Fix</h2>
                
                <p><strong>Step 1: Edit php.ini</strong></p>
                <p>File location: <code><?= $phpIniPath ?></code></p>
                
                <div class="code-box">
<span class="comment">; Find and change these values:</span>
<span class="setting">upload_max_filesize</span> = <span class="value">100M</span>
<span class="setting">post_max_size</span> = <span class="value">100M</span>
<span class="setting">memory_limit</span> = <span class="value">256M</span>
<span class="setting">max_execution_time</span> = <span class="value">300</span>
<span class="setting">max_input_time</span> = <span class="value">300</span>
                </div>

                <p><strong>Step 2: Restart PHP-FPM</strong></p>
                <div class="code-box">
<span class="comment"># For PHP 8.1</span>
sudo systemctl restart php8.1-fpm

<span class="comment"># For PHP 8.2</span>
sudo systemctl restart php8.2-fpm

<span class="comment"># For Apache</span>
sudo systemctl restart apache2

<span class="comment"># For Nginx</span>
sudo systemctl restart nginx
                </div>

                <p><strong>Step 3: Verify Changes</strong></p>
                <p>Refresh this page after restarting PHP to verify the changes.</p>
            <?php endif; ?>

            <h2 class="section-title">🧪 Test Upload</h2>
            <div class="test-section">
                <form method="post" enctype="multipart/form-data" id="testForm">
                    <input type="file" name="test_file" accept="video/*" style="margin-bottom: 15px;">
                    <button type="submit">Test Upload</button>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
                    $file = $_FILES['test_file'];
                    echo '<div style="margin-top: 20px;">';
                    
                    if ($file['error'] === UPLOAD_ERR_OK) {
                        echo '<div class="status-box status-ok">';
                        echo '<h3>✅ Upload Successful!</h3>';
                        echo '<p><strong>File:</strong> ' . htmlspecialchars($file['name']) . '</p>';
                        echo '<p><strong>Size:</strong> ' . round($file['size'] / 1024 / 1024, 2) . ' MB</p>';
                        echo '<p><strong>Type:</strong> ' . htmlspecialchars($file['type']) . '</p>';
                        echo '</div>';
                    } else {
                        $errors = [
                            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
                            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                            UPLOAD_ERR_EXTENSION => 'Upload stopped by extension',
                        ];
                        
                        echo '<div class="status-box status-error">';
                        echo '<h3>❌ Upload Failed</h3>';
                        echo '<p><strong>Error Code:</strong> ' . $file['error'] . '</p>';
                        echo '<p><strong>Error:</strong> ' . ($errors[$file['error']] ?? 'Unknown error') . '</p>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>