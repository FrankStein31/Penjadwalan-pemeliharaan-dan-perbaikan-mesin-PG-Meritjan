@extends('layouts.app')

@section('title', 'Detail Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">{{ $mesin->nama }}</h4>
        </div>
        <div class="card-body">
            <h5>Suku Cadang yang Digunakan:</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Kode Suku Cadang</th>
                            <th class="text-center">Nama Suku Cadang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mesin->spareParts as $sparePart)
                            <tr>
                                <td class="text-center">{{ $sparePart->kode_part }}</td>
                                <td>{{ $sparePart->nama }}</td>
                                <td class="text-center">{{ $sparePart->pivot->jumlah }}</td>
                                <td class="text-center">
                                    <form action="{{ route('mesin.update_spare_part', [$mesin->id, $sparePart->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        {{-- <input type="number" name="jumlah" value="{{ $sparePart->pivot->jumlah }}" min="1" class="form-control d-inline w-auto"> --}}
                                        {{-- <button type="submit" class="btn btn-primary btn-sm">Update</button> --}}
                                    </form>
                                    <form action="{{ route('mesin.remove_spare_part', [$mesin->id, $sparePart->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus spare part ini dari mesin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h5 class="mt-4">Tambah Suku Cadang :</h5>
            <form action="{{ route('mesin.add_spare_part', $mesin->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="spare_part_id">Pilih Suku Cadang</label>
                    <select name="spare_part_id" class="form-control" required>
                        @foreach($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}">{{ $sparePart->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="jumlah" class="form-control" required min="1">
                </div>
                <button type="submit" class="btn btn-success">Tambah Suku Cadang</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "language": {
                    "search": "Cari Spare Part:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "➡️",
                        "previous": "⬅️"
                    },
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ data keseluruhan)"
                }
            });
        });
    </script>
@endpush
