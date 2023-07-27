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

    <style>
        .control-label{
            margin-bottom: 0px !important;
            font-weight: 700 !important;
            font-size: 15px !important;
        }
        .check {
            margin-right: 10px;
        }

        .minmax{
            display: flex;
            align-items: center;
        }

        .minmax > :first-child{
            margin-right: 10px;
        }

        .form-group {
            background-color: rgb(240, 240, 240);
            border: solid 1px rgb(221, 221, 221);
            padding: 8px;
            /* margin: 1rem; */
        }

        .select2-selection {
            height: 38px !important;
            display: flex;
            vertical-align: middle;
            align-items: center;
        }

    </style>

</head>

<body>


<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    
    
    
    <div class="col p-3">

        <h3>Add new Product Specifications</h3>
        
        <div>
            {{-- Customer Info --}}
            {{-- Customer Name --}}
            <div class="form-group">
                <label class="control-label" for="customers">Customer Name</label>
                <select  class="form-select" id="customers" style="width: 100%" required>
                    <option></option>
                    @foreach($customers as $val)
                        <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product --}}
            <div class="form-group">
                <label class="control-label" for="prodname">Product Name </label>
                <input type="text" class="form-control input-sm col-xs-1" id="prodname" required>
            </div>

            {{-- Product Application --}}
            <div class="form-group">
                <label class="control-label" for="productapplication">Product Application </label>
                <input type="text" class="form-control input-sm col-xs-1" id="productapplication" required>
            </div>

            {{-- Side To side Divs --}}
            <div style="display:inline-flex;height: 100%;width: 100%;">
                <div style="width:50%; float:left; margin-right: 1rem;">
                    {{-- Rod Spec --}}
                    {{-- Rod Diameter --}}
                    <div class="form-group">
                            <label class="control-label" for="roddiameter">Rod Diameter </label>
                            <input type="number" class="form-control input-sm col-xs-1" id="roddiameter" required>   
                    </div>

                    {{-- Rod Grade --}}
                    <div class="form-group">
                        <label class="control-label" for="rodgrade">Rod Grade </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="rodgrade" required>
                    </div>

                    {{-- Rod Treatment --}}
                    <div class="form-group">
                        <label class="control-label" for="rodtreatment">Rod Treatment </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="rodtreatment" required>
                    </div>

                    {{-- Galvanising Wire Spec --}}
                    {{-- Diameter Galv Wire --}}
                    <div class="form-group">
                        <label class="control-label" for="diametergalvwire">Diameter Galv Wire </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="diametergalvwire" required>
                    </div>

                    {{-- Diameter Tolerance --}}
                    <div class="form-group">
                        <label class="control-label" for="diametertolerance">Diameter Tolerance </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="diametertolerancestrict" name="diametertolerancestrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="diametertolerancemin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="diametertolerancemax" required>
                        </div>
                        
                    </div>

                    {{-- Tensile Strength --}}
                    <div class="form-group">
                        <label class="control-label" for="tensilestrenght">Tensile Strength </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="tensilestrenghtstrict" name="tensilestrenghtstrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="tensilestrenghtmin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="tensilestrenghtmax" required>
                        </div>
                    </div>

                    {{-- 1% Stress Test --}}
                    <div class="form-group">
                        <label class="control-label" for="stresstest">1% Stress Test </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="stressteststrict" name="stressteststrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <input type="number" class="form-control input-sm col-xs-1" id="stresstest" required>
                    </div>

                    {{-- Elongation --}}
                    <div class="form-group">
                        <label class="control-label" for="elongation">Elongation </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="elongationstrict" name="elongationstrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <input type="number" class="form-control input-sm col-xs-1" id="elongation" required>
                    </div>

                    {{-- Lead Bath Dip --}}
                    <div class="form-group">
                        <label class="control-label" for="leadbathdip">Lead Bath Dip </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="leadbathdip" required>
                    </div>
                </div>

                <div style="width:50%; float:right;">
                    {{-- Zinc Coating Type --}}
                    <div class="form-group">
                        <label class="control-label" for="zinccoatingtype">Zinc Coating Type </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="zinccoatingtype" required>
                    </div>
                    
                    {{-- Zinc Coating (g/m²) --}}
                    <div class="form-group">
                        <label class="control-label" for="zinccoating">Zinc Coating (g/m²)</label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="zinccoatingstrict" name="zinccoatingstrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="zinccoatingmin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="zinccoatingmax" required>
                        </div>
                    </div>

                    {{-- Coating Uniformity --}}
                    <div class="form-group">
                        <label class="control-label" for="coatinguniformity">Coating Uniformity </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="coatinguniformity" required>
                    </div>

                    {{-- Coating Adhesion --}}
                    <div class="form-group">
                        <label class="control-label" for="coatingadhesion">Coating Adhesion </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="coatingadhesion" required>
                    </div>

                    {{-- Speed --}}
                    <div class="form-group">
                        <label class="control-label" for="speed">Speed </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="speed" required>
                    </div>

                    {{-- MMCE (Nitro Setting) --}}
                    <div class="form-group">
                        <label class="control-label" for="mmcenitrosetting">MMCE (Nitro Setting) </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="mmcenitrosetting" required>
                    </div>

                    {{-- Nitro Die Size --}}
                    <div class="form-group">
                        <label class="control-label" for="nitrodiesize">Nitro Die Size </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="nitrodiesize" required>
                    </div>

                    {{-- Labelling --}}
                    <div class="form-group">
                        <label class="control-label" for="labelling">Labelling </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="labelling" required>
                    </div>

                    {{-- Max No. Of Welds Allowed --}}
                    <div class="form-group">
                        <label class="control-label" for="maxwelds">Max No. Of Welds Allowed </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="maxweldsstrict" name="maxweldsstrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <input type="number" class="form-control input-sm col-xs-1" id="maxwelds" required>
                    </div>            
                </div>
            </div>

            {{-- Packaging Requirements --}}
            <div class="form-group">
                <label class="control-label" for="packagingrequirements">Packaging Requirements </label>
                <input type="text" class="form-control input-sm col-xs-1" id="packagingrequirements" required>
            </div> 

            {{-- Special Instructions --}}
            <div class="form-group">
                <label class="control-label" for="specialinstructions">Special Instructions </label>
                <textarea  type="text" rows="3" max-rows="3" class="form-control input-sm col-xs-1" id="specialinstructions" required></textarea>
            </div>

            <div style="display: inline-flex; width:100%;">
                <button class="btn btn-success" id="add" style="width: 100%; margin-right:10px;">ADD</button>
            </div>
        </div>
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
        
        $("#customers").select2();

        $("input[type='text']").on("click", function() {
            $(this).select();
        });

        $("input").focus(function() {
            $(this).select();
        });

        $("input").focusin(function() {
            $(this).select();
        });
        
        $('#add').click(function(){
            $.ajax({
                url: '{!!url("/addproductspec")!!}',
                type: "POST",
                data: {
                    // Info
                    cutomername: $("#customers option:selected").val(),
                    productname: $("#prodname").val(),
                    productapplication: $("#productapplication").val(),
                    roddiameter: $("#roddiameter").val(),
                    rodgrade: $("#rodgrade").val(),
                    rodtreatment: $("#rodtreatment").val(),
                    diametergalvwire: $("#diametergalvwire").val(),
                    diametertolerancemin: $("#diametertolerancemin").val(),
                    diametertolerancemax: $("#diametertolerancemax").val(),
                    tensilestrenghtmin: $("#tensilestrenghtmin").val(),
                    tensilestrenghtmax: $("#tensilestrenghtmax").val(),
                    stresstest: $("#stresstest").val(),
                    elongation: $("#elongation").val(),
                    leadbathdip: $("#leadbathdip").val(),
                    zinccoatingtype: $("#zinccoatingtype").val(),
                    zinccoatingmin: $("#zinccoatingmin").val(),
                    zinccoatingmax: $("#zinccoatingmax").val(),
                    coatinguniformity: $("#coatinguniformity").val(),
                    coatingadhesion: $("#coatingadhesion").val(),
                    speed: $("#speed").val(),
                    mmcenitrosetting: $("#mmcenitrosetting").val(),
                    nitrodiesize: $("#nitrodiesize").val(),
                    labelling: $("#labelling").val(),
                    maxwelds: $("#maxwelds").val(),
                    packagingrequirements: $("#packagingrequirements").val(),
                    specialinstructions: $("#specialinstructions").val(),

                    // Strict Checkboxes
                    diametertolerancestrict: $("#diametertolerancestrict").is(':checked'),
                    tensilestrenghtstrict: $("#tensilestrenghtstrict").is(':checked'),
                    stressteststrict: $("#stressteststrict").is(':checked'),
                    elongationstrict: $("#elongationstrict").is(':checked'),
                    zinccoatingstrict: $("#zinccoatingstrict").is(':checked'),
                    maxweldsstrict: $("#maxweldsstrict").is(':checked'),

                },
                success: function (data) {
                    location.reload();
                }

                });
        });

        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
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
