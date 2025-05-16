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

            

            <div class="form-group">
                <button type="submit" class="btn btn-success">Kirim Laporan</button>
                <a href="{{ route('laporan-insidental.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('station_id').addEventListener('change', function () {
        var station_id = this.value;
        var mesinSelect = document.getElementById('mesin_id');
        mesinSelect.innerHTML = '<option value="">Pilih Mesin</option>';

        if (!station_id) return;

        fetch('/teknisi/getMesinByStation/' + station_id)
            .then(response => response.json())
            .then(data => {
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
