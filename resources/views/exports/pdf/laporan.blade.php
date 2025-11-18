<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PPDB Online</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4361ee; padding-bottom: 20px; }
        .header h1 { color: #4361ee; margin: 0; font-size: 24px; }
        .header h2 { color: #666; margin: 5px 0; font-size: 18px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 5px 0; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .stat-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; padding: 15px; text-align: center; width: 23%; }
        .stat-box h3 { margin: 0; color: #4361ee; font-size: 18px; }
        .stat-box p { margin: 5px 0 0 0; color: #666; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background-color: #4361ee; color: white; font-weight: bold; text-align: center; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .status { padding: 3px 8px; border-radius: 3px; color: white; font-size: 9px; text-align: center; }
        .status-draft { background-color: #6c757d; }
        .status-submitted { background-color: #ffc107; color: #000; }
        .status-verified { background-color: #28a745; }
        .status-rejected { background-color: #dc3545; }
        .status-paid { background-color: #17a2b8; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎓 SMK Bakti Nusantara 666</h1>
        <h2>Laporan Penerimaan Peserta Didik Baru (PPDB)</h2>
        <p>Periode: {{ $periode ?? 'Semua Data' }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="20%"><strong>Tanggal Export:</strong></td>
                <td>{{ date('d F Y, H:i') }} WIB</td>
                <td width="20%"><strong>Filter Jurusan:</strong></td>
                <td>{{ $filter_jurusan ?? 'Semua Jurusan' }}</td>
            </tr>
            <tr>
                <td><strong>Total Data:</strong></td>
                <td>{{ $statistics['total'] ?? 0 }} pendaftar</td>
                <td><strong>Filter Gelombang:</strong></td>
                <td>{{ $filter_gelombang ?? 'Semua Gelombang' }}</td>
            </tr>
        </table>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>{{ $statistics['total'] ?? 0 }}</h3>
            <p>Total Pendaftar</p>
        </div>
        <div class="stat-box">
            <h3>{{ $statistics['verified'] ?? 0 }}</h3>
            <p>Terverifikasi</p>
        </div>
        <div class="stat-box">
            <h3>{{ $statistics['paid'] ?? 0 }}</h3>
            <p>Terbayar</p>
        </div>
        <div class="stat-box">
            <h3>Rp {{ number_format($statistics['total_payment'] ?? 0, 0, ',', '.') }}</h3>
            <p>Total Pembayaran</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">No Pendaftaran</th>
                <th width="15%">Nama Lengkap</th>
                <th width="15%">Email</th>
                <th width="10%">NIK</th>
                <th width="8%">NISN</th>
                <th width="5%">JK</th>
                <th width="12%">Jurusan</th>
                <th width="10%">Status</th>
                <th width="10%">Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $pendaftar)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $pendaftar->no_pendaftaran ?: '-' }}</td>
                <td>{{ $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama ?? '-' }}</td>
                <td>{{ $pendaftar->user->email ?? '-' }}</td>
                <td>{{ $pendaftar->dataSiswa->nik ?? '-' }}</td>
                <td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
                <td style="text-align: center;">{{ $pendaftar->dataSiswa->jk ?? '-' }}</td>
                <td>{{ $pendaftar->jurusan->nama ?? '-' }}</td>
                <td>
                    <span class="status status-{{ strtolower(str_replace('_', '-', $pendaftar->status)) }}">
                        {{ $status_texts[$pendaftar->status] ?? $pendaftar->status }}
                    </span>
                </td>
                <td>{{ $pendaftar->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; color: #666;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
        <p>Sistem PPDB Online - SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>