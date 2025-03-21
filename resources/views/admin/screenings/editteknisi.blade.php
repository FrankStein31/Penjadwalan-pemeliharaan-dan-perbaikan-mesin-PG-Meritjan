@extends('layouts.app')

@section('title', 'Edit Screening Mesin')

@section('contents')
    <form action="{{ route('screenings.updateteknisi', $screening->id)  }}" method="POST">
        @csrf
        @method('PUT')

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Edit Screening Mesin
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                    $isAdmin = auth()->user()->level === 'Administrator';
                @endphp
                        <div class="form-group">
                            <label for="mesin_id">Pilih Mesin</label>
                            <select name="mesin_id" id="mesin_id" class="form-control" {{ $isAdmin ? '' : 'disabled' }} required>
                                @foreach($mesins as $mesin)
                                    <option value="{{ $mesin->id }}" {{ $screening->mesin_id == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="mesin_id" value="{{ $screening->mesin_id }}">
                        </div>

                        <div class="form-group">
                            <label for="teknisi_id">Pilih Teknisi</label>
                            <select name="teknisi_id" id="teknisi_id" class="form-control" {{ $isAdmin ? '' : 'disabled' }}  >
                                @foreach($teknisis as $teknisi)
                                    <option value="{{ $teknisi->id }}" {{ $screening->teknisi_id == $teknisi->id ? 'selected' : '' }}>
                                        {{ $teknisi->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="teknisi_id" value="{{ $screening->teknisi_id }}">
                        </div>

                        <div class="form-group">
                            <label for="admin_id">Pilih Admin</label>
                            <select name="admin_id" id="admin_id" class="form-control" {{ $isAdmin ? '' : 'disabled' }} required>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $screening->admin_id == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="admin_id" value="{{ $screening->admin_id }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                            <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="form-control" {{ $isAdmin ? '' : 'readonly' }} value="{{ $screening->tanggal_pemeriksaan }}" >
                        </div>

                        <div class="form-group">
                            <label for="status_operasional">Status Operasional</label>
                            <select name="status_operasional" id="status_operasional" class="form-control" {{ $isAdmin ? '' : 'disabled' }} required>
                                <option value="Normal" {{ $screening->status_operasional == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Tidak Normal" {{ $screening->status_operasional == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                            </select>
                            <input type="hidden" name="status_operasional" value="{{ $screening->status_operasional }}">
                        </div>

                        <div class="form-group">
                            <label for="kode_error">Kode Error</label>
                            <input type="text" name="kode_error" id="kode_error" class="form-control" {{ $isAdmin ? '' : 'readonly' }}  value="{{ $screening->kode_error }}">
                        </div>

                        <div class="form-group">
                            <label for="suara_anomali">Suara Anomali</label>
                            <select name="suara_anomali" id="suara_anomali" class="form-control" {{ $isAdmin ? '' : 'disabled' }}  >
                                <option value="1" {{ $screening->suara_anomali ? 'selected' : '' }}>Terdengar suara anomali</option>
                                <option value="0" {{ !$screening->suara_anomali ? 'selected' : '' }}>Tidak ada suara anomali</option>
                            </select>
                            <input type="hidden" name="suara_anomali" value="{{ $screening->suara_anomali }}">
                        </div>

                        <div class="form-group">
                            <label for="getaran_berlebih">Getaran Berlebih</label>
                            <select name="getaran_berlebih" id="getaran_berlebih" class="form-control" {{ $isAdmin ? '' : 'disabled' }} >
                                <option value="1" {{ $screening->getaran_berlebih ? 'selected' : '' }}>Terdeteksi getaran berlebih</option>
                                <option value="0" {{ !$screening->getaran_berlebih ? 'selected' : '' }}>Getaran normal</option>
                            </select>
                            <input type="hidden" name="getaran_berlebih" value="{{ $screening->getaran_berlebih }}">
                        </div>

                        <div class="form-group">
                            <label for="kebocoran">Kebocoran</label>
                            <select name="kebocoran" id="kebocoran" class="form-control" {{ $isAdmin ? '' : 'disabled' }} required>
                                <option value="1" {{ $screening->kebocoran ? 'selected' : '' }}>Terdeteksi kebocoran</option>
                                <option value="0" {{ !$screening->kebocoran ? 'selected' : '' }}>Tidak ada kebocoran</option>
                            </select>
                            <input type="hidden" name="kebocoran" value="{{ $screening->kebocoran }}">
                        </div>

                        <div class="form-group">
                            <label for="terakhir_perawatan">Terakhir Perawatan</label>
                            <input type="date" name="terakhir_perawatan" id="terakhir_perawatan" class="form-control" {{ $isAdmin ? '' : 'readonly' }}  value="{{ $screening->terakhir_perawatan }}">
                        </div>

                        <div class="form-group">
                            <label for="tindakan_rekomendasi">Tindakan Rekomendasi</label>
                            <select name="tindakan_rekomendasi" id="tindakan_rekomendasi" class="form-control" {{ $isAdmin ? '' : 'disabled' }}  >
                                <option value="Lanjut Operasi" {{ $screening->tindakan_rekomendasi == 'Lanjut Operasi' ? 'selected' : '' }}>Lanjut Operasi</option>
                                <option value="Perbaikan" {{ $screening->tindakan_rekomendasi == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                <option value="Penggantian Komponen" {{ $screening->tindakan_rekomendasi == 'Penggantian Komponen' ? 'selected' : '' }}>Penggantian Komponen</option>
                            </select>
                            <input type="hidden" name="tindakan_rekomendasi" value="{{ $screening->tindakan_rekomendasi }}">
                        </div>

                        <div class="form-group">
                            <label for="catatan">Pertanyaan</label>
                            <textarea name="catatan" id="catatan" class="form-control" {{ $isAdmin ? '' : 'readonly' }} >{{ $screening->catatan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="jawaban">Jawaban</label>
                            <textarea name="jawaban" id="jawaban" class="form-control" >{{ $screening->jawaban }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('screenings.indexteknisi') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
