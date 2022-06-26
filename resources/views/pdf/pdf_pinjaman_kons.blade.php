<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
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
            PINJAMAN KONSUMPTIF</div>
        <p><b>{{ $nama }}</b></p>
        <table class="styled-table" style="width:100%">
            <thead>
                <tr style="background-color: cadetblue; height: 40px;">
                    <th style="text-align:left;">Bulan</th>
                    <th style="text-align:left;">Cicilan</th>
                    <th style="text-align:left;">Bunga</th>
                    <th style="text-align:left;">Kredit</th>
                    <th style="text-align:left;">Kredit PRT</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($listpinjaman ?? '' as $data)
                    <tr style="border: 1px solid black; height: 25px;">
                        <td style="text-align:left;"><b>Total</b> {{ $data->Bulan }} Bulan</td>
                        <td style="text-align:left;">@money($data->Bunga) </td>
                        <td style="text-align:left;">@money($data->kredit_Kendaraan)</td>
                        <td style="text-align:left;">@money($data->Kredit_PRT)</td>
                        <td>{{ $data->Kode }}</td>

                    </tr>
                @endforeach

                @foreach ($total ?? '' as $data)
                    <tr style="border: 1px solid black; height: 25px; background-color:pink;font-weight:bolder;">
                        <td style="text-align:left;"><b>Total</b> {{ $data->Bulan }} Bulan</td>
                        <td style="text-align:left;">@money($data->Cicilan_pokok) </td>
                        <td style="text-align:left;">@money($data->Cicilan_bunga)</td>
                        <td style="text-align:left;">@money($data->Cicilan_total)</td>
                        <td style="text-align:left;">@money($data->Kredit_PRT)</td>
                        <td></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>

    </div>

</body>

</html>
