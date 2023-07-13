<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Roofing Label</title>
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
            
        }
        .container {
            display: inline;
            height: 100%;
            width: 100%;
        }

        table td{
            margin: 0mm;
            padding: 0mm;
            padding-left: 1mm;
            padding-right: 1mm;
            /* border: 1px solid black; */
        }
        table{
            margin: 0mm;
            padding: 0mm;
            /* border: 1px solid black; */
            width: 100%;
        }

        .qrcode{
            text-align:right;
            vertical-align: bottom;
        }
        .nowrap{
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{asset('images/HENDOK-LOGO-FLAT BLACK.jpg')}}" alt="" style="width: 40%; margin-top: 1mm; margin-left: 1mm;margin-bottom: -0.5mm;"/>
        <table>
            <tr>
                <td><p>CUSTOMER:</p></td>
                <td colspan="2"><p>{{ $job[0]->strCustomerName }}</p></td>
            </tr>
            <tr>
                <td><p>SO#:</p></td>
                <td colspan="2"><p>{{ $job[0]->strRef }}</p></td>
            </tr>
            <tr>
                <td><p>TYPE:</p></td>
                <td><p>{{ $job[0]->strType }}</p></td>
                <td rowspan="5" class="qrcode">
                    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                </td>
            </tr>
            <tr>
                <td><p>THICKNESS:</p></td>
                <td><p>{{ $job[0]->strThickness }}</p></td>
            </tr>
            <tr>
                <td><p>LENGTH:</p></td>
                <td><p>{{ $job[0]->strLength }}</p></td>
            </tr>
            <tr>
                <td><p>PACK:</p></td>
                <td><p>{{ $job[0]->intPackSize }} SHEETS</p></td>
            </tr>
            <tr>
                <td><p>DATE:</p></td>
                <td class="nowrap"><p>{{ $job[0]->dteJobCreated }}</p></td>
            </tr>
        </table>
    </div>
</body>
</html>