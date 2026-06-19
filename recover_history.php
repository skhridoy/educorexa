<?php
$historyDir = 'C:/Users/kajol/AppData/Roaming/Code/User/History';
if (is_dir($historyDir)) {
    $dirs = scandir($historyDir);
    foreach ($dirs as $dir) {
        if ($dir == '.' || $dir == '..') continue;
        $files = scandir($historyDir . '/' . $dir);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $path = $historyDir . '/' . $dir . '/' . $file;
            $content = file_get_contents($path);
            if (strpos($content, '<!-- Header Area -->') !== false && strpos($content, 'receipt_pdf.blade.php') === false) {
                // Check if it has the orange ribbon
                if (strpos($content, '#f69320') !== false && strpos($content, 'INVOICE') !== false) {
                    echo "Found matching history file: $path\n";
                    // Only output first 200 chars to verify
                    echo substr($content, 0, 200) . "\n\n";
                    
                    // Copy it back!
                    copy($path, 'C:/xampp/htdocs/laravel/schoolerp/resources/views/school/fee-manage/payment/receipt_pdf.blade.php');
                    echo "Restored from VS Code history!\n";
                    exit;
                }
            }
        }
    }
} else {
    echo "VS Code history dir not found.";
}
?>
