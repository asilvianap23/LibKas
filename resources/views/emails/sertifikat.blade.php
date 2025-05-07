<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <style>
        @page {
            size: A4 landscape; /* Pastikan ukuran sesuai */
            margin: 0;
        }
        body {
            width: 1123px;
            height: 794px;
            margin: 0;
            padding: 0;
            background: url('{{ public_path('images/sertifikat.png') }}') no-repeat center center;
            background-size: cover;
            position: relative;
        }
        .text {
            position: absolute;
            font-weight: bold;
            width: 100%;
        }
        .Instansi {
            top: 430px;
            left: 50%; 
            transform: translateX(-50%);
            font-size: 32px;
            text-align: center;
        }
        .nomor {
            top: 300px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            text-align: center;
        }
        .tahun {
            top: 572px;
            left: 650px;
            font-size: 28px;
        }
    </style>
</head>
<body>
    <div class="text Instansi">{{ $kas->instansi }}</div>
    <div class="text nomor">No. 2/FPPTMA/I/{{ date('Y', strtotime($kas->created_at)) }}</div>
    <div class="text tahun">{{ date('Y', strtotime($kas->created_at)) }}</div>
</body>
</html>
