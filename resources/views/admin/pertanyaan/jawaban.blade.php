@extends('layouts.app')

@section('title', 'Jawaban Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Jawaban Screening Mesin</h4>
        </div>
        <div class="card-body">
            @forelse ($pertanyaan as $item)
                <div class="card mb-4 border-left-primary">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Getaran:</strong> {{ $item->getaran }}
                            </li>
                            <li class="list-group-item">
                                <strong>Suara:</strong> {{ $item->suara }}
                            </li>
                            <li class="list-group-item">
                                <strong>Pelumasan:</strong> {{ $item->pelumasan }}
                            </li>
                            <li class="list-group-item">
                                <strong>Bocor:</strong> {{ $item->bocor }}
                            </li>
                            <li class="list-group-item">
                                <strong>Kerusakan:</strong> {{ $item->kerusakan }}
                            </li>
                            <li class="list-group-item">
                                <strong>Tindakan:</strong> {{ $item->tindakan }}
                            </li>

                            @if ($item->tindakan === 'Pergantian Komponen')
                                <li class="list-group-item">
                                    <strong>Komponen yang Diganti:</strong>
                                    {{ $item->komponen && $item->komponen !== '' ? $item->komponen : '-' }}
                                </li>
                            @endif


                        </ul>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    Belum ada jawaban screening yang tersedia.
                </div>
            @endforelse
        </div>
    </div>
@endsection
