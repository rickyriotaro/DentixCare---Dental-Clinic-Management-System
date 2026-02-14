<?php
/**
 * Fix case-sensitive folder issue
 */

$oldPath = __DIR__ . '/../app/Http/Controllers/api';
$newPath = __DIR__ . '/../app/Http/Controllers/Api';

if (is_dir($oldPath) && !is_dir($newPath)) {
    // Folder exists as lowercase 'api', need to rename
    $tempPath = __DIR__ . '/../app/Http/Controllers/Api_temp';
    
    // Step 1: Rename to temp
    if (rename($oldPath, $tempPath)) {
        echo "✓ Step 1: Renamed 'api' to 'Api_temp'<br>";
        
        // Step 2: Rename temp to Api
        if (rename($tempPath, $newPath)) {
            echo "✓ Step 2: Renamed 'Api_temp' to 'Api'<br>";
            echo "<br><strong>✅ SUCCESS!</strong><br>";
            echo "Folder renamed from 'api' to 'Api'<br>";
            echo "<br><a href='/clear-cache.php'>Clear Cache</a> | <a href='/login'>Test Login</a>";
        } else {
            echo "❌ Failed step 2<br>";
        }
    } else {
        echo "❌ Failed step 1<br>";
    }
} elseif (is_dir($newPath)) {
    echo "✅ Folder 'Api' already exists (correct)<br>";
    echo "<br>Check files inside:<br>";
    $files = scandir($newPath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- {$file}<br>";
        }
    }
} else {
    echo "❌ Folder not found at both paths!<br>";
    echo "Expected: {$newPath}";
}
?>
