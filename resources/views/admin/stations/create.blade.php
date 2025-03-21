@extends('layouts.app')

@section('title', 'Tambah Stasiun')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Stasiun</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.stations.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_station">Nama Stasiun</label>
                    <input type="text" class="form-control @error('nama_station') is-invalid @enderror" id="nama_station" 
                           name="nama_station" value="{{ old('nama_station') }}" placeholder="Masukkan nama stasiun" required>
                    @error('nama_station')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
