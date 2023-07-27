<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Barbed Wire Label</title>
    <style>
        html, body {
            margin: 0;
            height: 100%;
        }
        
        @page {
            margin-top: 0mm;
            margin-bottom: 0mm;
            margin-left: 0mm;
            margin-right: 0mm;
        }
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        p {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            margin: 0;
            font-size: 1.5mm; /* Adjust the font size as needed */
        }
        
        .container {
            display: flex;
            height: 100%;
            width: 100%;
            page-break-inside: avoid; /* Prevent container from breaking across pages */
        }

        table {
            margin: 0;
            padding: 1mm;
            border-collapse: collapse;
            height: 80%;
        }

        td, th {
            padding: 0;
            white-space: nowrap;
        }

        .qrcode {
            text-align: right;
            vertical-align: bottom;
            padding-left: 1mm;
        }

        .barcode {
            max-width: 100%;
            height: auto;
            display: block;
            border: 0.1mm solid white;
        }

        .barcodeText {
            text-align: center;
        }

        .nowrap {
            white-space: nowrap;
        }

        .image {
            width: 35%; 
            margin-top: 0.5mm; 
            margin-left: 1mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <td colspan="2"><p>&nbsp;</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p>&nbsp;</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p>&nbsp;</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p>{{ $job[0]->strProductGroup }}</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p>{{ $job[0]->strProductDescription }}</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p>{{ $job[0]->strCoating }}</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td><p>OPERATIOR: {{ $job[0]->strOperator }}</p></td>
                <td><p style="margin-left: 1mm;">SHIFT: ______________</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="2"><p style="font-size: 1mm; text-align: center;">{{ $job[0]->dteJobCreated }}</p></td>
                <td><p>&nbsp;</p></td>
            </tr>
            <tr>
                <td>
                    <img src="data:image/png;base64,{{ base64_encode($barcode) }}" alt="Barcode" class="barcode">
                    <p class="barcodeText">{{ $job[0]->strBarcode }}</p>
                    <td><p>&nbsp;</p></td>
                </td>
                <td class="qrcode">
                    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                </td>
                <td><p>&nbsp;</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
