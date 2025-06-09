<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Insidental #{{ $laporan->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #2c3e50;
            margin: 20px;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 20px;
        }

        hr {
            border: none;
            border-top: 2px solid #2980b9;
            margin: 6px auto 20px auto;
            width: 40%;
        }

        .section {
            padding: 12px 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .section-title {
            font-weight: bold;
            color: #2c3e50;
            font-size: 13px;
            margin-bottom: 8px;
            border-left: 4px solid #3498db;
            padding-left: 10px;
        }

        .info p {
            margin: 3px 0;
        }

        .info strong {
            color: #34495e;
            min-width: 100px;
            display: inline-block;
        }

        p {
            margin: 4px 0;
        }

        .photo-container {
            margin-top: 10px;
            text-align: center;
        }

        .photo-container img {
            max-width: 60%;
            max-height: 200px;
            border-radius: 6px;
            margin-top: 8px;
            box-shadow: 0 0 6px rgba(41, 128, 185, 0.2);
        }
    </style>
</head>

<body>

    <h2>Laporan Insidental #{{ $laporan->id }}</h2>
    <hr>

    <div class="section">
        <div class="section-title">Informasi Umum</div>
        <div class="info">
            <p><strong>Mesin:</strong> {{ $laporan->mesin->nama }}</p>
            <p><strong>Stasiun:</strong> {{ $laporan->station->nama_station }}</p>
            <p><strong>Status:</strong> {{ $laporan->status }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Deskripsi Kerusakan</div>
        <p>{{ $laporan->description }}</p>
    </div>

    <div class="section">
        <div class="section-title">Informasi Sparepart</div>
        @if ($laporan->requires_spare_part)
            <p>
                <strong>Dibutuhkan:</strong> Ya<br>
                @if ($laporan->sparePart)
                    <strong>Nama:</strong> {{ $laporan->sparePart->nama }}<br>
                    <strong>Kode:</strong> {{ $laporan->sparePart->kode_part }}
                @else
                    <em>Data spare part tidak ditemukan.</em>
                @endif
            </p>
        @else
            <p><strong>Dibutuhkan:</strong> Tidak</p>
        @endif
    </div>

    @if ($laporan->photo_path)
        <div class="section">
            <div class="section-title">Dokumentasi Foto</div>
            <div class="photo-container">
                @php
                    $path = storage_path('app/public/' . $laporan->photo_path);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = base64_encode(file_get_contents($path));
                    $src = 'data:image/' . $type . ';base64,' . $data;
                @endphp
                <img src="{{ $src }}" alt="Foto Laporan">
            </div>
        </div>
    @endif

</body>

</html>
