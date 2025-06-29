@extends('layouts.app')

@section('title', 'Upload Bukti Pemeliharaan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">UPLOAD BUKTI PEMELIHARAAN</h4>
            <a href="{{ route('admin.jadwal.indexteknisi') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-dark-50 mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('jadwal.upload-bukti.store', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="foto_sebelum" class="font-weight-bold">Foto Sebelum</label>
                    <input type="file" class="form-control-file" name="foto_sebelum" id="foto_sebelum" accept="image/*">
                    @error('foto_sebelum')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_sesudah" class="font-weight-bold">Foto Sesudah</label>
                    <input type="file" class="form-control-file" name="foto_sesudah" id="foto_sesudah" accept="image/*">
                    @error('foto_sesudah')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="video" class="font-weight-bold">Video Bukti (Opsional)</label>
                    <input type="file" class="form-control-file" name="video" id="video" accept="video/*">
                    @error('video')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary font-weight-bold shadow-sm">
                    <i class="fas fa-upload mr-1"></i> Upload Bukti
                </button>
            </form>
        </div>
    </div>
@endsection
