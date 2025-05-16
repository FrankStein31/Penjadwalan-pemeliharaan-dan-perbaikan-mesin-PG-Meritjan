@extends('layouts.app')

@section('title', 'Edit Jadwal Pasca Giling')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Jadwal Pasca Giling</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pasca-giling.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" name="station_id" class="form-control" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}"
                                {{ $jadwal->mesin->station_id == $station->id ? 'selected' : '' }}>
                                {{ $station->nama_station }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ $jadwal->mesin_id == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                        value="{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                        value="{{ $jadwal->tanggal_selesai ? \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('Y-m-d') : '' }}">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $jadwal->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Terjadwal" {{ $jadwal->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Selesai" {{ $jadwal->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ $jadwal->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('pasca-giling.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const selectedMesinId = {{ $jadwal->mesin_id }};
        const selectedStationId = {{ $jadwal->mesin->station_id }};

        document.getElementById('station_id').addEventListener('change', function() {
            let station_id = this.value;
            let mesinSelect = document.getElementById('mesin_id');

            // Reset mesin dropdown
            mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';

            if (!station_id) return;

            fetch('/admin/getMesinByStation/' + station_id)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(mesin => {
                            let selected = mesin.id === selectedMesinId ? 'selected' : '';
                            mesinSelect.innerHTML +=
                                `<option value="${mesin.id}" ${selected}>${mesin.nama}</option>`;
                        });
                    } else {
                        mesinSelect.innerHTML += '<option value="">Tidak ada mesin tersedia</option>';
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Trigger change untuk load mesin sesuai station saat load halaman
        document.addEventListener('DOMContentLoaded', function() {
            const stationSelect = document.getElementById('station_id');
            if (stationSelect.value) {
                stationSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
