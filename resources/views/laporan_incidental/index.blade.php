@extends('layouts.app')

@section('title', 'Laporan Insidental')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">LAPORAN INSIDENTAL</h4>
            @if (in_array(auth()->user()->level, ['Teknisi', 'Operator Mesin']))
                <a href="{{ route('laporan-insidental.create') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                    <i class="fas fa-plus fa-sm text-dark-50 mr-2"></i>Tambah Laporan
                </a>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No.</th>
                            <th>Mesin</th>
                            <th>Station</th>
                            <th>Deskripsi Kerusakan</th>
                            <th>Foto Bukti</th>
                            <th>Pengajuan Suku Cadang</th>
                            <th>Tanggal Laporan</th>
                            <th>Status</th>
                            <th>Cetak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $item)
                            @php
                                $statusDisplay = $item->status === 'Dalam Peninjauan' ? 'Peninjauan' : $item->status;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->mesin->nama ?? 'Mesin tidak ditemukan' }}</td>
                                <td class="text-center">{{ $item->station->nama_station ?? 'Station tidak ditemukan' }}</td>
                                <td>{{ Str::limit($item->description, 50, '...') }}</td>
                                <td class="text-center">
                                    @if ($item->photo_path && Storage::disk('public')->exists($item->photo_path))
                                        <a href="{{ asset('storage/' . $item->photo_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $item->photo_path) }}" alt="Foto Bukti" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->requires_spare_part == 1)
                                        <span class="badge badge-warning">Iya</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge
                                    @if ($item->status == 'Dalam Peninjauan') badge-warning
                                    @elseif($item->status == 'Setuju') badge-success
                                    @elseif($item->status == 'Tolak') badge-danger
                                    @elseif($item->status == 'Selesai') badge-primary
                                    @else badge-secondary @endif">
                                        {{ $statusDisplay }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if (Auth::user()->level === 'Manajer Teknisi' && $item->status === 'Selesai')
                                        <a href="{{ route('laporan-insidental.export-pdf', $item->id) }}" target="_blank" class="btn btn-secondary btn-sm btn-circle" data-toggle="tooltip" title="Export PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('laporan-insidental.show', $item->id) }}" class="btn btn-info btn-sm btn-circle" data-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if (Auth::user()->level === 'Manajer Teknisi' && $item->status !== 'Selesai')
                                        @if ($item->status !== 'Setuju')
                                            <form action="{{ route('laporan-insidental.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Setuju">
                                                <button type="submit" class="btn btn-success btn-sm btn-circle" data-toggle="tooltip" title="Setujui" onclick="return confirm('Setujui laporan ini?');">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @elseif ($item->status === 'Setuju' && !$item->assigned_user_id)
                                            <a href="{{ route('laporan-insidental.assignForm', $item->id) }}" class="btn btn-primary btn-sm btn-circle" data-toggle="tooltip" title="Tugaskan Teknisi">
                                                <i class="fas fa-user-cog"></i>
                                            </a>
                                        @endif

                                        @if (!$item->assigned_user_id)
                                            <form action="{{ route('laporan-insidental.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Dalam Peninjauan">
                                                <button type="submit" class="btn btn-warning btn-sm btn-circle" data-toggle="tooltip" title="Peninjauan" onclick="return confirm('Tandai sebagai peninjauan?');">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('laporan-insidental.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Tolak">
                                                <button type="submit" class="btn btn-danger btn-sm btn-circle" data-toggle="tooltip" title="Tolak" onclick="return confirm('Tolak laporan ini?');">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if (in_array(Auth::user()->level, ['Teknisi', 'Operator Mesin']))
                                        @if ($item->status == 'Setuju')
                                            <form action="{{ route('laporan-insidental.selesai', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm btn-circle" data-toggle="tooltip" title="Selesai" onclick="return confirm('Tandai sebagai selesai?');">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('laporan-insidental.edit', $item->id) }}" class="btn btn-warning btn-sm btn-circle" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('laporan-insidental.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-circle" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin ingin menghapus laporan ini?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
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
                    "search": "Cari laporan:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "⬆️",
                        "previous": "⬅️"
                    },
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ laporan",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 laporan",
                    "infoFiltered": "(disaring dari _MAX_ laporan keseluruhan)"
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
