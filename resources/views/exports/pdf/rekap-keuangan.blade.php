<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Keuangan PPDB</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
            @top-center {
                content: "REKAP KEUANGAN PPDB ONLINE";
                font-size: 10px;
                color: #666;
            }
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
            border-bottom: 3px solid #2c5aa0;
            position: relative;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-right: 20px;
        }
        
        .school-info h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #2c5aa0;
            text-transform: uppercase;
        }
        
        .school-info h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }
        
        .report-title {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
            color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }
        
        .report-title h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .report-title p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 15px;
        }
        
        .summary-card {
            flex: 1;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .summary-card .icon {
            font-size: 24px;
            color: #2c5aa0;
            margin-bottom: 10px;
        }
        
        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 5px;
        }
        
        .summary-card .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        
        .section-title {
            background: #f8f9fa;
            border-left: 4px solid #2c5aa0;
            padding: 12px 15px;
            margin: 30px 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            color: #2c5aa0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
            color: white;
            padding: 12px 10px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:hover {
            background-color: #e3f2fd;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .total-row {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            color: white;
            font-weight: bold;
        }
        
        .total-row td {
            border-bottom: none;
            padding: 15px 10px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #666;
        }
        
        .signature-section {
            text-align: right;
        }
        
        .signature-box {
            border: 1px solid #ddd;
            width: 150px;
            height: 80px;
            margin: 10px 0;
            display: inline-block;
            text-align: center;
            line-height: 80px;
            color: #999;
            font-style: italic;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(44, 90, 160, 0.05);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="watermark">PPDB ONLINE</div>
    
    <div class="header">
        <div class="logo-section">
            <div class="logo">🎓</div>
            <div class="school-info">
                <h1>SMK NEGERI 1 EXAMPLE</h1>
                <h2>Sistem Penerimaan Peserta Didik Baru</h2>
            </div>
        </div>
    </div>
    
    <div class="report-title">
        <h3>📊 LAPORAN REKAP KEUANGAN</h3>
        <p>Periode: {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }} | Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}</p>
    </div>
    
    <div class="summary-cards">
        <div class="summary-card">
            <div class="icon">💰</div>
            <div class="value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="label">Total Pemasukan</div>
        </div>
        <div class="summary-card">
            <div class="icon">📋</div>
            <div class="value">{{ $totalPembayaran }}</div>
            <div class="label">Total Pembayaran</div>
        </div>
        <div class="summary-card">
            <div class="icon">📈</div>
            <div class="value">Rp {{ $totalPembayaran > 0 ? number_format($totalPemasukan / $totalPembayaran, 0, ',', '.') : 0 }}</div>
            <div class="label">Rata-rata per Siswa</div>
        </div>
    </div>
    
    <div class="section-title">🌊 REKAP PER GELOMBANG PENDAFTARAN</div>
    <table>
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="40%">Nama Gelombang</th>
                <th width="20%">Jumlah Pembayaran</th>
                <th width="32%">Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapGelombang as $index => $rekap)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $rekap->nama_gelombang }}</td>
                <td class="text-center">{{ $rekap->jumlah_pembayaran }} siswa</td>
                <td class="text-right">Rp {{ number_format($rekap->total_pemasukan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2" class="text-center"><strong>TOTAL KESELURUHAN</strong></td>
                <td class="text-center"><strong>{{ $rekapGelombang->sum('jumlah_pembayaran') }} siswa</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($rekapGelombang->sum('total_pemasukan'), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div class="section-title">🎓 REKAP PER JURUSAN</div>
    <table>
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="40%">Nama Jurusan</th>
                <th width="20%">Jumlah Pembayaran</th>
                <th width="32%">Total Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapJurusan as $index => $rekap)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $rekap->nama_jurusan }}</td>
                <td class="text-center">{{ $rekap->jumlah_pembayaran }} siswa</td>
                <td class="text-right">Rp {{ number_format($rekap->total_pemasukan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2" class="text-center"><strong>TOTAL KESELURUHAN</strong></td>
                <td class="text-center"><strong>{{ $rekapJurusan->sum('jumlah_pembayaran') }} siswa</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($rekapJurusan->sum('total_pemasukan'), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <div>
            <strong>Dicetak pada:</strong> {{ date('d F Y, H:i') }} WIB<br>
            <strong>Sistem:</strong> PPDB Online v1.0
        </div>
        <div class="signature-section">
            <div>Mengetahui,</div>
            <div><strong>Kepala Bagian Keuangan</strong></div>
            <div class="signature-box">Tanda Tangan</div>
            <div><strong>(_________________)</strong></div>
        </div>
    </div>
</body>
</html>