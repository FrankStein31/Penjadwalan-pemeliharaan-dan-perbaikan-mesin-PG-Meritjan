<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Pemeliharaan & Perbaikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            margin: 20px;
            padding: 0;
        }
        h2 {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }
        .badge-primary { background-color: #007bff; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
    </style>
</head>
<body>

    <h2>RIWAYAT LAPORAN PEMELIHARAAN DAN PERBAIKAN</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Teknisi</th>
                <th>Mesin</th>
                <th>Jenis Perbaikan</th>
                <th>Tanggal Perbaikan</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->mesin->nama }}</td>
                    <td><strong>{{ ucfirst($item->jenis) }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                    <td>
                        <span class="badge
                            @if ($item->status == 'Terjadwal') badge-primary
                            @elseif($item->status == 'Selesai') badge-success
                            @else badge-danger
                            @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
