<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

</head>
<body>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="col-lg-12 d-inline-flex" >
            <h3 style="flex-grow: 1; padding-left: 15px;">Galv Module Logs</h3>
        </div>
        
        <div id="gridContainer" style=""></div>
        
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

</body>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {


        
        var jArray = JSON.stringify({!! json_encode($galvloggrid) !!});
        var finalGalvGrid = $.map(JSON.parse(jArray), function (item) {
            return {
                    dtTimeStamp:item.dtTimeStamp,
					intJobNo:item.intJobNo,
					intTestNumber:item.intTestNumber,
					intSequenceNo:item.intSequenceNo,
					strStatusJob:item.strStatusJob,
					strValueZinc:item.strValueZinc,
					strReferenceNo:item.strReferenceNo,
					strCustomerName:item.strCustomerName,
					strDepartment:item.strDepartment,
					strMachine:item.strMachine,
					strWireSize:item.strWireSize,
					strValueMPA:item.strValueMPA,
					strValueRod:item.strValueRod,
					strValueCast:item.strValueCast,
					strValueTensileTicket:item.strValueTensileTicket,
					strWeight:item.strWeight,
					strProductName:item.strProductName,
					strValueTicket:item.strValueTicket,
					bitRegraded:item.bitRegraded,
					strRegradeRef:item.strRegradeRef,
					strOperator:item.strOperator,
					bitStockChange:item.bitStockChange,
					strZincInitialMass:item.strZincInitialMass,
					strZincStripMass:item.strZincStripMass,
					strZincStripSize:item.strZincStripSize,
					strGrossMass:item.strGrossMas,
					strTearMass:item.strTearMass,
					strComment1:item.strComment1,
					strComment2:item.strComment2,
					strComment3:item.strComment3,
					strProducedMass:item.strProducedMass,
					strValueStressTest:item.strValueStressTest,
					strValueElongTest:item.strValueElongTest,
					strValueDiameterTest:item.strValueDiameterTest,
					strValueTorsionTest:item.strValueTorsionTest,
					strValueUniformTest:item.strValueUniformTest
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#gridContainer").dxDataGrid({
            dataSource:finalGalvGrid,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            hoverStateEnabled: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            paging:{
                pageSize: 10,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50, 100, 200],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            columns: [
                
            {
                    dataField: "dtTimeStamp",
                    caption: "Timestamp",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "intJobNo",
                    caption: "Job ID",
                    headerFilter: {
                        allowSearch: true,
                    }
                },{
                    dataField: "strStatusJob",
                    caption: "Job Status",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "intTestNumber",
                    caption: "Test Number",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "intSequenceNo",
                    caption: "Sequence Number",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "strReferenceNo",
                    caption: "Reference Number",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "strCustomerName",
                    caption: "Customer Name",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "strDepartment",
                    caption: "Department",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "strMachine",
                    caption: "Machine",
                    headerFilter: {
                        allowSearch: true,
                    }

                },{
                    dataField: "strProductName",
                    caption: "Product Name",
                    headerFilter: {
                        allowSearch: true,
                    }

                }


            ] 
        });

        // For Side bar nav to work        
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


</script>

</html>
