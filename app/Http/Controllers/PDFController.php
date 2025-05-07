<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kas;
use App\Mail\SendPDFMail;

class PDFController extends Controller
{
    public function generatePDF($sertifikatId)
    {
        $sertifikat = Kas::findOrFail($sertifikatId);

        $pdfSertifikat = Pdf::loadView('emails.sertifikat', compact('sertifikat'));
        $pdfSertifikatPath = storage_path("app/public/sertifikat_{$sertifikat->id}.pdf");
        $pdfSertifikat->save($pdfSertifikatPath);


        $pdfKwitansi = Pdf::loadView('emails.kwitansi', compact('sertifikat'));
        $pdfKwitansiPath = storage_path("app/public/kwitansi_{$sertifikat->id}.pdf");
        $pdfKwitansi->save($pdfKwitansiPath);

        if (!empty($sertifikat->email)) {
            Mail::to($sertifikat->email)->send(new SendPDFMail($sertifikat, $pdfSertifikatPath, $pdfKwitansiPath));
        } else {
            return response()->json(['message' => 'Email tidak tersedia.'], 400);
        }

        return response()->json(['message' => 'PDF Sertifikat dan Kuitansi berhasil dikirim ke email.']);
    }
}
