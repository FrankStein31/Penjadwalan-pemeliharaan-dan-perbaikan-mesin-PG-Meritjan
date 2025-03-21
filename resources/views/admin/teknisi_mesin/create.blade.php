@extends('layouts.app')

@section('title', 'Form Tambah Teknisi & Mesin')

@section('contents')
    <form action="{{ route('teknisi_mesin.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Tambah Teknisi & Mesin
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Mesin</label>
                            <select name="mesin_id" class="form-control" required>
                                <option value="">Pilih Mesin</option>
                                @foreach ($mesin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Teknisi</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Pilih Teknisi</option>
                                @foreach ($teknisi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('teknisi_mesin.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
