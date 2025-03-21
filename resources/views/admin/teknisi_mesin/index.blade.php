@extends('layouts.app')

@section('title', 'Teknisi & Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">TEKNISI & MESIN</h4>
            <a href="{{ route('teknisi_mesin.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Data
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Teknisi</th>
                            <th>Nama Mesin</th>
                            <th>Station</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teknisiMesins as $tm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tm->user->nama }}</td>
                                <td>{{ $tm->mesin->nama }}</td>
                                <td>{{ $tm->mesin->station ? $tm->mesin->station->nama_station : 'Belum ditentukan' }}</td>
                                <td>
                                    <a href="{{ route('teknisi_mesin.edit', $tm->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('teknisi_mesin.destroy', $tm->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
                    "search": "Cari Teknisi & Mesin:",
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

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
