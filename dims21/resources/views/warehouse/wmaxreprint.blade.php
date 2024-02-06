@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Galv Reprint')



{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $Edit = $v->getThingsUserPermissions(Auth::user()->UserID,'Reprint Edit');

        $canEdit = ($Edit == 1) ? true : false;
    }

    $includeMenu = true;
    
@endphp

@section('page')

<style>
    #gridReprint{
        height: calc(100vh - 2rem);
        max-height: calc(100vh - 2rem);
    }

    .customPadding {
        padding: 0px 1rem !important;
    }
</style>

<div id="gridReprint" style="width: 100% !important;"></div>

@endsection

@section('scripts')

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

            const gridReprint = $("#gridReprint").dxDataGrid({
                dataSource:[], //as json
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
                    pageSize: 20,
                },
                pager: {
                    visible: true,
                    allowedPageSizes: [5, 10, 20, 50, 'all'],
                    showPageSizeSelector: true,
                    showInfo: true,
                    showNavigationButtons: true,
                },
                editing: {
                    mode: 'row',
                    allowUpdating: '{{ $canEdit }}',
                },
                selection: {
                    mode: "single",
                    rowCssClass: 'custom-selected-row'
                    // showCheckBoxesMode: "onClick"
                },
                columns: [
                    {
                        cellTemplate: function (container, options) {
                            container.addClass("customPadding");
                            $("<div>")
                                .dxButton({
                                    icon: "fa fa-print",
                                    text: "",
                                    onClick: function(e) {
                                        // options.data.TicketNo
                                        window.open('{!!url("/printGalvLabel")!!}/'+options.data.TicketNo,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");
                                    }
                                })
                                .appendTo(container);
                        }
                    },
                    {
                        dataField: "TicketNo",
                        caption: "Ticket",
                        allowEditing: false,
                    },{
                        dataField: "SequenceNo",
                        caption: "Seq",
                        alignment: "center",
                        allowEditing: false,
                    },{
                        dataField: "JobNo",
                        caption: "Job No",
                        allowEditing: false,
                        groupIndex: 0,
                    }, {
                        dataField: "Customer",
                        caption: "Customer",
                        allowEditing: false,
                    }, 
                    {
                        dataField: "Department",
                        caption: "Department",
                        allowEditing: false,
                    },
                    {
                        dataField: "Machine",
                        caption: "Machine",
                        allowEditing: false,
                    },
                    {
                        dataField: "ProductName",
                        caption: "Product",
                        allowEditing: false,
                    },
                    {
                        dataField: "ActualWireSize",
                        caption: "Tested Wire Size",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "TreatedMPA",
                        caption: "Tested MPA",
                        alignment: "center",
                    },
                    {
                        dataField: "TestedZinc",
                        caption: "Tested Zinc",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "Weight",
                        caption: "Mass",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "Reference",
                        caption: "Ref.",
                        allowEditing: false,
                    }, 
                    {
                        dataField: "strStatus",
                        caption: "Status",
                        allowEditing: false,
                    },
                    {
                        dataField: "strTable",
                        caption: "Table",
                        allowEditing: false,
                    },
                ],
                onRowDblClick:function(e){
                    window.open('{!!url("/printGalvLabel")!!}/'+e.data.TicketNo,"_blank", "location=1, status=1,s crollbars=1, width=1200, height=850");
                },
                onRowUpdated: function(e) {
                    $.ajax({
                        url: '{!!url("/galvReprintEdit")!!}',
                        type: "POST",
                        data: {
                            TicketNo: e.data.TicketNo,
                            ActualWireSize: e.data.ActualWireSize,
                            TreatedMPA: e.data.TreatedMPA,
                            TestedZinc: e.data.TestedZinc,
                            Weight: e.data.Weight,
                            Table: e.data.strTable,
                        },
                        success: function (data) {
                            alert(data[0].Result);
                            getReprints();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('Reprint');
                            }
                        }
                    );
                },
            }).dxDataGrid('instance');

            getReprints();

            function getReprints(){
                $.ajax({
                    url: '{!!url("/getGalvReprints")!!}',
                    type: "GET",
                    success: function (data) {
                        gridReprint.option('dataSource', data);
                        gridReprint.refresh();

                        gridData = gridReprint.option("dataSource");
                    },

                });
            };
        });

    </script>

@endsection
