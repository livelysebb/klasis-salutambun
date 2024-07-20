<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Laporan Keuangan</h1>

    @if ($jemaatId)
        <h2>Jemaat: {{ $jemaats[$jemaatId] }}</h2>
    @else
        <h2>Semua Jemaat</h2>
    @endif

    <h2>Transaksi:</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksiKeuangan as $transaksi)
                <tr>
                    <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->jenis_transaksi }}</td>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Ringkasan:</h2>
    <p>Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
    <p>Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
    <p>Sisa Dana: Rp {{ number_format($sisaDana, 0, ',', '.') }}</p>
</body>
</html>

