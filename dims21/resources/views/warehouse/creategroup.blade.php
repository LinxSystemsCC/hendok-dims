<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Create Groups</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Multiselect --> 
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <style>
        .dx-datagrid .dx-link {
            color: #df2413;
        }
    
        .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
            font-weight: 500;
            background-color: #df2413;
            color: #fff;
        }
    
        .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
            color: #df2413;
            font-size: 14px;
            line-height: 18px;
        }
    
        #gridGroups {
            height: calc(100vh - 35px);
            max-height: calc(100vh - 35px);
            width: 50%;
        }
    </style>

</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >

        <div id="gridGroups" style=""></div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Multiselect -->
<script src="{{ asset('js/jquery.multiselect.js') }}"></script>

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $('#savessettingname').click(function(){

            $.ajax({

                url: '{!!url("/savessettingname")!!}',
                type: "POST",
                data: {
                    groupID: $('#group option:selected').val(),
                    settingname: $('#settingname option:selected').text()

                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        //initiate datagrid
        const gridGroups = $("#gridGroups").dxDataGrid({
            dataSource: getGroups(), //as json
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            paging:{
                pageSize: 50,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50, 'all'],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            export: {
                enabled: true
            },
            editing: {
                mode: 'popup',
                allowUpdating: true,
                allowDeleting: true,
                allowAdding: true,
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('groups');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'groups.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [
                {
                    dataField: "GroupId",
                    caption: "ID",
                    allowEditing: false,
                }, 
                {
                    dataField: "GroupName",
                    caption: "Group Name",
                },
            ],
            masterDetail: {
                enabled: true,
                template(container, options) {
                    const selectedGroupId = options.data.GroupId;
                    const gridGroupType = $('<div>')
                    .dxDataGrid({
                        dataSource: {
                            load: function(loadOptions) {
                                return $.ajax({
                                    url: '{!!url("/getGroupTypeById")!!}',
                                    method: 'GET',
                                    data: { groupId: selectedGroupId},
                                    xhrFields: { withCredentials: true },
                                });
                            },
                            update: function (key, values) {
                                gridGroupType.dxDataGrid('instance').refresh();
                            },
                            insert: function (key, values) {
                                gridGroupType.dxDataGrid('instance').refresh();
                            },
                        },                        
                        editing: {
                            mode: 'popup',
                            allowUpdating: true,
                            allowAdding: true,
                        },
                        showBorders: true,     
                        columns: [
                            {
                                dataField: "intAutoId",
                                caption: "ID",
                                allowEditing: false,
                                visible: false,
                            },
                            {
                                dataField: "intGroupId",
                                caption: "GroupId",
                                allowEditing: false,
                                visible: false,
                            },
                            {
                                dataField: "strGroupType",
                                caption: "Type",
                            },
                        ],
                        masterDetail: {
                            enabled: true,
                            template(container, options) {
                                const selectedTypeId = options.data.intAutoId;
                                const groupMappedType = $('<div>')
                                .dxDataGrid({
                                    dataSource: {
                                        load: function(loadOptions) {
                                            return $.ajax({
                                                url: '{!!url("/getProductsMappedToGroupType")!!}',
                                                method: 'GET',
                                                data: { typeId: selectedTypeId},
                                                xhrFields: { withCredentials: true },
                                            });
                                        },
                                        update: function (key, values) {
                                            groupMappedType.dxDataGrid('instance').refresh();
                                        },
                                        insert: function (key, values) {
                                            groupMappedType.dxDataGrid('instance').refresh();
                                        },
                                    },                        
                                    editing: {
                                        mode: 'popup',
                                        allowUpdating: true,
                                        allowAdding: true,
                                    },
                                    showBorders: true,     
                                    columns: [
                                        {
                                            dataField: "intAutoId",
                                            caption: "ID",
                                            allowEditing: false,
                                            visible: false,
                                        },
                                        {
                                            dataField: "intGroupTypeId",
                                            caption: "TypeId",
                                            allowEditing: false,
                                            visible: false,
                                        },
                                        {
                                            dataField: "strCategory",
                                            caption: "Type",
                                            lookup:{
                                                dataSource: {!! json_encode($storageCategory) !!},
                                                valueExpr: "strStorageCategory",
                                                displayExpr: "strStorageCategory",
                                            }
                                        },
                                    ],
                                    onRowPrepared: function(e) {
                                        
                                    },
                                    onRowUpdating: function(e) {
                                        alert("This feature is not yet available");
                                    },
                                    onRowInserting: function(e) {
                                        console.log(e.data.GroupName);
                                        $.ajax({
                                            url: '{!!url("/saveProductsMappedToGroupType")!!}',
                                            type: "POST",
                                            data: {
                                                typeId: selectedTypeId,
                                                category: e.data.strCategory
                                            },
                                            success: function (data) {
                                                groupMappedType.dxDataGrid('instance').refresh();
                                            }
                                        });
                                    },
                                    onRowRemoving: function(e) {
                                        alert("This feature is not yet available");
                                    },
                                }).appendTo(container);
                            },
                        },
                        onRowPrepared: function(e) {
                            
                        },
                        onRowUpdating: function(e) {
                            alert("This feature is not yet available");
                        },
                        onRowInserting: function(e) {
                            console.log(e.data.GroupName);
                            $.ajax({
                                url: '{!!url("/saveGroupTypeById")!!}',
                                type: "POST",
                                data: {
                                    groupId: selectedGroupId,
                                    groupType: e.data.strGroupType
                                },
                                success: function (data) {
                                    gridGroupType.dxDataGrid('instance').refresh();
                                }
                            });
                        },
                        onRowRemoving: function(e){
                            alert("This feature is not yet available");
                        },
                    }).appendTo(container);
                },
            },
            onRowDblClick:function(e){ 

            },
            onRowRemoving: function(e) {
                alert("This feature is not yet available");
            },
            onRowUpdating: function(e) {
                alert("This feature is not yet available");
            },
            onRowInserting: function(e) {
                $.ajax({
                    url: '{!!url("/savesgroupname")!!}',
                    type: "POST",
                    data: {
                        groupname: e.data.GroupName
                    },
                    success: function (data) {
                        getGroups();
                    }
                });
            }
        }).dxDataGrid('instance');

        function getGroups(){
            $.ajax({
                url: '{!!url("/getgroupname")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    gridGroups.option('dataSource', data);
                    gridGroups.refresh();
                }
            });
        }

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });
    });
</script>
