<?php

use App\Mail\KasMasukNotificaion; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublikasiController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/event-public', [EventController::class, 'public'])->name('event.public');
Route::get('event/{id}/daftar', [PaymentController::class, 'create'])->name('public.event.daftar');
Route::post('event/{id}/pay', [PaymentController::class, 'store'])->name('public.payment.store');
// Rute untuk user (user bisa mengakses profil dan kas masuk)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::post('/kas', [KasController::class, 'store'])->name('kas.store');
    Route::get('/kas/verifikasi', [KasController::class, 'showKasMasuk'])->name('kas.masuk.index');
    Route::post('/kas/verifikasi', [KasController::class, 'storeKasMasuk'])->name('kas.masuk.store');

    // Anggota routes for user
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::resource('publikasi', PublikasiController::class)->except(['index', 'show']);
    Route::get('publikasi/create/{anggotaId}', [PublikasiController::class, 'create'])->name('publikasi.create');
    Route::post('publikasi/store/{anggotaId}', [PublikasiController::class, 'store'])->name('publikasi.store');
    Route::get('publikasi/edit/{id}', [PublikasiController::class, 'edit'])->name('publikasi.edit');
    Route::put('publikasi/update/{id}', [PublikasiController::class, 'update'])->name('publikasi.update');
    Route::delete('publikasi/destroy/{id}', [PublikasiController::class, 'destroy'])->name('publikasi.destroy');
    Route::get('publikasi/{id}', [PublikasiController::class, 'show'])->name('publikasi.show');


    Route::get('/dataKas', [KasController::class, 'dataKas'])->name('dataKas');

    Route::get('/kas/{id}/download-sertifikat', [KasController::class, 'downloadSertifikat'])->name('kas.downloadSertifikat');
    Route::get('/kas/{id}/download-kwitansi', [KasController::class, 'downloadKwitansi'])->name('kas.downloadKwitansi');

    // Event untuk user
    Route::get('/user/events', [EventController::class, 'userIndex'])->name('user.event.index');
    Route::get('user/events/{id}', [EventController::class, 'userShow'])->name('user.event.show');

    Route::get('event/{id}/bayar', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('event/{id}/bayar', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('payment/{payment}/download', [PaymentController::class, 'downloadKuitansi'])
    ->middleware('auth')
    ->name('kuitansi.download');

});
// Route untuk Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    

    // Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/sertifikat/{id}', [PDFController::class, 'generatePDF']);
    Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF']);

    
    Route::patch('/kas/verifikasi/{id}/verify', [KasController::class, 'verifyKasMasuk'])->name('kas.masuk.verify');
    Route::patch('/kas/verifikasi/{id}/reject', [KasController::class, 'rejectKasMasuk'])->name('kas.masuk.reject');

    Route::get('/kas/keluar', [KasController::class, 'showKasKeluar'])->name('kas.keluar.index');
    Route::post('/kas/keluar', [KasController::class, 'storeKasKeluar'])->name('kas.keluar.store');

    Route::get('/laporan/kas-masuk', [KasController::class, 'laporanKasMasuk'])->name('laporan.kasMasuk');
    Route::get('/laporan/kas-keluar', [KasController::class, 'laporanKasKeluar'])->name('laporan.kasKeluar');

    Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
    Route::post('/reminder/send', [ReminderController::class, 'sendReminder'])->name('reminder.send');
    Route::post('/reminder/all', [ReminderController::class, 'sendToAll'])->name('reminder.send.all');
    Route::post('/reminder/unverified', [ReminderController::class, 'sendToUnverified'])->name('reminder.send.unverified');

    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create'); // <--- Ini route tambah
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');


});

require __DIR__.'/auth.php'; 
