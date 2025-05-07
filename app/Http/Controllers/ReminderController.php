<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    public function index()
    {
        return view('reminder.index');
    }

    public function sendReminder(Request $request)
    {
        if ($request->has('verified_only') && $request->verified_only == 'no') {
            $users = User::whereHas('kas', function ($query) {
                $query->whereNull('verified_at'); 
            })->get();
        } else {
            $users = User::all();
        }

        foreach ($users as $user) {
            Mail::raw('Dengan hormat, kami mengingatkan Bapak/Ibu untuk melakukan pembayaran iuran kas FPPTMA tahun'.date('Y').'Dukungan dan partisipasi Bapak/Ibu sangat kami hargai demi kelancaran kegiatan organisasi. ', function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reminder Pembayaran');
            });
        }

        return redirect()->route('reminder.index')->with('success', 'Pengingat berhasil dikirim!');
    }
}
