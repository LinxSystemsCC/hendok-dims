
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
<h3>View Areas</h3>
<div>

    <div class="dx-field-value">
        <div id="gridBox"></div>
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

        $.ajax({
            url: '{!!url("/arealookjson")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {

                $('#gridBox').dxDropDownBox({

                    valueExpr: 'iAreasID',
                    placeholder: 'Select a value...',
                    displayExpr: 'Route',
                    showClearButton: true,
                    dataSource: data,
                    contentTemplate(e) {
                        const v = e.component.option('value');
                        const $dataGrid = $('<div>').dxDataGrid({
                            dataSource: e.component.getDataSource(),
                            columns: ['Route', 'areaname'],
                            hoverStateEnabled: true,
                            paging: {enabled: true, pageSize: 10},
                            filterRow: {visible: true},
                            scrolling: {mode: 'virtual'},
                            height: 345,
                            selection: {mode: 'multiple'},
                            selectedRowKeys: v,
                            onSelectionChanged(selectedItems) {
                                const keys = selectedItems.selectedRowKeys;
                                e.component.option('value', keys);
                            },
                        });

                        dataGrid = $dataGrid.dxDataGrid('instance');

                        e.component.on('valueChanged', (args) => {
                            const {value} = args;
                            dataGrid.selectRows(value, false);
                        });

                        return $dataGrid;
                    },
                });
            }
        });


    });

</script>
</div>
</body>
</html>
