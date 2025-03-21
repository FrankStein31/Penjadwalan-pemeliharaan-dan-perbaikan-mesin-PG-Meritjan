@extends('layouts.app')

@section('title', 'Tambah Jadwal Pemeliharaan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Jadwal Pemeliharaan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" class="form-control" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->nama_station }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select id="mesin_id" name="mesin_id" class="form-control" required disabled>
                        <option value="">Pilih Mesin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Pilih Teknisi</label>
                    <select id="user_id" name="user_id" class="form-control" required disabled>
                        <option value="">Pilih Teknisi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Pemeliharaan</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="rutin">Rutin</option>
                        <option value="incidental">Incidental</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
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
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('station_id').addEventListener('change', function () {
        var station_id = this.value;
        var mesinSelect = document.getElementById('mesin_id');
        var teknisiSelect = document.getElementById('user_id');
        
        // Reset dropdowns
        mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';
        teknisiSelect.innerHTML = '<option value="">Pilih Teknisi</option>';
        
        // Disable dropdowns if no station selected
        if (!station_id) {
            mesinSelect.disabled = true;
            teknisiSelect.disabled = true;
            return;
        }
        
        // Get mesin by station
        fetch('/admin/getMesinByStation/' + station_id)
            .then(response => response.json())
            .then(data => {
                mesinSelect.disabled = false;
                if (data.length > 0) {
                    data.forEach(mesin => {
                        mesinSelect.innerHTML += `<option value="${mesin.id}">${mesin.nama}</option>`;
                    });
                } else {
                    mesinSelect.innerHTML += '<option value="">Tidak ada mesin tersedia</option>';
                }
            })
            .catch(error => console.error('Error:', error));
            
        // Get teknisi by station
        fetch('/admin/getTeknisiByStation/' + station_id)
            .then(response => response.json())
            .then(data => {
                teknisiSelect.disabled = false;
                if (data.length > 0) {
                    data.forEach(teknisi => {
                        teknisiSelect.innerHTML += `<option value="${teknisi.id}">${teknisi.nama}</option>`;
                    });
                } else {
                    teknisiSelect.innerHTML += '<option value="">Tidak ada teknisi tersedia</option>';
                }
            })
            .catch(error => console.error('Error:', error));
    });
    
    document.getElementById('mesin_id').addEventListener('change', function () {
        var mesin_id = this.value;
        var teknisiSelect = document.getElementById('user_id');
        
        // Reset dropdown
        teknisiSelect.innerHTML = '<option value="">Pilih Teknisi</option>';
        
        if (mesin_id) {
            fetch('/admin/getTeknisiByMesin/' + mesin_id)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(teknisi => {
                            teknisiSelect.innerHTML += `<option value="${teknisi.id}">${teknisi.nama}</option>`;
                        });
                    } else {
                        teknisiSelect.innerHTML += '<option value="">Tidak ada teknisi tersedia</option>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
    </script>
@endsection
