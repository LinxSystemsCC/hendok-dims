@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Edit Galv Products')

{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;
    
@endphp

@section('page')

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

        <h3>Edit Product Specifications</h3>
        
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
                <label class="control-label" for="prodname">Products Name</label>
                <select  class="form-select" id="prodname" style="width: 100%" required>
                    <option></option>
                </select>
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
                            <div class="form-check mr-2">
                                <input class="form-check-input" type="radio" name="flexRadioStressTest" id="stresstestless">
                                <label class="control-label" for="stresstestless">
                                    Less Than
                                </label>
                            </div>
                            <div class="form-check mr-2">
                                <input class="form-check-input" type="radio" name="flexRadioStressTest" id="stresstestgreater">
                                <label class="control-label" for="stresstestgreater">
                                    Greater Than
                                </label>
                            </div>
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

                    {{-- Coil ID Tolerance --}}
                    <div class="form-group">
                        <label class="control-label" for="coilidtolerance">Coil ID Tolerance </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="coilidtolerancestrict" name="coilidtolerancestrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="coilidtolerancemin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="coilidtolerancemax" required>
                        </div>
                    </div>

                    {{-- Coil OD Tolerance --}}
                    <div class="form-group">
                        <label class="control-label" for="coilodtolerance">Coil OD Tolerance </label>
                        <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="coilodtolerancestrict" name="coilodtolerancestrict">
                            <label class="control-label">QC Strict</label>
                        </div>
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="coilodtolerancemin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="coilodtolerancemax" required>
                        </div>
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

                    {{-- HDW Tolerance --}}
                    <div class="form-group">
                        <label class="control-label" for="diametertolerance">HDW Tolerance </label>
                        {{-- <div style="display: inline-flex; float:right;">
                            <input class="check" type="checkbox" id="diametertolerancestrict" name="diametertolerancestrict">
                            <label class="control-label">QC Strict</label>
                        </div> --}}
                        <div class="minmax">
                            <input type="number" Value="MIN" class="form-control input-sm col-xs-1" id="hdwtolerancemin" required>
                            <input type="number" Value="MAX" class="form-control input-sm col-xs-1" id="hdwtolerancemax" required>
                        </div>
                    </div>
                    
                    {{-- Product Application --}}
                    <div class="form-group">
                        <label class="control-label" for="productapplication">Product Application </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="productapplication" required>
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
                <button class="btn btn-success" id="edit" style="width: 100%; margin-right:10px;">EDIT</button>
            </div>
        </div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        
        $("#customers").select2();
        $("#prodname").select2();

        $("input[type='text']").on("click", function() {
            $(this).select();
        });

        $("input").focus(function() {
            $(this).select();
        });

        $("input").focusin(function() {
            $(this).select();
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

                        toAppend += '<option value="'+o.ProductName+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });
        });
        
        $("#prodname").change(function () {
            $.ajax({

                url: '{!!url("/wmaxgetproductinfo")!!}',
                type: "GET",
                data: {
                    customer: $("#customers").val(),
                    product: $("#prodname").val(),
                },
                success: function (data) {
                    $("#productapplication").val(data[0].strProductApplication);
                    $("#roddiameter").val(data[0].RodSize);
                    $("#rodgrade").val(data[0].RodType);
                    $("#rodtreatment").val(data[0].strRodTreatment);
                    $("#diametergalvwire").val(data[0].WireSize);

                    if (data[0].SizeTolerance !== null) {
                        var tolerance = data[0].SizeTolerance.split("-");
                        $("#diametertolerancemin").val(tolerance[0]);
                        $("#diametertolerancemax").val(tolerance[1]);
                    }

                    if (data[0].MPATolerance !== null) {
                        var tensile = data[0].MPATolerance.split("-");
                        $("#tensilestrenghtmin").val(tensile[0]);
                        $("#tensilestrenghtmax").val(tensile[1]);
                    }

                    $("#stresstest").val(data[0].intStressTest);
                    $("#elongation").val(data[0].intElongation);
                    $("#leadbathdip").val(data[0].strLeadBathDip);
                    $("#zinccoatingtype").val(data[0].Type);

                    if (data[0].strZincCoatingMinMax !== null) {
                        var coating = data[0].strZincCoatingMinMax.split("-");
                        $("#zinccoatingmin").val(coating[0]);
                        $("#zinccoatingmax").val(coating[1]);
                    }

                    $("#coatinguniformity").val(data[0].strCoatingUniformity);
                    $("#coatingadhesion").val(data[0].strCoatingAdhesion);
                    $("#speed").val(data[0].GalvRPM);
                    $("#mmcenitrosetting").val(data[0].Gas);
                    $("#nitrodiesize").val(data[0].intNitroDieSize);
                    $("#labelling").val(data[0].strLabelling);
                    $("#maxwelds").val(data[0].intMaxWelds);
                    $("#packagingrequirements").val(data[0].strPackagingRequirements);
                    $("#specialinstructions").val(data[0].strSpecialInstructions);

                    // Added 20240220
                    if (data[0].strHDWMinMax !== null) {
                        var hdw = data[0].strHDWMinMax.split("-");
                        $("#hdwtolerancemin").val(hdw[0]);
                        $("#hdwtolerancemax").val(hdw[1]);
                    }

                    if (data[0].strCoilIDMinMax !== null) {
                        var coilID = data[0].strCoilIDMinMax.split("-");
                        $("#coilidtolerancemin").val(coilID[0]);
                        $("#coilidtolerancemax").val(coilID[1]);
                    }

                    if (data[0].strCoilODMinMax !== null) {
                        var coilOD = data[0].strCoilODMinMax.split("-");
                        $("#coilodtolerancemin").val(hdw[0]);
                        $("#coilodtolerancemax").val(hdw[1]);
                    }
                    
                    // Strict Checkboxes
                    $("#diametertolerancestrict").prop( "checked", parseInt(data[0].boolStrictDiameterTolerance));
                    $("#tensilestrenghtstrict").prop( "checked", parseInt(data[0].boolStrictTensileStrength));
                    $("#stressteststrict").prop( "checked", parseInt(data[0].boolStrictStressTest));
                    $("#elongationstrict").prop( "checked", parseInt(data[0].boolStrictElongation));
                    $("#zinccoatingstrict").prop( "checked", parseInt(data[0].boolStrictZincCoatingMinMax));
                    $("#maxweldsstrict").prop( "checked", parseInt(data[0].boolStrictMaxWelds));
                    
                    // Added 20240220
                    $("#coilidtolerancestrict").prop( "checked", parseInt(data[0].boolStrictCoilID));
                    $("#coilodtolerancestrict").prop( "checked", parseInt(data[0].boolStrictCoilOD));

                    var greaterLessValue = data[0].strStressTestGreaterLess;

                    $('input[name="flexRadioStressTest"]').prop('checked', false);

                    if (greaterLessValue === 'greater') {
                        $('#stresstestgreater').prop('checked', true);
                    } else if (greaterLessValue === 'less') {
                        $('#stresstestless').prop('checked', true);
                    }
                    $('input[name="flexRadioStressTest"]').change(function(){
                        var selectedValue = $('input[name="flexRadioStressTest"]:checked').attr('id');
                        if (selectedValue === 'stresstestgreater') {
                            data[0].strStressTestGreaterLess = 'greater';
                        } else if (selectedValue === 'stresstestless') {
                            data[0].strStressTestGreaterLess = 'less';
                        } else {
                            data[0].strStressTestGreaterLess = null;
                        }
                    });


                }
            });
        });
        
        $('#edit').click(function(){
            var selectedValue = $('input[name="flexRadioStressTest"]:checked').attr('id');
            var strStressTestGreaterLess = selectedValue === 'stresstestgreater' ? 'greater' : 'less';
            $.ajax({
                url: '{!!url("/editproductspec")!!}',
                type: "POST",
                data: {
                    // Info
                    cutomername: $("#customers option:selected").text(),
                    productname: $("#prodname option:selected").text(),
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


                    // ADDED 20240220
                    strStressTestGreaterLess: strStressTestGreaterLess,
                    strHDWMinMax: $("#hdwtolerancemin").val(),
                    strHDWMax: $("#hdwtolerancemax").val(),
                    strCoilIDMin: $("#coilidtolerancemin").val(),
                    strCoilIDMax: $("#coilidtolerancemax").val(),
                    strCoilODMin: $("#coilodtolerancemin").val(),
                    strCoilODMax: $("#coilodtolerancemax").val(),
                    boolStrictCoilID: $("#coilidtolerancestrict").is(':checked'),
                    boolStrictCoilOD: $("#coilodtolerancestrict").is(':checked'),

                },
                success: function (data) {
                    location.reload();
                }

                });
        });
    });

</script>

@endsection