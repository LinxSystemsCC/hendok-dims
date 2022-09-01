<!DOCTYPE html>
<html>
<head>
    <title>job label</title>
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

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>
<body>


    <div class="col-lg-12"  style="background: white;">
        <div class="col-lg-12"  style="background: white;margin-left: 30px;">
            <img  src="{{ asset('images/grouplogo.jpg') }}" alt="" style="height: 50px" />
        </div>
        <div class="col-lg-12"  style="background: white;border: 1px solid black;font-size: 11px;margin-left: 45px;margin-right: 25px;width: 80%">
            <?php $barcode = ""; ?>
            @foreach($qrcodeothers as $val)
            <table>
                <tr>
                    <td><strong>GROUP</strong></td>
                        <td><h5><strong>{{$val->ItemGrouping}}</strong></h5></td>
                </tr>
                <tr>
                    <td><strong>COATING</strong></td>
                        <td><h5><strong>{{$val->zincCoating}}</strong></h5></td>
                </tr>
                <tr>
                    <td><strong>ITEM</strong></td>
                    <td><h5><strong>{{$val->PastelDescription}}</strong></h5></td>
                </tr>
                <tr>
                    <td><strong>PACK</strong></td>
                    <td><h5><strong>{{$val->strPalletTypeDescription}}</strong></h5></td>
                </tr>
            </table>
                <input type="hidden" value="{{$val->Barcode}}" id="hiddenbarcode">
                <?php $barcode = $val->Barcode;$valqty = $val->Barcode ?>

                @endforeach
        </div>

    </div>

    <div class="col-lg-12"  style="background: white;display:flex;text-align: center;margin-left: 105px; margin-top: 5px;">

        {!! QrCode::size(65)->generate($qrcode); !!}
        <svg id="barcode"></svg>
        </div>
    <br>

    </div>
    <div class="col-lg-12"  style="background: white;display:flex;text-align: center;margin-left: 105px; margin-top: 5px;">
        <input type="number" id="qty" value="4"> <br>
        <input type="hidden" id="jobid" value="{{$jobid}}" style="width: 100%"> <br>


        <button class="btn btn-lg btn-primary" id="printthislabels">PRINT</button>

    </div>
    <br>




</body>
</html>
<script>
    $(document).ready(function() {
        JsBarcode("#barcode", $('#hiddenbarcode').val(),{
            height: 40
        });
        $('#printthislabels').click(function(){

                $.ajax({
                    url: '{!!url("/sendLabelToThePrinter")!!}',
                    type: "GET",
                    data: {
                        qty: $('#qty').val(),
                        type:2,
                        jobid:$('#jobid').val()
                    },
                    success: function (data) {
                        if(data ="Success"){
                            window.location = '{!!url("/doneprintingpallet")!!}';
                        }

                    }

                });

        })

    });
</script>
