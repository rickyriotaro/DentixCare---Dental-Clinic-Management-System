<?php
/**
 * CACHE CLEARER FOR HOSTING WITHOUT TERMINAL
 * 
 * Access: https://dentix.my.id/clear-cache.php
 * 
 * ⚠️ DELETE THIS FILE AFTER USE FOR SECURITY!
 */

echo '<html><head><title>Cache Clearer</title></head><body style="font-family: Arial; padding: 20px; background: #f5f5f5;">';
echo '<h1 style="color: #ec4899;">🧹 Laravel Cache Clearer</h1>';
echo '<p>Clearing all caches...</p>';
echo '<hr>';

// Change to Laravel root directory
chdir(__DIR__ . '/..');

$results = [];

// 1. Clear Route Cache
echo '<h3>1️⃣ Clearing Route Cache...</h3>';
try {
    @unlink('bootstrap/cache/routes-v7.php');
    @unlink('bootstrap/cache/routes.php');
    $results['routes'] = '✅ Route cache cleared';
    echo '<p style="color: green;">' . $results['routes'] . '</p>';
} catch (Exception $e) {
    $results['routes'] = '⚠️ Route cache: ' . $e->getMessage();
    echo '<p style="color: orange;">' . $results['routes'] . '</p>';
}

// 2. Clear Config Cache
echo '<h3>2️⃣ Clearing Config Cache...</h3>';
try {
    @unlink('bootstrap/cache/config.php');
    $results['config'] = '✅ Config cache cleared';
    echo '<p style="color: green;">' . $results['config'] . '</p>';
} catch (Exception $e) {
    $results['config'] = '⚠️ Config cache: ' . $e->getMessage();
    echo '<p style="color: orange;">' . $results['config'] . '</p>';
}

// 3. Clear View Cache
echo '<h3>3️⃣ Clearing View Cache...</h3>';
try {
    $viewPath = 'storage/framework/views';
    if (is_dir($viewPath)) {
        $files = glob($viewPath . '/*');
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file) && $file !== $viewPath . '/.gitignore') {
                @unlink($file);
                $count++;
            }
        }
        $results['views'] = '✅ View cache cleared (' . $count . ' files)';
        echo '<p style="color: green;">' . $results['views'] . '</p>';
    }
} catch (Exception $e) {
    $results['views'] = '⚠️ View cache: ' . $e->getMessage();
    echo '<p style="color: orange;">' . $results['views'] . '</p>';
}

// 4. Clear Application Cache
echo '<h3>4️⃣ Clearing Application Cache...</h3>';
try {
    $cachePath = 'storage/framework/cache/data';
    if (is_dir($cachePath)) {
        $files = glob($cachePath . '/*/*');
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitignore') {
                @unlink($file);
                $count++;
            }
        }
        $results['cache'] = '✅ Application cache cleared (' . $count . ' files)';
        echo '<p style="color: green;">' . $results['cache'] . '</p>';
    }
} catch (Exception $e) {
    $results['cache'] = '⚠️ Application cache: ' . $e->getMessage();
    echo '<p style="color: orange;">' . $results['cache'] . '</p>';
}

// 5. Clear Compiled Files
echo '<h3>5️⃣ Clearing Compiled Files...</h3>';
try {
    @unlink('bootstrap/cache/packages.php');
    @unlink('bootstrap/cache/services.php');
    $results['compiled'] = '✅ Compiled files cleared';
    echo '<p style="color: green;">' . $results['compiled'] . '</p>';
} catch (Exception $e) {
    $results['compiled'] = '⚠️ Compiled files: ' . $e->getMessage();
    echo '<p style="color: orange;">' . $results['compiled'] . '</p>';
}

// 6. Regenerate Autoload (if composer is available)
echo '<h3>6️⃣ Checking Autoload...</h3>';
if (file_exists('vendor/autoload.php')) {
    echo '<p style="color: green;">✅ Autoload file exists</p>';
    $results['autoload'] = '✅ Autoload OK';
} else {
    echo '<p style="color: red;">❌ Autoload missing - upload vendor folder!</p>';
    $results['autoload'] = '❌ Autoload missing';
}

// Summary
echo '<hr>';
echo '<h2 style="color: #ec4899;">📊 Summary:</h2>';
echo '<ul>';
foreach ($results as $key => $result) {
    echo '<li><strong>' . ucfirst($key) . ':</strong> ' . $result . '</li>';
}
echo '</ul>';

echo '<hr>';
echo '<div style="background: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107;">';
echo '<strong>⚠️ IMPORTANT:</strong><br>';
echo '1. Test your site now: <a href="/" target="_blank">Open Site</a><br>';
echo '2. Try FHIR Explorer: <a href="/fhir-explorer" target="_blank">Open FHIR Explorer</a><br>';
echo '3. <strong style="color: red;">DELETE THIS FILE (clear-cache.php) after use!</strong><br>';
echo '</div>';

echo '<hr>';
echo '<p style="color: #666;">Done! Refresh your site and try again.</p>';
echo '</body></html>';
?>
