@extends('layouts.app')

@section('title', 'Status Pendaftaran - PPDB Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>
            Status Pendaftaran
        </h1>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                <div>
                    <h3 class="font-semibold text-blue-900">Status: Menunggu Verifikasi</h3>
                    <p class="text-sm text-blue-800">Data Anda sedang dalam proses verifikasi administrasi</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Formulir Pendaftaran</h4>
                    <p class="text-sm text-gray-600">Data berhasil dikirim</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-white text-sm"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Verifikasi Administrasi</h4>
                    <p class="text-sm text-gray-600">Sedang dalam proses verifikasi</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-credit-card text-white text-sm"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Pembayaran</h4>
                    <p class="text-sm text-gray-600">Menunggu verifikasi administrasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection