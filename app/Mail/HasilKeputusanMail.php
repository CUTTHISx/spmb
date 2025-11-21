<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar;

class HasilKeputusanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;

    public function __construct(Pendaftar $pendaftar)
    {
        $this->pendaftar = $pendaftar;
    }

    public function build()
    {
        $subject = 'Pengumuman Hasil PPDB SMK Bakti Nusantara 666';
        
        return $this->subject($subject)
                    ->view('emails.hasil-keputusan')
                    ->with([
                        'pendaftar' => $this->pendaftar,
                        'nama' => $this->pendaftar->dataSiswa->nama_lengkap ?? $this->pendaftar->user->name,
                        'hasil' => $this->pendaftar->hasil_keputusan,
                        'catatan' => $this->pendaftar->catatan_keputusan,
                        'jurusan' => $this->pendaftar->jurusan->nama ?? '',
                    ]);
    }
}