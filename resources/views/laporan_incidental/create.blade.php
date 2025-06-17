@extends('layouts.app')

@section('title', 'Buat Laporan Insidental')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Buat Laporan Insidental</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan-insidental.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Station --}}
                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" name="station_id" class="form-control" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
                                {{ $station->nama_station }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mesin --}}
                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label for="description">Deskripsi Masalah</label>
                    <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                </div>

                {{-- Foto --}}
                <div class="form-group">
                    <label for="photo_path">Upload Foto</label>
                    <input type="file" name="photo_path" id="photo_path" class="form-control-file">
                </div>

                {{-- Spare Part --}}
                <div class="form-group">
                    <label for="requires_spare_part">Perlu Suku Cadang?</label>
                    <select name="requires_spare_part" id="requires_spare_part" class="form-control" required>
                        <option value="0" {{ old('requires_spare_part') == '0' ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ old('requires_spare_part') == '1' ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <div id="spare-part-wrapper" style="display: none">
                    <label for="spare_part_id">Spare Part</label>
                    <select name="spare_part_id" id="spare_part_id" class="form-control">
                        <option value="">Pilih Spare Part</option>
                        @foreach ($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}"
                                {{ old('spare_part_id') == $sparePart->id ? 'selected' : '' }}>
                                {{ $sparePart->nama }} ({{ $sparePart->kode_part }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Kirim Laporan</button>
                    <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stationSelect = document.getElementById('station_id');
            const mesinSelect = document.getElementById('mesin_id');
            const requiresSparePart = document.getElementById('requires_spare_part');
            const sparePartWrapper = document.getElementById('spare-part-wrapper');
            const sparePartSelect = document.getElementById('spare_part_id');

            // Load mesin berdasarkan station
            stationSelect?.addEventListener('change', function () {
                const stationId = this.value;
                mesinSelect.innerHTML = '<option value="">Memuat...</option>';

                if (!stationId) {
                    mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';
                    return;
                }

                fetch('/teknisi/getMesinByStation/' + stationId)
                    .then(response => response.json())
                    .then(data => {
                        mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';
                        if (Array.isArray(data)) {
                            data.forEach(mesin => {
                                const option = document.createElement('option');
                                option.value = mesin.id;
                                option.textContent = mesin.nama;
                                if ({{ old('mesin_id') ?? 'null' }} == mesin.id) {
                                    option.selected = true;
                                }
                                mesinSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(() => {
                        mesinSelect.innerHTML = '<option value="">Gagal memuat mesin</option>';
                    });
            });

            // Tampilkan/Hide spare part
            function toggleSparePart() {
                const show = requiresSparePart.value === '1';
                sparePartWrapper.style.display = show ? 'block' : 'none';
                if (!show && sparePartSelect) sparePartSelect.value = '';
            }

            requiresSparePart?.addEventListener('change', toggleSparePart);
            toggleSparePart(); // initial check

            // Trigger event station select untuk load mesin jika station sudah terisi (pas re-render error)
            if (stationSelect.value) {
                const event = new Event('change');
                stationSelect.dispatchEvent(event);
            }
        });
    </script>
@endsection
