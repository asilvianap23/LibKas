<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPDFMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kas;
    public $pdfSertifikatPath;
    public $pdfKwitansiPath;
    
    public function __construct($kas, $pdfSertifikatPath, $pdfKwitansiPath)
    {
        $this->kas = $kas; 
        $this->pdfSertifikatPath = $pdfSertifikatPath;
        $this->pdfKwitansiPath = $pdfKwitansiPath;
    }
    
    public function build()
    {
        return $this->subject('Sertifikat dan Kwitansi Anda')
                    ->view('emails.templatesertifikat') // Template email utama
                    ->attach($this->pdfSertifikatPath, [
                        'as' => "sertifikat_{$this->kas->id}.pdf", // Gunakan $kas
                        'mime' => 'application/pdf',
                    ])
                    ->attach($this->pdfKwitansiPath, [
                        'as' => "kwitansi_{$this->kas->id}.pdf", // Gunakan $kas
                        'mime' => 'application/pdf',
                    ]);
    }
}

