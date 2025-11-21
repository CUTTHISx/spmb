<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PPDB - SMK BAKNUS 666</title>
    <style>
        @page { margin: 15mm; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; margin: 0; color: #333; line-height: 1.4; }
        
        .letterhead { text-align: center; margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; }
        .letterhead h1 { margin: 0; font-size: 24px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.3); }
        .letterhead h2 { margin: 8px 0 4px 0; font-size: 18px; font-weight: 500; }
        .letterhead h3 { margin: 4px 0; font-size: 16px; font-weight: 400; }
        .letterhead .date { margin-top: 15px; font-size: 13px; opacity: 0.9; }
        
        .info-section { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #667eea; }
        .info-section h3 { margin: 0 0 15px 0; font-size: 16px; color: #495057; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dotted #dee2e6; }
        .info-label { font-weight: 600; color: #495057; }
        .info-value { color: #6c757d; }
        
        .stats-container { margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .stat-card { background: white; border: 2px solid #e9ecef; border-radius: 10px; padding: 20px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card.primary { border-color: #667eea; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .stat-card.success { border-color: #28a745; }
        .stat-card.warning { border-color: #ffc107; }
        .stat-card.info { border-color: #17a2b8; }
        .stat-number { font-size: 28px; font-weight: bold; margin-bottom: 8px; }
        .stat-label { font-size: 13px; opacity: 0.8; }
        
        .table-container { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .table-header { background: #495057; color: white; padding: 15px 20px; }
        .table-header h3 { margin: 0; font-size: 16px; }
        
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #6c757d; color: white; padding: 12px 10px; text-align: left; font-size: 12px; font-weight: 600; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e9ecef; font-size: 11px; vertical-align: middle; }
        .data-table tr:nth-child(even) { background: #f8f9fa; }
        .data-table tr:hover { background: #e3f2fd; }
        
        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 600; text-transform: uppercase; }
        .status-draft { background: #6c757d; color: white; }
        .status-submitted { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .status-verified { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .footer-section { margin-top: 40px; }
        .legend-box { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; }
        .legend-box h4 { margin: 0 0 15px 0; font-size: 14px; color: #495057; }
        .legend-list { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 0; padding: 0; list-style: none; }
        .legend-item { padding: 8px 12px; background: white; border-radius: 5px; border-left: 3px solid #667eea; font-size: 11px; }
        .legend-item strong { color: #495057; }
        
        .signature { text-align: right; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; }
        .signature-text { font-size: 11px; color: #6c757d; font-style: italic; }
    </style>
</head>
<body>
    <div class="letterhead">
        <h1>LAPORAN DATA PENDAFTAR</h1>
        <h2>PENERIMAAN PESERTA DIDIK BARU (PPDB)</h2>
        <h3>SMK BAKNUS 666</h3>
        <div class="date">Dicetak pada: {{ date('d F Y, H:i:s') }} WIB</div>
    </div>

    <div class="info-section">
        <h3>📋 Informasi Laporan</h3>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <span class="info-label">Jurusan:</span>
                    <span class="info-value">{{ $filter_jurusan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Periode:</span>
                    <span class="info-value">{{ $periode }}</span>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-label">Gelombang:</span>
                    <span class="info-value">{{ $filter_gelombang }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Data:</span>
                    <span class="info-value">{{ $statistics['total'] }} pendaftar</span>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-number">{{ $statistics['total'] }}</div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
            <div class="stat-card success">
                <div class="stat-number">{{ $statistics['verified'] }}</div>
                <div class="stat-label">Terverifikasi</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-number">{{ $statistics['paid'] }}</div>
                <div class="stat-label">Terbayar</div>
            </div>
            <div class="stat-card info">
                <div class="stat-number">{{ number_format($statistics['total_payment']/1000000, 1) }}M</div>
                <div class="stat-label">Total Pembayaran</div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>📊 Data Pendaftar</h3>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%">#</th>
                    <th style="width: 22%">Nama Lengkap</th>
                    <th style="width: 20%">Email</th>
                    <th style="width: 12%">NIK</th>
                    <th style="width: 16%">Jurusan</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 8%">Tgl Daftar</th>
                    <th style="width: 6%">Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $p)
                <tr>
                    <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                    <td style="font-weight: 500;">{{ $p->dataSiswa->nama ?? $p->user->nama ?? '-' }}</td>
                    <td style="color: #6c757d;">{{ $p->user->email ?? '-' }}</td>
                    <td style="font-family: monospace;">{{ $p->dataSiswa->nik ?? '-' }}</td>
                    <td><strong>{{ $p->jurusan->nama ?? '-' }}</strong></td>
                    <td>
                        @php
                            $statusClass = match($p->status) {
                                'DRAFT' => 'status-draft',
                                'SUBMITTED' => 'status-submitted', 
                                'VERIFIED_ADM' => 'status-verified',
                                'REJECTED' => 'status-rejected',
                                default => 'status-draft'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $status_texts[$p->status] ?? $p->status }}
                        </span>
                    </td>
                    <td style="font-family: monospace; font-size: 10px;">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td style="text-align: center; font-size: 10px;">{{ $p->pembayaran ? '✓' : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer-section">
        <div class="legend-box">
            <h4>📝 Keterangan Status Pendaftar</h4>
            <ul class="legend-list">
                <li class="legend-item"><strong>Draft:</strong> Data belum lengkap</li>
                <li class="legend-item"><strong>Submitted:</strong> Menunggu verifikasi</li>
                <li class="legend-item"><strong>Terverifikasi:</strong> Data sudah diverifikasi</li>
                <li class="legend-item"><strong>Ditolak:</strong> Data tidak memenuhi syarat</li>
                <li class="legend-item"><strong>Terbayar:</strong> Pembayaran terkonfirmasi</li>
                <li class="legend-item"><strong>Simbol ✓:</strong> Sudah bayar</li>
            </ul>
        </div>
        
        <div class="signature">
            <div class="signature-text">
                📊 Laporan ini digenerate otomatis oleh Sistem PPDB SMK BAKNUS 666<br>
                🔒 Data akurat per {{ date('d F Y, H:i:s') }} WIB
            </div>
        </div>
    </div>
</body>
</html>