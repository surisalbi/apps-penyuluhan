<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Screenshot</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .center {
            text-align: center;
        }

        .container {
            width: 100%;
            margin-bottom: 20px;
            /* JANGAN pakai overflow hidden */
        }

        .box {
            float: left;
            width: 25%;      /* aman */
            margin-bottom: 15px;
        }

        .box:nth-child(4n) {
            margin-right: 0;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 6px;
            text-align: center;
            padding-bottom: 5px;
            margin: 10px;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 6px 6px 0 0;
        }

        .title {
            display: block;
            font-size: 14px;
            margin: 8px 0;
        }

        .clearfix {
            clear: both;
        }

    </style>


</head>
<body>
    <div class="center">
        <h4>Data Screenshot <br>
            {{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->locale('id')->translatedFormat('F') }}
            {{ \Carbon\Carbon::now()->year }}
        </h4>
    </div>
    <br>
    <span style="font-size: 13px">
        <b>Screenshot Like</b>
    </span>
    <div class="container">
    @foreach ($like_upload as $index => $row)
        <div class="box">
            <div class="card">
                <img src="{{ public_path($row->screenshot) }}">
                <span class="title">{{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        @if (($index + 1) % 4 == 0)
        <div class="clearfix"></div>
        @endif
        @endforeach
        <div class="clearfix"></div>
    </div>
    <br><br>

    <span style="font-size: 13px">
        <b>Screenshot Comment</b>
    </span>
    <div class="container">
    @foreach ($comment_upload as $index => $row)
        <div class="box">
            <div class="card">
                <img src="{{ public_path($row->screenshot) }}">
                <span class="title">{{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        @if (($index + 1) % 4 == 0)
        <div class="clearfix"></div>
        @endif
        @endforeach
        <div class="clearfix"></div>
    </div>
    <br><br>

    <span style="font-size: 13px">
        <b>Screenshot Comment</b>
    </span>
    <div class="container">
    @foreach ($share_upload as $index => $row)
        <div class="box">
            <div class="card">
                <img src="{{ public_path($row->screenshot) }}">
                <span class="title">{{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        @if (($index + 1) % 4 == 0)
        <div class="clearfix"></div>
        @endif
        @endforeach
        <div class="clearfix"></div>
    </div>

</body>
</html>