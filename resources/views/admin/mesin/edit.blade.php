@extends('layouts.app')

@section('title', 'Edit Data Mesin')

@section('contents')
<form action="{{ route('mesin.update', $mesin->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Edit Data Mesin
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $mesin->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <input type="text" name="jenis" class="form-control" value="{{ $mesin->jenis }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ $mesin->tahun }}" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ $mesin->deskripsi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="station_id">Station</label>
                            <select name="station_id" id="station_id" class="form-control">
                                <option value="">Pilih Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ $mesin->station_id == $station->id ? 'selected' : '' }}>
                                        {{ $station->nama_station }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('mesin.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
