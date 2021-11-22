<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Code</th>
        <th>Barcode</th>

    </tr>

    @foreach($products as $val)
        <tr>
            <td><a href={!!url("/recordbarcode")!!}/{{$val->Code}}>{{$val->Description_1}}</a> <br> {{$val->group3}}</td>
            <td>{{$val->strItemBarcode}}<br>{{$val->strLocationName}}<br>{{$val->dteExpiryDate}}</td>

        </tr>
    @endforeach
</table>

</body>
</html>
