<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!-- DevExtreme Theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('resources/css/jobmodulestyle.css') }}">
</head>

<body>

    <div class="col-12 d-flex px-0 bg-white">
        <div class="col-custom-2 bg-white">
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>



<div style="overflow-x: auto; width: 100%;">
   <center> <h2>Tracking Table</h2></center>
<br>
    <!-- 🔍 Filter Form -->
    <form id="filterForm" method="GET" class="row g-3 align-items-center mb-3" style="margin-left: 5px;">
        <div class="col-auto">
            <label for="fromDate" class="col-form-label">From:</label>
        </div>
        <div class="col-auto">
            <input type="date" id="fromDate" name="from_date" class="form-control" required>
        </div>

        <div class="col-auto">
            <label for="toDate" class="col-form-label">To:</label>
        </div>
        <div class="col-auto">
            <input type="date" id="toDate" name="to_date" class="form-control" required>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <!-- 📊 Data Grid -->
    <div id="gridContainer" style="min-width: 1500px;"></div>
</div>
    </div>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden;
            /* Prevent entire page from shifting horizontally */
        }

        #gridContainer .dx-scrollable-scroll.dx-scrollable-scroll-horizontal {
            bottom: 0 !important;
        }

        .dx-datagrid-table {
            font-size: 15px;
        }

        .dx-datagrid .dx-link {
            color: #df2413;
        }

        .dx-pager .dx-page-sizes .dx-selection,
        .dx-pager .dx-pages .dx-selection {
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

        div.scrollmenu {
            background-color: #333;
            overflow: auto;
            white-space: nowrap;
        }

        div.scrollmenu a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }
    </style>

    <!-- jQuery & DevExtreme -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

    <script>
        $(function () {
            $("#gridContainer").dxDataGrid({
                dataSource: @json($trackingData),
                keyExpr: "QRJobID",
                showBorders: true,
                columnAutoWidth: true,
                wordWrapEnabled: true,


                paging: {
                    pageSize: 10
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [10, 20, 50],
                    showInfo: true
                },
                searchPanel: {
                    visible: true,
                    highlightCaseSensitive: true
                },
                filterRow: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                columns: [
                    { dataField: "Date", dataType: "date" },
                    { dataField: "User" },
                    { dataField: "TL_Number", caption: "TL Number" },
                    { dataField: "SO_Number", caption: "SO Number" },
                    { dataField: "Move_From_Location", caption: "Move From Location" },
                    { dataField: "QRJobID", caption: "QR Job ID" },
                    { dataField: "Product_Code", caption: "Product Code" },
                    { dataField: "QTY_Moved", dataType: "number", caption: "QTY Moved" },
                    { dataField: "Tons_Moved", dataType: "number", caption: "Tons Moved" },
                    { dataField: "INV_Number", caption: "Invoice Number" },
                    { dataField: "Customer_Name", caption: "Customer Name" },
                    { dataField: "Product_Name", caption: "Product Name" },
                    { dataField: "WireSize", caption: "Wire Size" },
                    { dataField: "TreatedMPA", caption: "Treated MPA" },
                    { dataField: "TestedZinc", caption: "Tested Zinc" },
                    { dataField: "Weight", dataType: "number" },
                    { dataField: "TicketNo", caption: "Ticket No" },
                    { dataField: "ElongationAtBreak", caption: "Elongation At Break" }
                ]
            });
        });
    </script>

    <!-- Optional Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

</body>

</html>