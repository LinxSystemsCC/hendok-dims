
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Customer Lookup</h3>
<div>

   <div style="display: flex;">
       <div >
           <form>
               <lable>Area</lable>
               <select id="area" class="form-control" style="width: 300px">
                   @foreach($sageareas as $val)
                       <option value="{{$val->areanames}}">{{$val->areanames}}</option>
                   @endforeach

               </select>
               <lable>Route</lable>
               <select id="route" class="form-control" style="width: 300px">
                   @foreach($routes as $val)
                       <option value="{{$val->Route}}">{{$val->Route}}</option>
                   @endforeach
               </select>
               <br><br>
               <button id="save" style="width: 200px">Add</button>
           </form>

       </div>

       <div id="gridContainer" style="height: 800px;"/>

   </div>


</div>


<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/maproutetoareinsert")!!}',
                type: "POST",
                data: {
                    route: $('#route').val(),
                    area: $('#area').val()
                },
                success: function (data) {


                }
            });

        });

        $.ajax({
            url: '{!!url("/jsonreturnroutemappers")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: true
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        // columns: ['Account', 'Name','areaname','RouteName','companyName'],
                        {
                            width: 90,
                            dataField: "strRouteDescription",
                            caption: "Area Name",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width: 150,
                            dataField: "strRoute",
                            caption: "Route Name",
                            visible:true

                        }


                    ] ,
                    onRowClick: function (e) {



                    },


                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });



            }
        });


    });

</script>
</div>
</body>
</html>
