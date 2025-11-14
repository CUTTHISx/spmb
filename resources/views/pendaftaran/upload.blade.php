@extends('layouts.app')

@section('title', 'Upload Berkas - PPDB Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center">
            <i class="fas fa-file-upload text-2xl text-green-600 mr-3"></i>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Upload Berkas Pendaftaran</h1>
                <p class="text-gray-600">Upload dokumen yang diperlukan untuk pendaftaran</p>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form action="/pendaftaran/upload" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Ijazah/Rapor -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-certificate mr-2 text-blue-600"></i>
                        Ijazah/Rapor SMP *
                    </label>
                    <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('ijazah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kartu Keluarga -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-2 text-purple-600"></i>
                        Kartu Keluarga *
                    </label>
                    <input type="file" name="kk" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('kk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Akta Kelahiran -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card mr-2 text-green-600"></i>
                        Akta Kelahiran *
                    </label>
                    <input type="file" name="akta" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('akta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KIP/KKS (Opsional) -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-credit-card mr-2 text-yellow-600"></i>
                        KIP/KKS (Opsional)
                    </label>
                    <input type="file" name="kip" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('kip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto 3x4 -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera mr-2 text-red-600"></i>
                        Pas Foto 3x4 *
                    </label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 1MB</p>
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Surat Keterangan Sehat -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heartbeat mr-2 text-pink-600"></i>
                        Surat Keterangan Sehat
                    </label>
                    <input type="file" name="surat_sehat" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('surat_sehat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between pt-6">
                <a href="/dashboard/pendaftar" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Berkas
                </button>
            </div>
        </form>
    </div>

    <!-- Status Berkas -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-list-check mr-2 text-blue-600"></i>
            Status Berkas
        </h3>
        
        <div class="space-y-3">
            @php
                $berkasTypes = [
                    'ijazah' => ['icon' => 'certificate', 'color' => 'blue', 'label' => 'Ijazah/Rapor SMP'],
                    'kk' => ['icon' => 'users', 'color' => 'purple', 'label' => 'Kartu Keluarga'],
                    'akta' => ['icon' => 'id-card', 'color' => 'green', 'label' => 'Akta Kelahiran'],
                    'foto' => ['icon' => 'camera', 'color' => 'red', 'label' => 'Pas Foto 3x4'],
                    'rapor' => ['icon' => 'file-alt', 'color' => 'indigo', 'label' => 'Rapor Semester Terakhir'],
                    'kip' => ['icon' => 'credit-card', 'color' => 'yellow', 'label' => 'KIP/KKS']
                ];
            @endphp
            
            @foreach($berkasTypes as $type => $config)
                @php
                    $berkas = null;
                    if (isset($pendaftar)) {
                        $jenisMap = ['foto' => 'LAINNYA', 'ijazah' => 'IJAZAH', 'rapor' => 'RAPOR', 'kk' => 'KK', 'akta' => 'AKTA', 'kip' => 'KIP'];
                        $jenis = $jenisMap[$type] ?? 'LAINNYA';
                        $berkas = App\Models\PendaftarBerkas::where('pendaftar_id', $pendaftar->id)->where('jenis', $jenis)->first();
                    }
                @endphp
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-{{ $config['icon'] }} text-{{ $config['color'] }}-600 mr-3"></i>
                        <span>{{ $config['label'] }}</span>
                    </div>
                    @if($berkas)
                        @if($berkas->status_verifikasi === 'APPROVED')
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Disetujui
                            </span>
                        @elseif($berkas->status_verifikasi === 'REJECTED')
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                        @elseif($berkas->status_verifikasi === 'REVISION')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                <i class="fas fa-edit mr-1"></i>Perbaikan
                            </span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                            </span>
                        @endif
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                            <i class="fas fa-times mr-1"></i>Belum Upload
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection