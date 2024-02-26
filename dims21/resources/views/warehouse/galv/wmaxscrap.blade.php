@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Scrap Weigh')

{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {
        $editScrapWeight = '0';
    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $editScrapWeight = $v->getThingsUserPermissions(Auth::user()->UserID,'editScrapWeight');
    }

    $includeMenu = true;
    
@endphp

@section('page')

    <h3>Scrap Weigh</h3>

    <form>
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="selectScale">Scale</label>
            <select  type="text" class="form-select" id="selectScale">
                <option value=""></option>
                @foreach ($scales as $scale)
                    <option value="{{ $scale->intAutoId }}">{{ $scale->strName }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="selectBin">Bin</label>
            <select  type="text" class="form-select" id="selectBin" required>
                <option></option>
                @foreach ($scrapBins as $bin)
                    <option value="{{ $bin->intAutoId }}">{{ $bin->strBinName }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="inputWeight">Weight</label>
            @if ($editScrapWeight != '0')  
            <div class="input-group mb-2">
                <input type="number" class="form-control" id="inputWeight" disabled>
                <button type="button" class="btn btn-secondary" id="btnEditWeight"><i class="fa fa-edit p-0"></i></button>
            </div>
            @else
            <input type="number" class="form-control" id="inputWeight" disabled>
            <button type="button" class="btn btn-secondary" id="btnEditWeight" hidden><i class="fa fa-edit p-0"></i></button>
            @endif
        </div>
        
        <button type="submit" class="btn btn-success w-100" id="btnWeighScrap">Weigh Scrap</button>
    </form>
    



@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        let tareWeight;
        let scrapBins = ({!! json_encode($scrapBins) !!});

        $("#btnEditWeight").click(function(){
            $("#inputWeight").prop("disabled", function(i, v) { return !v; });
        });
        
        $('#selectScale').change(function(){
            if ($("#selectScale").val() == ''){
                toggleWeigh(false);
                $('#btnEditWeight').prop('disabled', false);
            }else{
                toggleWeigh(true);
                $('#btnEditWeight').prop('disabled', true);
                $("#inputWeight").prop("disabled", true);
            }
        });

        $('#selectBin').change(function(){
            var selectedValue = $(this).val();

            var selectedBin = scrapBins.find(function(bin) {
                return bin.intAutoId == selectedValue;
            });

            if (selectedBin) {
                tareWeight = selectedBin.fltTareMass;
            }else{
                tareWeight = 0;
            }

            // Now you can use tareWeight as needed
            console.log("Tare weight for selected bin:", tareWeight);
        });

        $("#btnWeighScrap").click(function(){
            $.ajax({
                url: '{!!url("/postScrapWeigh")!!}',
                type: "POST",
                data: {
                    id: 0,
                    bin: $('#selectBin').val(),
                    weight: $("#inputWeight").val(),
                    command: 'Create'
                },
                success: function (data) {
                    location.reload();
                }
            });
        });
        
        let weighInterval;

        function toggleWeigh(enable) {
            if (enable) {
                weighInterval = setInterval(fetchWeight, 10000);
            } else {
                clearInterval(weighInterval);
            }
        }

        function fetchWeight() {
            $.ajax({
                url: '{!!url("/listenToScale")!!}',
                type: "GET",
                data: {
                    scaleID: $('#selectScale').val(),
                },
                success: function(data) {
                    if (data) {
                        finalweight = (data - tareWeight);
                        $('#inputWeight').val(finalweight);
                    } else {
                        $('#inputWeight').val(0);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while fetching weight:", error);
                    // Handle error here, for example, display an error message to the user
                }
            });
        }
    });
</script>

@endsection