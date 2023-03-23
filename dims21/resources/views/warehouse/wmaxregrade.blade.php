<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
        <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
        <title>Regrade</title>
    
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
        <!-- DevExtreme theme -->
        {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}
    </head>

    <div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
        <div class="col-lg-2" style="background: white;">
    
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <div class="col-lg-10">
            <h3 style="flex-grow: 1;">Regrade</h3>
            <div class="tablearea" >
            <div id="gridContainer" style="">
            </div>
        </div>
    </div>

    <div title="Job Creation" id="createjob" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Regrade Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="customer"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                        <select  class="form-control input-sm col-xs-1" id="customer" required>
                            <option></option>
                            @foreach($customers as $val)
                                <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="product"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Regrade to Product</label>
                        <select  class="form-control input-sm col-xs-1" id="product" required>
                            <option></option>
                        </select>
                    </div>


                </div>
                
                <br>
                <div class="modal-footer">
                    <button class="btn btn-success" id="regrade">REGRADE</button>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .dx-datagrid-table{
        font-size:15px;
    }

    .dx-datagrid .dx-link {
        color: #df2413;
    }

    .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
        font-weight: 500;
        background-color: #df2413;
        color: #fff;
    }

    .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
        color: #df2413;
        font-size: 14px;
        line-height: 18px;
    }

    .dx-datagrid {
        height: calc(100vh - 63px);
        max-height: calc(100vh - 63px);
    }
</style>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>


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
        
        $("#customer").change(function () {
            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#customer").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#product").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductID+'">'+o.ProductName+'</option>';
                    });
                    $("#product").append(toAppend);
                    $("#product").select2();
                }
            });
        });

        //GetWeigh
        $.ajax({

            url: '{!!url("/getregrade")!!}',
            type: "GET",
            data: {
        
            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json
                    hoverStateEnabled: true,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    paging:{
                        pageSize: 10,
                    },
                    pager: {
                        visible: true,
                        allowedPageSizes: [5, 10, 20, 50, 'all'],
                        showPageSizeSelector: true,
                        showInfo: true,
                        showNavigationButtons: true,
                    },
                    export: {
                        enabled: true
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('regrade');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'regrade.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "Reference",
                            caption: "Reference",
                            //width:100,
                        },{
                            dataField: "TicketNo",
                            caption: "TicketNo",
                            //width:100,
                        },{
                            dataField: "Customer",
                            caption: "Customer",
                            //width:100,
                        },
                        {
                            dataField: "Department",
                            caption: "Deaprtment",
                            //width:100,
                        },
                        {
                            dataField: "Machine",
                            caption: "Machine",
                            //width:100,
                        },
                        {
                            dataField: "JobNo",
                            caption: "Job No",
                            //width:100,
                        },
                        {
                            dataField: "SequenceNo",
                            caption: "Seq No",
                            //width:100,
                        },
                        {
                            dataField: "WireTol",
                            caption: "Wire Spec",
                            //width:100,
                        },
                        {
                            dataField: "ActualWireSize",
                            caption: "Wire Test", 
                            dataType: "number",  
                            alignment: "left",
                            type:"fixedPoint",  
                            precision:2,
                            //width:100,
                        },
                        {
                            dataField: "MPASpec",
                            caption: "Mpa Spec",
                            //width:100,
                        },
                        {
                            dataField: "TreatedMPA",
                            caption: "MPa Test",
                            //width:100,
                        },
                        {
                            dataField: "ZincSpec",
                            caption: "Zinc Spec",
                            //width:100,
                        },
                        {
                            dataField: "TestedZinc",
                            caption: "Zinc Test",
                            //width:100,
                        },
                        {
                            dataField: "Type",
                            caption: "Zinc Coating",
                            //width:100,
                        },
                        {
                            dataField: "Weight",
                            caption: "Weight",
                            //width:100,
                        },
                    ],


                    onRowDblClick:function(e){
                        $('#createjob').modal('toggle');
                        var dataGrid = $("#gridContainer").dxDataGrid("instance");
                        var selectedRowsData = dataGrid.getSelectedRowsData();
                        
                        //var jobnum = selectedRowsData[0].JobNo;

                    },

                    onRowClick:function(e){

                    },
                });

            }

        }); 

        //Get Scales
        $.ajax({

            url: '{!!url("/getTare")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                // $("#tare").select2({ data:result });
                // console.log(data.length);
                // console.log(data);

                for (let i = 0; i < data.length; i++) {
                    // console.log(data[i].StandName);
                    name = data[i].StandName;
                    mass = data[i].StandMass;

                    $('#tare').append(`<option value="${mass}">${name}</option>`);
                }


            }
        });

        $('#regrade').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            var ref = selectedRowsData[0].Reference;
            var custnum = selectedRowsData[0].Customer;
            var prod = selectedRowsData[0].ProductName;
            var dept = selectedRowsData[0].Department;
            var machine = selectedRowsData[0].Machine;
            var jobnum = selectedRowsData[0].JobNo;
            var zinc = selectedRowsData[0].TestedZinc;
            var mpa = selectedRowsData[0].TreatedMPA;
            var wire = selectedRowsData[0].WireSize;
            var sequm = selectedRowsData[0].SequenceNo;
            var tensile = selectedRowsData[0].TicketNo;

            $.ajax({
                
                url: '{!!url("/regradeproduct")!!}',
                type: "POST",
                data: {
                    jobnum:jobnum,
                    sequm:sequm,
                    custnum:$('#customer option:selected').val(),
                    custnumfrom:custnum,
                    dept:dept,
                    ref:ref,
                    machine:machine,
                    prod:$('#product option:selected').text(),
                    prodfrom:prod,
                    zinc:zinc,
                    tensile:tensile,
                    mpa:mpa,
                    wire:wire,
                },
                success: function (data) {
                    
                    if (data[0].Result = "Success"){
                        var customer =  data[0].CustomerName;
                        var product =  data[0].ProductName;
                        var ticket =  data[0].TicketNo;

                        window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket + '/Regrade' , "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");

                        location.reload();
                    }
                }

            });
        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");

        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        doacheck();
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

    function doacheck(){
        setInterval(checkforchanges,10000);
    };

    function checkforchanges(){
        $.ajax({
            url: '{!!url("/checkForGalvUpdates")!!}',
            type: "GET",
            data: {
                checker: "REGRADE",
            },
            success: function (data) {
                // console.log(data[0].Result);
                if (data[0].Result == "Reload"){
                    console.log("deleting record and reloading");
                    //runs store procedure to delete the record
                    $.ajax({
                        url: '{!!url("/deleteGalvChecker")!!}',
                        type: "GET",
                        data: {
                            checker: "REGRADE",
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
                else{
                    console.log("as you where young lad");
                }
            }
        });
    };
</script>
