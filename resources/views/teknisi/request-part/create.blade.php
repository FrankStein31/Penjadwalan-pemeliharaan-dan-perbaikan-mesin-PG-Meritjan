@extends('layouts.app')

@section('title', 'Request Suku Cadang')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Request Suku Cadang</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('teknisi.request-part.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}">{{ $mesin->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="spare_part_id">Pilih Suku Cadang</label>
                    <select name="spare_part_id" id="spare_part_id" class="form-control" required>
                        <option value="">Pilih Suku Cadang</option>
                        @foreach ($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}">{{ $sparePart->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1"
                        placeholder="Jumlah">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"
                        placeholder="Deskripsi Tambahan (opsional)"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('teknisi.request-part.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
