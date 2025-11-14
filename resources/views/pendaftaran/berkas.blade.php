@extends('layouts.app')

@section('title', 'Upload Berkas - PPDB Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Upload Berkas</h1>
        <p class="text-gray-600">Upload dokumen pendukung pendaftaran</p>
    </div>

    <form action="/pendaftaran/berkas" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Ijazah -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Ijazah/SKHUN</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="ijazah" accept="image/*,.pdf" class="hidden" id="ijazah">
                <label for="ijazah" class="cursor-pointer block text-center">
                    @if($pendaftar->berkas?->ijazah)
                        <i class="fas fa-file-check text-4xl text-green-500 mb-2"></i>
                        <p class="text-green-600 font-semibold">File sudah diupload</p>
                        <a href="{{ $pendaftar->berkas->ijazah_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                    @else
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload Ijazah/SKHUN</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </label>
            </div>
        </div>

        <!-- Rapor -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Rapor Semester Terakhir</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="rapor" accept="image/*,.pdf" class="hidden" id="rapor">
                <label for="rapor" class="cursor-pointer block text-center">
                    @if($pendaftar->berkas?->rapor)
                        <i class="fas fa-file-check text-4xl text-green-500 mb-2"></i>
                        <p class="text-green-600 font-semibold">File sudah diupload</p>
                        <a href="{{ $pendaftar->berkas->rapor_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                    @else
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload Rapor</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </label>
            </div>
        </div>

        <!-- KK -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Kartu Keluarga (KK)</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="kk" accept="image/*,.pdf" class="hidden" id="kk">
                <label for="kk" class="cursor-pointer block text-center">
                    @if($pendaftar->berkas?->kk)
                        <i class="fas fa-file-check text-4xl text-green-500 mb-2"></i>
                        <p class="text-green-600 font-semibold">File sudah diupload</p>
                        <a href="{{ $pendaftar->berkas->kk_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                    @else
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload KK</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </label>
            </div>
        </div>

        <!-- Akta -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Akta Kelahiran</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="akta" accept="image/*,.pdf" class="hidden" id="akta">
                <label for="akta" class="cursor-pointer block text-center">
                    @if($pendaftar->berkas?->akta)
                        <i class="fas fa-file-check text-4xl text-green-500 mb-2"></i>
                        <p class="text-green-600 font-semibold">File sudah diupload</p>
                        <a href="{{ $pendaftar->berkas->akta_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                    @else
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload Akta Kelahiran</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </label>
            </div>
        </div>

        <!-- Foto -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Pas Foto 3x4</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <input type="file" name="foto" accept="image/*" class="hidden" id="foto">
                <label for="foto" class="cursor-pointer block text-center">
                    @if($pendaftar->berkas?->foto)
                        <img src="{{ $pendaftar->berkas->foto_url }}" alt="Foto" class="w-24 h-32 object-cover mx-auto mb-2 border">
                        <p class="text-green-600 font-semibold">Foto sudah diupload</p>
                    @else
                        <i class="fas fa-camera text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk upload Pas Foto</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max: 1MB)</p>
                </label>
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