
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

<table class='border' style = "width:800">
                <tbody>

<tr>
                        <td>
                            <div id="gridContainer"/>


                        </td>

<td>
<label class="control-label" for="customerid"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer ID</label>
<input type = "text" id = "customerid"readonly>
<br>
            <label class="control-label" for="CustomerStorename"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
<input type = "text" id = "CustomerStorename"readonly>
<br>
            <label class="control-label" for="pastelcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Code</label>
<input type = "text" id = "pastelcode" readonly>
<br>
            <label class="control-label" for="route"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Route</label>
<select id = "route"name = "route"></select>
<br>
<label class="control-label" for="Email"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Email Address</label>
<input type = "text" id = "Email" >
<br>
<label class="control-label" for="ContactPerson"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Person</label>
<input type = "text" id = "ContactPerson" >
<br>
<label class="control-label" for="PriceListName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Price List Name</label>
<input  type = "text"id = "PriceListName" name = "PriceListName"readonly></select>
<br>
<label class="control-label" for="ContactNumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contact Number</label>
<input type = "text" id = "ContactNumber" >
<br>
<label class="control-label" for="GroupName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Group Name</label>
<select  id = "GroupName" name = "GroupName" type = "text"></select>
<br>
<label class="control-label" for="SalesRep"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Sales Representative</label>
<select  id = "SalesRep" name = "SalesRep"type = "text">
<option value = "">None</option>
</select>
<br>
<label class="control-label" for="DeliverySeq"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Sequence</label>
<input type = "text" id = "DeliverySeq" >
<br>
<label class="control-label" for="DocPrintOrEmail"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Receives Email</label>
<select  id = "DocPrintOrEmail" type = "text">
<option value = "False">No</option>
<option value = "True">Yes</option>
</select>
<br>
<label class="control-label" for="Discount"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Discount</label>
<input type = "text" id = "Discount" readonly>
<br>
<label class="control-label" for="CreditLimit"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Credit Limit</label>
<input type = "text" id = "CreditLimit" readonly>
<br>
<label class="control-label" for="UniqueDelivery"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Unique Delivery</label>
<select  id = "UniqueDelivery" type = "text">
<option value = "False">No</option>
<option value = "True">Yes</option>
</select>
<br>
<label class="control-label" for="PriorityCustomer"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Priority Customer</label>
<select  id = "PriorityCustomer" type = "text">
<option value = "False">No</option>
<option value = "True">Yes</option>
</select>
<br>
<label class="control-label" for="CustomerOnHold"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer On Hold?</label>
<select  id = "CustomerOnHold"type = "text" >
<option value = "False">No</option>
<option value = "True">Yes</option>
</select>
<br>
<label class="control-label" for="MarkupPercentage"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Markup Percentage</label>
<input type = "text" id = "MarkupPercentage" >
<br>
<br>
            <button class="form-control btn-md btn-success" id="update">Update</button>
                        </td>
                    </tr>
                </tbody>
            </table>


<script>
    
    var jArray = JSON.stringify({!! json_encode($routes) !!});

    var Routes = $.map(JSON.parse(jArray), function (item) {
        return {
            Route: item.Route, //
            RouteId:item.Routeid,
            CustomerId:item.CustomerId,//
            StoreName:item.StoreName,//
            CustomerPastelCode:item.CustomerPastelCode,//
            Email:item.Email,
            ContactPerson:item.ContactPerson,
            ContactTel:item.ContactTel,
            PriceListName:item.PriceListName,
            PriceListId:item.PriceListId,
            GroupName:item.groupname,
            GroupId:item.GroupId,
            UserName:item.UserName,
            SalesAnalysisCode:item.SalesAnalysisCode,
            DeliverySequence:item.DeliverySequence,
            DocPrintOrEmail:item.DocPrintOrEmail,
            Discount:item.Discount, 
            CreditLimit:item.CreditLimit,
            UniqueDelivery:item.UniqueDelivery,
            PriorityCustomer:item.PriorityCustomer,
            CustomerOnHold:item.CustomerOnHold,
            MarkupPercentage:item.MarkupPercentage,
            LocationName:item.locationName
        }

    });

    var jArrayRoutesOnly = JSON.stringify({!! json_encode($routesonly) !!});
    var RoutesOnly = $.map(JSON.parse(jArrayRoutesOnly), function (item) {
        return {
            Route: item.Route,
            RouteId:item.RouteId
        }

    });
    var jArrayGroupsOnly = JSON.stringify({!! json_encode($groups) !!});
    var GroupsOnly = $.map(JSON.parse(jArrayGroupsOnly), function (item) {
        return {
            Group: item.GroupName,
            GroupId:item.GroupId
        }

    });
    var jArraySalesMenOnly = JSON.stringify({!! json_encode($salesmen) !!});
    var SalesMen = $.map(JSON.parse(jArraySalesMenOnly), function (item) {
        return {
            Name: item.UserName,
            SalesCode:item.strSalesmanCode
        }

    });

        $( document ).on( 'focus', ':input', function(){

            $( this ).attr( 'autocomplete', 'off' );
        });
        var clickTimer, lastRowClickedId;
        $(document).ready(function() {  
            for(var index = 0; index < RoutesOnly.length;index++){
                $('#route').append('<option value="'+RoutesOnly[index].RouteId+'">'+RoutesOnly[index].Route +'</option>');
          
            }
            for(var index = 0; index < GroupsOnly.length;index++){
                $('#GroupName').append('<option value="'+GroupsOnly[index].GroupId+'">'+GroupsOnly[index].Group +'</option>');
          
            }
            for(var index = 0; index < SalesMen.length;index++){
                $('#SalesRep').append('<option value="'+SalesMen[index].SalesCode+'">'+SalesMen[index].Name +'</option>');
          
            }
           
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $('#update').click(function(){

                $.ajax({
                    url: '{!!url("/updateCustomerGrid")!!}',
                    type: "Post",
                    data:{
                    customerid: $('#customerid').val(),
                    route:$('#route').val(),
                    email:$('#Email').val(),
                    contactperson:$('#ContactPerson').val(),
                    pricelist:$('#PriceListName').val(),
                    contactno:$('#ContactNumber').val(),
                    groupname:$('#GroupName').val(),
                    salesrep:$('#SalesRep').val(),
                    deliveryseq:$('#DeliverySeq').val(),
                    receivesemail:$('#DocPrintOrEmail').val(),
                    discount:$('#Discount').val(),
                    creditlim:$('#CreditLimit').val(),
                    uniquedel:$('#UniqueDelivery').val(),
                    priocust:$('#PriorityCustomer').val(),
                    onhold:$('#CustomerOnHold').val(),
                    markupperc:$('#MarkupPercentage').val()
                    },
                    success: function(data){
                        var dialog = $('<p>Data Saved.</p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "OKAY": function () {

                                            dialog.dialog('close');
                                            location.reload(true);

                                        }
                                    }
                                });
                    }
                });
           
        });

                            $("#gridContainer").dxDataGrid({
                                dataSource:Routes,
                                showBorders: true,
                                width:1000,
                                filterRow: { visible: true },scrolling: {
            columnRenderingMode: "virtual"
        },columnWidth:200,
        columnAutoWidth:true,
                                columns: [
                                    {
                                        dataField: "CustomerId",
                                        caption: "Customer ID"

                                    },
                                    {
                                        dataField: "StoreName",
                                        caption: "Customer Name"

                                    },
                                    {
                                        dataField: "CustomerPastelCode",
                                        caption: "Customer Code"

                                    },
                                    {
                                        dataField: "Route",
                                        caption: "Route"

                                    },
                                    {
                                        width:0,
                                        dataField:"RouteId",
                                        caption:"RouteId",
                                        visible:"false"
                                    },
                                    {
                                        dataField: "Email",
                                        caption: "Email Address"

                                    },{
                                        dataField: "ContactPerson",
                                        caption: "Contact Person"

                                    },{
                                        dataField: "ContactTel",
                                        caption: "Contact Number"

                                    },{
                                        dataField: "PriceListName",
                                        caption: "PriceList Name"

                                    },{
                                        dataField: "GroupName",
                                        caption: "Group Name"

                                    },{
                                        width :0,
                                        dataField: "GroupId",
                                        caption: "GroupId "

                                    },{
                                        dataField: "UserName",
                                        caption: "Sales Rep"

                                    },{
                                        width:0,
                                        dataField: "SalesAnalysisCode",
                                        caption: "Sales Code"

                                    },{
                                        dataField: "DeliverySequence",
                                        caption: "Delivery Sequence"

                                    },{
                                        dataField: "DocPrintOrEmail",
                                        caption: "Receives Email?"
                                        
                                    },{
                                        dataField: "Discount",
                                        caption: "Discount"

                                    },{
                                        dataField: "CreditLimit",
                                        caption: "Credit Limit"

                                    },{
                                        dataField: "UniqueDelivery",
                                        caption: "Unique Delivery?"

                                    },{
                                        dataField: "PriorityCustomer",
                                        caption: "Priority Customer?"

                                    },{
                                        dataField: "CustomerOnHold",
                                        caption: "Customer On Hold?"

                                    },{
                                        dataField: "MarkupPercentage",
                                        caption: "Markup Percentage"

                                    },{
                                        dataField: "LocationName",
                                        caption: "Location Name"

                                    },

                                ] ,
                                
                        onRowClick: function (e) {
                          
                            $('#customerid').val(e.key.CustomerId);
                            $('#CustomerStorename').val(e.key.StoreName);
                            $('#pastelcode').val(e.key.CustomerPastelCode);
                            $('#route').val(e.key.RouteId);
                            $('#Email').val(e.key.Email)
                            $('#ContactPerson').val(e.key.ContactPerson);
                            $('#PriceListName').val(e.key.PriceListName);
                            $('#ContactNumber').val(e.key.ContactTel);
                            $('#GroupName').val(e.key.GroupId);
                            $('#SalesRep').val(e.key.SalesAnalysisCode);
                            $('#DeliverySeq').val(e.key.DeliverySequence);
                            $('#DocPrintOrEmail').val(e.key.DocPrintOrEmail);
                            $('#Discount').val(e.key.Discount);
                            $('#CreditLimit').val(e.key.CreditLimit);
                            $('#UniqueDelivery').val(e.key.UniqueDelivery);
                            $('#PriorityCustomer').val(e.key.PriorityCustomer);
                            $('#CustomerOnHold').val(e.key.CustomerOnHold);
                            $('#MarkupPercentage').val(e.key.MarkupPercentage);

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
                
            });
    </script>
</div>
</body>
</html>
