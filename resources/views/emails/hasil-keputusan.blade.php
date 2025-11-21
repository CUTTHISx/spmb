<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Hasil PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: #1e40af; color: white; padding: 20px; text-align: center; }
        .logo { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px; }
        .result-box { padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .lulus { background: #dcfce7; border: 2px solid #16a34a; color: #15803d; }
        .tidak-lulus { background: #fef2f2; border: 2px solid #dc2626; color: #dc2626; }
        .cadangan { background: #fef3c7; border: 2px solid #d97706; color: #d97706; }
        .result-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .info-table td { padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .info-table .label { font-weight: bold; width: 40%; }
        .catatan { background: #f8fafc; padding: 15px; border-radius: 6px; margin: 15px 0; border-left: 4px solid #3b82f6; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
        .btn { display: inline-block; padding: 12px 24px; background: #1e40af; color: white; text-decoration: none; border-radius: 6px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🏫 SMK BAKTI NUSANTARA 666</div>
            <div class="subtitle">Pengumuman Hasil PPDB {{ date('Y') }}</div>
        </div>
        
        <div class="content">
            <h2>Kepada Yth. {{ $nama }}</h2>
            <p>Dengan hormat,</p>
            <p>Berdasarkan hasil seleksi PPDB SMK Bakti Nusantara 666 Tahun {{ date('Y') }}, dengan ini kami sampaikan hasil keputusan sebagai berikut:</p>
            
            <table class="info-table">
                <tr>
                    <td class="label">Nomor Pendaftaran</td>
                    <td>: {{ $pendaftar->no_pendaftaran }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td>: {{ $nama }}</td>
                </tr>
                <tr>
                    <td class="label">Jurusan Pilihan</td>
                    <td>: {{ $jurusan }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Keputusan</td>
                    <td>: {{ $pendaftar->tgl_keputusan ? \Carbon\Carbon::parse($pendaftar->tgl_keputusan)->format('d F Y') : date('d F Y') }}</td>
                </tr>
            </table>
            
            @if($hasil == 'LULUS')
                <div class="result-box lulus">
                    <div class="result-title">🎉 SELAMAT! ANDA DITERIMA</div>
                    <p>Anda dinyatakan <strong>LULUS</strong> dan diterima di SMK Bakti Nusantara 666</p>
                </div>
                
                <h3>📋 Langkah Selanjutnya:</h3>
                <ul>
                    <li>Lakukan daftar ulang paling lambat 7 hari setelah pengumuman</li>
                    <li>Siapkan berkas asli untuk verifikasi</li>
                    <li>Datang ke sekolah sesuai jadwal yang ditentukan</li>
                    <li>Bawa surat keterangan lulus dari sekolah asal</li>
                </ul>
                
            @elseif($hasil == 'TIDAK_LULUS')
                <div class="result-box tidak-lulus">
                    <div class="result-title">😔 MOHON MAAF</div>
                    <p>Anda dinyatakan <strong>TIDAK LULUS</strong> dalam seleksi PPDB ini</p>
                </div>
                
                <p>Jangan berkecil hati! Anda dapat mencoba mendaftar di gelombang berikutnya atau sekolah lain yang sesuai dengan minat dan bakat Anda.</p>
                
            @else
                <div class="result-box cadangan">
                    <div class="result-title">⏳ DAFTAR CADANGAN</div>
                    <p>Anda masuk dalam <strong>DAFTAR CADANGAN</strong></p>
                </div>
                
                <p>Anda akan dipanggil jika ada peserta yang mengundurkan diri. Pantau terus pengumuman selanjutnya melalui website atau email.</p>
            @endif
            
            @if($catatan)
                <div class="catatan">
                    <strong>📝 Catatan:</strong><br>
                    {{ $catatan }}
                </div>
            @endif
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/dashboard/pendaftar') }}" class="btn">Lihat Dashboard</a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>SMK Bakti Nusantara 666</strong></p>
            <p>Jl. Pendidikan No. 123, Jakarta | Tel: (021) 123-4567</p>
            <p>Email: info@smkbaktinusantara666.sch.id | www.smkbaktinusantara666.sch.id</p>
            <p style="margin-top: 15px; font-size: 11px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>