@extends('layouts.app')

@section('title', 'Tugaskan Teknisi')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tugaskan Teknisi</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan-insidental.assignTeknisi', $laporan->id) }}" method="POST">
                @csrf

                {{-- Informasi Mesin dan Station --}}
                <div class="form-group">
                    <label>Mesin</label>
                    <input type="text" class="form-control" value="{{ $laporan->mesin->nama }}" readonly>
                </div>

                <div class="form-group">
                    <label>Station</label>
                    <input type="text" class="form-control" value="{{ $laporan->station->nama_station }}" readonly>
                </div>

                <div class="form-group">
                    <label>Deskripsi Kerusakan</label>
                    <textarea class="form-control" rows="4" readonly>{{ $laporan->description }}</textarea>
                </div>

                {{-- Pilih Teknisi --}}
                <div class="form-group">
                    <label for="user_id">Pilih Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @forelse ($teknisis as $teknisi)
                            <option value="{{ $teknisi->id }}">{{ $teknisi->nama }} - {{ $teknisi->telp }}</option>
                        @empty
                            <option disabled>Tidak ada teknisi yang sesuai</option>
                        @endforelse
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Tugaskan Teknisi</button>
                    <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
