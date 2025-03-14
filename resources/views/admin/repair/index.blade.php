@extends('layouts.app')

@section('title', 'Daftar Tugas Perbaikan')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Daftar Tugas Perbaikan</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('repair.assign') }}" class="btn btn-primary mb-3">Tambah Tugas Perbaikan</a>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mesin</th>
                            <th>Teknisi</th>
                            <th>Jenis Perbaikan</th>
                            <th>Tanggal Perbaikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repairs as $index => $repair)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $repair->machine->name }}</td>
                                <td>{{ $repair->user->name }}</td>
                                <td>{{ ucfirst($repair->repair_type) }}</td>
                                <td>{{ \Carbon\Carbon::parse($repair->repair_date)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge
                                        @if($repair->status == 'Terjadwal') badge-warning
                                        @elseif($repair->status == 'Selesai') badge-success
                                        @else badge-danger @endif">
                                        {{ $repair->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('repair.update.status', $repair->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('repair.destroy', $repair->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                            Hapus
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
