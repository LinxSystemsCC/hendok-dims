
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

    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">

    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Flex Picking Plan</h3>
<a href='{!!url("/viewpickingtickets")!!}' onclick="window.open(this.href, 'viewpickingtickets',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="background: red;padding:10px;color: black;font-weight: 900" >My Picking Sips</a>
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

<div id="nameyourplan">
<input type="text" id="saveplanNickName" ><br>
    <button id="savethisnickname" style="width:50px;height:50px;">SAVE</button>
</div>
</div>
</body>
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
        $('#nameyourplan').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


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
                        var newvalue = new Number(value.qtyPlan);
                        if(qty !="0"){
                            console.log("no zero"+ value.qtyPlan);
                            checkedLines.push({
                                'orderdetail': value.OrderDetailId,
                                'qty': newvalue.toFixed(4),
                                'pickingtype':'priority',
                                'ownerId':value.OwnerID,
                                'referenceNo':$('#ref').val()
                            });
                        }
                    });
                });

                $.ajax({
                    url: '{!!url("/saveplan")!!}',
                    type: "POST",
                    data: {

                        referenceno: $('#ref').val(),
                        priority: checkedLines
                    },
                    success: function (data) {
                        console.debug("Plan Priority");

                        window.open('{!!url("/plannickname")!!}/' + $('#ref').val(), "plannickname" + $('#ref').val(), "location=1,status=1,scrollbars=1, width=1200,height=850");

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
                            width:40,
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
                            caption: "Route Name" ,width: 50

                        }
                        ,{
                            width: 80,
                            dataField: "DeliveryDate",
                            caption: "Due Date"

                        }
                        ,{
                            width: 80,
                            dataField: "OrderDate",
                            caption: "Ordered Date"

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
                            width:300,
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
                            dataField: "mnyQtyRemaining",dataType:"number",
                            caption: "Outstanding Quantity",format: "#0.####"

                        }
                        ,{
                            width: 80,
                            dataField: "qtyPlan",
                            caption: "Plan",format: "#0.####",
                            dataType:"number", cellTemplate: function(element, info) {
                                element.append("<div>" + info.text + "</div>")
                                    .css("background", "#5c95c573")
                                    .css("font-size", "16px")
                                    .css("font-weight", "900");
                            }

                        },
                        {
                            width: 80,
                            caption: "M X Q",dataField: "mxq",sColor: "Red",format: "#0.####",dataType:"number",
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
                    onRowPrepared(e) {
                        if (e.rowType == 'data' && e.data.DocType ==1) {
                            e.rowElement.css('background', 'yellow');
                        }
                        if (e.rowType == 'data' && e.data.isRoofing !="Roofing" && parseInt(e.data.qtyPlan) >  parseInt(e.data.QtyOnHand) ) {
                            e.rowElement.css('background', 'red');
                        }
                        if (e.rowType == 'data' && e.data.instruct =="WAREHOUSE TRANSFER") {
                            e.rowElement.css('background', 'lightgreen');
                        }

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

</html>
