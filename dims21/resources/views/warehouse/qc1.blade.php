<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
        <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
        <title>QC Phase 1</title>
    
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
        <h3 style="flex-grow: 1;">QC Phase 1</h3>

        <div class="tablearea" >
        <div id="gridContainer" style="max-width: 100% !important; height: 100%;">
        </div>
    </div>
                    </div>

    <div title="Job Creation" id="createjob" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qc1TestTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                
                    <div class="form-group">
                        <label class="control-label" for="initmass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Initial Mass</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="initmass" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="stripmass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Strip Mass</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="stripmass" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="stripsize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Strip Size</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="stripsize" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" id="calczinc" style="margin-top: 10px; margin-bottom: 10px;">
                            Calculate Zinc
                        </button>
                        <br>
                        <label class="control-label" for="zinc"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Zinc</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="zinc" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="mpa"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">MPA Tested</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="mpa" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="wiresize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Wire Size</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="wiresize" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="stresstest"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">1 % Stress Test</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="stresstest" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="elongation"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Elongation at Break %</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="elongation" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="torsion"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Torsion Test</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="torsion" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="wraptest"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">1 Diameter Wrap Test</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="wraptest" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="coating"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Coating Uniformity</label>

                        <select  class="form-control input-sm col-xs-1" id="coating" required>
                            <option>
                                PASS
                            </option>

                            <option>
                                FAIL
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="CastNo"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Cast Number</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="CastNo" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="test"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Test Number</label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="test" required disabled>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="comment1"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Comment</label>
                        <select  class="form-control input-sm col-xs-1" id="comment1" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control input-sm col-xs-1" id="comment2" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control input-sm col-xs-1" id="comment3" required>
                            <option>
                            </option>
                        </select>
                    </div>

                </div>
                
                <br>
                <div class="modal-footer">
                    <button class="btn btn-success" id="testpass" style="width:50%">PASS</button>
                    <button class="btn btn-danger" id="testfail" style="width:50%">FAIL</button>
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

        $('#zinc').prop( "disabled", true );

        $("#wiresize").change(function() {
            $(this).val(parseFloat($(this).val()).toFixed(2));
        });

        $.ajax({

            url: '{!!url("/getqc1")!!}',
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
                        const worksheet = workbook.addWorksheet('qc1');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'qc1.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "JobNo",
                            caption: "Job No",
                            //width:100,
                        },{
                            dataField: "TestNo",
                            caption: "Test No",
                            //width:100,
                        },{
                            dataField: "Reference",
                            caption: "Reference",
                            //width:150,
                        },{
                            dataField: "ProductName",
                            caption: "Product",
                            //width:150,
                        },{
                            dataField: "DepartmentName",
                            caption: "Department",
                            //width: 450,
                        },{
                            dataField: "MachineName",
                            caption: "Machine",
                            //width: 350,
                        },{
                            dataField: "WireSize",
                            caption: "Wire Size",
                            dataType: "number", 
                            alignment: "left",
                            type:"fixedPoint",  
                            precision:2,
                            //width:200,
                        },{
                            dataField: "MaxTDT",
                            caption: "Date",
                            //width:250,
                        },
                        {
                            dataField: "MassRequired",
                            caption: "Required",
                            //width:100,
                        },{
                            dataField: "count",
                            caption: "Count",
                            visible: false,
                            //width:100,
                        },

                    ],

                    onRowDblClick:function(e){
                        $('#createjob').modal('toggle');
                        var dataGrid = $("#gridContainer").dxDataGrid("instance");
                        var selectedRowsData = dataGrid.getSelectedRowsData();
                        var dept = selectedRowsData[0].DepartmentName;
                        var mach = selectedRowsData[0].MachineName;
                        var title = dept + ", " + mach;
                        var testNo = selectedRowsData[0].TestNo;

                        $('#qc1TestTitle').text(title);
                        $('#test').val(testNo);
                    },

                    onRowClick:function(e){

                    },
                });

            }

        });
        
        // Update Comments Lists
        $.ajax({

            url: '{!!url("/getqc1comments")!!}',
            type: "GET",
            data: {
    

            },
            success: function (data) {
                var toAppend = '';
                $("#comment1").empty();
                $("#comment2").empty();
                $("#comment3").empty();
                toAppend += '<option></option>';
                $.each(data,function(i,o){

                    toAppend += '<option value="'+o.RemarkID+'">'+o.Remark+'</option>';
                });
                $("#comment1").append(toAppend);
                $("#comment2").append(toAppend);
                $("#comment3").append(toAppend);

            },
        });

        $('#testpass').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            $.ajax({
                
                url: '{!!url("/qc1pf")!!}',
                type: "POST",
                data: {
                    Reference: selectedRowsData[0].Reference,
                    CustomerName: selectedRowsData[0].CustomerName,
                    ProductName: selectedRowsData[0].ProductName,
                    DepartmentName: selectedRowsData[0].DepartmentName,
                    MachineName: selectedRowsData[0].MachineName,
                    JobNo: selectedRowsData[0].JobNo,
                    WireSize: selectedRowsData[0].WireSize,
                    MassRequired: selectedRowsData[0].MassRequired,
                    testNo: $("#test").val(),
                    zincTested: $("#zinc").val(),
                    mpaTested: $("#mpa").val(),
                    castNo: $("#CastNo").val(),
                    wireSizeTested: $("#wiresize").val(),
                    stressTest: $("#stresstest").val(),
                    elongBreakTest: $("#elongation").val(),
                    torsionTest: $("#torsion").val(),
                    wrapTest: $("#wraptest").val(), 
                    coating: $("#coating option:selected").text(), 
                    comment1: $("#comment1 option:selected").text(),
                    massProduced: selectedRowsData[0].MassProduced,
                    zincInitialMass: $("#initmass").val(),
                    zincStripMass: $("#stripmass").val(),
                    zincStripSize: $("#stripsize").val(),
                    comment2: $("#comment2 option:selected").text(),
                    comment3: $("#comment3 option:selected").text(),
                    testpf: "P",

                },
                success: function (data) {
                    console.debug(data[0]);
                    if (data[0].Result != "Success"){
                        alert(data[0].Result);
                    }
                    else{
                        if (data[0].Warnings != "Warning:"){
                            alert(data[0].Warnings);
                            location.reload();
                        }
                        else{
                            location.reload();
                        }
                    }
                }
            });
            
                
        });

        $('#testfail').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            // if ((selectedRowsData.lenght) < 1){
            //     alert("No Data Selected0");
            //     console.debug("no item selected");
            //     console.log(selectedRowsData.lenght);
            // }
                
            console.debug(selectedRowsData);
            console.debug(selectedRowsData[0]);
            //console.debug(reference);

            $.ajax({
                
                url: '{!!url("/qc1pf")!!}',
                type: "POST",
                data: {
                    Reference: selectedRowsData[0].Reference,
                    CustomerName: selectedRowsData[0].CustomerName,
                    ProductName: selectedRowsData[0].ProductName,
                    DepartmentName: selectedRowsData[0].DepartmentName,
                    MachineName: selectedRowsData[0].MachineName,
                    JobNo: selectedRowsData[0].JobNo,
                    WireSize: selectedRowsData[0].WireSize,
                    MassRequired: selectedRowsData[0].MassRequired,
                    testNo: $("#test").val(),
                    zincTested: $("#zinc").val(),
                    mpaTested: $("#mpa").val(),
                    castNo: $("#CastNo").val(),
                    wireSizeTested: $("#wiresize").val(),
                    stressTest: $("#stresstest").val(),
                    elongBreakTest: $("#elongation").val(),
                    torsionTest: $("#torsion").val(),
                    wrapTest: $("#wraptest").val(), 
                    coating: $("#coating option:selected").text(), 
                    comment1: $("#comment1 option:selected").text(),
                    massProduced: selectedRowsData[0].MassProduced,
                    zincInitialMass: $("#initmass").val(),
                    zincStripMass: $("#stripmass").val(),
                    zincStripSize: $("#stripsize").val(),
                    comment2: $("#comment2 option:selected").text(),
                    comment3: $("#comment3 option:selected").text(),
                    testpf: "F",


                },
                success: function (data) {
                    console.debug(data[0]);
                    if (data[0].Result != "Success"){
                        alert(data[0].Result);
                    }
                    else{
                        if (data[0].Warnings != "Warning:"){
                            alert(data[0].Warnings);
                            location.reload();
                        }
                        else{
                            location.reload();
                        }
                    }
                }

            });
        });

        $('#calczinc').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            var zincInitialMass = $("#initmass").val();
            var zincStripMass = $("#stripmass").val();
            var zincStripSize = $("#stripsize").val();

            var formula = ((zincInitialMass-zincStripMass)/zincStripMass)*(1960*zincStripSize);
            formula = parseFloat(formula).toFixed(2);
            
            $('#zinc').val(formula);

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
    };

    function doacheck(){
        setInterval(checkforchanges,10000);
    };

    function checkforchanges(){
        $.ajax({
            url: '{!!url("/checkForGalvUpdates")!!}',
            type: "GET",
            data: {
                checker: "QC1",
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
                            checker: "QC1",
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
