<!DOCTYPE html>
<html>
<head>
    <title>WIMS Qr CODE</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="{{ asset('js/qrcode.js') }}"></script>
    <style>
        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
        }
    </style>
</head>
<body>

<div class="visible-print text-center" style="text-align: center;">

    <div id="qrcode"></div>
    <strong style=" font-size:65px;margin-top:-30px">{{$ID}}</strong>


</div>
<script>
    $(document).ready(function() {

        console.log($('#hiddenqrmessages').val())

        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{$ID}}",
            width: 400,
            height: 400,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });

</script>
</body>
</html>
