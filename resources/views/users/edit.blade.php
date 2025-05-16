@extends('layouts.app')

@section('title', 'Edit User')

@section('contents')
    <form action="{{ route('users.tambah.update', ['id' => $user->id]) }}" method="POST">
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
                        <h4 class="m-0 font-weight-bold text-white">Edit Data Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Username</label>
                            <input type="text" class="form-control" id="user_id" name="user_id"
                                value="{{ old('user_id', $user->user_id) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $user->nama) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="" disabled>Pilih Level</option>
                                <option value="Teknisi" {{ old('level', $user->level) == 'Teknisi' ? 'selected' : '' }}>
                                    Teknisi</option>
                                <option value="Administrator"
                                    {{ old('level', $user->level) == 'Administrator' ? 'selected' : '' }}>Administrator
                                </option>
                                <option value="Manajer Teknisi"
                                    {{ old('level', $user->level) == 'Manajer Teknisi' ? 'selected' : '' }}>Manajer Teknisi
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="{{ old('alamat', $user->alamat) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">Telp</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                value="{{ old('telp', $user->telp) }}" required>
                        </div>
                        {{-- <div class="form-group">
                        <label for="rincian_pekerjaan">Rincian Pekerjaan</label>
                        <input type="text" class="form-control" id="rincian_pekerjaan" name="rincian_pekerjaan" value="{{ old('rincian_pekerjaan', $users->rincian_pekerjaan) }}" required>
                    </div> --}}
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
