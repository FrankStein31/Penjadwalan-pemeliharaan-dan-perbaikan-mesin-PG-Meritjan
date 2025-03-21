@extends('layouts.app')

@section('title', '')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">DATA MESIN</h4>
            @if(auth()->user()->level === 'Administrator')
            <a href="{{ route('mesin.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Data
            </a>
            @endif
        </div>
        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Station</th>
                            @if(auth()->user()->level === 'Administrator')
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($mesins as $mesin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mesin->nama }}</td>
                                <td>{{ $mesin->jenis }}</td>
                                <td>{{ $mesin->tahun }}</td>
                                <td>{{ $mesin->station ? $mesin->station->nama_station : 'Belum ditentukan' }}</td>
                                @if(auth()->user()->level === 'Administrator')
                                <td class="text-center">
                                    <a href="{{ route('mesin.show', $mesin->id) }}"
                                        class="btn btn-info btn-sm btn-circle" data-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('mesin.edit', $mesin->id) }}"
                                        class="btn btn-warning btn-sm btn-circle" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('mesin.destroy', $mesin->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle" data-toggle="tooltip" title="Hapus"
                                            onclick="return confirm('Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
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
                    "search": "Cari Mesin:",
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
