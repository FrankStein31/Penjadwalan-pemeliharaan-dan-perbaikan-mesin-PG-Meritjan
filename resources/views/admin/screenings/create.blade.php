@extends('layouts.app')

@section('title', 'Tambah Screening Mesin')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-white">Tambah Screening Mesin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('screenings.store') }}" method="POST">
                @csrf

                <!-- Pilih Mesin -->
                <div class="form-group">
                    <label for="mesin_id">Pilih Mesin</label>
                    <select name="mesin_id" id="mesin_id" class="form-control @error('mesin_id') is-invalid @enderror"
                        required>
                        <option value="">Pilih Mesin</option>
                        @foreach ($mesins as $mesin)
                            <option value="{{ $mesin->id }}" {{ old('mesin_id') == $mesin->id ? 'selected' : '' }}>
                                {{ $mesin->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mesin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Teknisi -->
                <div class="form-group">
                    <label for="teknisi_id">Pilih Teknisi</label>
                    <select name="teknisi_id" id="teknisi_id" class="form-control @error('teknisi_id') is-invalid @enderror"
                        required>
                        <option value="">Pilih Teknisi</option>
                        @foreach ($teknisis as $teknisi)
                            <option value="{{ $teknisi->id }}" {{ old('teknisi_id') == $teknisi->id ? 'selected' : '' }}>
                                {{ $teknisi->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('teknisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Admin -->
                <div class="form-group">
                    <label for="admin_id">Pilih Admin</label>
                    <select name="admin_id" id="admin_id" class="form-control @error('admin_id') is-invalid @enderror"
                        required>
                        <option value="">Pilih Admin</option>
                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('admin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Pemeriksaan -->
                <div class="form-group">
                    <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan"
                        class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror"
                        value="{{ old('tanggal_pemeriksaan') }}" required>
                    @error('tanggal_pemeriksaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Operasional -->
                <div class="form-group">
                    <label for="status_operasional">Status Operasional</label>
                    <select name="status_operasional" id="status_operasional"
                        class="form-control @error('status_operasional') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="Normal" {{ old('status_operasional') == 'Normal' ? 'selected' : '' }}>Normal
                        </option>
                        <option value="Tidak Normal" {{ old('status_operasional') == 'Tidak Normal' ? 'selected' : '' }}>
                            Tidak Normal</option>
                    </select>
                    @error('status_operasional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kode Error -->
                <div class="form-group">
                    <label for="kode_error">Kode Error</label>
                    <input type="text" name="kode_error" id="kode_error"
                        class="form-control @error('kode_error') is-invalid @enderror" value="{{ old('kode_error') }}">
                    @error('kode_error')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Suara Anomali -->
                <div class="form-group">
                    <label for="suara_anomali">Suara Anomali</label>
                    <select name="suara_anomali" id="suara_anomali"
                        class="form-control @error('suara_anomali') is-invalid @enderror" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('suara_anomali') == '1' ? 'selected' : '' }}>Terdengar suara anomali
                        </option>
                        <option value="0" {{ old('suara_anomali') == '0' ? 'selected' : '' }}>Tidak ada suara anomali
                        </option>
                    </select>
                    @error('suara_anomali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Getaran Berlebih -->
                <div class="form-group">
                    <label for="getaran_berlebih">Getaran Berlebih</label>
                    <select name="getaran_berlebih" id="getaran_berlebih"
                        class="form-control @error('getaran_berlebih') is-invalid @enderror" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('getaran_berlebih') == '1' ? 'selected' : '' }}>Terdeteksi getaran
                            berlebih</option>
                        <option value="0" {{ old('getaran_berlebih') == '0' ? 'selected' : '' }}>Getaran normal
                        </option>
                    </select>
                    @error('getaran_berlebih')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kebocoran -->
                <div class="form-group">
                    <label for="kebocoran">Kebocoran</label>
                    <select name="kebocoran" id="kebocoran" class="form-control @error('kebocoran') is-invalid @enderror"
                        required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('kebocoran') == '1' ? 'selected' : '' }}>Terdeteksi kebocoran
                        </option>
                        <option value="0" {{ old('kebocoran') == '0' ? 'selected' : '' }}>Tidak ada kebocoran</option>
                    </select>
                    @error('kebocoran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Tanggal Terakhir Perawatan -->
                <div class="form-group">
                    <label for="terakhir_perawatan">Terakhir Perawatan</label>
                    <input type="date" name="terakhir_perawatan" id="terakhir_perawatan"
                        class="form-control @error('terakhir_perawatan') is-invalid @enderror"
                        value="{{ old('terakhir_perawatan') }}">
                    @error('terakhir_perawatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tindakan Rekomendasi -->
                <div class="form-group">
                    <label for="tindakan_rekomendasi">Tindakan Rekomendasi</label>
                    <select name="tindakan_rekomendasi" id="tindakan_rekomendasi"
                        class="form-control @error('tindakan_rekomendasi') is-invalid @enderror" required>
                        <option value="">Pilih Tindakan</option>
                        <option value="Lanjut Operasi"
                            {{ old('tindakan_rekomendasi') == 'Lanjut Operasi' ? 'selected' : '' }}>Lanjut Operasi</option>
                        <option value="Perbaikan" {{ old('tindakan_rekomendasi') == 'Perbaikan' ? 'selected' : '' }}>
                            Perbaikan</option>
                        <option value="Penggantian Komponen"
                            {{ old('tindakan_rekomendasi') == 'Penggantian Komponen' ? 'selected' : '' }}>Penggantian
                            Komponen</option>
                    </select>
                    @error('tindakan_rekomendasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="form-group">
                    <label for="catatan">Pertanyaan</label>
                    <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('screenings.index') }}" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
@endsection
