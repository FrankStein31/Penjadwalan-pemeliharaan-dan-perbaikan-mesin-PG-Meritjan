@extends('layouts.app')

@section('title', 'Tambah Jadwal Pasca Giling')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Jadwal Pasca Giling</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pasca-giling.store') }}" method="POST">
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

                {{-- <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control" required disabled>
                        <option value="">Pilih Mesin</option>
                    </select>
                </div> --}}

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
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
                    <a href="{{ route('pasca-giling.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('station_id').addEventListener('change', function () {
            var station_id = this.value;
            var mesinSelect = document.getElementById('mesin_id');

            // Reset mesin dropdown
            mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';
            mesinSelect.disabled = true;

            if (!station_id) return;

            // Fetch mesin berdasarkan station
            fetch('/admin/getMesinByStation/' + station_id)
                .then(response => response.json())
                .then(data => {
                    mesinSelect.disabled = false;
                    if (data.length > 0) {
                        data.forEach(mesin => {
                            mesinSelect.innerHTML += `<option value="${mesin.id}">${mesin.nama}</option>`;
                        });
                    } else {
                        mesinSelect.innerHTML = '<option value="">Tidak ada mesin tersedia</option>';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
