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

                {{-- Station --}}
                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" name="station_id" class="form-control @error('station_id') is-invalid @enderror" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}" {{ old('station_id', $laporan->station_id) == $station->id ? 'selected' : '' }}>
                                {{ $station->nama_station }}
                            </option>
                        @endforeach
                    </select>
                    @error('station_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mesin --}}
                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control @error('mesin_id') is-invalid @enderror" required>
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ old('mesin_id', $laporan->mesin_id) == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mesin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label for="description">Deskripsi Kerusakan</label>
                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $laporan->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="form-group">
                    <label for="photo_path">Foto Bukti</label>
                    @if ($laporan->photo_path && Storage::disk('public')->exists($laporan->photo_path))
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $laporan->photo_path) }}" alt="Foto Bukti" style="max-width: 200px; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="photo_path" id="photo_path" class="form-control-file @error('photo_path') is-invalid @enderror" accept="image/*">
                    @error('photo_path')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                {{-- Spare Part Toggle --}}
                <div class="form-group">
                    <label for="requires_spare_part">Pengajuan Suku Cadang</label>
                    <select name="requires_spare_part" id="requires_spare_part" class="form-control @error('requires_spare_part') is-invalid @enderror" required>
                        <option value="0" {{ old('requires_spare_part', $laporan->requires_spare_part) == 0 ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ old('requires_spare_part', $laporan->requires_spare_part) == 1 ? 'selected' : '' }}>Ya</option>
                    </select>
                    @error('requires_spare_part')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dropdown Spare Part --}}
                <div id="spare-part-wrapper" class="form-group" style="display: {{ old('requires_spare_part', $laporan->requires_spare_part) ? 'block' : 'none' }}">
                    <label for="spare_part_id">Pilih Spare Part</label>
                    <select name="spare_part_id" id="spare_part_id" class="form-control @error('spare_part_id') is-invalid @enderror">
                        <option value="">Pilih Spare Part</option>
                        @foreach ($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}" {{ old('spare_part_id', $laporan->spare_part_id) == $sparePart->id ? 'selected' : '' }}>
                                {{ $sparePart->nama }} ({{ $sparePart->kode_part }})
                            </option>
                        @endforeach
                    </select>
                    @error('spare_part_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const requiresSparePart = document.getElementById('requires_spare_part');
            const sparePartWrapper = document.getElementById('spare-part-wrapper');
            const sparePartSelect = document.getElementById('spare_part_id');

            function toggleSparePart() {
                const show = requiresSparePart.value === '1';
                sparePartWrapper.style.display = show ? 'block' : 'none';
                if (!show && sparePartSelect) sparePartSelect.value = '';
            }

            requiresSparePart.addEventListener('change', toggleSparePart);
            toggleSparePart(); // initial trigger
        });
    </script>
@endsection
