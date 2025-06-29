@extends('layouts.app')

@section('title', 'Form Tambah Teknisi & Mesin')

@section('contents')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-control {
            background-color: #1e2235;
            border: 1px solid #2e344e;
            color: #f8fafc;
            border-radius: 12px;
            height: 48px;
            padding: 10px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.3), inset -1px -1px 2px rgba(255, 255, 255, 0.05);
        }

        .form-control:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background-color: #1f263b;
        }

        .form-control[readonly] {
            background-color: #1e2235;
            opacity: 0.8;
            cursor: not-allowed;
        }

        /* ========== Button Styling ========== */
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            border-radius: 12px;
            padding: 10px 24px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background-color: #334155;
            border-color: #334155;
            border-radius: 12px;
            padding: 10px 24px;
            font-size: 16px;
            font-weight: 600;
            color: #f8fafc;
        }

        .btn-secondary:hover {
            background-color: #475569;
            border-color: #475569;
            box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.3);
        }
    </style>


    <form action="{{ route('teknisi_mesin.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Teknisi & Mesin</h6>
                    </div>
                    <div class="card-body">
                        {{-- Pilih Teknisi --}}
                        <div class="form-group">
                            <label>Pilih Teknisi</label>
                            <select name="user_id" id="user_id" class="form-control select2" required>
                                <option value="">Pilih Teknisi</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        data-station="{{ $item->station ? $item->station->nama_station : 'Belum ditentukan' }}"
                                        data-station-id="{{ $item->station ? $item->station->id : '' }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Info Station --}}
                        <div class="form-group">
                            <label>Station Teknisi</label>
                            <input type="text" class="form-control" id="station_info" readonly
                                value="Pilih teknisi terlebih dahulu">
                        </div>

                        {{-- Pilih Mesin --}}
                        <div class="form-group">
                            <label for="mesin_id">Pilih Mesin</label>
                            <select name="mesin_id" id="mesin_id" class="form-control" required>
                                <option value="">Pilih Teknisi terlebih dahulu</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}" data-station-id="{{ $mesin->station_id }}"
                                        style="display: none;">
                                        {{ $mesin->nama }}
                                        ({{ $mesin->station ? $mesin->station->nama_station : 'Belum ditentukan' }})
                                    </option>
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

@push('scripts')
    {{-- jQuery & Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('Select2 aktif');

            // Aktifkan Select2
            $('#user_id').select2({
                placeholder: "Pilih Teknisi",
                allowClear: true,
                width: '100%'
            });

            // Saat dropdown teknisi berubah
            $('#user_id').on('change', function() {
                const selectedUser = this.options[this.selectedIndex];
                const stationName = selectedUser.getAttribute('data-station') || 'Belum ditentukan';
                const stationId = selectedUser.getAttribute('data-station-id');
                $('#station_info').val(stationName);

                $('#mesin_id option').each(function() {
                    if (!this.value) return $(this).show();
                    const mesinStationId = $(this).data('station-id');
                    $(this).toggle(mesinStationId == stationId);
                });

                $('#mesin_id').val('');
            });
        });
    </script>
@endpush
