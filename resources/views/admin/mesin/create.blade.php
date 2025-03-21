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
                    <label for="mesin_id">Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" required>
                        <option value="">Pilih Mesin</option>
                        @foreach($mesins as $mesin)
                            <option value="{{ $mesin->id }}">{{ $mesin->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#mesin_id').on('change', function () {
                var mesinId = $(this).val();
                if (mesinId) {
                    $.ajax({
                        url: "{{ route('get.teknisi') }}",
                        type: "GET",
                        data: { mesin_id: mesinId },
                        success: function (data) {
                            $('#user_id').empty();
                            $('#user_id').append('<option value="">Pilih Teknisi</option>');
                            $.each(data, function (key, value) {
                                $('#user_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#user_id').empty();
                    $('#user_id').append('<option value="">Pilih Teknisi</option>');
                }
            });
        });
    </script>
@endsection
