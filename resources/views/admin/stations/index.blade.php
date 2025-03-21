@extends('layouts.app')

@section('title', 'Data Station')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Data Station</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('stations.create') }}" class="btn btn-primary mb-3">Tambah Station</a>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Station</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stations as $station)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $station->nama_station }}</td>
                            <td>
                                <a href="{{ route('stations.edit', $station->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('stations.destroy', $station->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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