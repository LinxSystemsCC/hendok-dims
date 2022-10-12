<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">


    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>


</head>
<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-3" >
        @foreach($products as $val)
            <h3>PRODUCT: {{$val->PastelDescription}}</h3>
            <input type="hidden" id="itemcode" value="{{$val->PastelCode}}">
        @endforeach
        <br>
            @foreach($machines as $val)
                <h3>MACHINE: {{$val->strMachineName}}</h3>
                <input type="hidden" id="machineid" value="{{$val->intAutoMachineID}}">
            @endforeach
            @foreach($pallet as $val)

                <input type="hidden" id="palletid" value="{{$val->intPalletId}}">
            @endforeach
            <br>
            <h3>QUANTITY TO PRODUCE: <input type="hidden" id="toproduce" value="{{$qty}}"> {{$qty}}</h3><br>

        <fieldset class="well">
            <form>
                <div class="form-group">
                        <label class="control-label" for="dateselect"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Start Date</label>
                        <input  type="date" class="form-control input-sm col-xs-1" id="dateselect" style="font-weight: 900;"><br>
                    <br>
                </div>
            </form>
        </fieldset>
        <br><br><br>
        <button class="btn-primary btn-lg" id="savemachine" style="width: 100%">FINISH</button>

    </div>
    <div class="col-lg-5" >
        <h5 style="text-align: center;">Currently Planned On @foreach($machines as $val)
             <strong> {{$val->strMachineName}}</strong>

            @endforeach </h5>
        <br>
        <div id="gridContainer" style="width: 900px !important;">
        </div>

    </div>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }
</style>

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

        $('#savemachine').click(function(){

            window.location.replace('{!!url("/startprintingjob")!!}/' +$('#toproduce').val()+"/"+$('#machineid').val()+"/"+$('#itemcode').val()+"/"+$('#palletid').val()+"/"+$('#dateselect').val());
        });

        $.ajax({
            url: '{!!url("/getProductPlannedOnThatMachine")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    filterRow: { visible: true },
                    allowColumnResizing: true,
                    paging:{
                        pageSize: 50,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('machineplan');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'machineplan.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                         {
                            dataField: "strItemCode",
                            caption: "Item Code",
                            width: 60,

                        }, {
                            dataField: "PastelDescription",
                            caption: "Item Description",
                            width: 400,

                        }, {
                            dataField: "mnyQtyRequired",
                            caption: "Planned",
                            width: 90,

                        }, {
                            dataField: "dteJobCreated",
                            caption: "Date Create",
                            width: 125,

                        }, {
                            dataField: "dteStartDate",
                            caption: "Start Date",
                            width: 125,

                        },
                    ],

                });

            }

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
