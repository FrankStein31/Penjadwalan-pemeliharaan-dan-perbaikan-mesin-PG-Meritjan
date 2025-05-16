@extends('layouts.app')

@section('title', 'Edit Laporan Insidental')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Laporan Insidental</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan-insidental.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" name="station_id" class="form-control @error('station_id') is-invalid @enderror"
                        required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}"
                                {{ $laporan->station_id == $station->id ? 'selected' : '' }}>
                                {{ $station->nama_station }}
                            </option>
                        @endforeach
                    </select>
                    @error('station_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control @error('mesin_id') is-invalid @enderror"
                        required>
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ $laporan->mesin_id == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mesin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Kerusakan</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $laporan->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo_path">Foto Bukti</label>
                    @if ($laporan->photo_path && Storage::disk('public')->exists($laporan->photo_path))
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $laporan->photo_path) }}" alt="Foto Bukti"
                                style="max-width: 200px; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="photo_path" id="photo_path"
                        class="form-control-file @error('photo_path') is-invalid @enderror" accept="image/*">
                    @error('photo_path')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <div class="form-group">
                    <label for="requires_spare_part">Pengajuan Suku Cadang</label>
                    <select name="requires_spare_part" id="requires_spare_part" class="form-control" required>
                        <option value="1" {{ $laporan->requires_spare_part ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ !$laporan->requires_spare_part ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
