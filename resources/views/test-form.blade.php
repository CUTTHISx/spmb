<!DOCTYPE html>
<html>
<head>
    <title>Test Form Submit</title>
</head>
<body>
    <h1>Test Form Submit</h1>
    
    @if(session('success'))
        <div style="color: green; padding: 10px; background: #d4edda; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div style="color: red; padding: 10px; background: #f8d7da; margin: 10px 0;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form action="{{ url('/pendaftaran/store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <h3>Data Siswa</h3>
        <label>Jurusan:</label>
        <select name="jurusan_id" required>
            <option value="">Pilih</option>
            @foreach(\App\Models\Jurusan::all() as $j)
                <option value="{{ $j->id }}">{{ $j->nama }}</option>
            @endforeach
        </select><br><br>
        
        <label>NIK:</label>
        <input type="text" name="nik" value="1234567890123456" required><br><br>
        
        <label>NISN:</label>
        <input type="text" name="nisn" value="1234567890" required><br><br>
        
        <label>Nama:</label>
        <input type="text" name="nama" value="Test User" required><br><br>
        
        <label>Jenis Kelamin:</label>
        <select name="jk" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select><br><br>
        
        <label>Tempat Lahir:</label>
        <input type="text" name="tmp_lahir" value="Bandung" required><br><br>
        
        <label>Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" value="2010-01-01" required><br><br>
        
        <label>Alamat:</label>
        <textarea name="alamat" required>Jl. Test No. 123</textarea><br><br>
        
        <label>Wilayah:</label>
        <select name="wilayah_id" required>
            @foreach(\App\Models\Wilayah::all() as $w)
                <option value="{{ $w->id }}">{{ $w->kelurahan }}</option>
            @endforeach
        </select><br><br>
        
        <h3>Data Orang Tua</h3>
        <label>Nama Ayah:</label>
        <input type="text" name="nama_ayah" value="Ayah Test"><br><br>
        
        <label>Nama Ibu:</label>
        <input type="text" name="nama_ibu" value="Ibu Test"><br><br>
        
        <h3>Asal Sekolah</h3>
        <label>Nama Sekolah:</label>
        <input type="text" name="nama_sekolah" value="SMP Test" required><br><br>
        
        <h3>Upload Berkas</h3>
        <label>Ijazah:</label>
        <input type="file" name="ijazah" required><br><br>
        
        <label>KK:</label>
        <input type="file" name="kk" required><br><br>
        
        <label>Akta:</label>
        <input type="file" name="akta" required><br><br>
        
        <label>Foto:</label>
        <input type="file" name="foto" required><br><br>
        
        <button type="submit">Submit Test</button>
    </form>
</body>
</html>
