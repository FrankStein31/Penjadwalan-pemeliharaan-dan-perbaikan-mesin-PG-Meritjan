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

                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" name="station_id" class="form-control" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->nama_station }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Masalah</label>
                    <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="photo_path">Upload Foto</label>
                    <input type="file" name="photo_path" id="photo_path" class="form-control-file">
                </div>

                <div class="form-group">
                    <label for="requires_spare_part">Perlu Suku Cadang?</label>
                    <select name="requires_spare_part" id="requires_spare_part" class="form-control" required>
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div id="spare-part-wrapper"
                    style="display: {{ old('requires_spare_part', $laporan->requires_spare_part ?? 0) ? 'block' : 'none' }}">
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

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Kirim Laporan</button>
                    <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stationSelect = document.getElementById('station_id');
            const mesinSelect = document.getElementById('mesin_id');
            const requiresSparePart = document.getElementById('requires_spare_part');
            const sparePartWrapper = document.getElementById('spare-part-wrapper');
            const sparePartSelect = document.getElementById('spare_part_id');

            // Load mesin berdasarkan station
            if (stationSelect && mesinSelect) {
                stationSelect.addEventListener('change', function() {
                    const station_id = this.value;
                    mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';

                    if (!station_id) return;

                    fetch('/teknisi/getMesinByStation/' + station_id)
                        .then(response => response.json())
                        .then(data => {
                            if (Array.isArray(data) && data.length > 0) {
                                data.forEach(mesin => {
                                    const option = document.createElement('option');
                                    option.value = mesin.id;
                                    option.textContent = mesin.nama;
                                    mesinSelect.appendChild(option);
                                });
                            } else {
                                mesinSelect.innerHTML =
                                    '<option value="">Tidak ada mesin tersedia</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Gagal mengambil data mesin:', error);
                            mesinSelect.innerHTML = '<option value="">Gagal memuat mesin</option>';
                        });
                });
            }

            // Tampilkan / sembunyikan dropdown spare part
            function toggleSparePart() {
                if (requiresSparePart && sparePartWrapper) {
                    const show = requiresSparePart.value === '1';
                    sparePartWrapper.style.display = show ? 'block' : 'none';
                    if (!show && sparePartSelect) sparePartSelect.value = '';
                }
            }

            if (requiresSparePart) {
                requiresSparePart.addEventListener('change', toggleSparePart);
                toggleSparePart(); // untuk handle saat form re-render karena error
            }
        });
    </script>
@endsection
