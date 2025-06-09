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
                        'kerusakan' => 'Apakah ada kerusakan lainnya?',
                    ];
                @endphp

                @foreach ($pertanyaan as $key => $label)
                    <div class="form-group">
                        <label for="{{ $key }}">{{ $label }}</label>
                        <select name="{{ $key }}" id="{{ $key }}" class="form-control" required>
                            <option value="Ya">Iya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                @endforeach

                {{-- Tindakan Rekomendasi --}}
                <div class="form-group">
                    <label for="tindakan">Tindakan Rekomendasi</label>
                    <select name="tindakan" id="tindakan" class="form-control" required>
                        <option value="">Pilih Tindakan</option>
                        <option value="Lanjut Operasi">Lanjut Operasi</option>
                        <option value="Perbaikan">Perbaikan</option>
                        <option value="Pergantian Komponen">Pergantian Komponen</option>
                    </select>
                </div>

                {{-- Dropdown Komponen (muncul jika tindakan = Pergantian Komponen) --}}
                <div class="form-group" id="komponen-wrapper" style="display: none;">
                    <label for="komponen">Pilih Komponen</label>
                    <select name="komponen" id="komponen" class="form-control">
                        <option value="">Pilih Komponen</option>
                        @foreach ($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}" data-stok="{{ $sparePart->stok }}">
                                {{ $sparePart->nama }} ({{ $sparePart->kode_part }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="stok-info" style="display: none;">
                    <label>Stok Tersisa:</label>
                    <p id="stok-value" class="font-weight-bold"></p>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Simpan Screening</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript: Tampilkan Dropdown Komponen Jika Diperlukan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tindakanSelect = document.getElementById('tindakan');
            const komponenWrapper = document.getElementById('komponen-wrapper');
            const komponenSelect = document.getElementById('komponen');
            const stokInfo = document.getElementById('stok-info');
            const stokValue = document.getElementById('stok-value');

            function updateKomponenVisibility() {
                const selectedTindakan = tindakanSelect.value;
                if (selectedTindakan === 'Pergantian Komponen') {
                    komponenWrapper.style.display = 'block';
                } else {
                    komponenWrapper.style.display = 'none';
                    komponenSelect.value = '';
                    stokInfo.style.display = 'none';
                    stokValue.textContent = '';
                }
            }

            function updateStokInfo() {
                const selectedOption = komponenSelect.options[komponenSelect.selectedIndex];
                const stok = selectedOption.getAttribute('data-stok');
                if (komponenSelect.value && stok !== null) {
                    stokValue.textContent = stok + ' unit';
                    stokInfo.style.display = 'block';
                } else {
                    stokInfo.style.display = 'none';
                    stokValue.textContent = '';
                }
            }

            // Event listeners
            tindakanSelect.addEventListener('change', updateKomponenVisibility);
            komponenSelect.addEventListener('change', updateStokInfo);

            // Inisialisasi saat load halaman
            updateKomponenVisibility();
            updateStokInfo();
        });
    </script>
@endsection
