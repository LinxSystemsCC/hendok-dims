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
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        h3{
            margin: 0px !important;
            margin-bottom: 10px !important;
            padding-left: 0px !important;
            font-weight: 700;
        }
    </style>

</head>


<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    
    <div class="col-lg-12 bd-highlight"  style="background: white; display: block; height: 100vh; width: 30%;padding: 20px !important;">

        <h3>PRODUCT LABEL PRINTING</h3>

        {{-- Department --}}
        <div>
            <div class="form-group">
                <label class="control-label" for="department"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department</label>
                <select  class="form-control input-sm col-xs-1 " id="department" style="width: 100%" required>
                    <option></option>
                            @foreach($dept as $val)
                                <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                            @endforeach
                    
                </select>
            </div>

            {{-- Product Category --}}
            <div class="form-group">
                <label class="control-label" for="category"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                <select  class="form-control input-sm col-xs-1" id="category" style="width: 100%" required>
                    <option></option>
                </select>
            </div>

            {{-- Product --}}
            <div class="form-group">
                <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                <select  class="form-control input-sm col-xs-1" id="prodname" style="width: 100%" required>
                    <option></option>
                </select>
            </div>

            {{-- Quantity --}}
            <div class="form-group">
                <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity to Print </label>
                <input  class="form-control input-sm col-xs-1" id="qty" style="width: 100%" required>
            </div>

            <br>
            <br>

            <button class="btn btn-success" id="print" style="width: 100%; margin-right: 10px;">PRINT</button>
            
            <br>
            <br>
            <h3>LABEL PRINTING REPORT</h3>
            {{-- Date from --}}
            <div class="form-group">
                <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date From </label>
                <input type="date" id="datefrom" style="float: right; width: 70%;">
            </div>

            {{-- Date To --}}
            <div class="form-group">
                <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date To </label>
                <input type="date" id="dateto" style="float: right; width: 70%;">
            </div>
            
            <button class="btn btn-info" id="report" style="width: 100%;">REPORT</button>
            

        </div>
        
    </div>
    <div class="col-lg-12 bd-highlight"  style="background: white; display: block; height: 100vh; width: 100%;padding: 20px !important;">
        <h3 id="gridHeading"></h3>
        <div id="gridContainer" style="width: 100% !important;">
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


        $('#print').click(function(){

            $.ajax({

                url: '{!!url("/printgenericlabel")!!}',
                type: "POST",
                data: {
                    department: $('#department option:selected').val(),
                    category: $('#category option:selected').text(),
                    product: $('#prodname option:selected').text(),
                    qty: $('#qty').val()
                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        $('#report').click(function(){
            var datefrom =  $('#datefrom').val();
            var dateto = $('#dateto').val();
            $('#gridHeading').text("PRINTING REPORT FROM: "+datefrom + " TO: "+dateto);
            $.ajax({
                url: '{!!url("/getgenericlabelprintscreen")!!}',
                type: "GET",
                data: {
                    datefrom: $('#datefrom').val(),
                    dateto: $('#dateto').val()
                },
                success: function (data) {
                    $("#gridContainer").dxDataGrid({
                        dataSource:data, //as json
                        showBorders: true,
                        hoverStateEnabled: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        allowColumnResizing: true,
                        columnAutoWidth: true,
                        paging:{
                            pageSize: 20,
                        },
                        export: {
                            enabled: true
                        },
                        selection: {
                            mode: 'single',
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('printReport');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'printReport.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "intJobId",
                                caption: "JobNo",
                                //width: 80,

                            }, {
                                dataField: "Code",
                                caption: "Code",
                                //width: 100,

                            }, {
                                dataField: "Description_1",
                                caption: "Description",
                                //width: 200,

                            },
                            {
                                dataField: "mnyQtyRequired",
                                caption: "Qty Required",
                                //width: 250,

                            },
                            {
                                dataField: "dteStartDate",
                                caption: "Date",
                                //width: 500,

                            },
                            

                        ],
                        onRowDblClick:function(e){
                            // console.log(e.data.intJobId);
                            // var intJobId =  e.data.intJobId;

                            // window.open('{!!url("/jobupdateprint")!!}/' +intJobId, "Job" +intJobId, "location=1,status=1,scrollbars=1, width=1200,height=850");

                        }

                    });

                }

            });
        });

        $('#department').change(function(){
            $.ajax({

                url: '{!!url("/getDepListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#department option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#category").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoGroupCategoryId+'">'+o.strProductCategory+'</option>';
                    });
                    $("#category").append(toAppend);
                    $("#category").select2();

                }

            });
        });

        $('#category').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#category option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();

                }

            });
        });
        
        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
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
