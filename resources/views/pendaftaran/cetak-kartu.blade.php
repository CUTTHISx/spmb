<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Peserta PPDB</title>
    <style>
        @page { margin: 20mm; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .kartu { width: 85mm; height: 54mm; border: 2px solid #333; border-radius: 8px; padding: 8mm; margin: 0 auto; position: relative; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
        .header { text-align: center; margin-bottom: 8px; }
        .logo { font-size: 16px; font-weight: bold; color: #2563eb; }
        .title { font-size: 10px; color: #666; margin-top: 2px; }
        .content { font-size: 9px; line-height: 1.4; }
        .field { margin-bottom: 3px; }
        .label { font-weight: bold; color: #333; }
        .value { color: #555; }
        .no-pendaftaran { background: #2563eb; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold; font-size: 8px; }
        .footer { position: absolute; bottom: 5px; right: 8px; font-size: 7px; color: #999; }
        .qr-placeholder { position: absolute; top: 8px; right: 8px; width: 20mm; height: 20mm; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 6px; color: #999; }
    </style>
</head>
<body>
    <div class="kartu">
        <div class="qr-placeholder">QR CODE</div>
        
        <div class="header">
            <div class="logo">SMK BAKTI NUSANTARA 666</div>
            <div class="title">KARTU PESERTA PPDB {{ date('Y') }}</div>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="label">No. Pendaftaran:</span>
                <span class="no-pendaftaran">{{ $pendaftar->no_pendaftaran }}</span>
            </div>
            
            <div class="field">
                <span class="label">Nama:</span>
                <span class="value">{{ $pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama }}</span>
            </div>
            
            <div class="field">
                <span class="label">Jurusan:</span>
                <span class="value">{{ $pendaftar->jurusan->nama ?? '-' }}</span>
            </div>
            
            <div class="field">
                <span class="label">Tgl. Daftar:</span>
                <span class="value">{{ $pendaftar->created_at->format('d/m/Y') }}</span>
            </div>
            
            <div class="field">
                <span class="label">Status:</span>
                <span class="value">{{ $pendaftar->status }}</span>
            </div>
        </div>
        
        <div class="footer">
            Dicetak: {{ date('d/m/Y H:i') }}
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>