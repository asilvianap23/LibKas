<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            width: 794px;
            height: 1123px;
            background: url('{{ public_path('images/kwitansi.png') }}') no-repeat center center;
            height: 100vh;
            position: relative;
            background-size: cover;
        }
        .text {
            position: absolute;
            white-space: nowrap;
        }
        .instansi {
            top: 335px;
            left: 90px;
            width: 600px;
            font-size: 24px;
            font-weight: bold;
        }
        .tanggal {
            bottom: 465px;
            right: 200px;
            font-size: 19px;
        }
        .nominal {
            bottom: 225px;
            left: 200px;
            width: 600px;
            font-size: 20px;
            font-weight: bold;
        }
        .deskripsi {
            bottom: 550px;
            left: 90px;
            width: 600px;
            font-size: 24px;
            font-weight: bold;
        }
        .terbilang {
            top: 423px;
            left: 90px;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
        <div class="text instansi">{{ $kas->instansi }}</div>
        <div class="text terbilang">{{ ucwords(terbilang($kas->amount)) }} rupiah</div>
        <div class="text nominal">Rp. {{ number_format($kas->amount, 0, ',', '.') }}</div>
        <div class="text tanggal">{{ date('d/m/Y', strtotime($kas->created_at)) }}</div>
        <div class="text deskripsi">Iuran Keanggotaan FPPTMA tahun {{ date('Y', strtotime($kas->created_at)) }}</div>
</body>
</html>
