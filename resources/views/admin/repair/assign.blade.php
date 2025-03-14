@extends('layouts.app')

@section('title', 'Tambah Tugas Perbaikan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Tugas Perbaikan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('repair.assign.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="machine_id">Mesin</label>
                    <select name="machine_id" id="machine_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}">{{ $machine->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="repair_type">Jenis Perbaikan</label>
                    <select name="repair_type" id="repair_type" class="form-control" required>
                        <option value="rutin">Rutin</option>
                        <option value="incidental">Incidental</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="repair_date">Tanggal Perbaikan</label>
                    <input type="date" name="repair_date" id="repair_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Terjadwal">Terjadwal</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('admin.repair.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
