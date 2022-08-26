<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




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
    </style>


</head>
<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            <a href='{!!url("/createPalletConfig")!!}'>Pallets Configurations</a>
            <a href='{!!url("/mapitemstopallet")!!}' >Map Pallet To Items</a>
            <a href='{!!url("/departmentpage")!!}'>Departments</a>
            <a href='{!!url("/machines")!!}'>Machines</a>
            <a href='{!!url("/mapmachinestodept")!!}' >Map Machines To Dept</a>
            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines,Dept & Prod</a>
            <a href='{!!url("/createjobs")!!}'  class="active">Create Jobs</a>
            <a href="#">In Progress Jobs</a>
            <a href="#">Jobs Data</a>
        </div>
    </div>
    <div class="col-lg-10" >

        <h1>CHOOSE PRODUCT</h1>
        <fieldset class="well">
            <form>
        <div class="form-group">
            <label class="control-label" for="department"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Group </label>
            <select  class="form-control input-sm col-xs-1" id="department" required>
                <option></option>
                @foreach($prodGroups as $val)
                    <option value="{{$val->ItemGroup}}">{{$val->ItemGroupDescription}}</option>
                @endforeach

            </select><br><br>

            <input type='button' value='GO GET CATEGORIES' class="btn-lg btn-primary" id='but_read'><br>

        </div>
                <div class="form-group">
                    <label class="control-label" for="productcategory"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                    <select  class="form-control input-sm col-xs-1" id="productcategory" required>
                        <option></option>
                    </select><br><br>
                    <input type='button' class="btn-lg btn-primary" value='GO CHOOSE PRODUCT' id='getproduct' style="margin-top: 22px;">
                </div>
                <div class="form-group">
                    <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                    <select  class="form-control input-sm col-xs-1" id="prodname" required>
                        <option></option>
                    </select>

                </div>

            </form>
        </fieldset>
        <br><br><br>
        <button class="btn-danger btn-lg" id="savedepartment" style="width: 100%;">NEXT</button>
    </div>
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
        $("#department").select2();

        $('#but_read').click(function(){
            var ItemGroupDescription = $('#department option:selected').text();
            var ItemGroup = $('#department').val();
            $.ajax({

                url: '{!!url("/getProdCategory")!!}',
                type: "GET",
                data: {
                    ItemGroup: ItemGroup

                },
                success: function (data) {
                    var toAppend = '';
                    $("#productcategory").empty();
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.strProductCategory+'">'+o.strProductCategory+'</option>';
                    });
                    $("#productcategory").append(toAppend);
                    $("#productcategory").select2();
                    $("#productcategory").change(function () {
                        $("#prodname").empty();



                    });



                }

            });

           // $('#result').html("id : " + userid + ", name : " + username);

        });

        $('#getproduct').click(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#department').val(),
                    strProductCategory: $("#productcategory").val()

                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();

                }

            });
        });



        $('#savedepartment').click(function(){

            window.location.replace('{!!url("/choosemachine")!!}/' +$('#prodname').val());

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
