<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class KasMasukMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kasData;

    public $path;
    
    public function __construct($kasData, $path)
    {
        $this->kasData = $kasData; // menerima parameter details dari storeKasMasuk
        $this->path = $path; // menerima parameter details dari storeKasMasuk
    }

    public function build()
    {
        $email = $this->subject('Detail Kas Masuk')
                     ->view('emails.kasMasukMail')
                     ->with('data', $this->kasData);

        $photoPath = $this->path;
        if (file_exists($photoPath)) {
            // Gunakan File::mimeType untuk mendapatkan MIME type
            $mimeType = File::mimeType($photoPath);

            $email->attach($photoPath, [
                'as' => basename($photoPath), 
                'mime' => $mimeType, 
            ]);
        }    
        
    
        return $email;
    }    
    
}
