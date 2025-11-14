@extends('layouts.main')

@section('title', 'Edit Gelombang - PPDB Online')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Gelombang</h1>
        <p class="text-gray-600">Edit data gelombang pendaftaran</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="/admin/gelombang/{{ $gelombang->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Gelombang</label>
                <input type="text" name="nama" value="{{ $gelombang->nama }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ $gelombang->tgl_mulai }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                @error('tgl_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="{{ $gelombang->tgl_selesai }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                @error('tgl_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="/admin/master" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection