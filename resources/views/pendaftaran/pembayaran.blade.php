@extends('layouts.app')

@section('title', 'Pembayaran - PPDB Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pembayaran Pendaftaran</h1>
        <p class="text-gray-600">Lakukan pembayaran biaya pendaftaran sesuai instruksi</p>
    </div>

    <!-- Status Pembayaran -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Status Pembayaran</h2>
            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                Menunggu Pembayaran
            </span>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Nomor Pendaftaran</p>
                <p class="font-semibold text-gray-900">PPDB-2024-00001</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Jurusan Pilihan</p>
                <p class="font-semibold text-gray-900">Teknik Informatika</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Biaya Pendaftaran</p>
                <p class="font-bold text-2xl text-blue-600">Rp 250.000</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Batas Waktu Pembayaran</p>
                <p class="font-semibold text-red-600">15 November 2024, 23:59</p>
            </div>
        </div>
    </div>

    <!-- Instruksi Pembayaran -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Instruksi Pembayaran</h3>
        
        <div class="space-y-4">
            <div class="border-l-4 border-blue-500 pl-4">
                <h4 class="font-semibold text-gray-900 mb-2">Transfer Bank</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Bank BCA</strong></p>
                    <p>No. Rekening: <span class="font-mono bg-gray-100 px-2 py-1 rounded">1234567890</span></p>
                    <p>Atas Nama: <strong>YAYASAN PENDIDIKAN ABC</strong></p>
                    <p class="text-red-600"><strong>Nominal: Rp 250.000 (sesuai biaya pendaftaran)</strong></p>
                </div>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Penting!</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Transfer sesuai nominal yang tertera (Rp 250.000)</li>
                            <li>Simpan bukti transfer untuk diupload</li>
                            <li>Pembayaran maksimal 3 hari setelah pendaftaran</li>
                            <li>Jika lewat batas waktu, pendaftaran akan dibatalkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Bukti Pembayaran -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Bukti Pembayaran</h3>
        
        <form action="/pendaftaran/pembayaran" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Transfer</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" name="bukti_pembayaran" accept="image/*,.pdf" class="hidden" id="bukti-file" required>
                    <label for="bukti-file" class="cursor-pointer">
                        @if($pendaftar->pembayaran?->bukti_pembayaran)
                            <i class="fas fa-file-check text-4xl text-green-500 mb-2"></i>
                            <p class="text-green-600 font-semibold">Bukti sudah diupload</p>
                            <a href="{{ $pendaftar->pembayaran->bukti_pembayaran_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                        @else
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Klik untuk upload bukti transfer</p>
                        @endif
                        <p class="text-sm text-gray-500">Format: JPG, PNG, PDF (Max: 2MB)</p>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim</label>
                <input type="text" name="nama_pengirim" class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                       placeholder="Nama yang tertera di rekening pengirim" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Transfer</label>
                <input type="date" name="tanggal_transfer" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Transfer</label>
                <input type="number" name="nominal" class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                       placeholder="250000" value="250000" readonly>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 h-20" 
                          placeholder="Catatan tambahan jika ada"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="/pendaftaran/status" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Bukti Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('bukti-file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = e.target.nextElementSibling;
        label.innerHTML = `
            <i class="fas fa-file-alt text-4xl text-green-500 mb-2"></i>
            <p class="text-green-600 font-semibold">${file.name}</p>
            <p class="text-sm text-gray-500">Klik untuk ganti file</p>
        `;
    }
});
</script>
@endsection