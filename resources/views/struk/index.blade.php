<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 148mm;
            height: 210mm;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .struk {
            text-align: center;
        }
        .info {
            text-align: left;
            margin-top: 20px;
        }
        .info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total {
            font-weight: bold;
        }
        .separator {
            border-top: 2px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="struk">
        <h3>{{ $bayar->nmr_struk }}</h3>
        <p>4 February 2025</p>
        <div class="separator"></div>
        <div class="info">
            <div><span>No Lambung :</span> <span>{{ $bayar->no_lambung }}</span></div>
            <div><span>No Polisi :</span> <span>{{ $bayar->no_polisi }}</span></div>
            <div><span>Nama Driver :</span> <span>{{ $bayar->driver }}</span></div>
        </div>
        <div class="separator"></div>
        <div class="info">
            <div><span>Area :</span> <span>CHP1-SEL / 150.000</span></div>
            <div><span>Tonase :</span> <span>11.98</span></div>
            <div class="total"><span>Total Bayar :</span> <span>1.797.000</span></div>
            <div><span>Potongan 1 :</span> <span>5.000</span></div>
            <div><span>Potongan 2 :</span> <span>20.000</span></div>
        </div>
        <div class="separator"></div>
        <div class="info">
            <div class="total"><span>Jumlah Bayar :</span> <span>1.772.000</span></div>
            <div><span>No Rekening :</span> <span>24901016843535</span></div>
        </div>
        <div class="separator"></div>
        <p><strong>CV. ELLY MANDIRI</strong></p>
    </div>
</body>
</html>
