@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - PPDB Online')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            <i class="fas fa-credit-card mr-2 text-green-600"></i>
            Verifikasi Pembayaran
        </h1>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pendaftaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">PPDB-2025-00001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ahmad Siswa</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp 250.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-green-600 hover:text-green-900 mr-3">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button class="text-red-600 hover:text-red-900 mr-3">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                            <button class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i> Bukti
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection