<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Absensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .center {
            text-align: center
        }
        .has-border {
            border: 1px solid #797979;
            text-align: center;
        }
        h4,h5,p {
            margin: 0;
            padding: 0;
        }
        /* .photo {
            width: 190px;
            height: 190px;
            overflow: hidden;
        } */

        img {
            width: 185px;
            height: auto;
            margin-bottom: 10px;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div class="center">
        <h4>Data Absensi <br>
            {{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->locale('id')->translatedFormat('F') }}
            {{ \Carbon\Carbon::now()->year }}
        </h4>
    </div>
    <br><br>
    <table style="font-size: 12px">
        <tr>
            <td valign="bottom">
                <p>
                    {{ auth()->user()->name }} - {{ auth()->user()->nip }}
                </p>
                <p>Wilayah Binaan: {{ auth()->user()->wilayah_binaan }}</p>
            </td>
            <td align="right">
                <p>Kecamatan {{ auth()->user()->kecamatan }}</p>
                <p>Kabupaten {{ auth()->user()->kabupaten }}</p>
                <p>Provinsi {{ auth()->user()->provinsi }}</p>
            </td>
        </tr>
    </table>
    <br>
    <table class="has-border" cellspacing="0" cellpadding="3">
        <thead class="has-border">
            <tr class="has-border">
                <th class="has-border" width="10" rowspan="2" align="center">No</th>
                <th class="has-border" rowspan="2">Hari, Tanggal</th>
                <th class="has-border" colspan="2">Absen Pagi</th>
                <th class="has-border" colspan="2">Absen Sore</th>
            </tr>
            <tr class="has-border">
                <th class="has-border">Jam</th>
                <th class="has-border">Foto</th>
                <th class="has-border">Jam</th>
                <th class="has-border">Foto</th>
            </tr>
        </thead>
        <tbody class="has-border">
            @foreach ($absensi as $row)
            <tr class="has-border">
                <td class="has-border" align="center">{{ $loop->iteration }}</td>
                <td class="has-border">
                    {{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('l') }}, 
                    {{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('d F Y') }}
                </td>
                <td class="has-border">
                    {{ substr($row->clock_in,0,5) }}
                </td>
                <td class="has-border">
                    @if ($row->clock_in)
                    <div class="photo">
                        <img src="{{ public_path($row->foto_in) }}">
                    </div>
                    @endif
                </td>
                <td class="has-border">
                    {{ substr($row->clock_out,0,5) }}
                </td>
                <td class="has-border">
                    @if ($row->clock_out)
                    <div class="photo">
                        <img src="{{ public_path($row->foto_out) }}">
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>