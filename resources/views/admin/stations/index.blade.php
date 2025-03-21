@extends('layouts.app')

@section('title', 'Data Stasiun')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-white">DATA STASIUN</h4>
            <a href="{{ route('admin.stations.create') }}" class="btn btn-primary btn-sm font-weight-bold">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Stasiun
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Stasiun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stations as $station)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $station->nama_station }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.stations.edit', $station->id) }}"
                                        class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.stations.destroy', $station->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus"
                                            onclick="return confirm('Anda yakin ingin menghapus data ini?');">
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
