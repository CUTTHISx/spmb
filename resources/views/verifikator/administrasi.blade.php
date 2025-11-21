@extends('layouts.app')

@section('title', 'Verifikasi Administrasi - PPDB Online')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Verifikasi Administrasi</h1>
        <p class="text-gray-600">Periksa kelengkapan data dan berkas pendaftar</p>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <select class="border border-gray-300 rounded-lg px-3 py-2">
                <option>Semua Status</option>
                <option>Menunggu Verifikasi</option>
                <option>Lulus</option>
                <option>Perlu Perbaikan</option>
                <option>Ditolak</option>
            </select>
            <select class="border border-gray-300 rounded-lg px-3 py-2">
                <option>Semua Jurusan</option>
                <option>Teknik Informatika</option>
                <option>Akuntansi</option>
                <option>Administrasi Perkantoran</option>
            </select>
            <input type="text" placeholder="Cari nama/nomor pendaftaran" class="border border-gray-300 rounded-lg px-3 py-2 flex-1 min-w-64">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Daftar Pendaftar -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Berkas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendaftar as $p)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $p->dataSiswa->nama ?? 'Belum diisi' }}</div>
                                <div class="text-sm text-gray-500">{{ $p->no_pendaftaran }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->jurusan->nama ?? 'Belum dipilih' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->dataSiswa && $p->dataSiswa->nama && $p->dataSiswa->nik && $p->dataSiswa->nisn)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Lengkap</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Kurang</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->status === 'SUBMITTED')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                            @elseif($p->status === 'VERIFIED_ADM')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Lulus Administrasi</span>
                            @elseif($p->status === 'WAITING_PAYMENT')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu Pembayaran</span>
                            @elseif($p->status === 'REJECTED_ADM')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak Administrasi</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-action-button variant="primary" icon="fas fa-eye" href="/verifikator/detail/{{ $p->id }}">
                                Verifikasi
                            </x-action-button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data pendaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection