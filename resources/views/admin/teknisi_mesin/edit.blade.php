@extends('layouts.app')

@section('title', 'Edit Teknisi & Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Teknisi & Mesin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('teknisi_mesin.update', $teknisiMesin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" required>
                        <option value="">-- Pilih Mesin --</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ $teknisiMesin->mesin_id == $mesin->id ? 'selected' : '' }} 
                                data-station="{{ $mesin->station ? $mesin->station->nama_station : 'Belum ditentukan' }}">
                                {{ $mesin->nama }} ({{ $mesin->station ? $mesin->station->nama_station : 'Belum ditentukan' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Station Mesin</label>
                    <input type="text" class="form-control" id="station_info" readonly 
                           value="{{ $teknisiMesin->mesin->station ? $teknisiMesin->mesin->station->nama_station : 'Belum ditentukan' }}">
                </div>

                <div class="form-group">
                    <label for="user_id">Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @foreach($users as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $teknisiMesin->user_id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('teknisi_mesin.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('mesin_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stationInfo = selectedOption.getAttribute('data-station');
        document.getElementById('station_info').value = stationInfo || 'Belum ditentukan';
    });
    </script>
@endsection
