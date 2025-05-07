<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KuitansiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $pdfContent;

    public function __construct(Payment $payment, $pdfContent)
    {
        $this->payment = $payment;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Kuitansi Pembayaran Event: ' . $this->payment->event->nama_event)
                    ->markdown('emails.kuitansi')
                    ->attachData($this->pdfContent, 'Kuitansi_' . $this->payment->nama . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
