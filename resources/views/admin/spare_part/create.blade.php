@extends('layouts.app')

@section('title', 'Tambah Spare Part')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Suku Cadang</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.spare_part.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kode_part">Kode Suku Cadang</label>
                    <input type="text" name="kode_part" id="kode_part" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Suku Cadang</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Suku Cadang</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="mekanik">Mekanik</option>
                        <option value="elektrik">Elektrik</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('spare_part') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
