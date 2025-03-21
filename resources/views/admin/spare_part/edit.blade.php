@extends('layouts.app')

@section('title', 'Edit Spare Part')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Suku Cadang</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spare_part.update', $sparePart->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kode_part">Kode Suku Cadang</label>
                    <input type="text" name="kode_part" id="kode_part" class="form-control" value="{{ $sparePart->kode_part }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Suku Cadang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $sparePart->nama }}" required>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Suku Cadang</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="mekanik" {{ $sparePart->jenis == 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                        <option value="elektrik" {{ $sparePart->jenis == 'elektrik' ? 'selected' : '' }}>Elektrik</option>
                        <option value="lainnya" {{ $sparePart->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0" value="{{ $sparePart->stok }}" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $sparePart->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('spare_part') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
