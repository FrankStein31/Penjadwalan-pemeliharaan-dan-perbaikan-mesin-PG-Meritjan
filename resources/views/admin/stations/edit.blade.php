@extends('layouts.app')

@section('title', 'Edit Stasiun')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Stasiun</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.stations.update', $station->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_station">Nama Stasiun</label>
                    <input type="text" class="form-control @error('nama_station') is-invalid @enderror" id="nama_station" 
                           name="nama_station" value="{{ old('nama_station', $station->nama_station) }}" required>
                    @error('nama_station')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
