@extends('layouts.app')

@section('title', 'Daftar Spare Part')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">DAFTAR SUKU CADANG</h4>
            <a href="{{ route('admin.spare_part.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Suku Cadang
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Kode Suku Cadang</th>
                            <th class="text-center">Nama Suku Cadang</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($spareParts as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->kode_part }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ ucfirst($item->jenis) }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge
                                        @if ($item->stok > 10) badge-success
                                        @elseif($item->stok > 0) badge-warning
                                        @else badge-danger @endif">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('spare_part.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm btn-circle data-toggle="tooltip" title="Edit">

                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('spare_part.destroy', $item->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                            data-toggle="tooltip" title="Hapus"
                                            onclick="return confirm('Anda yakin ingin menghapus spare part ini?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
