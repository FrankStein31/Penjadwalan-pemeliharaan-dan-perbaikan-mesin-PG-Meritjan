@extends('layouts.app')

@section('title', 'Detail Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">Detail Screening Mesin</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Mesin</th>
                    <td>{{ $screening->mesin->nama }}</td>
                </tr>
                <tr>
                    <th>Teknisi</th>
                    <td>{{ $screening->teknisi->nama }}</td>
                </tr>
                <tr>
                    <th>Admin</th>
                    <td>{{ $screening->admin->nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pemeriksaan</th>
                    <td>{{ $screening->tanggal_pemeriksaan }}</td>
                </tr>
                <tr>
                    <th>Status Operasional</th>
                    <td>
                        <span class="badge badge-{{ $screening->status_operasional == 'Normal' ? 'success' : 'danger' }}">
                            {{ $screening->status_operasional }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Kode Error</th>
                    <td>{{ $screening->kode_error ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Suara Anomali</th>
                    <td>{{ $screening->suara_anomali ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <th>Getaran Berlebih</th>
                    <td>{{ $screening->getaran_berlebih ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <th>Kebocoran</th>
                    <td>{{ $screening->kebocoran ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <th>Terakhir Perawatan</th>
                    <td>{{ $screening->terakhir_perawatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tindakan Rekomendasi</th>
                    <td>{{ $screening->tindakan_rekomendasi }}</td>
                </tr>
                <tr>
                    <th>Pertanyaan</th>
                    <td>{{ $screening->catatan ?? '-' }}</td>
                </tr>
            </table>
        </div>
        @if(auth()->user()->level === 'Adminstrator')
        <div class="card-footer">
            <a href="{{ route('screenings.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        @endif
        <div class="card-footer">
            <a href="{{ route('screenings.indexteknisi') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
