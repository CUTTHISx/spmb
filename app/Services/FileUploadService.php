<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public static function uploadBerkas(UploadedFile $file, string $type, int $pendaftarId): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $type . '_' . $pendaftarId . '_' . time() . '.' . $extension;
        
        $path = $file->storeAs("berkas/{$type}", $filename, 'public');
        
        return $path;
    }
    
    public static function uploadPembayaran(UploadedFile $file, int $pendaftarId): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'bukti_' . $pendaftarId . '_' . time() . '.' . $extension;
        
        $path = $file->storeAs('pembayaran', $filename, 'public');
        
        return $path;
    }
    
    public static function uploadFoto(UploadedFile $file, int $pendaftarId): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'foto_' . $pendaftarId . '_' . time() . '.' . $extension;
        
        $path = $file->storeAs('foto', $filename, 'public');
        
        return $path;
    }
    
    public static function deleteFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }
    
    public static function getFileUrl(?string $path): ?string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        
        return null;
    }
}