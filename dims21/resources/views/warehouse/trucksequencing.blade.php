@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Load Sequencing')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

{{-- <div class="col-lg-12 d-inline-flex mb-2" >
    <div class="col-7 d-flex justify-content-end">
        <div class="col-5 d-inline-flex">
            <label class="d-flex align-items-center px-2 text-nowrap" >Date</label> 
            <input class="form-control" type="date" id='date'>
        </div>

        <div class="col-5 d-inline-flex">
            <label class="d-flex align-items-center px-2 text-nowrap" >Team Leader</label>
            <select class="form-select" style="width:100% !important;" id='teamLeader'>
                <option></option>
                @foreach ($teamleaders as $teamleader)
                    <option value="{{ $teamleader->UserID }}">{{ $teamleader->FullName }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-2 d-inline-flex">
            <button class="btn btn-success w-100 ms-2" id="btnGetTruckLoads">SEARCH</button>
        </div>
    </div>
</div> --}}

<div id="gridTruckSequencing"></div>

@endsection

@section('scripts')

    <style>
        #gridTruckSequencing{
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#teamLeader').select2({
                theme: 'bootstrap-5',
                // width: 100,
            });

            var today = new Date().toISOString().split('T')[0];
            $('#date').val(today);

            let gridData = [];

            var currentSelectedRow = [];

            const gridTruckSequencing = $("#gridTruckSequencing").dxDataGrid({
                dataSource: gridData,
                keyExpr: 'strUnickReference',
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                paging: {
                    enabled: false
                },
                rowDragging: {
                    allowReordering: true,
                    onReorder(e) {
                        const visibleRows = e.component.getVisibleRows();
                        const toIndex = gridData.findIndex((item) => item.intAutoPickingHeader === visibleRows[e.toIndex].data.intAutoPickingHeader);
                        const fromIndex = gridData.findIndex((item) => item.intAutoPickingHeader === e.itemData.intAutoPickingHeader);

                        gridData.splice(fromIndex, 1);
                        gridData.splice(toIndex, 0, e.itemData);

                        e.component.refresh();
                    },
                },
                selection: {
                    mode: "single",
                },
                columnFixing: {
                    enabled: true,
                },
                columnAutoWidth:true,
                allowColumnResizing: true,
                
                columnResizingMode: "nextColumn",
                columns: [
                    {
                        dataField: "date",
                        caption: "Date Created",
                        calculateCellValue: function (rowData) {
                            // Extract the date part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleDateString("en-ZA");
                        },
                    },
                    {
                        dataField: "time",
                        caption: "Time Created",
                        calculateCellValue: function (rowData) {
                            // Extract the time part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleTimeString();
                        },
                    },
                    {
                        dataField: "intAutoPickingHeader",
                        caption: "Load No.",
                        fixed: true,
                        calculateCellValue: function(data) {
                            return "TL" + data.intAutoPickingHeader;
                        },
                    },
                    {
                        dataField: "strUnickReference",
                        caption: "Reference",
                    },
                    {
                        dataField: "strPickingNickname",
                        caption: "Route",
                    },
                    {
                        dataField: "intTeamLeaderId",
                        caption: "Team Leader 1",
                        visible: false,
                    },
                    {
                        dataField: "strTeamLeader",
                        caption: "Team Leader 1",
                    },
                    {
                        dataField: "intTeamLeaderTwoId",
                        caption: "Team Leader 2",
                        visible: false,
                    },
                    {
                        dataField: "strTeamLeaderTwo",
                        caption: "Team Leader 2",
                    },
                    {
                        dataField: "intSequenceLoad",
                        caption: "Sequence",
                        dataType: "number",
                    },
                ],
                masterDetail: {
                    enabled: true,
                    template: function (container, options) {
                        const detailGridContainer = $("<div>");

                        // Load the external HTML content into the detailGridContainer
                        $.ajax({
                            url: '{!!url("/teamleaderUpdatePickingLoadingTable")!!}', // Replace with the actual URL
                            dataType: 'html',
                            method: 'GET',
                            data: {
                                ref: options.data.strUnickReference,
                            },
                            success: function (data) {
                                detailGridContainer.html(data);
                            },
                            error: function (error) {
                                console.error('Error loading content: ' + error);
                            }
                        });

                        // Append the loaded content to the detail grid's container
                        container.append(detailGridContainer);
                    }
                },
                onRowPrepared(e) {
                    //console.debug("RowPrepared");
                },
                onRowClick: function (e) {
                    var currentID = currentSelectedRow[0];
                    var clickedID = e.data.intAutoPickingHeader;

                    if (clickedID === currentID){
                        currentSelectedRow = [];
                        e.component.clearSelection();
                        $("#btnHold").prop("diabled", true);
                    } else {
                        currentSelectedRow = [];
                        currentSelectedRow.push(clickedID);
                        $("#btnHold").prop("diabled", false);
                    }
                },
                onSelectionChanged: function(e) {
                    //console.debug("SelectionChanged");
                },
                onRowDblClick: function (e) {
                    //console.debug("RowDblClick");
                },
                onInitNewRow: function(e) {
                    //console.debug("InitNewRow");
                },
                onRowInserting: function(e) {
                    //console.debug("RowInserting");
                },
                onRowInserted: function(e) {
                    //console.debug("RowInserted");
                },
                onRowUpdating: function(e) {
                    //console.debug("RowUpdating");
                },
                onToolbarPreparing: function (e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('Truck Load Sequencing');
                            }
                        }
                    );

                    // Create a button on the right side
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa-solid fa-arrow-down-1-9",
                                text: "SEQUENCE",
                                onClick: function (args) {
                                    // Handle button click event
                                    // console.log(gridData);
                                    updateSequence();
                                },
                            },
                        }
                    );

                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa-regular fa-hand",
                                text: "HOLD",
                                id: "btnHold",
                                onClick: function (args) {
                                    // Handle button click event
                                    holdTruckLoad();
                                    // updateSequence();
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            getTruckLoads();

            function getTruckLoads(){
                $.ajax({
                    url: '{!!url("/getTruckSequencing")!!}',
                    type: "GET",
                    data: {
                        date: $('#date').val(),
                        teamleaderId: $('#teamLeader').val()
                    },
                    success: function (data) {
                        gridTruckSequencing.option('dataSource', data);
                        gridTruckSequencing.refresh();

                        gridData = gridTruckSequencing.option("dataSource");

                        showLoadingIndicatorBriefly(gridTruckSequencing);
                    }
                });
            };

            function updateSequence(){
                gridData = gridTruckSequencing.option("dataSource");

                var newSequence = new Array();

                var seq = 0;

                gridData.forEach((element, index, value) => {
                    
                    newSequence.push({
                        'intAutoPickingHeader':element["intAutoPickingHeader"],
                        'seq' : seq,
                    });

                    seq += 1;
                });

                $.ajax({
                    url: '{!!url("/updateTruckLoadingSequence")!!}',
                    type: "POST",
                    data: {
                        newSequence: newSequence,
                    },
                    success: function (data) {
                        getTruckLoads();
                    }
                });
            };

            function holdTruckLoad(){
                if (gridTruckSequencing.getSelectedRowsData()[0]){
                    var selectedItem = gridTruckSequencing.getSelectedRowsData()[0];
                    var ref = selectedItem.strUnickReference;

                    $.ajax({
                        url: '{!!url("/teamleaderupdateholdstatus")!!}',
                        type: "GET",
                        data: {
                            ref: ref,
                            status: 2,
                        },
                        success: function (data) {
                            getTruckLoads();
                        }
                    });
                }else{
                    alert('Please select a row');
                }
                

            }

            function showLoadingIndicatorBriefly(dataGrid) {
                // Show the loading indicator
                dataGrid.beginCustomLoading();

                // Set a timeout to hide the loading indicator after a brief delay (e.g., 2 seconds)
                setTimeout(function () {
                    dataGrid.endCustomLoading();
                }, 1000); // Adjust the delay time as needed
            }
        });
    </script>

@endsection