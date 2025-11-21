<?php
// Script untuk memperbaiki status verifikasi yang belum diset

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pendaftar;

// Update semua pendaftar yang sudah submit tapi status verifikasi masih NULL
$updated = Pendaftar::whereIn('status', ['SUBMIT', 'SUBMITTED'])
    ->where(function($query) {
        $query->whereNull('status_berkas')
              ->orWhereNull('status_data');
    })
    ->update([
        'status_berkas' => 'PENDING',
        'status_data' => 'PENDING'
    ]);

echo "Updated {$updated} records with missing verification status\n";

// Tidak perlu update status karena SUBMITTED sudah valid
echo "Status SUBMITTED is valid, no need to change\n";

echo "Fix completed!\n";