@extends('layouts.app')


@section('content')

    <div class="col-lg-12">
        <a href='{!!url("/gridEditViewProducts")!!}' onclick="window.open(this.href, 'gridEditViewProducts',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900;background: #179a17;padding: 4px;">Other Settings</a>

        <a href='{!!url("/getCostsPerdate")!!}' onclick="window.open(this.href, 'getCostsPerdate',
'left=20,top=20,width=1000,height=900,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900;background: #179a17; padding: 4px;">Products Cost History</a>

        <button class="btn-success btn" id="printAll">Print ALL Barcodes</button>
    </div>
    <div class="col-lg-12"   style="height:100%;">
        <button class="btn-md btn-primary" id="refreshProducts">Refresh</button>
        <table class="table table-bordered stripe search-table" tabindex=0 id="tblMassProducts" style="font-size:11px;   color: black;overflow-y: scroll; width: 100%;font-family: monospace;" >
            <thead style="font-size: 17px;">
            <tr>

                <th class="col-sm-1">ProductId</th>
                <th class="col-sm-1">PastelCode</th>
                <th class="col-sm-3">PastelDescription</th>
                <th class="col-sm-3">UnitSize</th>
                <th class="col-sm-1">Cost</th>
                <th class="col-sm-1">QtyInStock</th>
                <th class="col-sm-1">Available</th>
                <th class="col-sm-1">Sales Orders</th>
                <th class="col-sm-1">Purchase</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot style="font-size: 17px;">

            <tr style="overflow-y: scroll; width: 100%;">

                <th class="col-sm-1">ProductId</th>
                <th class="col-sm-1">PastelCode</th>
                <th class="col-sm-3">PastelDescription</th>
                <th class="col-sm-1">UnitSize</th>
                <th class="col-sm-1">Cost</th>
                <th class="col-sm-1">QtyInStock</th>
                <th class="col-sm-1">Available</th>
                <th class="col-sm-1">Sales Orders</th>
                <th class="col-sm-1">Purchase</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
<link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">


<script>
    $(document).ready(function() {
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var otable = '';
        otable = $('#tblMassProducts').DataTable({
            "ajax": {
                url: '{!!url("/massproductdatatable")!!}', "type": "POST", data: function (data) {

                }
            },
            "processing": false,
            "serverSide": false,
            "stateSave": false,

            "columns": [
                {"data": "ProductId", "class": "small"},
                {"data": "PastelCode", "class": "small"},
                {"data": "PastelDescription", "class": "small"},
                {"data": "UnitSize", "class": "small"},
                {"data": "Cost", "class": "small",
                    render:function(data, type, row, meta) {
                    // check to see if this is JSON
                    try {
                        var jsn = JSON.parse(data);
                        //console.log(" parsing json" + jsn);
                    } catch (e) {

                       // return jsn.data;
                    }
                    return parseFloat(jsn).toFixed(2);

                } ,"bSortable": true },
                {"data": "QtyInStock", "class": "small",
                    render:function(data, type, row, meta) {
                    // check to see if this is JSON
                    try {
                        var jsn = JSON.parse(data);
                        //console.log(" parsing json" + jsn);
                    } catch (e) {

                        //return jsn.data;
                    }
                    return parseFloat(jsn).toFixed(2);

                } ,"bSortable": true },
                {"data": "Available", "class": "small",render:function(data, type, row, meta) {
                    // check to see if this is JSON
                    try {
                        var jsn = JSON.parse(data);
                        //console.log(" parsing json" + jsn);
                    } catch (e) {

                       // return jsn.data;
                    }
                    return parseFloat(jsn).toFixed(2);

                } ,"bSortable": true }
                ,
                {"data": "salesquantity", "class": "small",render:function(data, type, row, meta) {
                    // check to see if this is JSON
                    try {
                        var jsn = JSON.parse(data);
                        //console.log(" parsing json" + jsn);
                    } catch (e) {

                       // return jsn.data;
                    }
                    return parseFloat(jsn).toFixed(2);

                } ,"bSortable": true }
                ,
                {"data": "PurchOrder", "class": "small",
                    render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            // return jsn.data;
                        }
                        return jsn;

                    }  }

            ],

            "deferRender": true,
            "scrollY": "500px",
            "scrollX": "600px",
            "scrollCollapse": true,
            searching: true,
            bPaginate: false,
            bFilter: false,
            "LengthChange": false,
            "info": false,
            /*"ordering": true,*/
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel'
            ],
            "initComplete": function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            "bDestroy": true
        });

        $('#refreshProducts').on('click', function (event) {
            otable = $('#tblMassProducts').DataTable({
                "ajax": {
                    url: '{!!url("/massproductdatatable")!!}', "type": "POST", data: function (data) {

                    }
                },
                "processing": false,
                "serverSide": false,
                "stateSave": false,

                "columns": [
                    {"data": "ProductId", "class": "small"},
                    {"data": "PastelCode", "class": "small"},
                    {"data": "PastelDescription", "class": "small"},
                    {"data": "UnitSize", "class": "small"},
                    {"data": "Cost", "class": "small",
                        render:function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                // return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        } ,"bSortable": true },
                    {"data": "QtyInStock", "class": "small",
                        render:function(data, type, row, meta) {
                            // check to see if this is JSON
                            try {
                                var jsn = JSON.parse(data);
                                //console.log(" parsing json" + jsn);
                            } catch (e) {

                                //return jsn.data;
                            }
                            return parseFloat(jsn).toFixed(2);

                        } ,"bSortable": true },
                    {"data": "Available", "class": "small",render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            // return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(4);

                    } ,"bSortable": true },
                    {"data": "salesquantity", "class": "small",render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            // return jsn.data;
                        }
                        return parseFloat(jsn).toFixed(2);

                    } ,"bSortable": true }
                    ,
                    {"data": "PurchOrder", "class": "small",
                        render:function(data, type, row, meta) {
                        // check to see if this is JSON
                        try {
                            var jsn = JSON.parse(data);
                            //console.log(" parsing json" + jsn);
                        } catch (e) {

                            // return jsn.data;
                        }
                        return jsn;

                    }  }

                ],
                "deferRender": true,
                "scrollY": "500px",
                "scrollX": "600px",
                "scrollCollapse": true,
                searching: true,
                bPaginate: false,
                bFilter: false,
                "LengthChange": false,
                "info": false,
                /*"ordering": true,*/
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ],

                "bDestroy": true
            });
        });
        $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("input", function(e) { // Bind our desired behavior
                // If the length is 3 or more characters, or the user pressed ENTER, search
                if(this.value.length >= 3 || e.keyCode == 13) {
                    // Call the API search function
                    otable.search(this.value).draw();
                }
                // Ensure we clear the search if they backspace far enough
                if(this.value == "") {
                    otable.search("").draw();
                }
                return;
            });
        $('#tblMassProducts tbody').on('click', 'tr', function () {
            $("#tblMassProducts tbody tr").removeClass('row_selectedYellowish');
            $(this).addClass('row_selectedYellowish');

        });
        $('#tblMassProducts tbody').on('dblclick', 'tr', function () {

            var data = otable.row(this).data();
            var ProductId = data.ProductId;
            var code = data.PastelCode;
            window.open('{!!url("/extraProdInfoView")!!}/'+ProductId+"/"+code, 'extrainfoproducts'+ProductId,
                'left=100,top=100,width=800,height=400,toolbar=1,resizable=0');
        });

        $('#printAll').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{!!url("/printAllBarcode")!!}',
                type: "POST",
                data: {
                    value: "printall"
                },
                success: function (data) {

                }
            });
        });
    });
</script>