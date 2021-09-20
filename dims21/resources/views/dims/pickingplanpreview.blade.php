<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h2>Picking Plan Preview </h2>

<div style="padding-bottom: 4px;display: none;">
    <label>
        File Name:
        <input type="text" id="fileName"/>
    </label>
    <label style="margin-left: 20px;">
        Separator
        <input type="text" style="width: 20px;" id="columnSeparator" value=","/>
    </label>
    <label style="margin-left: 20px;">
        <button onclick="onBtExport()" style="background: #10f310;">Export to CSV</button>
    </label>
</div>

<div style="background: yellow;    padding: 15px;display: none;" >

    Date From <input id="datefrom1">
    Date To<input id="dateeto1">
    Status <select id="status">
        <option value="0">Plan no finalized</option>
        <option value="1">Finalized</option>
        <option value="2">Picking</option>
        <option value="3">Auth</option>
    </select>

    <button id="submit">Submit</button>
</div>

<div style="display: flex;">

    <div  style="height: 500px;overflow-y: scroll;width:100%">
        <input id="ref" value="{{$ref}}" readonly>
        Weight:<input id="weight" readonly>
        Volume:<input id="volume" readonly>
        <button id="savechanges">Save Changes</button>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Store Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Weight</th>
                <th>Quantity Planned</th>
            </tr>
            </thead>
            <tbody id="productsbyref">

            </tbody>

        </table>


    </div>
</div>
<div style="display: flex;">

    <div style="height: 500px;width:100%;">
        Route To<select id="routes">
            @foreach($routes as $val)
                <option value="{{$val->Routeid}}">{{$val->Route}}</option>
            @endforeach
        </select> Delivery Type<select id="ordertypes">
            @foreach($orderTypes as $val)
                <option value="{{$val->OrderTypeId}}">{{$val->OrderType}}</option>
            @endforeach
        </select> Trailor Type <select id="truckid">
            @foreach($trucks as $val)
                <option value="{{$val->TruckId}}">{{$val->TruckName}}</option>
            @endforeach
        </select>
        Delivery Date<input id="deliverydate">
        <button id="doneplanning" class="btn-lg btn-primary">Process</button>
        <br><br>
        <table>
            <thead>
            <tr>

                <th>Code</th>
                <th>Description</th>
                <th>Quantity Planned</th>
                <th>Explanation</th>
            </tr>
            </thead>
            <tbody id="explanations">

            </tbody>

        </table>
        <br>
        <button id="sendforapproval" class="btn-lg">Send For Approval</button>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $('#sendforapproval').hide();
        $("#datefrom1").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#dateeto1").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });
        $("#deliverydate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'yy-mm-dd'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        doSomething($('#ref').val());

        $('#doneplanning').click(function(){
            $('#sendforapproval').hide();
            $.ajax({
                url: '{!!url("/updatepickingheader")!!}',
                type: "POST",
                data: {
                    routeId: $('#routes').val(),
                    deliveryDate: $('#deliverydate').val(),
                    OrderType: $('#ordertypes').val(),
                    truckid: $('#truckid').val(),
                    ref:$('#ref').val()


                },
                success: function (data) {
                    var trHTML = '';
                    var counter = 0;

                    console.debug(data.length);
                    $('#explanations').empty();
                    $.each(data, function (key, value) {
                        trHTML +='<tr style="font-size: 12px;color: black;background: lightcoral" class="hidden_row1'+counter+' hidden_row">'+

                            '<td style="padding: 0px;width: 30%;">'+value.PastelCode+'</td>'+
                            '<td style="padding: 0px;width: 50%;">'+value.PastelDescription+'</td>'+
                            '<td style="padding: 0px;width: 30%;">'+value.mnyQty+'</td>'+
                            '<td style="padding: 0px;width: 50%;">'+value.strRuleExplanation+'</td>'+
                            '</tr>';
                        counter++;
                    });
                    //
                    $('#explanations').append(trHTML);
                    $('#sendforapproval').show();

                }
            });

        });

        $('#sendforapproval').click(function(){
            $.ajax({
                url: '{!!url("/markreftobeapproved")!!}',
                type: "POST",
                data: {
                    ref:$('#ref').val()
                },
                success: function (data) {


                }
            });

        });

        $('#savechanges').click(function(){
            var checkedLines = new Array();
            $('[name="unique"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                checkedLines.push({
                    'id': id,
                    'mnq': $(this).closest('tr').find('.mnq').val()
                });

            });
            $.ajax({
                url: '{!!url("/updateplanlines")!!}',
                type: "POST",
                data: {
                    ref:$('#ref').val(),
                    planlines:checkedLines
                },
                success: function (data) {
                    var dialog = $('<p><strong style="color:green">Plan Updated</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                            }
                        }
                    });

                }
            });

        });

    });

    $('#submit').click(function () {
        $( "#myGrid" ).empty();
        $('#myGrid').show();
        // specify the columns

        // lookup the container we want the Grid to use
        var eGridDiv = document.querySelector('#myGrid');

        // create the grid passing in the div to use together with the columns & data we want to use
        new agGrid.Grid(eGridDiv, gridOptions);

        var datefrom1 = $('#datefrom1').val();
        var dateto1 = $('#dateeto1').val();
        var status = $('#status').val();

        fetch('{!!url("/pickingticketslist")!!}/' + datefrom1 + "/" + dateto1 +"/"+status).then(function (response) {
            return response.json();
        }).then(function (data) {
            gridOptions.api.setRowData(data);
        });

        //onBtExport();

        //getBooleanValue(cssSelector);

    });
    function getBooleanValue(cssSelector) {
        return document.querySelector(cssSelector).checked === true;
    }
    function doSomething(strUnickReference){
        //
        //$('#ref').val(strUnickReference);
        $.ajax({
            url: '{!!url("/GetPickingReferenceProducts")!!}',
            type: "GET",
            data: {

                ref: strUnickReference

            },
            success: function (data) {
                var trHTML = '';
                var counter = 0;
                var massTotal = 0;
                $('#productsbyref').empty();
                $.each(data, function (key, value) {
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" class="hidden_row1'+counter+' hidden_row"><td style="padding: 0px;width: 10%;">'+
                        '<input type="checkbox" name="unique" id ="unique" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +value.intAutoPicking + '" /></td>' +
                        '<td style="padding: 0px;width: 30%;">'+value.StoreName+'</td>'+
                        '<td style="padding: 0px;width: 20%;">'+value.PastelCode+'</td>'+
                        '<td style="padding: 0px;width: 70%;">'+value.PastelDescription+'</td>'+
                        '<td style="padding: 0px;width: 10%;">'+parseFloat(value.mass*1000).toFixed(2)+'</td>'+
                        '<td style="padding: 0px;width: 30%;"><input class="mnq" value="'+value.mnyQty+'"><input type="hidden" class="intAutoPicking" value="' +value.intAutoPicking + '"> </td>'+
                        '</tr>';
                    counter++;
                    massTotal= parseFloat(massTotal) + parseFloat(value.mass);
                });

                //
                $('#productsbyref').append(trHTML);
                $('#weight').val(parseFloat(massTotal*1000).toFixed(2));



            }
        });



    }
    function numberParser(params) {
        var newValue = params.newValue;
        var valueAsNumber;
        if (newValue === null || newValue === undefined || newValue === '') {
            valueAsNumber = null;
        } else {
            valueAsNumber = parseFloat(params.newValue);
        }
        return valueAsNumber;
    }
    function onBtExport() {
        var params = {
            skipHeader: getBooleanValue('#skipHeader'),
            columnGroups: getBooleanValue('#columnGroups'),
            skipFooters: getBooleanValue('#skipFooters'),
            skipGroups: getBooleanValue('#skipGroups'),
            skipPinnedTop: getBooleanValue('#skipPinnedTop'),
            skipPinnedBottom: getBooleanValue('#skipPinnedBottom'),
            allColumns: getBooleanValue('#allColumns'),
            onlySelected: getBooleanValue('#onlySelected'),
            suppressQuotes: getBooleanValue('#suppressQuotes'),
            fileName: document.querySelector('#fileName').value,
            columnSeparator: document.querySelector('#columnSeparator').value
        };

        if (getBooleanValue('#skipGroupR')) {
            params.shouldRowBeSkipped = function (params) {
                return params.node.data.country.charAt(0) === 'R';
            };
        }

        if (getBooleanValue('#useCellCallback')) {
            params.processCellCallback = function (params) {
                if (params.value && params.value.toUpperCase) {
                    return params.value.toUpperCase();
                } else {
                    return params.value;
                }
            };
        }

        if (getBooleanValue('#useSpecificColumns')) {
            params.columnKeys = ['country', 'bronze'];
        }

        if (getBooleanValue('#processHeaders')) {
            params.processHeaderCallback = function (params) {
                return params.column.getColDef().headerName.toUpperCase();
            };
        }

        if (getBooleanValue('#customHeader')) {
            params.customHeader = '[[[ This ia s sample custom header - so meta data maybe?? ]]]\n';
        }
        if (getBooleanValue('#customFooter')) {
            params.customFooter = '[[[ This ia s sample custom footer - maybe a summary line here?? ]]]\n';
        }

        gridOptions.api.exportDataAsCsv(params);
    }

</script>
</body>
</html>
