<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <style>
        .styled-table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 0.9em;
            font-family: sans-serif;
        }
    </style>
</head>

<body style="margin: auto; width: 100%;">

    <div style="margin: 25px 0;">
        <div style="width:100%; margin: auto; text-align: center; margin-bottom: 20px; font-weight: bolder;">DATA
            SIMPANAN</div>
        <p><b>{{$niks}}</b></p>
        <table class="styled-table" style="width:100%">
            <thead>
                <tr style="background-color: cadetblue; height: 40px;">
                    <th style="text-align:left;">Tanggal Penyimpanan</th>
                    <th style="text-align:left;">Simpanan Wajib</th>
                    <th style="text-align:left;">Simpanan Sukarela</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($simpanan ?? '' as $data)
                    <tr style="border: 1px solid black; height: 25px;">
                        <td style="text-align:left;">{{ $data->Tgl_penyimpanan }}</td>
                        <td style="text-align:left;">@money($data->Simpanan_Pokok) </td>
                        <td style="text-align:left;">@money($data->Simpanan_Sukarela)</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="background-color:lightgray; height: 100px; right: 0; float: right; width: 50%; ">
        <table className="table">
            <tbody>
                <tr>
                    <th style="text-align:left;">Simpanan Pokok</th>
                    <td>:</td>
                    <td>@money($total->pokok)</td>
                </tr>
                <tr>
                    <th style="text-align:left;">Total Simpanan Wajib</th>
                    <td>:</td>
                    <td>@money($total->wajib)</td>
                </tr>
                <tr>
                    <th style="text-align:left;">Total Simpanan Sukarela</th>
                    <td>:</td>
                    <td>@money($total->sukarela)</td>
                </tr>
                <tr>
                    <th style="text-align:left;">Total</th>
                    <td>:</td>
                    <td>@money($total->totals)</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
