<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Pendaftaran PPDB - {{ $pendaftar->no_pendaftaran }}</title>
    <style>
        @page { margin: 15mm; size: A4; }
        * { box-sizing: border-box; }
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        
        .kartu {
            width: 85mm;
            height: 54mm;
            border: 2px solid #000;
            margin: 20px auto;
            position: relative;
            background: #ffffff;
            overflow: hidden;
        }
        
        /* Header Sekolah */
        .header-sekolah {
            text-align: center;
            padding: 3mm 4mm 2mm 4mm;
            border-bottom: 2px solid #000;
            background: #f8f9fa;
        }
        
        .logo-sekolah {
            width: 8mm;
            height: 8mm;
            background: #007bff;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 1mm;
            position: relative;
        }
        
        .logo-sekolah::after {
            content: "🏫";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4mm;
        }
        
        .nama-sekolah {
            font-size: 9px;
            font-weight: bold;
            color: #000;
            margin: 1mm 0;
            text-transform: uppercase;
        }
        
        .judul-kartu {
            font-size: 7px;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Foto Pendaftar */
        .foto-pendaftar {
            position: absolute;
            top: 15mm;
            right: 3mm;
            width: 18mm;
            height: 24mm;
            border: 1px solid #000;
            background: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 6px;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }
        
        /* Informasi Pendaftar */
        .informasi-pendaftar {
            padding: 2mm 3mm;
            margin-right: 20mm;
        }
        
        .field {
            margin-bottom: 1.5mm;
            display: flex;
            font-size: 6.5px;
            line-height: 1.2;
        }
        
        .label {
            min-width: 22mm;
            color: #000;
            font-weight: normal;
        }
        
        .colon {
            margin: 0 1mm;
            color: #000;
        }
        
        .value {
            color: #000;
            font-weight: bold;
            flex: 1;
        }
        
        .no-registrasi {
            background: #007bff;
            color: white;
            padding: 1mm 2mm;
            border-radius: 2mm;
            font-weight: bold;
            font-size: 6px;
        }
        
        /* Detail Output Tambahan */
        .detail-tambahan {
            position: absolute;
            bottom: 8mm;
            left: 3mm;
            right: 3mm;
            border-top: 1px solid #ddd;
            padding-top: 1mm;
        }
        
        .tanggal-cetak {
            font-size: 5px;
            color: #666;
            text-align: left;
        }
        
        .no-verifikasi {
            font-size: 5px;
            color: #666;
            text-align: right;
            margin-top: 0.5mm;
        }
        
        .qr-code {
            position: absolute;
            bottom: 2mm;
            right: 3mm;
            width: 8mm;
            height: 8mm;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4px;
            color: #999;
            background: #f9f9f9;
        }
        
        /* Footer */
        .footer {
            position: absolute;
            bottom: 1mm;
            left: 3mm;
            right: 12mm;
            font-size: 4.5px;
            color: #666;
            line-height: 1.2;
        }
        
        .website {
            color: #007bff;
            font-weight: bold;
        }
        
        @media print {
            body { background: white; }
            .kartu { box-shadow: none; margin: 0 auto; }
        }
    </style>
</head>
<body>
    <div class="kartu">
        <!-- Header Sekolah -->
        <div class="header-sekolah">
            <div class="logo-sekolah"></div>
            <div class="nama-sekolah">SMK BAKTI NUSANTARA 666</div>
            <div class="judul-kartu">Kartu Pendaftaran PPDB {{ date('Y') }}</div>
        </div>
        
        <!-- Foto Pendaftar -->
        <div class="foto-pendaftar">
            FOTO<br>3x4
        </div>
        
        <!-- Informasi Pendaftar -->
        <div class="informasi-pendaftar">
            <div class="field">
                <span class="label">Jenis Seleksi</span>
                <span class="colon">:</span>
                <span class="value">PPDB REGULER</span>
            </div>
            
            <div class="field">
                <span class="label">Jurusan Dipilih</span>
                <span class="colon">:</span>
                <span class="value">{{ strtoupper($pendaftar->jurusan->nama ?? 'BELUM DIPILIH') }}</span>
            </div>
            
            <div class="field">
                <span class="label">No. Registrasi</span>
                <span class="colon">:</span>
                <span class="no-registrasi">{{ $pendaftar->no_pendaftaran }}</span>
            </div>
            
            <div class="field">
                <span class="label">Email</span>
                <span class="colon">:</span>
                <span class="value">{{ $pendaftar->user->email ?? 'BELUM DIISI' }}</span>
            </div>
            
            <div class="field">
                <span class="label">Nama Lengkap</span>
                <span class="colon">:</span>
                <span class="value">{{ strtoupper($pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->user->name ?? 'BELUM DIISI') }}</span>
            </div>
            
            <div class="field">
                <span class="label">Jenis Kelamin</span>
                <span class="colon">:</span>
                <span class="value">{{ $pendaftar->dataSiswa->jk ?? 'BELUM DIISI' }}</span>
            </div>
            
            <div class="field">
                <span class="label">Gelombang</span>
                <span class="colon">:</span>
                <span class="value">{{ strtoupper($pendaftar->gelombang->nama ?? 'GELOMBANG 1') }}</span>
            </div>
        </div>
        
        <!-- Detail Output Tambahan -->
        <div class="detail-tambahan">
            <div class="tanggal-cetak">
                Dicetak: {{ date('d/m/Y H:i') }} WIB
            </div>
            <div class="no-verifikasi">
                No. Verifikasi: {{ strtoupper(substr(md5($pendaftar->id . date('Y-m-d')), 0, 8)) }}
            </div>
        </div>
        
        <!-- QR Code -->
        <div class="qr-code">
            QR
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <strong>PENTING:</strong> Bawa kartu ini saat verifikasi berkas<br>
            <span class="website">www.smkbaktinusantara666.sch.id</span> | Tel: (021) 123-4567
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>