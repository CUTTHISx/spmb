@props(['status', 'size' => 'sm'])

@php
$classes = match($status) {
    'ADM_PASS', 'VERIFIED', 'APPROVED' => 'bg-green-100 text-green-800',
    'ADM_REJECT', 'REJECTED' => 'bg-red-100 text-red-800',
    'PENDING', 'WAITING' => 'bg-yellow-100 text-yellow-800',
    'DRAFT' => 'bg-gray-100 text-gray-800',
    default => 'bg-blue-100 text-blue-800'
};

$sizeClasses = match($size) {
    'xs' => 'px-2 py-1 text-xs',
    'sm' => 'px-2.5 py-0.5 text-xs',
    'md' => 'px-3 py-1 text-sm',
    'lg' => 'px-4 py-2 text-base',
    default => 'px-2.5 py-0.5 text-xs'
};

$icon = match($status) {
    'ADM_PASS', 'VERIFIED', 'APPROVED' => 'fas fa-check-circle',
    'ADM_REJECT', 'REJECTED' => 'fas fa-times-circle',
    'PENDING', 'WAITING' => 'fas fa-clock',
    'DRAFT' => 'fas fa-edit',
    default => 'fas fa-info-circle'
};

$text = match($status) {
    'ADM_PASS' => 'Terverifikasi',
    'ADM_REJECT' => 'Ditolak',
    'PENDING' => 'Menunggu',
    'DRAFT' => 'Draft',
    'VERIFIED' => 'Terverifikasi',
    'APPROVED' => 'Disetujui',
    'REJECTED' => 'Ditolak',
    'WAITING' => 'Menunggu',
    default => ucfirst(strtolower($status))
};
@endphp

<span class="inline-flex items-center {{ $classes }} {{ $sizeClasses }} font-medium rounded-full">
    <i class="{{ $icon }} mr-1"></i>
    {{ $text }}
</span>