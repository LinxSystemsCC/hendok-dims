<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .collapsible {
            background-color: #777;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #555;
        }

        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }
        .hidden_row {
            display: none;
        }
    </style>
</head>
<body>

<h3>My Market Orders </h3>
<div style="overflow: scroll;height: 500px;width: 100%;">
<table id="pastInvoices" class="table" style="width: 100%">
    <tr style="font-size: 16px;" >
        <th>ID</th>
        <th>name</th>
        <th>orgID</th>
        <th>Purchase Date</th>

    </tr>
    <tbody>

    </tbody>
</table>
</div>
<button id="pullorders">Pull Orders To Deal With</button>
<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    var a = new Array();

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    $.ajax({
        url: '{!!url("/mymarketGetSales")!!}',
        type: "GET",
        success: function (data) {
            var trHTML = '';
            var inv = 'id';
            var counter = 0;
            console.debug(data);

            var b = new Array();

            for(var k=0; k < data.length;k++)
            {
                console.debug(data[k][0]['salesOrderNumber']);
                console.debug(data[k].length);
                for( var i=0;i < data[k].length; i++){
                if (inv != data[k][i]['salesOrderNumber'] )
                {
                    console.debug("inside"+data[k][i]['salesOrderNumber']);
                    var x = parseInt(counter)+1;
                   // a.push(data[k][i]['salesOrderNumber']);
                    trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 16px;background: #bbbaa6" onclick="show_hide_row(\'hidden_row1'+ x +'\') ;"><td><input type="checkbox" name="salesordersselected" class="orderid" value="'+data[k][i]['salesOrderNumber']+'">'+
                        data[k][i]['salesOrderNumber'] +'</td><td>'+
                        data[k][i]['name'] +'</td><td>'+
                        data[k][i]['orgID'] +'</td><td>'+
                        data[k][i]['purchaseOrderDate'] +'<input type="hidden" class="dontTakeme" value="thisIsIt"></td><td></tr>';
                    counter++;

                }

                trHTML +='<tr style="font-size: 13px;color: black" class="hidden_row1'+counter+' hidden_row">'+
                    '<td style="padding: 0px;">Name:  '+data[k][i]['shortDescription']+'</td>'+
                    '<td style="padding: 0px;">Qty:   '+parseFloat(data[k][i]['quantity']).toFixed(2)+'</td>'+
                    '<td style="padding: 0px;">Code:  '+data[k][i]['partNumber']+'</td>'+
                    '<td style="padding: 0px;">Price: '+parseFloat(data[k][i]['unitPriceExclTax']).toFixed(2)+'</td>'+


                    '<tr>';


                inv = data[k][i]['salesOrderNumber'];
                }
            }

              $('#pastInvoices').append(trHTML);
        }

    });

    $('#pullorders').click(function(){
        a = new Array();
        $("input:checkbox[name=salesordersselected]:checked").each(function(){
            a.push( $(this).val());

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.debug(a);
       //getMymarketOrdersToDealWith
        $.ajax({
            url: '{!!url("/getMymarketOrdersToDealWith")!!}',
            type: "Post",
            data: {

                salesorderids: a
            },
            success: function (data) {


            }
        });
    });

    function show_hide_row(row)
    {
        $("."+row).toggle();
    }
</script>

</body>
</html>
