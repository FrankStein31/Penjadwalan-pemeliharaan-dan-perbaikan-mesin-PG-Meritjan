@extends('layouts.app')

@section('title', 'Edit Jadwal Pemeliharaan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Jadwal Pemeliharaan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="station_id">Pilih Station</label>
                    <select id="station_id" class="form-control" required>
                        <option value="">Pilih Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}" {{ $jadwal->mesin->station_id == $station->id ? 'selected' : '' }}>
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
                    <label for="user_id">Pilih Teknisi</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @foreach ($teknisis as $teknisi)
                            <option value="{{ $teknisi->id }}" {{ $jadwal->user_id == $teknisi->id ? 'selected' : '' }}>
                                {{ $teknisi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Pemeliharaan</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="rutin" {{ $jadwal->jenis == 'rutin' ? 'selected' : '' }}>Rutin</option>
                        <option value="incidental" {{ $jadwal->jenis == 'incidental' ? 'selected' : '' }}>Incidental</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
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
                        <option value="Dibatalkan" {{ $jadwal->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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
    // Simpan ID mesin dan teknisi yang dipilih
    const selectedMesinId = {{ $jadwal->mesin_id }};
    const selectedTeknisiId = {{ $jadwal->user_id }};

    document.getElementById('station_id').addEventListener('change', function () {
        var station_id = this.value;
        var mesinSelect = document.getElementById('mesin_id');
        var teknisiSelect = document.getElementById('user_id');
        
        // Reset dropdowns tetapi simpan opsi pertama
        mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';
        teknisiSelect.innerHTML = '<option value="">Pilih Teknisi</option>';
        
        if (!station_id) return;
        
        // Get mesin by station
        fetch('/admin/getMesinByStation/' + station_id)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(mesin => {
                        const selected = mesin.id === selectedMesinId ? 'selected' : '';
                        mesinSelect.innerHTML += `<option value="${mesin.id}" ${selected}>${mesin.nama}</option>`;
                    });
                    
                    // Jika data sudah dimuat, trigger change event pada mesin_id jika nilai sesuai
                    if (mesinSelect.value == selectedMesinId) {
                        mesinSelect.dispatchEvent(new Event('change'));
                    }
                } else {
                    mesinSelect.innerHTML += '<option value="">Tidak ada mesin tersedia</option>';
                }
            })
            .catch(error => console.error('Error:', error));
            
        // Get teknisi by station
        fetch('/admin/getTeknisiByStation/' + station_id)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(teknisi => {
                        const selected = teknisi.id === selectedTeknisiId ? 'selected' : '';
                        teknisiSelect.innerHTML += `<option value="${teknisi.id}" ${selected}>${teknisi.nama}</option>`;
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
        
        // Simpan pilihan yang sudah ada jika bukan dari event pertama
        const isInitialChange = teknisiSelect.options.length <= 1;
        
        if (!isInitialChange) {
            // Simpan pilihan saat ini
            const currentSelection = teknisiSelect.value;
            
            // Reset dropdown tetapi simpan opsi pertama
            teknisiSelect.innerHTML = '<option value="">Pilih Teknisi</option>';
            
            if (mesin_id) {
                fetch('/admin/getTeknisiByMesin/' + mesin_id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(teknisi => {
                                const selected = (teknisi.id == selectedTeknisiId) ? 'selected' : '';
                                teknisiSelect.innerHTML += `<option value="${teknisi.id}" ${selected}>${teknisi.nama}</option>`;
                            });
                        } else {
                            teknisiSelect.innerHTML += '<option value="">Tidak ada teknisi tersedia</option>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    });
    
    // Pada saat halaman dimuat, pilih station yang sesuai
    document.addEventListener('DOMContentLoaded', function() {
        // Hanya perlu memicu event jika station_id memiliki nilai
        const stationSelect = document.getElementById('station_id');
        if (stationSelect.value) {
            stationSelect.dispatchEvent(new Event('change'));
        }
    });
    </script>
@endsection
