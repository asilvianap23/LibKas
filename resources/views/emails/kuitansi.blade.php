@component('mail::message')
# Kuitansi Pembayaran Anda

Halo {{ $payment->nama }},

Terima kasih atas pembayaran Anda untuk event **{{ $payment->event->nama_event }}**.

Silakan download kuitansi Anda yang terlampir pada email ini.

@component('mail::button', ['url' => url('/')])
Kunjungi Website
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
