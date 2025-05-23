@extends('layouts.app')

@section('title', 'Tambah Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Screening Mesin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('screening.store') }}" method="POST">
            @csrf
<input type="hidden" name="jadwal_pemeliharaan_id" value="{{ $jadwal->id }}">

            {{-- Pertanyaan Screening --}}
            @php
                $pertanyaan = [
                    'getaran' => 'Apakah ada getaran berlebih?',
                    'suara' => 'Apakah ada suara asing dari dalam mesin?',
                    'pelumasan' => 'Apakah oli dan stempet sudah dicek dan diganti?',
                    'bocor' => 'Apakah ada kebocoran?',
                    'kerusakan' => 'Apakah ada kerusakan lainnya?'
                ];
            @endphp

            @foreach($pertanyaan as $key => $label)
                <div class="form-group">
                    <label for="{{ $key }}">{{ $label }}</label>
                    <select name="{{ $key }}" id="{{ $key }}" class="form-control" required>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
            @endforeach

            {{-- Tindakan Rekomendasi --}}

            <div class="form-group">
                <label for="tindakan">Tindakan Rekomendasi</label>
                <select name="tindakan" id="tindakan" class="form-control" required>
                    <option value="">-- Pilih Tindakan --</option>
                    <option value="Lanjut Operasi">Lanjut Operasi</option>
                    <option value="Perbaikan">Perbaikan</option>
                    <option value="Pergantian Komponen">Pergantian Komponen</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Screening</button>
        </form>
        </div>
    </div>
@endsection
