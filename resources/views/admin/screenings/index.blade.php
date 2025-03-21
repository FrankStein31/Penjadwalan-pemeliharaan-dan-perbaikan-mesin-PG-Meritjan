@extends('layouts.app')

@section('title', 'Data Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">DATA SCREENING MESIN</h4>
            <a href="{{ route('screenings.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Screening
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Mesin</th>
                            <th class="text-center">Teknisi</th>
                            <th class="text-center">Admin</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Kode Error</th>
                            <th class="text-center">Terakhir Perawatan</th>
                            <th class="text-center">Tindakan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($screenings as $index => $screening)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $screening->mesin->nama }}</td>
                                <td>{{ $screening->teknisi->nama }}</td>
                                <td>{{ $screening->admin->nama }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($screening->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $screening->status_operasional == 'Normal' ? 'success' : 'danger' }}">
                                        {{ $screening->status_operasional }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $screening->kode_error ?? '-' }}</td>
                                <td class="text-center">{{ $screening->terakhir_perawatan ? \Carbon\Carbon::parse($screening->terakhir_perawatan)->format('d-m-Y') : '-' }}</td>
                                <td class="text-center">{{ $screening->tindakan_rekomendasi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('screenings.show', $screening->id) }}"
                                        class="btn btn-info btn-sm btn-circle" data-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('screenings.edit', $screening->id) }}"
                                        class="btn btn-warning btn-sm btn-circle" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('screenings.destroy', $screening->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle" data-toggle="tooltip" title="Hapus"
                                            onclick="return confirm('Anda yakin ingin menghapus data ini?');">
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
                    "search": "Cari Screening:",
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
