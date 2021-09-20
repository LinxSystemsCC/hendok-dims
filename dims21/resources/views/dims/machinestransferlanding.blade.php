<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"  type='text/css'>
    <script src="https://kit.fontawesome.com/8110324a96.js" crossorigin="anonymous"></script>
    <title>Transfers</title>
</head>
<body>
<h3 style="text-align: center;">Transfers Landing Page</h3>
<div class="container" >

    <div class="row">
        <div class="col">
            <a href='{!!url("/createTransfer")!!}' onclick="window.open(this.href, 'createTransfer',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" style="color: black" target="_blank"> <i class="fas fa-plus fa-9x" style="color: #00FF00"></i>
                <br>
            <h4>Create Transfer</h4>
            </a>

        </div>
        <div class="col">
            <a href='{!!url("/receiveTransfer")!!}' onclick="window.open(this.href, 'receiveTransfer',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" style="color: black" target="_blank"> <i class="fas fa-exclamation-circle fa-9x" style="color: #00FF00"></i>
                <br>
                <h4>Receive Transfer</h4>
            </a>
        </div>
</div>
    </div>
</div>
</body>
</html>
