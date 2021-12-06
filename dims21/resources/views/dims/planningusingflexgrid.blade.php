
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Flex Picking Plan</h3>
<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>
<select  id="rouTabletLoadingtesonPlanning"  >

    @foreach($routes as $values)
        <option value="{{$values->Routeid}}">{{$values->Route}} </option>
    @endforeach

</select>
Ref: <input id="ref" >
 <input id="routeassigned" readonly style="display: none;">
<button id="save"> Save</button>
<button id="print" style="float: right">View & Print</button>
<div id="gridContainer" style="height: 800px;"/>

<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });
    window.onstorage = event => { // same as window.addEventListener('storage', event => {

        if (event.key == 'routeplanner'){
            console.debug("And a what");
            console.debug(event.key + ':' + event.newValue + " at " + event.url);

            let parameters = JSON.parse(event.newValue);
            console.debug(parameters.deliveryDate);
            getinfo(parameters.routeId,parameters.deliveryDate,parameters.deliveryDateTo);
            $('#ref').val(parameters.reference);

        }
        if (event.key == 'routechosen'){
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let parameters2 = JSON.parse(event.newValue);
            $('#routeassigned').val(parameters2.routes);
        }
    };
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
/*
        $('#gridBox').dxDropDownBox({
            value: [3],
            valueExpr: 'ID',
            placeholder: 'Select a value...',
            displayExpr: 'CompanyName',
            showClearButton: true,
            dataSource: makeAsyncDataSource('customers.json'),
            contentTemplate(e) {
                const v = e.component.option('value');
                const $dataGrid = $('<div>').dxDataGrid({
                    dataSource: e.component.getDataSource(),
                    columns: ['CompanyName', 'City', 'Phone'],
                    hoverStateEnabled: true,
                    paging: { enabled: true, pageSize: 10 },
                    filterRow: { visible: true },
                    scrolling: { mode: 'virtual' },
                    height: 345,
                    selection: { mode: 'multiple' },
                    selectedRowKeys: v,
                    onSelectionChanged(selectedItems) {
                        const keys = selectedItems.selectedRowKeys;
                        e.component.option('value', keys);
                    },
                });

                dataGrid = $dataGrid.dxDataGrid('instance');

                e.component.on('valueChanged', (args) => {
                    const { value } = args;
                    dataGrid.selectRows(value, false);
                });

                return $dataGrid;
            },
        });*/

        $('#print').click(function() {
            window.open('{!!url("/pickingplanlist")!!}/' + $('#ref').val(), "plan" + $('#ref').val(), "location=1,status=1,scrollbars=1, width=1200,height=850");
        });
        $('#save').click(function(){
            //var selectedRo = $('#routeassigned').val();
            var selectedRo = $('#rouTabletLoadingtesonPlanning').val();
            if(selectedRo.length < 1){
                var dialog = $('<p><strong style="color:black"> Please Assign Route </strong></p>').dialog({
                    height: 200, width: 900, modal: true, containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');
                        },

                    }
                });
            }else{
                var allGridItems =  $("#gridContainer").dxDataGrid("getDataSource").items();
                var checkedLines = new Array();
                console.log( allGridItems);
                allGridItems.forEach((element, index, array) => {


                    $.each(element.items, function(key, value) {
                        console.log( value);
                        var qty = value.qtyPlan;
                        if(qty !="0"){
                            console.log("no zero"+ value.qtyPlan);
                            checkedLines.push({
                                'orderdetail': value.OrderDetailId,
                                'qty': value.qtyPlan,
                                'pickingtype':'priority',
                                'ownerId':value.OwnerID,
                                'referenceNo':$('#ref').val()
                            });
                        }
                    });
                });

              /*  $.each(allGridItems, function(key, value) {
                     console.log( value);
                    var qty = value.toplan;
                    if(qty !="0"){
                        console.log("no zero"+ value.toplan);
                        checkedLines.push({
                            'orderdetail': value.OrderDetailId,
                            'qty': value.toplan,
                            'pickingtype':'priority',
                            'ownerId':value.OwnerID,
                            'referenceNo':$('#ref').val()
                        });
                    }
                });*/

                $.ajax({
                    url: '{!!url("/saveplan")!!}',
                    type: "POST",
                    data: {

                        referenceno: $('#ref').val(),
                        priority: checkedLines
                    },
                    success: function (data) {
                        console.debug("Plan Priority");

                        var nname = data[0].nickname;
                        console.debug(nname);
                        if (nname == "aegona") {
                            var dialog2 = $('<input type="text" placeholder="Picking Nickname" class="thisplannickname" style="border: 2px solid black;height:50px !important">').dialog({
                                height: 200, width: 700, modal: true, containment: false,
                                buttons: {
                                    "SAVE": function () {
                                        dialog2.dialog('close');
                                        $.ajax({
                                            url: '{!!url("/pickingNickName")!!}',
                                            type: "POST",
                                            data: {
                                                referenceno: $('#ref').val(),
                                                nickname: $('.thisplannickname').val()
                                            },
                                            success: function (data) {

                                            }
                                        });

                                    }
                                }
                            });
                        }
                    }
                });
            }

        });


    });function getinfo(routeid,datefrom,dateto){
        $.ajax({
            url: '{!!url("/getRouteDataMultiSelected")!!}',
            type: "POST",
            data: {
                routeId: routeid,
                deliveryDate: datefrom,
                OrderType: 1,
                deliveryDateTo:dateto,
                dateTo: dateto,
                status: 0,
                productId: -1,
            },
            success: function (data) {

                console.debug(data);
                $("#gridContainer").dxDataGrid({
                    dataSource:data.priority,
                    showBorders: true,
                    selection: {
                        mode: 'multiple',
                    },

                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                        paging: {
                            enabled: false
                        }
                        ,
                        editing: {
                            mode: "cell",
                            allowUpdating: true,
                            selectTextOnEditStart: true,
                            startEditAction: 'click',
                            allowDeleting: true,
                            confirmDelete: false
                        }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 30,
                            dataField: "CustomerId",
                            caption: "Customer ID",
                            visible: false

                        },
                        {
                            width: 30,
                            dataField: "OwnerID",
                            caption: "CompanyId",   visible: false

                        },{
                            width: 90,
                            dataField: "CompanyName",
                            caption: "Company Name",
                            visible: false

                        },
                        {
                            width: 80,
                            dataField: "CustomerPastelCode",

                            caption: "Customer Code"

                        },
                        {
                            width:300,
                            dataField: "StoreName",
                            groupIndex: 0,
                            caption: "Customer Name",

                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width:300,
                            dataField: "cName",

                            caption: "Customer Name",

                            headerFilter: {
                                allowSearch: true,
                            }

                        },

                        {
                            width: 80,
                            dataField: "OrderNo",
                            caption: "Sales Order No",

                            headerFilter: {
                                allowSearch: true,
                            },

                        },{
                            dataField: "areaname",
                            caption: "Area", width: 80

                        },{
                            dataField: "rname",
                            caption: "Route Name" ,width: 80

                        },{
                            width: 80,
                            dataField: "DeliveryDate",
                            caption: "Due Date"

                        }
                        ,{
                            dataField: "instruct",
                            caption: "Instruction"

                        }
                        ,{
                            width: 80,
                            dataField: "QtyOnHand",
                            caption: "OnHand",dataType:"number"

                        }
                        ,
                        {
                            dataField: "PastelDescription",
                            caption: "Item Name",
                            headerFilter: {
                                allowSearch: true,
                            }

                        }
                      ,{
                            width: 80,
                            dataField: "Mass",
                            caption: "Mass",dataType:"number",format: "#0.####"

                        }
                        ,{
                            width: 80,
                            dataField: "mnyQtyRemaining",
                            caption: "Outstanding Quantity"

                        }
                        ,{
                            dataField: "qtyPlan",
                            caption: "Plan",
                            dataType:"number", cellTemplate: function(element, info) {
                                element.append("<div>" + info.text + "</div>")
                                    .css("background", "#5c95c573")
                                    .css("font-size", "16px")
                                    .css("font-weight", "900");
                            }

                        },
                        {
                            caption: "M X Q",dataField: "mxq",sColor: "Red",format: "#0.####",
                            calculateCellValue: function (rowData) {
                                return rowData.Mass * rowData.qtyPlan;
                            }
                            , cellTemplate: function(element, info) {
                                element.append("<div>" + info.text + "</div>")
                                    .css("background", "#3175af")
                                    .css("font-size", "16px")
                                    .css("font-weight", "900");
                            }
                        }

                    ] ,
                    sortByGroupSummaryInfo: [{
                        summaryItem: 'count',
                    }],
                    summary: {
                        recalculateWhileEditing: true,
                        groupItems: [{
                            column: 'StoreName',
                            summaryType: 'count',
                            displayFormat: '{0} lines',
                        },{
                            column: 'qtyPlan',
                            summaryType: 'sum',
                            displayFormat: 'Total: {0}',
                            showInGroupFooter: true,
                        },{
                            column: 'mxq',
                            summaryType: 'sum',
                            displayFormat: 'MXQ: {0}',
                            showInGroupFooter: true,
                        }],
                        totalItems: [
                            {
                            column: "qtyPlan",
                            summaryType: "sum",format: "#0.####"
                        },
                            {
                            column: "toplan",
                            summaryType: "sum",format: "#0.####"
                        },
                            {
                                column: "mxq",
                                summaryType: "sum",format: "#0.####"
                            }

                        ]


                    },
                    onContentReady: function (e) {
                        var selectedDatasUsers = e.component.getDataSource().items();

                        var qty = 0;
                            console.log(selectedDatasUsers);  console.log("work wen 2");
                        selectedDatasUsers.forEach((element, index, array) => {
                            console.log(element.items[0]); // 100, 200, 300
                            qty = qty +(parseFloat(element.items[0].Mass) * parseFloat(element.items[0].qtyPlan)  );
                            console.log("no zero*************"+ qty);
                            if(qty !="0"){

                            }
                           // console.log(index); // 0, 1, 2
                            //console.log(array); // same myArray object 3 times
                        });
                      /*  $.each(selectedDatasUsers, function(key, value) {
                            console.log( (value.items).Mass);
                            console.log( key);
                             //qty = qty +(parseFloat(value.items.Mass) * parseFloat(value.items.mnyQtyRemaining)  );
                            console.log("no zero*************"+ qty);
                            if(qty !="0"){

                            }
                        });*/
                            //$('#weightshere').val( qty);
                    },

                    onRowClick: function (e) {



                    },


                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });

            }
        });


    }
</script>
</div>
</body>
</html>
