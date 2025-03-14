@extends('layouts.app')

@section('title', 'Edit Tugas Perbaikan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Tugas Perbaikan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('repair.update', $repair->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="mesin_id">Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                        @foreach($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ $repair->machine_id == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $repair->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Perbaikan</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="rutin" {{ $repair->repair_type == 'rutin' ? 'selected' : '' }}>Rutin</option>
                        <option value="incidental" {{ $repair->repair_type == 'incidental' ? 'selected' : '' }}>Incidental</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $repair->repair_date }}" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $repair->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Terjadwal" {{ $repair->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Selesai" {{ $repair->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ $repair->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('repair.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
