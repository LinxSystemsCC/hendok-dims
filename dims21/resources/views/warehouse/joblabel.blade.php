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
</head>
<body>


    <div class="col-lg-12"  style="background: white;margin-top: 60px;">
        <div class="col-lg-12"  style="background: white;display:flex;">
            <div class="col-lg-6"  style="background: white;">HENDOK GROUP<br>{!! QrCode::size(100)->generate($qrcode); !!}</div>
            <div class="col-lg-6"  style="background: white;font-size: 8px;float: right">
                <p>200 Aberdare Drive<br>
                Phoenix Industrial Park<br>
                Durban, South Africa<br>
                Tel: +27 507 6731<br>
                Website: www.hendok.com<br></p>
            </div>
        </div>
        <div class="col-lg-12"  style="background: white;border: 1px solid black;font-size: 8px;margin-left: 25px;margin-right: 25px;width: 75%">
            <?php $barcode = ""; ?>
            @foreach($qrcodeothers as $val)
            <table>
                <tr>
                    <td>Group</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Coating</td>
                    <td>{{$val->zincCoating}}</td>
                </tr>
                <tr>
                    <td>Item</td>
                    <td>{{$val->PastelDescription}}</td>
                </tr>
                <tr>
                    <td>Code</td>
                    <td>{{$val->strItemCode}}</td>
                </tr>
                <tr>
                    <td>Pack</td>
                    <td>{{$val->Pack}}</td>
                </tr>
            </table>
                <?php $barcode = $val->Barcode; ?>
                @endforeach
        </div>

    </div>
    <div class="col-lg-12"  style="background: white;display:flex;text-align: center;margin-left: 25px; margin-top: 5px;">
        <div class="col-lg-6"  style="background: white;float: right"> </div>

        </div>

    </div>
    <br>




</body>
</html>
