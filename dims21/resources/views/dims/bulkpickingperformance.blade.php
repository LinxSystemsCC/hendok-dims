<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="60">
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

    <style>
        .rag-red {
            background-color: lightcoral;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body>
<div style="background: black;color:white;">
<table class="table">
    <tbody>
    <tr>
        <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
        <td style="color:#efefef;font-size: 20px;font-family: sans-serif;font-weight: 900;">PLANNED <input id="totalplanned" style="color: black"> </td>
        <td style="color:#efefef;font-size: 20px;font-family: sans-serif;font-weight: 900;">PICKED<input id="totalpicked" style="color: black"> </td>
        <td style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;"> </td>
    </tr></tbody>
</table>
    <table class="table" id="livepickingtable">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Time Generated</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Reference</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Route</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Trailor/Truck Type</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">Team Leader</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">T.Start</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">T.End</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Planned</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Picked</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Load Efficiency</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Driver/Horse Assigned</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Truck Extras Assigned</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">WB Ticket Assigned</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Ready To Process</th>
        <th style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;">Status</th>
        </thead>
        <?php $totalplanned = 0; $totalpicked = 0; ?>
        <tbody style="font-size: 21px;font-family: sans-serif;font-weight: 900;">
        @foreach($performance as $val)
            @if( $val->blnAttended =="NOT STARTED")
            <tr style="background: red;color: black">@endif
            @if( $val->blnAttended =="PROGRESS")
            <tr style="background: yellow;color: black" >
            @endif
            @if( $val->blnAttended =="DONE")
                <tr style="background: green;color: black" >
                    @endif
                <td style="font-size: 12px;">{{$val->dteTimeCreated}}   </td>
                <td style="font-size: 9px;">{{$val->strUnickReference}}</td>
                <td>{{$val->strPickingNickname}}</td>
                <td>{{$val->trucktrailortype}}</td>
                <td>{{$val->TeamLeader}}</td>
                <td>{{$val->startPicking}}</td>
                <td>{{$val->endPicking}}</td>
                <td>{{$val->weightsPlnned}}</td>
                <td>{{$val->picked}}</td>
                <td>{{$val->Effeciency}}</td>
                    @if( $val->truckAssigned =="YES")
                     <td style="background: #0BA008"> </td>
                    @else
                        <td style="background: darkred">-</td>
                    @endif
                    @if( $val->isextraThere =="YES")
                        <td style="background: #0BA008"> </td>
                    @else
                        <td style="background: darkred">-</td>
                    @endif
                    @if( $val->WBAssigned =="YES")
                        <td style="background: #0BA008"> </td>
                    @else
                        <td style="background: darkred">-</td>
                    @endif
                    @if( $val->readyToProcess =="YES")
                        <td style="background: #0BA008"> </td>
                    @else
                        <td style="background: darkred">-</td>
                    @endif
                <td>{{$val->blnAttended}}</td>
                    <?php $totalplanned = $totalplanned + $val->weightsPlnned ; $totalpicked = $totalpicked+ $val->picked; ?>

            </tr>

        @endforeach

                <tr>        <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">T </td>
                    <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;"> </td>
                    <td style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;"><input id="totalplannedtt" value="{{$totalplanned}}" style="color: black;width: 97px;"> </td>
                    <td style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;"><input id="totalpickedtt" value="{{$totalpicked}}" style="color: black;width: 97px;"> </td>
                    <td style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;"> </td></tr>
        </tbody>
    </table>

</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        $('#totalplanned').val($('#totalplannedtt').val());
        $('#totalpicked').val($('#totalpickedtt').val());

        $('#livepickingtable').on('dblclick', 'tbody tr', function () {


            var $this = $(this);
            var row = $this.closest("tr");
            var ref = row.find('td:eq(1)').text();
           // var route = row.find('td:eq(1)').text();
            var del = row.find('td:eq(2)').text();

            window.open('{!!url("/pickingplanlist")!!}/'+ref, 'onewinbulk', "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
    });
</script>
</body>
</html>
