@extends('layouts.app')

@section('title', 'Jadwal Pemeliharaan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">RIWAYAT LAPORAN PEMELIHARAAN DAN PERBAIKAN</h4>
            @if(auth()->user()->level === 'Administrator'|| auth()->user()->level === 'Manajer Teknisi')
            <a href="{{ route('admin.riwayat.pdf', ['mesin_id' => request('mesin_id')]) }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-dark-50 mr-2"></i> Cetak Laporan
            </a>
            @endif
        </div>
        <div class="card-body">

            @if(auth()->user()->level === 'Administrator'|| auth()->user()->level === 'Manajer Teknisi')
                <form method="GET" class="form-inline mb-3">
                    <label for="mesin_id" class="mr-2">Filter berdasarkan Mesin :</label>
                    <select name="mesin_id" id="mesin_id" class="form-control mr-2">
                        <option value="">Semua Mesin</option>
                        @foreach ($mesinList as $mesin)
                            <option value="{{ $mesin->id }}" {{ request('mesin_id') == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
                </form>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Tanggal Perbaikan</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a>{{ $item->user->nama }} melakukan perbaikan mesin {{ $item->mesin->nama }} dengan jenis perbaikan {{ ucfirst($item->jenis) }} pada tanggal</a>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                                <td>
                                    <a>{{ $item->user->nama }} menyelesaikan tugas pada tanggal</a>
                                    {{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge
                                        @if ($item->status == 'Terjadwal') badge-primary
                                        @elseif($item->status == 'Selesai') badge-success
                                        @else badge-danger @endif">
                                        {{ $item->status }}
                                    </span>
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
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "language": {
                    "search": "Cari Jadwal:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "➡",
                        "previous": "⬅"
                    },
                    "info": "Menampilkan START sampai END dari TOTAL data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari MAX data keseluruhan)"
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush