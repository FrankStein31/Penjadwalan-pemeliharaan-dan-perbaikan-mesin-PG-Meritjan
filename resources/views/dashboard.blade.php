@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
    <div class="mt-2 mb-4">
        <h2 class="text-white pb-2">Selamat Datang Kembali, {{ auth()->user()->nama }}!</h2>
        <h5 class="text-white op-7 mb-4">Dashboard Monitoring Pemeliharaan Mesin</h5>
    </div>

    {{-- Statistik utama --}}
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-users text-primary"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Jumlah Teknisi</p>
                                <h4 class="card-title">{{ $jumlahUser ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-settings text-warning"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Jumlah Mesin</p>
                                <h4 class="card-title">{{ $jumlahMesin ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round border border-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="icon-big text-center">
                                <i class="flaticon-success text-success"></i>
                            </div>
                        </div>
                        <div class="col-9 col-stats">
                            <div class="numbers">
                                <p class="card-category">Jadwal Pemeliharaan Terjadwal</p>
                                <h4 class="card-title">{{ $totalPemeliharaanTerjadwal ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter tanggal --}}
    <form method="GET" action="{{ route('dashboard') }}" class="form-inline mb-3 mt-4">
        <div class="form-group mr-2">
            <label for="tanggal_awal" class="mr-2 text-white">Dari:</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                   value="{{ request('tanggal_awal') }}">
        </div>
        <div class="form-group mr-2">
            <label for="tanggal_akhir" class="mr-2 text-white">Sampai:</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                   value="{{ request('tanggal_akhir') }}">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    {{-- Info filter tanggal --}}
    @if(request('tanggal_awal') && request('tanggal_akhir'))
        <p class="text-muted mt-2">
            Menampilkan data dari tanggal
            <strong>{{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d M Y') }}</strong>
            sampai
            <strong>{{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y') }}</strong>
        </p>
    @else
        <p class="text-muted mt-2">Menampilkan semua data teknisi tanpa filter tanggal.</p>
    @endif

    {{-- Grafik --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Grafik Kinerja Teknisi</div>
                </div>
                <div class="card-body">
                    <canvas id="grafikKetepatan" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Grafik Jumlah Pemeliharaan Rutin & Incidental</div>
                </div>
                <div class="card-body">
                    <canvas id="grafikJadwal" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Jadwal Terbaru --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Jadwal Pemeliharaan Terbaru</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover border-0" id="jadwalTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Mesin</th>
                                    <th>Teknisi</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalTerbaru as $jadwal)
                                    <tr class="text-center">
                                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $jadwal->mesin->nama }}</td>
                                        <td>{{ $jadwal->user->nama }}</td>
                                        <td class="text-capitalize">{{ $jadwal->jenis }}</td>
                                        <td>
                                            @if ($jadwal->status == 'Terjadwal')
                                                <span class="badge badge-warning px-3 py-2" style="font-size: 0.85rem;">{{ $jadwal->status }}</span>
                                            @elseif($jadwal->status == 'Selesai')
                                                <span class="badge badge-success px-3 py-2" style="font-size: 0.85rem;">{{ $jadwal->status }}</span>
                                            @else
                                                <span class="badge badge-danger px-3 py-2" style="font-size: 0.85rem;">{{ $jadwal->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada jadwal pemeliharaan.</td>
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

@push('scripts')
    {{-- Load Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Grafik Jumlah Pemeliharaan Rutin & Incidental
        const ctxJadwal = document.getElementById('grafikJadwal').getContext('2d');
        new Chart(ctxJadwal, {
            type: 'bar',
            data: {
                labels: ['Rutin', 'Incidental'],
                datasets: [{
                    label: 'Jumlah Pemeliharaan',
                    data: [{{ $jumlahRutin ?? 0 }}, {{ $jumlahIncidental ?? 0 }}],
                    backgroundColor: ['#4e73df', '#e74a3b'],
                    borderRadius: 6,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Jenis Pemeliharaan' }},
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Jadwal' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        // Grafik Ketepatan Penyelesaian Per Teknisi
        const ctxKetepatan = document.getElementById('grafikKetepatan').getContext('2d');
        const labelsTeknisi = @json($labelsTeknisi ?? []);
        const dataKetepatan = @json($dataKetepatan ?? []);

        new Chart(ctxKetepatan, {
            type: 'bar',
            data: {
                labels: labelsTeknisi,
                datasets: [{
                    label: 'Persentase Tepat Waktu (%)',
                    data: dataKetepatan,
                    backgroundColor: '#1cc88a',
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Nama Teknisi' }},
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: { display: true, text: 'Persentase (%)' },
                        ticks: { stepSize: 10 }
                    }
                }
            }
        });
    </script>
@endpush