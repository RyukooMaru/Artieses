<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikasiEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $kodeVerifikasi; // Variabel yang akan dikirim ke view

    public function __construct($kodeVerifikasi)
    {
        $this->kodeVerifikasi = $kodeVerifikasi;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Anda')
                    ->view('emails.verifikasi') // Pastikan nama view sesuai
                    ->with([
                        'kodeVerifikasi' => $this->kodeVerifikasi
                    ]);
    }
}
