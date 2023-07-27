<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Galv Label</title>
    <style>
        body{
            margin: 0px;
            zoom: 500;
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
            font-size: 1.2mm
            
        }
        .container {
            display: inline;
            height: 100%;
        }

        .left-panel {
            width: 70%;
            height: 100vh;
            float: left;
            box-sizing: border-box;
            padding: 1mm;
            /* background-color: #f0f0f0; */
        }

        .right-panel {
            margin-left: 70%;
            width: 30%;
            height: 100vh;
            float: right;
            box-sizing: border-box;
            /* background-color: #d0d0d0; */
        }
        tr td{
            margin: 0mm;
            padding: 0mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <table>
                <tr>
                    <td><p>CUSTOMER:</p></td>
                    <td><p>{{ $job[0]->Customer }}</p></td>
                </tr>
                <tr>
                    <td><p>PRODUCT:</p></td>
                    <td><p>{{ $job[0]->ProductName }}</p></td>
                </tr>
                <tr>
                    <td><p>MPA:</p></td>
                    <td><p>{{ $job[0]->TreatedMPA }}</p></td>
                </tr>
                <tr>
                    <td><p>CODE:</p></td>
                    <td><p>{{ $job[0]->SECode }}</p></td>
                </tr>
                <tr>
                    <td><p>MASS:</p></td>
                    <td><p>{{ $job[0]->Weight }}</p></td>
                </tr>
                <tr>
                    <td><p>OPERATOR:</p></td>
                    <td><p>{{ $job[0]->Operator }}</p></td>
                </tr>
                <tr>
                    <td><p>DATE:</p></td>
                    <td><p>{{ $job[0]->DateTime }}</p></td>
                </tr>
                <tr>
                    <td><p>TICKET:</p></td>
                    <td><p>{{ $job[0]->TicketNo }}</p></td>
                </tr>
            </table>
        </div>
        <div class="right-panel">
            <p style="font-size: 1.5mm !important; margin-top: 1mm; margin-bottom:1mm; text-align: center;">{{ $job[0]->strStatus }} &nbsp;</p>
            <div>
                <img src="{{asset('images/hdkLogo.png')}}" alt="" style="margin-bottom: 1mm; width: 60%; margin-left: 1.8mm;"/>
                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" style=" margin-left: 1.4mm;">
                {{-- <img src="{{asset('images/hdkLogo.png')}}" alt="" style="width:60%; padding-left: 2mm; padding-top:1mm;"/> --}}
            </div>
            
        </div>
    </div>
</body>
</html>