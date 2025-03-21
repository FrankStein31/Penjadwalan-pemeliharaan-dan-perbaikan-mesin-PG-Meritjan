@extends('layouts.app')

@section('title', 'Edit Teknisi & Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Edit Teknisi & Mesin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('teknisi_mesin.update', $teknisiMesin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="mesin_id">Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control" required>
                        @foreach($mesin as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $teknisiMesin->mesin_id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">Teknisi</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Teknisi</option>
                        @foreach($teknisi as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $teknisiMesin->user_id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                                    </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('teknisi_mesin.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
