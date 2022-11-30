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
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <!-- Select2 JS -->

    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

</head>

<body>
<div class="col-lg-12 bd-highlight"  style="background: white; display: block; height: 100vh; padding: 20px !important;">

    <h3>Re-Test</h3>

    <div class="d-flex">
        {{-- Left Div --}}
        <div style="padding: 20px;">

            {{-- scales --}}
            <div class="form-group">
                <label class="control-label" for="scales"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Scales</label>
                <select  class="form-control input-sm col-xs-1 " id="scales" style="width: 100%; height:38px !important;" required>
                    <option></option>
                    @foreach($scales as $val)
                        <option value="{{$val->ScaleID}}">{{$val->ScaleDescription}}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- customer --}}
            <div class="form-group">
                <label class="control-label" for="customers"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                <select  class="form-control input-sm col-xs-1 " id="customers" style="width: 100%; height:38px !important;" required>
                    <option></option>
                    @foreach($customers as $val)
                        <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product --}}
            <div class="form-group">
                <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                <select  class="form-control input-sm col-xs-1" id="prodname" style="width: 100%; height:38px !important;" required>
                    <option></option>
                </select>
            </div>

            {{-- Zinc Spec --}}
            <div class="form-group">
                <label class="control-label" for="zincspec"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Zinc</label>
                <input type="text" class="form-control input-sm col-xs-1" id="zincspec" required disabled>
            </div>

            {{-- MPA Spec --}}
            <div class="form-group">
                <label class="control-label" for="mpaspec"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">MPA Spec</label>
                <input type="text" class="form-control input-sm col-xs-1" id="mpaspec" required disabled>
            </div>

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label" for="blank"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;"></label>
                <input type="text" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- Wire Size Spec --}}
            <div class="form-group">
                <label class="control-label" for="wirespec"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Wire Size Spec</label>
                <input type="text" class="form-control input-sm col-xs-1" id="wirespec" required disabled>
            </div>

        </div>

        {{-- Right Div --}}
        <div style="padding: 20px;">

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label" for="blank"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;"></label>
                <input type="number" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label" for="blank"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;"></label>
                <input type="number" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- SE Code --}}
            <div class="form-group">
                <label class="control-label" for="SECode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">SE no.</label>
                <input type="text" class="form-control input-sm col-xs-1" id="SECode" required disabled>
            </div>
            

            {{-- Zinc Tested --}}
            <div class="form-group">
                <label class="control-label" for="zinctested"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Actual Zinc Tested</label>
                <input type="number" class="form-control input-sm col-xs-1" id="zinctested" required>
            </div>

            {{-- MPA Tested --}}
            <div class="form-group">
                <label class="control-label" for="mpatested"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Actual MPA Tested</label>
                <input type="number" class="form-control input-sm col-xs-1" id="mpatested" required>
            </div>

            {{-- Tensile Ticket--}}
            <div class="form-group">
                <label class="control-label" for="tensileticket"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tensile Ticket No</label>
                <input type="number" class="form-control input-sm col-xs-1" id="tensileticket" required>
            </div>
            
            {{-- Wire Size --}}
            <div class="form-group">
                <label class="control-label" for="wiresize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Actual Wire Size</label>
                <input type="number" class="form-control input-sm col-xs-1" id="wiresize" required>
            </div>

        </div>
    </div>
    {{-- Remarks --}}
    <div class="form-group">
        <label class="control-label" for="remark"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Remarks</label>
        <textarea  type="text" rows="3" class="form-control input-sm col-xs-1" id="remark" required></textarea>
    </div>

    {{-- Tare Mass --}}
    <div class="form-group">
        <label class="control-label" for="tare"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tare Mass</label>
        <select  class="form-control input-sm col-xs-1" id="tare" required>
            <option>
            </option>
        </select>
    </div>

    {{-- Gross Mass --}}
    <div class="form-group">
        <label class="control-label" for="mass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass</label>
        <input type="number" class="form-control input-sm col-xs-1" id="mass" required>
    </div>

    {{-- Final Mass --}}
    <div class="form-group">
        <label class="control-label" for="final"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Final Mass</label>
        <input type="number" class="form-control input-sm col-xs-1" id="final" required disabled>
    </div>
    
    <button class="btn btn-success" id="save" style="width: 100%;">SAVE</button>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }
</style>

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
        
        $("#tare").change(function() {
            //console.debug($('#tare').val());
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });
        
        $("#mass").change(function() {
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });

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

                        toAppend += '<option value="'+o.ProductID+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });

        });

        //Get Scales
        $.ajax({

            url: '{!!url("/getscales")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                // $("#tare").select2({ data:result });
                // console.log(data.length);
                // console.log(data);

                for (let i = 0; i < data.length; i++) {
                    // console.log(data[i].StandName);
                    name = data[i].StandName;
                    mass = data[i].StandMass;

                    $('#tare').append(`<option value="${mass}">${name}</option>`);
                }


            }
        });

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

                        toAppend += '<option value="'+o.ProductID+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });

        });


        $("#prodname").change(function () {
            $.ajax({

                url: '{!!url("/getretest")!!}',
                type: "GET",
                data: {
                    customer: $("#customers").val(),
                    product: $("#prodname option:selected").text(),
                },
                success: function (data) {
                    $('#zincspec').val(data[0].ZincSpec);
                    $('#mpaspec').val(data[0].MPATolerance);
                    $('#wirespec').val(data[0].SizeTolerance);
                    $('#SECode').val(data[0].SECode);
                }
            });
        });

        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/saveretest")!!}',
                type: "POST",
                data: {
                    custname  : $('#customers option:selected').val(),
                    prodname  : $('#prodname option:selected').val(),
                    zincTested  : $('#zinctested').val(),
                    MPATested  : $('#mpatested').val(),
                    tensileTicket  : $('#tensileticket').val(),
                    wireSize  : $('#wiresize').val(),
                    remark  : $('#remark').val(),
                    taremass  : $('#tare option:selected').val(),
                    grossmass  : $('#mass').val(),
                    finalmass  : $('#final').val(),

                },
                success: function (data) {
                    location.reload();
                }

                });
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
