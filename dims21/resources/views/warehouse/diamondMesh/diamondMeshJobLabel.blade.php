@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Diamond Mesh Labels')

@php
    $includeMenu = false;
@endphp

@section('page')
    <div class="col-lg-12">
        <div class="col-lg-12 p-2">
            <img src="{{ asset('images/grouplogo.jpg') }}" alt="" style="height: 70px;"/>
        </div>
        <div class="col-lg-12">
            <?php $barcode = ''; ?>
            @foreach ($qrcodeothers as $val)
                <table class="table table-bordered border-dark">
                    <tr>
                        <td><strong>ID</strong></td>
                        <td>
                            <h5><strong>{{ $val->intJobId }}</strong></h5>
                        </td>
                        <input type='hidden' id ='jobId' value="{{ $val->intJobId }}">
                    </tr>
                    <tr>
                        <td><strong>Customer</strong></td>
                        <td>
                            <h5><strong>{{ $val->strCustomerName }}</strong></h5>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ITEM</strong></td>
                        <td>
                            <h5><strong>{{ $val->PastelDescription }}</strong></h5>
                        </td>
                    </tr>
                </table>
                <input type="hidden" value="{{ $val->Barcode }}" id="hiddenbarcode">
                <?php $barcode = $val->Barcode;
                $valqty = $val->Barcode;
                $fullfilled = $val->fullfilled;
                $mnyQtyRequired = $val->mnyQtyRequired;
                $mnyQtyProduced = $val->mnyQtyProduced; ?>
            @endforeach
        </div>
    </div>

    <div class="col-lg-12">
        {!! QrCode::size(65)->generate($qrcode) !!}
        <svg id="barcode"></svg>
    </div>

    <div class="col-lg-12 d-inline-flex">
        <input type="number" id="qty" value="1" class="form-control me-2">
        <input type="hidden" id="jobId" value="{{ $jobid }}" style="width: 100%"> <br>

        @if ($fullfilled != 'Finished')
            <button class="btn btn-lg btn-primary" id="printthislabels">PRINT</button>
        @else
            <h3 style="color: red;font-weight: 900;">You have Produced Required Quantity Of {{ $mnyQtyProduced }} /
                {{ $mnyQtyRequired }}.<br>Please speak to your operator</h3><br><br>
            <p><a href='{!! url('/production_departments') !!}' style="text-decoration: underline;">Main Menu</a></p>
        @endif
    </div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
    $(document).ready(function() {
        JsBarcode("#barcode", $('#hiddenbarcode').val(), {
            height: 40
        });
        $('#printthislabels').click(function() {

            $.ajax({
                url: '{!! url('/sendDiamondMeshLabelToThePrinter') !!}',
                type: "GET",
                data: {
                    qty: $('#qty').val(),
                    type: 2,
                    jobId: $('#jobId').val(),
                    isnew: "NEW"
                },
                success: function(data) {
                    if (data = "Success") {
                        window.location = '{!! url('/doneprintingpallet') !!}';
                    }

                }

            });

        })

    });
</script>

@endsection
