@extends('layouts.app')

@section('title', 'Jawaban Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">Jawaban Screening Mesin</h4>
            <a href="{{ url()->previous() }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-dark-50 mr-2"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover border-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No.</th>
                            <th>Getaran</th>
                            <th>Suara</th>
                            <th>Pelumasan</th>
                            <th>Bocor</th>
                            <th>Kerusakan</th>
                            <th>Tindakan</th>
                            <th>Komponen Diganti</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pertanyaan as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->getaran }}</td>
                                <td>{{ $item->suara }}</td>
                                <td>{{ $item->pelumasan }}</td>
                                <td>{{ $item->bocor }}</td>
                                <td>{{ $item->kerusakan }}</td>
                                <td>{{ $item->tindakan }}</td>
                                <td>
                                    @if ($item->tindakan === 'Pergantian Komponen')
                                        {{ $item->komponen ?: '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->tindakan === 'Pergantian Komponen')
                                        @if (isset($item->stok_komponen))
                                            {{ is_numeric($item->stok_komponen) ? $item->stok_komponen . ' unit' : $item->stok_komponen }}
                                        @else
                                            <span class="text-danger">Tidak ditemukan</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada jawaban screening yang tersedia.</td>
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

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
