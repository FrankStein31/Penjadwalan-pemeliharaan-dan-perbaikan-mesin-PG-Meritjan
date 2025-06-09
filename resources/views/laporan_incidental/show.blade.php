@extends('layouts.app')

@section('title', 'Detail Laporan Insidental')

@section('contents')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h4 class="m-0 font-weight-bold text-white">DETAIL LAPORAN INSIDENTAL</h4>
        <a href="{{ route('laporan-insidental.index') }}" class="btn btn-white btn-sm font-weight-bold shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-dark-50 mr-2"></i>Kembali ke Daftar
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover border-0">
            <tbody>
                <tr>
                    <th width="200">Mesin</th>
                    <td>{{ optional($laporan->mesin)->nama ?? 'Mesin tidak ditemukan' }}</td>
                </tr>
                <tr>
                    <th>Station</th>
                    <td>{{ optional($laporan->station)->nama_station ?? 'Station tidak ditemukan' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Kerusakan</th>
                    <td>{{ $laporan->description }}</td>
                </tr>
                <tr>
                    <th>Foto Bukti</th>
                    <td>
                        @if ($laporan->photo_path && Storage::disk('public')->exists($laporan->photo_path))
                            <a href="{{ asset('storage/' . $laporan->photo_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $laporan->photo_path) }}" alt="Foto Bukti"
                                    style="max-width: 300px; border-radius: 5px;">
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pengajuan Suku Cadang</th>
                    <td>
                        @if ($laporan->requires_spare_part)
                            <span class="badge badge-warning">Ya</span>
                        @else
                            <span class="badge badge-secondary">Tidak</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Spare Part Diajukan</th>
                    <td>
                        @if ($laporan->requires_spare_part && $laporan->sparePart)
                            {{ $laporan->sparePart->nama }} ({{ $laporan->sparePart->kode_part }})
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Laporan</th>
                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
