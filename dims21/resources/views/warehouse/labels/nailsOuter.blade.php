<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nails Outer Label</title>
    <style>
        body{
            margin: 0px;
        }
        
        @page {
            margin-top: 0mm; /* Adjust the top margin */
            margin-bottom: 0mm; /* Adjust the bottom margin */
            margin-left: 0mm; /* Adjust the left margin */
            margin-right: 0mm; /* Adjust the right margin */
        }
        p{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            margin-top: 0mm;
            margin-bottom: 0mm;
            font-size: 1mm;
            padding-bottom: 0.2mm;
            
        }
        .container {
            display: inline;
            height: 100%;
            width: 100%;
        }

        table {
            margin: 0;
            padding: 1mm;
            border-collapse: collapse;
            margin-top: -1mm;
            
        }
        td, th {
            padding: 0;
            white-space: nowrap;
            /* border: 0.1px solid black; */
        }

        .qrcode{
            text-align:right;
            vertical-align: bottom;
            padding-left: 1mm;
        }
        .barcode{
            max-width: 100%;
            height: auto;
            display: block;
            border: 0.1mm solid white;
        }
        .barcodeText{
            text-align:center;
        }
        .nowrap{
            white-space: nowrap;
        }
        .image{
            width: 35%; 
            margin-top: 0.5mm; 
            margin-left: 1mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{asset('images/HENDOK-LOGO-FLAT BLACK.jpg')}}" alt="" class="image"/>
        <table>
            <tr>
                <td colspan="3"><p>{{ $job[0]->strProduct }}</p></td>
            </tr>
            <tr>
                <td><p>PACK:</p></td>
                <td colspan="2"><p>{{ $job[0]->strPack }}</p></td>
            </tr>
            <tr>
                <td><p>SIZE:</p></td>
                <td colspan="2"><p>{{ $job[0]->strSize }}</p></td>
            </tr>
            <tr>
                <td><p>WEIGHT:</p></td>
                <td colspan="2"><p>{{ $job[0]->intWeight }}</p></td>
            </tr>
            <tr>
                <td><p>CODE:</p></td>
                <td colspan="2"><p>{{ $job[0]->strProductCode }}</p></td>
            </tr>
            <tr>
                <td colspan="2">
                    <img src="data:image/png;base64,{{ base64_encode($barcode) }}" alt="Barcode" class="barcode">
                    <p class="barcodeText">{{ $job[0]->strBarcode }}</p>
                </td>
                <tr>
                    <td class="qrcode">
                        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                    </td>
                </tr>
            </tr>
        </table>
    </div>
</body>
</html>