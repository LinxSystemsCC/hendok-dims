<?php
if ((Auth::guest()))
{
}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
$nwor = $v->getThingsUserPermissions(Auth::user()->UserID,'New Work Order Roof');
$ppso = $v->getThingsUserPermissions(Auth::user()->UserID,'Pre Planning SO');
$print = $v->getThingsUserPermissions(Auth::user()->UserID,'Roof Print');
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    

    <!-- Select2 JS -->

    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

</head>

<body>
<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>

    <div class="col-lg-10"  style="width:100%; max-width:100% !important">
        <ul class="nav nav-tabs">
            <li class="nav-item">
            <a class="nav-link active" onclick="openPage('barcodepage', this,'defaultOpen')"id="defaultOpen">Barcode</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" onclick="openPage('barcodelesspage', this, 'barcodelesstab')"id="barcodelesstab">Barcodeless</a>
            </li>
        </ul>
        
        <div class="tab-content p-3">
            <div class="tabcontent tab-pane" id="barcodepage" role="tabpanel">
            {{-- Barcode Scan Page --}}
            <div class="col-lg-12 bd-highlight"  style="background: white; display: block; height: 100vh; width: 30%;padding: 20px !important;">

                <h3>PALLET LABEL PRINTING</h3>
                {{--Input of Job ID--}}
                <div class="form-group">
                    <label class="control-label" for="jobid"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Job ID </label>
                    <input  class="form-control input-sm col-xs-1" id="jobid" style="width: 100%" >
                </div>

                {{-- Department --}}
                <div class="form-group">
                    <label class="control-label" for="department"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department </label>
                    <input  class="form-control input-sm col-xs-1" id="department" style="width: 100%" readonly>
                </div>

                {{-- Product Category --}}
                <div class="form-group">
                    <label class="control-label" for="category"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                    <input  class="form-control input-sm col-xs-1" id="category" style="width: 100%" readonly>
                </div>

                {{-- Product --}}
                <div class="form-group">
                    <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                    <input class="form-control input-sm col-xs-1" id="prodname" style="width: 100%" readonly>
                </div>

                {{-- Pallets --}}
                <div class="form-group">
                    <label class="control-label" for="pallet"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pallet Configuration</label>
                    <select  class="form-control input-sm col-xs-1 " id="pallet" style="width: 100%" >
                        <option></option>
                                @foreach($pallets as $val)
                                    <option value="{{$val->intPalletId}}">{{$val->strPalletTypeDescription}}</option>
                                @endforeach
                        
                    </select>
                </div>

                {{-- Quantity --}}
                <div class="form-group">
                    <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity to Print </label>
                    <input  class="form-control input-sm col-xs-1" id="qty" style="width: 100%"type="number">
                </div>

                {{-- Weight --}}
                <div class="form-group">
                    <label class="control-label" for="weight"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Weight to Print </label>
                    <input  class="form-control input-sm col-xs-1" id="weight" style="width: 100%"type="number">
                </div>

                {{-- Barcode --}}
                <div class="form-group">
                    <label class="control-label" for="barcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Barcode</label>
                    <input class="form-control input-sm col-xs-1" id="barcode" style="width: 100%"type="number">
                </div>

                <br>
                <br>

                <button class="btn btn-success" id="print" style="width: 100%; margin-right: 10px;">PRINT</button>

    

            </div>
            </div>

        </div>

        <div class="tab-content p-3">
            <div class="tabcontent tab-pane" id="barcodelesspage" role="tabpanel">
                {{-- Barcode Scan Page --}}
                <div class="col-lg-12 bd-highlight"  style="background: white; display: block; height: 100vh; width: 30%;padding: 20px !important;">

                    <h3>PRODUCT LABEL PRINTING NO BARCODE</h3>

                    {{-- Department --}}
                    <div class="form-group">
                        <label class="control-label" for="departmentbarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department</label>
                        <select  class="form-control input-sm col-xs-1 " id="departmentbarcodeless" style="width: 100%" >
                            <option></option>
                                    @foreach($dept as $val)
                                        <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                                    @endforeach
                            
                        </select>
                    </div>

                        {{-- Product Category --}}
                    <div class="form-group">
                        <label class="control-label" for="categorybarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                        <select  class="form-control input-sm col-xs-1" id="categorybarcodeless" style="width: 100%" required>
                            <option></option>
                        </select>
                    </div>

                    {{-- Product --}}
                    <div class="form-group">
                        <label class="control-label" for="prodnamebarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                        <select  class="form-control input-sm col-xs-1" id="prodnamebarcodeless" style="width: 100%" required>
                            <option></option>
                        </select>
                    </div>

                    {{-- Pallets --}}
                    <div class="form-group">
                        <label class="control-label" for="palletbarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pallet Configuration</label>
                        <select  class="form-control input-sm col-xs-1 " id="palletbarcodeless" style="width: 100%" >
                            <option></option>
                                    @foreach($pallets as $val)
                                        <option value="{{$val->intPalletId}}">{{$val->strPalletTypeDescription}}</option>
                                    @endforeach
                            
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div class="form-group">
                        <label class="control-label" for="qtybarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity to Print </label>
                        <input  class="form-control input-sm col-xs-1" id="qtybarcodeless" style="width: 100%">
                    </div>

                    {{-- Weight --}}
                    <div class="form-group">
                        <label class="control-label" for="weightbarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Weight to Print </label>
                        <input  class="form-control input-sm col-xs-1" id="weightbarcodeless" style="width: 100%">
                    </div>

                    {{-- Barcode --}}
                    <div class="form-group">
                        <label class="control-label" for="barcodebarcodeless"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Barcode</label>
                        <input class="form-control input-sm col-xs-1" id="barcodebarcodeless" style="width: 100%">
                    </div>

                    <br>
                    <br>

                    <button class="btn btn-success" id="printbarcodeless" style="width: 100%; margin-right: 10px;">PRINT</button>
                </div> 
            </div>
    
        </div>

        </div>
        
    </div>

</div>


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
       
        document.getElementById("defaultOpen").click();
     


        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });


        $('#jobid').change(function(){
            $.ajax({

                url: '{!!url("/getproductbyjobid")!!}',
                type: "GET",
                data: {
                    jobid: $('#jobid').val()
                },
                success: function (data) {
                    $('#department').text(data[0]['DepartmentName']);
                    $('#department').val(data[0]['DeptID']);
                    $('#category').val(data[0]['strItemGroup']);
                    $('#prodname').val(data[0]['ProductDescription']);
                    $('#barcode').val(data[0]['Barcode']);
                }

            });
        });
        $('#print').click(function(){
            $.ajax({

                url: '{!!url("/printgenericpalletlabel")!!}',
                type: "POST",
                data: {
                    dept:$('#department').val(),
                    prodcat:$('#category').val(),
                    prodname:$('#prodname').val(),
                    palletconfid:$('#pallet').val(),
                    qty:$('#qty').val(),
                    weight:$('#weight').val(),
                    barcode:$('#barcode').val()
                },
                success: function (data) {
                    alert('Succesful Printout.');
                }

            });
        });
        $('#printbarcodeless').click(function(){
            $.ajax({

                url: '{!!url("/printgenericpalletlabel")!!}',
                type: "POST",
                data: {
                    dept:$('#departmentbarcodeless').val(),
                    prodcat:$('#categorybarcodeless').val(),
                    prodname:$('#prodnamebarcodeless').val(),
                    palletconfid:$('#palletbarcodeless').val(),
                    qty:$('#qtybarcodeless').val(),
                    weight:$('#weightbarcodeless').val(),
                    barcode:$('#barcodebarcodeless').val()
                },
                success: function (data) {
                    alert('Succesful Printout.');
                }

            });
        });

        
        $('#departmentbarcodeless').change(function(){
            $.ajax({

                url: '{!!url("/getDepListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#departmentbarcodeless option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#categorybarcodeless").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoGroupCategoryId+'">'+o.strProductCategory+'</option>';
                    });
                    $("#categorybarcodeless").append(toAppend);

                }

            });
        });

        $('#categorybarcodeless').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#categorybarcodeless option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodnamebarcodeless").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#prodnamebarcodeless").append(toAppend);

                }

            });
        });

        $('#prodnamebarcodeless').change(function(){
            $.ajax({

                url: '{!!url("/getProductBarcode")!!}',
                type: "GET",
                data: {
                    productCode: $('#prodnamebarcodeless option:selected').val(),

                },
                success: function (data) {
                    var barcode = data[0]["BarCode"];
                    console.debug(barcode);

                    if (barcode == null){
                        $('#barcodebarcodeless').val("0000000000000");
                    }else{
                        $('#barcodebarcodeless').val(barcode);
                    }
                    

                }

            });
        });

        
        
    });




    function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
function openPage(pageName, elmnt, elementid) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Remove the upper tabs class active
  
  var uppertabs = document.getElementsByClassName("nav-link active");
  console.log(uppertabs[0].id);
  console.log(elementid);
  $('#'+uppertabs[0].id).removeClass("active");
  $('#'+elementid).addClass("active");
  // Show the specific tab content
  document.getElementById(pageName).style.display = "block"; 
  

  // Add the specific color to the button used to open the tab content
}
function showDialog(tag,width,height){
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
