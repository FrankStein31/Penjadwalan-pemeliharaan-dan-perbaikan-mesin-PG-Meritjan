@extends('layouts.app')

@section('title', 'Penjadwalan Pasca Giling')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">PENJADWALAN PASCA GILING</h4>
            <a href="{{ route('pasca-giling.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Jadwal
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No.</th>
                            <th>Station</th>
                            {{-- <th>Mesin</th> --}}
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pascaGilings as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->station->nama_station ?? 'Tidak ada Station' }}</td>
                                {{-- <td class="text-center">{{ $item->mesin->nama ?? 'Tidak ada Mesin' }}</td> --}}
                                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') : '-' }}
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50, '...') }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'Terjadwal')
                                        <span class="badge badge-primary">Terjadwal</span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- <a href="{{ route('pasca-giling.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm btn-circle" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a> -->

                                    <form action="{{ route('pasca-giling.destroy', $item->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-circle"
                                            onclick="return confirm('Yakin ingin menghapus jadwal ini?');" title="Hapus">
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
                    "search": "Cari jadwal:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "➡️",
                        "previous": "⬅️"
                    },
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ jadwal",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 jadwal",
                    "infoFiltered": "(disaring dari _MAX_ jadwal keseluruhan)"
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
