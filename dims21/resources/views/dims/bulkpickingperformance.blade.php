<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="20">
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
<div class="col-md-12" style="background: black;color:white;height: 1500px;">

    <table class="table" id="livepickingtable">
        <thead>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Time Generated</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Reference</th>
        <th style="color:#61ff13;font-size: 25px;font-family: sans-serif;font-weight: 900;">Route</th>
        <th style="color:#61ff13;font-size: 17px;font-family: sans-serif;font-weight: 900;">Trailor/Truck Type</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">Team Leader</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">T.Start</th>
        <th style="color:#61ff13;font-size: 16px;font-family: sans-serif;font-weight: 900;">T.End</th>
        <th style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;">Planned</th>
        <th style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;">Picked</th>
        <th style="color:#61ff13;font-size: 20px;font-family: sans-serif;font-weight: 900;">Status</th>
        </thead>
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
                <td>{{$val->dteTimeCreated}}   </td>
                <td>{{$val->strUnickReference}}</td>
                <td>{{$val->strPickingNickname}}</td>
                <td>{{$val->trucktrailortype}}</td>
                <td>{{$val->TeamLeader}}</td>
                <td>{{$val->startPicking}}</td>
                <td>{{$val->endPicking}}</td>
                <td>{{$val->weightsPlnned}}</td>
                <td>{{$val->picked}}</td>
                <td>{{$val->blnAttended}}</td>

            </tr>

        @endforeach
        </tbody>
    </table>

</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
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
