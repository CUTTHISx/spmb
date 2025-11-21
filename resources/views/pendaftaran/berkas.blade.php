@extends('layouts.main')

@section('title', 'Upload Berkas - PPDB Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Upload Berkas</h1>
        <p class="text-gray-600">Upload dokumen pendukung pendaftaran</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if($pendaftar && ($pendaftar->status_berkas == 'REJECTED' || $pendaftar->status_berkas == 'REVISION'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Berkas Perlu Diperbaiki</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p><strong>Catatan Verifikator:</strong></p>
                        <p>{{ $pendaftar->catatan_berkas ?? $pendaftar->catatan_verifikasi ?? 'Silakan upload ulang berkas yang sesuai' }}</p>
                    </div>
                    <p class="mt-2 text-sm text-red-600">Silakan upload ulang berkas yang diminta di bawah ini.</p>
                </div>
            </div>
        </div>
    @endif

    @if($pendaftar && $pendaftar->status_berkas == 'VERIFIED')
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Berkas Sudah Terverifikasi</h3>
                    <p class="mt-1 text-sm text-green-700">Semua berkas Anda sudah diverifikasi dan disetujui.</p>
                </div>
            </div>
        </div>
    @endif

    <form action="/pendaftaran/berkas" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Ijazah -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Ijazah/SKHUN <span class="text-red-500">*</span></h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="ijazah" accept="image/*,.pdf" class="w-full p-2 border rounded" id="ijazah">
                @if(isset($existingFiles['ijazah']))
                    <div class="mt-3 p-3 bg-green-50 rounded">
                        <p class="text-green-600 font-semibold mb-2"><i class="fas fa-check-circle"></i> File sudah diupload</p>
                        <a href="{{ asset($existingFiles['ijazah']->url) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i> Lihat File
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Upload file baru untuk mengganti</p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
            </div>
        </div>

        <!-- Rapor -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Rapor Semester Terakhir</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="rapor" accept="image/*,.pdf" class="w-full p-2 border rounded" id="rapor">
                @if(isset($existingFiles['rapor']))
                    <div class="mt-3 p-3 bg-green-50 rounded">
                        <p class="text-green-600 font-semibold mb-2"><i class="fas fa-check-circle"></i> File sudah diupload</p>
                        <a href="{{ asset($existingFiles['rapor']->url) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i> Lihat File
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Upload file baru untuk mengganti</p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
            </div>
        </div>

        <!-- KK -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Kartu Keluarga (KK) <span class="text-red-500">*</span></h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="kk" accept="image/*,.pdf" class="w-full p-2 border rounded" id="kk">
                @if(isset($existingFiles['kk']))
                    <div class="mt-3 p-3 bg-green-50 rounded">
                        <p class="text-green-600 font-semibold mb-2"><i class="fas fa-check-circle"></i> File sudah diupload</p>
                        <a href="{{ asset($existingFiles['kk']->url) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i> Lihat File
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Upload file baru untuk mengganti</p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
            </div>
        </div>

        <!-- Akta -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Akta Kelahiran <span class="text-red-500">*</span></h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="akta" accept="image/*,.pdf" class="w-full p-2 border rounded" id="akta">
                @if(isset($existingFiles['akta']))
                    <div class="mt-3 p-3 bg-green-50 rounded">
                        <p class="text-green-600 font-semibold mb-2"><i class="fas fa-check-circle"></i> File sudah diupload</p>
                        <a href="{{ asset($existingFiles['akta']->url) }}" target="_blank" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i> Lihat File
                        </a>
                        <p class="text-sm text-gray-600 mt-1">Upload file baru untuk mengganti</p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
            </div>
        </div>

        <!-- Foto -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Pas Foto 3x4 <span class="text-red-500">*</span></h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="foto" accept="image/*" class="w-full p-2 border rounded" id="foto">
                @if(isset($existingFiles['lainnya']))
                    <div class="mt-3 p-3 bg-green-50 rounded text-center">
                        <img src="{{ asset($existingFiles['lainnya']->url) }}" alt="Foto" class="w-24 h-32 object-cover mx-auto mb-2 border">
                        <p class="text-green-600 font-semibold mb-2"><i class="fas fa-check-circle"></i> Foto sudah diupload</p>
                        <p class="text-sm text-gray-600">Upload file baru untuk mengganti</p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG (Max: 1MB)</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="/dashboard/pendaftar" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Kembali
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>
                Simpan Berkas
            </button>
        </div>
    </form>
</div>
@endsection