<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Job Card</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

    <style>
        body {
            background: rgb(204,204,204) !important; 
            }
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            }
        page[size="A5"] {  
            width: 21cm;
            height: 14.85cm;
            }
        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }

        .barcode{
            height:25%; 
            position: relative; 
        }

        .barcode p {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            white-space: nowrap;
        }

        .h3{
            
        }
        
        .printdlg{
            float: right; 
            margin-right: 25px;
            background-color: white;
            /* border: solid 1px rgb(221, 221, 221); */
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="printdlg">
        <label class="control-label" for="qty">Qty to print </label>
        <input type="number" id="qty" required>
        <button class="btn btn-info" id="print" style="margin-right:10px;">PRINT</button>
    </div>

    @foreach($jobdata as $val)
    <page size="A5">
        <div style="padding: 30px; height:100%">
            <option id="code" style="font-weight:700; font-size:22pt;" value="{{$val->SECode}}">CODE:&emsp;&emsp;&emsp;&emsp;&emsp;{{$val->SECode}}</option>
            <option id="product" style="font-weight:700; font-size:22pt;" value="{{$val->ProductName}}">PRODUCT:&emsp;&emsp;&emsp;{{$val->ProductName}}</option>
            <option id="mpa" style="font-weight:700; font-size:22pt;" value="{{$val->TreatedMPA}}">MPA:&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;{{$val->TreatedMPA}}</option>
            <option id="type" style="font-weight:700; font-size:22pt;" value="{{$val->Type}}">TYPE:&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{$val->Type}}</option>
            <option id="mass" style="font-weight:700; font-size:22pt;" value="{{$val->Weight}}">MASS:&emsp;&emsp;&emsp;&emsp;&emsp;{{$val->Weight}}</option>
            <option id="date" style="font-weight:700; font-size:22pt;" value="{{$val->DateTime}}">DATE:&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{$val->DateTime}}</option>
            <option id="operator" style="font-weight:700; font-size:22pt;" value="{{$val->Operator}}">OPERATOR:&emsp;&emsp;{{$val->Operator}}</option>
            <option id="ticketno" style="font-weight:700; font-size:22pt;" value="{{$val->TicketNo}}">TICKET:&emsp;&emsp;&emsp;&emsp;&nbsp;{{$val->TicketNo}}</option>
            <option id="Status" style="font-weight:700; font-size:22pt;" value="{{$val->Status}}">Status:&emsp;&emsp;&emsp;&emsp;&nbsp;{{$val->Status}}</option>
        </div>
    </page>
    @endforeach
    
</body>

<script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $('#print').click(function(){
            $.ajax({
                url: '{!!url("/printgalvlabel")!!}',
                type: "POST",
                data: {
                    ticketno: $('#ticketno').val(),
                    qty: $('#qty').val(),
                    status:$('#status').val()
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

    });

    function showDialog(tag,width,height)
    {



        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
</script>

</html>