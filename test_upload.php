<?php
// Test upload functionality
echo "Testing upload functionality...\n";

// Check if uploads directory exists
$uploadsDir = __DIR__ . '/public/uploads/berkas';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
    echo "Created uploads directory: $uploadsDir\n";
} else {
    echo "Uploads directory exists: $uploadsDir\n";
}

// Check permissions
if (is_writable($uploadsDir)) {
    echo "Uploads directory is writable\n";
} else {
    echo "ERROR: Uploads directory is not writable\n";
}

// Test file creation
$testFile = $uploadsDir . '/test.txt';
if (file_put_contents($testFile, 'test content')) {
    echo "Test file created successfully\n";
    unlink($testFile);
    echo "Test file deleted\n";
} else {
    echo "ERROR: Cannot create test file\n";
}

echo "Upload test completed.\n";
?>