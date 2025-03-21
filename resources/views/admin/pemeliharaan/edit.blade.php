@extends('layouts.app')

@section('title', 'Edit Jadwal Pemeliharaan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Jadwal Pemeliharaan</h4>
        </div>
        <div class="card-body">

                @php
                    $isAdmin = auth()->user()->level === 'Administrator';
                @endphp
            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" {{ $isAdmin ? '' : 'readonly' }} required>
                        @foreach($mesins as $mesin)
                            <option value="{{ $mesin->id }}" data-station="{{ $mesin->station_id }}" {{ $mesin->id == $jadwal->mesin_id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Pilih Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" {{ $isAdmin ? '' : 'readonly' }} required>
                        <option value="">Pilih Teknisi</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-station="{{ $user->station_id }}" {{ $user->id == $jadwal->user_id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Pemeliharaan</label>
                    <select name="jenis" id="jenis" class="form-control" {{ $isAdmin ? '' : 'readonly' }} required>
                        <option value="rutin" {{ $jadwal->jenis == 'rutin' ? 'selected' : '' }}>Rutin</option>
                        <option value="incidental" {{ $jadwal->jenis == 'incidental' ? 'selected' : '' }}>Incidental</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" {{ $isAdmin ? '' : 'readonly' }} required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" {{ $isAdmin ? '' : 'readonly' }}>{{ $jadwal->deskripsi }}</textarea>
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
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function loadTeknisi(mesin_id, selectedTeknisiId = null) {
        var teknisiSelect = document.getElementById('user_id');
        teknisiSelect.innerHTML = '<option value="">-- Pilih Teknisi --</option>'; // Reset dropdown

        if (mesin_id) {
            fetch('/admin/getTeknisiByMesin/' + mesin_id)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(teknisi => {
                            var isSelected = selectedTeknisiId == teknisi.id ? 'selected' : '';
                            teknisiSelect.innerHTML += `<option value="${teknisi.id}" ${isSelected}>${teknisi.nama}</option>`;
                        });
                    } else {
                        teknisiSelect.innerHTML += '<option value="">Tidak ada teknisi tersedia</option>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    document.getElementById('mesin_id').addEventListener('change', function () {
        loadTeknisi(this.value);
    });

    // Load teknisi yang sesuai saat halaman pertama kali dimuat
    window.onload = function () {
        loadTeknisi({{ $jadwal->mesin_id }}, {{ $jadwal->user_id }});
    };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mesinSelect = document.getElementById("mesin_id");
            const teknisiSelect = document.getElementById("user_id");
            
            function filterTeknisi() {
                const selectedMesin = mesinSelect.options[mesinSelect.selectedIndex];
                const selectedStation = selectedMesin.getAttribute("data-station");
                
                Array.from(teknisiSelect.options).forEach(option => {
                    if (option.value === "") {
                        option.style.display = "block";
                    } else {
                        const teknisiStation = option.getAttribute("data-station");
                        option.style.display = teknisiStation === selectedStation ? "block" : "none";
                    }
                });
            }
            
            mesinSelect.addEventListener("change", filterTeknisi);
            filterTeknisi(); // Jalankan saat halaman pertama kali dimuat
        });
    </script>
@endsection
