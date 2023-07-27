<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
        <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
        <title>Stock Change</title>
    
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
        <!-- DevExtreme theme -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    
    </head>

<body>
    <div class="col-12 d-flex px-0"  style="background: white;">
        <div class="col-custom-2" style="background: white;">
    
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <div class="col p-3">
            <h3>Stock Change</h3>

            {{-- Initial customer --}}
            <div>
                <div class="form-group">
                    <label class="control-label" for="customers"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                    <select  class="form-control input-sm col-xs-1 " id="customers" style="width: 100%" required>
                        <option></option>
                        @foreach($customers as $val)
                            <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Initial Product --}}
                <div class="form-group">
                    <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                    <select  class="form-control input-sm col-xs-1" id="prodname" style="width: 100%" required>
                        <option></option>
                    </select>
                </div>

                {{-- Ticket Number --}}
                <div class="form-group">
                    <label class="control-label" for="ticketNo"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Ticket Number </label>
                    <select  class="form-control input-sm col-xs-1" id="ticketNo" style="width: 100%" required>
                        <option></option>
                    </select>
                </div>

                {{-- Mass --}}
                <div class="form-group">
                    <label class="control-label" for="mass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass</label>
                    <input type="number" class="form-control input-sm col-xs-1" id="mass" required disabled>
                </div>

                {{-- New Customer --}}
                <div class="form-group">
                    <label class="control-label" for="newcustomers"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">New Customer</label>
                    <select  class="form-control input-sm col-xs-1 " id="newcustomers" style="width: 100%" required>
                        <option></option>
                        @foreach($customers as $val)
                            <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- New Product Name --}}
                <div class="form-group">
                    <label class="control-label" for="newprodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">New Product Name </label>
                    <select  class="form-control input-sm col-xs-1" id="newprodname" style="width: 100%" required>
                        <option></option>
                    </select>
                </div>

                {{-- SE Code --}}
                <div class="form-group">
                    <label class="control-label" for="SECode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">SE no.</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="SECode" required disabled>
                </div>

                <button class="btn btn-success" id="save" style="width: 100%;">SAVE</button>
            </div>
        </div>

    </div>
</body>

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
        
        $("#customers").select2();
        $("#newcustomers").select2();

        $("#customers").change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#customers").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductName+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });

        });

        $("#newcustomers").change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#newcustomers").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#newprodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductName+'">'+o.ProductName+'</option>';
                    });
                    $("#newprodname").append(toAppend);
                    $("#newprodname").select2();
                }
            });
        });

        $("#prodname").change(function () {
            $.ajax({

                url: '{!!url("/getticketno")!!}',
                type: "GET",
                data: {
                    customer: $("#customers").val(),
                    product: $("#prodname option:selected").text(),
                },
                success: function (data) {
                    var toAppend = '';
                    $("#ticketNo").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.TicketNo+'">'+o.TicketNo+'</option>';
                    });
                    $("#ticketNo").append(toAppend);
                    $("#ticketNo").select2();
                }
            });
        });
        
        $("#ticketNo").change(function () {
            $.ajax({

                url: '{!!url("/getmasswmax")!!}',
                type: "GET",
                data: {
                    ticket: $("#ticketNo option:selected").text(),
                },
                success: function (data) {
                    mass = data[0].Weight;
                    $('#mass').val(mass);
                }
            });
        });

        $("#newprodname").change(function () {
            $.ajax({

                url: '{!!url("/getSEno")!!}',
                type: "GET",
                data: {
                    customer: $("#newcustomers").val(),
                    product: $("#newprodname option:selected").text(),
                },
                success: function (data) {
                    SECode = data[0].SECode;
                    console.debug(SECode);
                    $('#SECode').val(SECode);
                }
            });
        });

        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/savestockchangewmax")!!}',
                type: "POST",
                data: {
                    ticketNo : $('#ticketNo option:selected').val(),
                    mass : $('#mass').val(),
                    newcustname : $('#newcustomers option:selected').val(),
                    newprodname : $('#newprodname option:selected').val(),
                    SENo : $('#SECode').val(),
                },
                success: function (data) {
                    location.reload();
                }

            });
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
    }






</script>
</body>
