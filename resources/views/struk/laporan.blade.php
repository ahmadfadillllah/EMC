<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f4f7f6; */
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            margin: 50px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        th,
        td {
            padding: 8px 20px;
            text-align: center;
        }

        th {
            background-color: #0B3C40FF;
            color: white;
            border: 1px solid black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td {
            border-bottom: 1px solid #ddd;
            border: 1px solid black;
        }

        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th,
            td {
                font-size: 12px;
                padding: 10px;
            }
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                font-family: Arial, sans-serif;
            }

            table {
                width: 100%;
            }

            th, td {
                font-size: 10px;
            }
        }
    </style>

</head>

<body>
    @php
        $totalBayar = 0;
    @endphp

    <h2 style="text-align: center; margin-top: 20px;"><u>Laporan Pembayaran</u></h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Struk</th>
                <th>Tgl Bayar</th>
                <th>Muat</th>
                <th>Bongkar</th>
                <th>No Lambung</th>
                <th>Area</th>
                <th>Tonase</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bayar as $item)
            @php
                $totalBayar = $item->harga - $item->potongan1 - $item->potongan2 - $item->potongan_dll;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nmr_struk }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_bayar)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_muat)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_bongkar)->format('d-m-Y') }}</td>
                <td>{{ $item->no_lambung }}</td>
                <td>{{ $item->area }}</td>
                <td>{{ $item->tonase }}</td>
                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($totalBayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
