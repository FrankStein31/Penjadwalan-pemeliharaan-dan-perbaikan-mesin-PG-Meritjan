@extends('layouts.app')

@section('title', '')

@section('contents')
    <div class="mt-2 mb-4">
        <h2 class="text-white pb-2">Selamat Datang Kembali, {{ auth()->user()->nama }} !</h2>
        <h5 class="text-white op-7 mb-4">Kemarin aku ingin bekerja lebih cepat, hari ini aku sadar bahwa bekerja dengan aman
            lebih penting.</h5>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-settings text-warning"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Mesin Ditangani</p>
                                <h4 class="card-title">{{ $mesinTeknisi ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-calendar text-primary"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Jadwal</p>
                                <h4 class="card-title">{{ $jadwalTeknisi ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-success text-success"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Jadwal Terjadwal</p>
                                <h4 class="card-title">{{ $jadwalTerjadwal ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jadwal Terbaru -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Jadwal Pemeliharaan Terbaru</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mesin</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalTerbaru as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->tanggal }}</td>
                                    <td>{{ $jadwal->mesin->nama }}</td>
                                    <td>{{ ucfirst($jadwal->jenis) }}</td>
                                    <td>
                                        @if($jadwal->status == 'Terjadwal')
                                            <span class="badge badge-warning">{{ $jadwal->status }}</span>
                                        @elseif($jadwal->status == 'Selesai')
                                            <span class="badge badge-success">{{ $jadwal->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $jadwal->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada jadwal pemeliharaan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
