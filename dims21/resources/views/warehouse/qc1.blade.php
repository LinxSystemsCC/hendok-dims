<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
        <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
        <title>QC Phase 1</title>
    
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
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

        <div class="tablearea">
            <div id="gridContainer" style="max-width: 100% !important; height: 100%;">
        </div>
    </div>
</div>

    {{-- <div id="createjob" class="modal fade" tabindex="-1" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qc1TestTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                    </div>

                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>

    </div> --}}

<!-- Modal New Item -->
<div class="modal modal-lg fade" id="createjob" aria-labelledby="createjob" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="qc1TestTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="initmass">Initial Mass</label>
                        <input type="number"  class="form-control" id="initmass" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="stripmass">Strip Mass</label>
                        <input type="number"  class="form-control" id="stripmass" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="stripsize">Strip Size</label>
                        <input type="number"  class="form-control" id="stripsize" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="zinc">Zinc</label>
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-primary px-4" id="calczinc">
                                    Calculate
                                </button>
                            </div>
                            <div class="col-md-8">
                                <input type="number"  class="form-control" id="zinc" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="mpa">MPA Tested</label>
                        <input type="number"  class="form-control" id="mpa" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="wiresize">Wire Size</label>
                        <input type="number"  class="form-control" id="wiresize" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="stresstest">1 % Stress Test</label>
                        <input type="number"  class="form-control" id="stresstest" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="elongation">Elongation at Break %</label>
                        <input type="number"  class="form-control" id="elongation" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="torsion">Torsion Test</label>
                        <input type="number"  class="form-control" id="torsion" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="wraptest">1 Diameter Wrap Test</label>
                        <input type="number"  class="form-control" id="wraptest" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="coating">Coating Uniformity</label>

                        <select  class="form-control" id="coating" required>
                            <option>
                                PASS
                            </option>

                            <option>
                                FAIL
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="CastNo">Cast Number</label>
                        <input type="number"  class="form-control" id="CastNo" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="test">Test Number</label>
                        <input type="number"  class="form-control" id="test" required disabled>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="col-form-label" for="comment1">Comment</label>
                        <select  class="form-control" id="comment1" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control" id="comment2" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control" id="comment3" required>
                            <option>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-inline-flex gap-2">
                    <button class="btn btn-success" id="testpass">PASS</button>
                    <button class="btn btn-danger" id="testfail">FAIL</button>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

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
        
        $('#wiresize').on('input', function() {
            // console.log($('#wiresize').val());
            var inputValue = $(this).val();
            
            if (inputValue.length > 4) {
                $(this).val(inputValue.slice(0, 4)); // Truncate the input to four characters
            }
        });

        $('#mpa').on('input', function() {
            var inputValue = $(this).val();
            
            if (inputValue.length > 4) {
                $(this).val(inputValue.slice(0, 4)); // Truncate the input to four characters
            }
        });
        
        // Clear inputs and selects within the modal
        $("#createjob").on("hidden.bs.modal", function () {
            $("#createjob input, #createjob select").val("");
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
            formula = parseFloat(formula).toFixed(4);
            
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
                    // console.log("as you where young lad");
                }
            }
        });
    };

</script>
