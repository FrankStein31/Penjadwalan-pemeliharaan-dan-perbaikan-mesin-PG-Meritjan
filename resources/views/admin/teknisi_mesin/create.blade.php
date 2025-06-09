@extends('layouts.app')

@section('title', 'Form Tambah Teknisi & Mesin')

@section('contents')
    <form action="{{ route('teknisi_mesin.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Tambah Teknisi & Mesin
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Pilih Teknisi --}}
                        <div class="form-group">
                            <label>Pilih Teknisi</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Pilih Teknisi</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        data-station="{{ $item->station ? $item->station->nama_station : 'Belum ditentukan' }}"
                                        data-station-id="{{ $item->station ? $item->station->id : '' }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Info Station --}}
                        <div class="form-group">
                            <label>Station Teknisi</label>
                            <input type="text" class="form-control" id="station_info" readonly
                                value="Pilih teknisi terlebih dahulu">
                        </div>

                        {{-- Pilih Mesin --}}
                        <div class="form-group">
                            <label for="mesin_id">Pilih Mesin</label>
                            <select name="mesin_id" id="mesin_id" class="form-control" required>
                                <option value="">Pilih Teknisi terlebih dahulu</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}" data-station-id="{{ $mesin->station_id }}"
                                        style="display: none;">
                                        {{ $mesin->nama }}
                                        ({{ $mesin->station ? $mesin->station->nama_station : 'Belum ditentukan' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('teknisi_mesin.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Script untuk handle perubahan user dan filter mesin --}}
    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            const selectedUser = this.options[this.selectedIndex];
            const stationName = selectedUser.getAttribute('data-station') || 'Belum ditentukan';
            const stationId = selectedUser.getAttribute('data-station-id');

            // Tampilkan nama station
            document.getElementById('station_info').value = stationName;

            // Filter mesin berdasarkan station teknisi
            const mesinOptions = document.querySelectorAll('#mesin_id option');
            mesinOptions.forEach(option => {
                if (!option.value) {
                    option.style.display = 'block'; // "Pilih mesin" tetap tampil
                    return;
                }

                const mesinStationId = option.getAttribute('data-station-id');
                if (mesinStationId === stationId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });

            // Reset pilihan mesin
            document.getElementById('mesin_id').value = '';
        });
    </script>
@endsection
