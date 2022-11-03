<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



    <!-- Select2 JS -->


    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

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

        .stock {
            background-color: #ccc !important;
        }
    </style>


</head>
<body>


<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-10" >
        <div class="contentWrapper">
            <div class="content" id="profile"  aria-labelledby="profile-tab">
                <h5>Detail Bin Balance</h5>
                    <input type="hidden" id="productCode" value="{{$productCode}}">
                    
                    

                    <div id="balance" style="width: 100% !important;">
                    </div>
            </div>
            
            <div class="content" id="profile"  aria-labelledby="profile-tab">
                <h5>Detail Bin Report</h5>
                    <input type="hidden" id="productCode" value="{{$productCode}}">
                    
                    

                    <div id="report" style="width: 100% !important;">
                    </div>
            </div>
        </div>


    </div>
    <div title="JOB" id="viewjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="viewjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewjobTitle">Job Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


    <div title="Location Type" id="createlocationtype" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="createlocationtypeTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createlocationtypeTitle">Create A Location Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="strLocationType"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Description</label>
                        <input  class="form-control input-sm col-xs-1 " id="strLocationType" style="width: 100%" required>
                    </div>
                </div>
                <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn-danger btn-lg" id="savelocationtype" style="width: 100%;">SAVE</button>
                </div>
            </div>
        </div>

    </div>

    <div title="Location Name" id="createlocationname" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createlocationname" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createlocationnameTitle">Create A Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="strLocationName"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Location Name</label>
                        <input  class="form-control input-sm col-xs-1 " id="strLocationName" style="width: 100%" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label" for="locationtype"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Location Type</label>

                    </div>
                </div>
                <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn-danger btn-lg" id="savelocationame" style="width: 100%;">SAVE</button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>

    const tabs = document.querySelector(".wrapper");
    const tabButton = document.querySelectorAll(".tab-button");
    const contents = document.querySelectorAll(".content");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });


    $(document).ready(function() {
        console.debug($('#productCode').val())
        $.ajax({
            url: '{!!url("/getviewGridStockBalance")!!}',
            type: "GET",
            data: {
                ItemCode:$('#productCode').val()
            },
            success: function (data) {
                $("#balance").dxDataGrid({
                    dataSource: data, //as json
                    showBorders: true,
                    filterRow: {visible: true},
                    filterPanel: {visible: true},
                    headerFilter: {visible: true},
                    allowColumnResizing: true,
                    paging: {
                        pageSize: 20,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('getviewGridStockDetails');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], {type: 'application/octet-stream'}), 'getLocationNamesAndTypes.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "strErpItemCode",
                            caption: "Item Code",
                            width: 150,
                        }, {
                            dataField: "Description_1",
                            caption: "Item Name",
                            width: 460,
                        }, {
                            dataField: "ItemGroupDescription",
                            caption: "Item Group",
                            width: 180,
                        }, {
                            dataField: "Username",
                            caption: "User Name",
                            width: 140,
                        }, {
                            dataField: "PalletQty",
                            caption: "Qty", dataType: "number", format: "#0",
                            width: 80,
                        },{
                            dataField: "strLocation",
                            caption: "Location",
                            width: 80,
                        },

                    ],
                    onRowDblClick: function (e) {


                    }

                });
            }
        });

        $.ajax({
            url: '{!!url("/getviewGridStockReport")!!}',
            type: "GET",
            data: {
                ItemCode:$('#productCode').val()
            },
            success: function (data) {
                $("#report").dxDataGrid({
                    dataSource: data, //as json
                    showBorders: true,
                    filterRow: {visible: true},
                    filterPanel: {visible: true},
                    headerFilter: {visible: true},
                    allowColumnResizing: true,
                    paging: {
                        pageSize: 20,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('getviewGridStockDetails');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], {type: 'application/octet-stream'}), 'getLocationNamesAndTypes.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "strErpItemCode",
                            caption: "Item Code",
                            width: 150,
                        }, 
                        {
                            dataField: "Description_1",
                            caption: "Item Name",
                            width: 460,
                        }, 
                        {
                            dataField: "ItemGroupDescription",
                            caption: "Item Group",
                            width: 180,
                        }, 
                        {
                            dataField: "Username",
                            caption: "User Name",
                            width: 140,
                        }, 
                        {
                            dataField: "mnyPalletQty",
                            caption: "Qty", dataType: "number", format: "#0",
                            width: 80,
                        }, 
                        {
                            dataField: "MinLevel",
                            caption: "Min Level",
                            width: 80,
                        }, 
                        {
                            dataField: "MaxLevel",
                            caption: "Max Level",
                            width: 80,
                        }, 
                        {
                            dataField: "QtyInStock",
                            caption: "Stock On Hand",
                            width: 80,
                        }, 
                        {
                            dataField: "strLocation",
                            caption: "Location",
                            width: 180,
                        },
                        {
                            dataField: "intJobId",
                            caption: "Job Id",
                            width: 80,
                        },
                        {
                            dataField: "strMoveType",
                            caption: "Mov Type",
                            width: 80,
                        },
                        {
                            dataField: "strItem",
                            caption: "strItem",
                            width: 80,
                        },
                        {
                            dataField: "TransactionType",
                            caption: "TransactionType",
                            width: 80,
                        }
                    ],
                    onRowDblClick: function (e) {


                    }

                });
            }
        });



    });


    

</script>
</body>