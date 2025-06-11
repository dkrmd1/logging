<!DOCTYPE html>
<html>
<head>
    <title>Laporan Reset Password</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .small-col { width: 10%; }
        .medium-col { width: 15%; }
        .large-col { width: 30%; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <h2>Laporan Reset Password</h2>
    <h4>
        @if (isset($tanggal_awal) && isset($tanggal_akhir))
            Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') }}
        @else
            Tanggal: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        @endif
    </h4>

    <p>Total Data: {{ count($records) }}</p>

    <table>
        <thead>
            <tr>
                <th class="medium-col">Nama</th>
                <th class="medium-col">User ID</th>
                <th class="small-col">Tgl</th>
                <th class="small-col">Jam</th>
                <th class="small-col">Status</th>
                <th class="large-col">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    <td>{{ $record->nama }}</td>
                    <td>{{ $record->user_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->tanggal_permohonan)->format('d-m-Y') }}</td>
                    <td>{{ $record->waktu_permohonan }}</td>
                    <td style="color:
                        {{ $record->status == 'Selesai' ? 'green' : ($record->status == 'Proses' ? 'orange' : 'red') }}">
                        {{ $record->status }}
                    </td>
                    <td>{{ $record->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
    </div>
</body>
</html>
