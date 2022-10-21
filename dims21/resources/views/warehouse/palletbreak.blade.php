<!DOCTYPE html>
<html>
<head>
    <title>WIMS Qr CODE</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script src="{{ asset('js/jquery.classyqr.js') }}"></script>
</head>
<body>

<div class="visible-print text-center" style="text-align: center;">
    <input id="hiddenqrmessages" type="hidden" value="BREAK PALLET">

    <div id="barcode" style="margin-top:-10px;" ></div>
    <strong style=" font-size:65px;margin-top:-30px">BREAK PALLET</strong>


</div>
<script>
    $(document).ready(function() {

        $("#barcode").ClassyQR({
            create: true,
            type: 'text',
            text:  $('#hiddenqrmessages').val(),
            size: 400
        });

    });


</script>
</body>
</html>
