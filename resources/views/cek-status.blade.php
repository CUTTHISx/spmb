@extends('layouts.app')

@section('title', 'Status Pendaftaran - PPDB Online')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Status Pendaftaran</h1>
            <p class="text-gray-600">Nomor Pendaftaran: <span class="font-semibold">{{ $pendaftar->no_pendaftaran }}</span></p>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Status Pendaftaran</h2>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($pendaftar->status === 'DRAFT') bg-gray-100 text-gray-800
                    @elseif($pendaftar->status === 'SUBMITTED') bg-blue-100 text-blue-800
                    @elseif($pendaftar->status === 'VERIFIED') bg-green-100 text-green-800
                    @elseif($pendaftar->status === 'REJECTED') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    @if($pendaftar->status === 'DRAFT') Draft
                    @elseif($pendaftar->status === 'SUBMITTED') Disubmit
                    @elseif($pendaftar->status === 'VERIFIED') Terverifikasi
                    @elseif($pendaftar->status === 'REJECTED') Ditolak
                    @else {{ $pendaftar->status }}
                    @endif
                </span>
            </div>
            
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress Pendaftaran</span>
                    <span>
                        @if($pendaftar->status === 'DRAFT') 25%
                        @elseif($pendaftar->status === 'SUBMITTED') 50%
                        @elseif($pendaftar->status === 'VERIFIED') 100%
                        @else 75%
                        @endif
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 
                        @if($pendaftar->status === 'DRAFT') 25%
                        @elseif($pendaftar->status === 'SUBMITTED') 50%
                        @elseif($pendaftar->status === 'VERIFIED') 100%
                        @else 75%
                        @endif"></div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                    <div>
                        <p class="font-medium">Pendaftaran Dibuat</p>
                        <p class="text-sm text-gray-600">{{ $pendaftar->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                
                @if($pendaftar->status !== 'DRAFT')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                    <div>
                        <p class="font-medium">Data Disubmit</p>
                        <p class="text-sm text-gray-600">{{ $pendaftar->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                @endif
                
                @if($pendaftar->status === 'VERIFIED')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                    <div>
                        <p class="font-medium">Data Terverifikasi</p>
                        <p class="text-sm text-gray-600">Selamat! Pendaftaran Anda telah diverifikasi</p>
                    </div>
                </div>
                @elseif($pendaftar->status === 'REJECTED')
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-500 rounded-full mr-4"></div>
                    <div>
                        <p class="font-medium">Pendaftaran Ditolak</p>
                        <p class="text-sm text-gray-600">Silakan hubungi admin untuk informasi lebih lanjut</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Data Pendaftar -->
        @if($pendaftar->dataSiswa)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Siswa</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Lengkap</p>
                    <p class="font-medium">{{ $pendaftar->dataSiswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">NIK</p>
                    <p class="font-medium">{{ $pendaftar->dataSiswa->nik }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">NISN</p>
                    <p class="font-medium">{{ $pendaftar->dataSiswa->nisn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jenis Kelamin</p>
                    <p class="font-medium">{{ $pendaftar->dataSiswa->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                @if($pendaftar->jurusan)
                <div>
                    <p class="text-sm text-gray-600">Jurusan Pilihan</p>
                    <p class="font-medium">{{ $pendaftar->jurusan->nama }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Informasi Kontak -->
        <div class="bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Butuh Bantuan?</h3>
            <p class="text-blue-700 mb-4">Jika Anda memiliki pertanyaan tentang status pendaftaran, silakan hubungi:</p>
            <div class="space-y-2 text-blue-700">
                <p><i class="fas fa-envelope mr-2"></i> Email: admin@ppdb.com</p>
                <p><i class="fas fa-phone mr-2"></i> Telepon: (021) 123-4567</p>
                <p><i class="fas fa-clock mr-2"></i> Jam Kerja: Senin-Jumat 08:00-16:00</p>
            </div>
        </div>
    </div>
</div>
@endsection