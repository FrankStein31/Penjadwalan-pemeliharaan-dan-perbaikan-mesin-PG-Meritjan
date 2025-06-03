@extends('layouts.app')

@section('title', 'Request Suku Cadang')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">REQUEST SUKU CADANG</h4>
            @if (auth()->user()->level === 'Teknisi')
                <a href="{{ route('teknisi.request-part.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                    <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i> Tambah Request
                </a>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Mesin</th>
                            <th class="text-center">Suku Cadang</th> <!-- Tambah kolom ini -->
                            <th class="text-center">Jumlah</th> <!-- Tambah kolom ini -->
                            <th class="text-center">Tanggal Request</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requestParts as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->mesin->nama ?? '-' }}</td>
                                <td class="text-center">{{ $item->sparePart->nama ?? '-' }}</td>
                                <!-- Tampilkan suku cadang -->
                                <td class="text-center">{{ $item->jumlah }}</td> <!-- Tampilkan jumlah -->
                                <td class="text-center">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="text-center">{{ $item->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge
                    @if ($item->status === 'Pending') badge-warning
                    @elseif($item->status === 'Disetujui') badge-success
                    @else badge-danger @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if (auth()->user()->level === 'Administrator')
                                        <form action="{{ route('admin.request-part.approve', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm btn-circle"
                                                data-toggle="tooltip" title="Setujui Request"
                                                onclick="return confirm('Setujui request ini?');">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.request-part.reject', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                                data-toggle="tooltip" title="Tolak Request"
                                                onclick="return confirm('Tolak request ini?');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="8">Belum ada data request suku cadang.</td>
                            </tr>
                        @endforelse
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
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "➡️",
                        "previous": "⬅️"
                    },
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(disaring dari _MAX_ data keseluruhan)"
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
