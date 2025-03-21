@extends('layouts.app')

@section('title', 'Tambah Station')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Station</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('stations.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_station">Nama Station</label>
                    <input type="text" class="form-control" id="nama_station" name="nama_station" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('stations.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection 