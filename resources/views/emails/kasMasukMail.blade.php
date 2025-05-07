<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Laporan Kas FPPTMA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h1 {
            font-size: 20px;
            color: #333;
        }
        p {
            font-size: 14px;
            color: #555;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .data-table td:first-child {
            font-weight: bold;
            color: #333;
            width: 30%;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Data sudah kami terima, terima kasih telah mengirimkan bukti pembayaran kas.</p>
        <h1>Detail Data Kas Masuk</h1>
        <table class="data-table">
            <tr>
                <td>Jumlah</td>
                <td>Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td>{{ $data['instansi'] }}</td>
            </tr>
            <tr>
                <td>PIC</td>
                <td>{{ $data['pic'] }}</td>
            </tr>
            <tr>
                <td>WhatsApp</td>
                <td>{{ $data['wa'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>{{ $data['description'] }}</td>
            </tr>
            <tr>
                <td>Bukti Pembayaran</td>
                <td>Terlampir dalam email ini</td>
            </tr>
        </table>
        <p class="footer">Tunggu email balasan untuk bukti jika kas sudah diverifikasi oleh petugas.</p>
    </div>
</body>
</html>
