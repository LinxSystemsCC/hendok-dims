@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Regrade')

{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;
    
@endphp

@section('page')

<style>
    #gridRegrade{
        height: calc(100vh - 2rem);
        max-height: calc(100vh - 2rem);
    }
</style>

    <div id="gridRegrade"></div>

    <div title="Regrade" id="modalRegrade" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalRegradeTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Regrade Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModal"></button>
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

@endsection

@section('scripts')

<script>

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
                    $("#product").select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#modalRegrade'),
                    });
                }
            });
        });

        const gridRegrade = $("#gridRegrade").dxDataGrid({
            dataSource:[], //as json
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
                    dataField: "DateTime",
                    caption: "Date",
                    //width:100,
                },{
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
                {
                    dataField: "TensileTicket",
                    caption: "Tensile Ticket",
                    //width:100,
                },
            ],
            onRowDblClick:function(e){
                $('#modalRegrade').modal('toggle');
                var selectedRowsData = gridRegrade.getSelectedRowsData();
                
                //var jobnum = selectedRowsData[0].JobNo;

            },
            onToolbarPreparing: function (e) {
                // Create a custom header on the left side
                e.toolbarOptions.items.unshift(
                    {
                        location: 'before',
                        template: function () {
                            return $('<h3>').text('REGRADE');
                        }
                    }
                );
            },
        }).dxDataGrid('instance');

        getRegrade();

        function getRegrade(){
            $('#regrade').prop("disabled", false);
            $.ajax({
                url: '{!!url("/getregrade")!!}',
                type: "GET",
                data: {
                },
                success: function (data) {
                    gridRegrade.option('dataSource', data);
                    gridRegrade.refresh();

                    gridData = gridRegrade.option("dataSource");
                }
            }); 
        };
        

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
            $(this).prop("disabled", true);
            var selectedRowsData = gridRegrade.getSelectedRowsData();

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
            var tensile = selectedRowsData[0].TensileTicket;

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

                        // window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket +'/Accept', "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                        window.open('{!!url("/printGalvLabel")!!}/'+ticket,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");

                        $('#modalRegrade').modal('hide');
                        getRegrade();
                    }
                }

            });
        });

        doacheck();

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
                    if (data[0].Result == "Reload"){
                        $.ajax({
                            url: '{!!url("/deleteGalvChecker")!!}',
                            type: "GET",
                            data: {
                                checker: "REGRADE",
                            },
                            success: function (data) {
                                getRegrade();
                                $('#modalRegrade').modal('hide');
                            }
                        });
                    }
                }
            });
        };
    });
</script>

@endsection