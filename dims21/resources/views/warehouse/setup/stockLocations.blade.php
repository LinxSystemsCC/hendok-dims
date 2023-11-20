@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Locations')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')
    <style>
        .red-cell {
            background-color: red;
            color: white;
        }

        .customPadding {
            padding: 3px !important;
        }

        .grid{
            height: 100%;
            max-height: 100%;
        }

    </style>

    <div class="col-md-12 h-100">
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Locations</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="true">Location Types</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3" role="tab" aria-controls="content3" aria-selected="true">Location Attributes</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4" role="tab" aria-controls="content4" aria-selected="true">Bins</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5" role="tab" aria-controls="content5" aria-selected="true">Bin Attributes</a>
            </li>
        </ul>

        <div class="tab-content h-auto py-3" id="tabs">
            <!-- Locations -->
            <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1" style="height: calc(100vh - 110px); overflow-y: auto;">
                <div class="grid" id="gridLocations"></div>

                <!-- Modal Add Locations -->
                <div class="modal fade" id="modalLocations" aria-labelledby="modalLocations" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLocations">Add a location</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Location Name</label>
                                    <input type="text" class="form-control" id="txtLocationName"/>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Location Abreviation</label>
                                    <input type="text" class="form-control" id="txtLocationAbreviation"/>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="control-label" for="selLocationType">Location Type</label>
                                    <select class="form-select" type="text" id="selLocationType">
                                        <option value="None" selected disabled></option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveLocation" class="btn btn-success" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Location Types -->
            <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2" style="height: calc(100vh - 110px); overflow-y: auto;">
                <div class="grid" id="gridLocationTypes"></div>

                <!-- Modal Add Location Types -->
                <div class="modal fade" id="modalLocationTypes" aria-labelledby="modalLocationTypes" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLocationTypes">Add a location Type</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Location Type Name</label>
                                    <input type="text" class="form-control" id="txtLocationType"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveLocationType" class="btn btn-success" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Location Attributes -->
            <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3" style="height: calc(100vh - 110px); overflow-y: auto;">
                <div class="grid" id="gridLocationAttributes"></div>

                <!-- Modal Add Location Attributes -->
                <div class="modal fade" id="modalLocationAttributes" aria-labelledby="modalLocationAttributes" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLocationAttributes">Add a location Attribute</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Location Attribute Name</label>
                                    <input type="text" class="form-control" id="txtLocationAttribute"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveLocationAttribute" class="btn btn-success" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bins -->
            <div class="tab-pane fade" id="content4" role="tabpanel" aria-labelledby="tab4" style="height: calc(100vh - 110px); overflow-y: auto;">
                <div class="grid" id="gridBins"></div>

                <!-- Modal Add Bins -->
                <div class="modal fade" id="modalBins" aria-labelledby="modalBins" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalBins">Add a Bin</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2" id="locationForBin">

                                </div>
                                <div class="form-group mb-2" id="attributesForBin">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveBin" class="btn btn-success" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bin Attributes -->
            <div class="tab-pane fade" id="content5" role="tabpanel" aria-labelledby="tab5" style="height: calc(100vh - 110px); overflow-y: auto;">
                <div class="grid" id="gridBinAttributes"></div>

                <!-- Modal Add Bin Attributes -->
                <div class="modal fade" id="modalBinAttributes" aria-labelledby="modalBinAttributes" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalBinAttributes">Add a Bin Attribute</h1>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Bin Attribute Name</label>
                                    <input type="text" class="form-control" id="txtBinAttributeName"/>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="control-label" for="printer">Bin Attribute Default Character</label>
                                    <input type="text" class="form-control" id="txtBinAttributeChar"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveBinAttribute" class="btn btn-success" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script>
        let binName = '';
        $(document).ready(function() {
            let LocationTypes = [];

            const gridLocations = $('#gridLocations').dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 1000,
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'batch',
                    allowUpdating: true,
                    allowDeleting: true,
                },
                columns: [
                    {
                        dataField: "intLocationNameId",
                        caption: "ID",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "strLocationAbv",
                        caption: "Location Abrviation",
                    },
                    {
                        dataField: "strLocationName",
                        caption: "Location Name",
                    },
                    {
                        dataField: "intLocationTypeId",
                        caption: "Location Type",
                        lookup: {
                            dataSource: LocationTypes,
                            valueExpr: "intLocationTypeId",
                            displayExpr: "strLocationType",
                        },
                    },
                    {
                        dataField: "dtmCreated",
                        caption: "Date Created",
                        allowEditing: false,
                    }
                ] ,
                onRowClick: function(e) {
                    // console.debug(e);
                },
                onRowDblClick: function (e) {
                    var strLocationName =  e.data.strLocationName;
                    window.open('{!!url("/printlocationqrcodes")!!}/' +strLocationName, "Location" +strLocationName, "location=1,status=1,scrollbars=1, width=1200,height=850");
                },
                onInitNewRow: function(e) {
                    // console.debug(e);
                },
                onRowInserting: function(e) {
                    // console.debug(e);
                },
                onRowInserted: function(e) {
                    // console.debug(e);
                },
                onRowUpdating: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationCrud")!!}',
                        type: "POST",
                        data: {
                            intLocationId: e.oldData.intLocationNameId,
                            strLocationName: e.newData.strLocationName || e.oldData.strLocationName,
                            strLocationAbv: e.newData.strLocationAbv || e.oldData.strLocationAbv,
                            intLocationTypeId: e.newData.intLocationTypeId || e.oldData.intLocationTypeId,
                            command: 'UPDATE'
                        },
                        success: function (data) {
                            getLocations();
                        }
                    });
                },
                onRowRemoving: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationCrud")!!}',
                        type: "POST",
                        data: {
                            intLocationId: e.data.intLocationNameId,
                            command: 'DELETE'
                        },
                        success: function (data) {
                            getLocations();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('LOCATIONS');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function (args) {
                                    $('#modalLocations').modal('show');
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            const gridLocationTypes = $('#gridLocationTypes').dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 1000,
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'batch',
                    allowUpdating: true,
                    allowDeleting: true,
                },
                columns: [
                    {
                        dataField: "intLocationTypeId",
                        caption: "ID",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "strLocationType",
                        caption: "Location Name",
                    },
                    {
                        dataField: "dteCreatedDate",
                        caption: "Date Created",
                        allowEditing: false,
                    },

                ] ,
                onRowClick: function(e) {
                    // console.debug(e);
                },
                onRowDblClick: function (e) {
                    // console.debug(e);
                },
                onInitNewRow: function(e) {
                    // console.debug(e);
                },
                onRowInserting: function(e) {
                    // console.debug(e);
                },
                onRowInserted: function(e) {
                    // console.debug(e);
                },
                onRowUpdating: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationTypesCrud")!!}',
                        type: "POST",
                        data: {
                            intLocationTypeId: e.oldData.intLocationTypeId,
                            strLocationType: e.newData.strLocationType || e.oldData.strLocationType,
                            command: 'UPDATE'
                        },
                        success: function (data) {
                            getLocationTypes();
                        }
                    });
                },
                onRowRemoving: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationTypesCrud")!!}',
                        type: "POST",
                        data: {
                            intLocationTypeId: e.data.intLocationTypeId,
                            command: 'DELETE'
                        },
                        success: function (data) {
                            getLocationTypes();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('LOCATION TYPES');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function (args) {
                                    $('#modalLocationTypes').modal('show');
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            const gridLocationAttributes = $('#gridLocationAttributes').dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 1000,
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'batch',
                    allowUpdating: true,
                    allowDeleting: true,
                },
                columns: [
                    {
                        dataField: "intAutoId",
                        caption: "ID",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "strAttribute",
                        caption: "Attribute Name",
                    },
                    {
                        dataField: "dtmCreated",
                        caption: "Date Created",
                        allowEditing: false
                    },

                ] ,
                onRowClick: function(e) {
                    // console.debug(e);
                },
                onRowDblClick: function (e) {
                    // console.debug(e);
                },
                onInitNewRow: function(e) {
                    // console.debug(e);
                },
                onRowInserting: function(e) {
                    // console.debug(e);
                },
                onRowInserted: function(e) {
                    // console.debug(e);
                },
                onRowUpdating: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationAttributesCrud")!!}',
                        type: "POST",
                        data: {
                            intAutoId: e.oldData.intAutoId,
                            strAttribute: e.newData.strAttribute || e.oldData.strAttribute,
                            command: 'UPDATE'
                        },
                        success: function (data) {
                            getLocationAttributes();
                        }
                    });
                },
                onRowRemoving: function(e) {
                    $.ajax({
                        url: '{!!url("/stockLocationAttributesCrud")!!}',
                        type: "POST",
                        data: {
                            intAutoId: e.data.intAutoId,
                            command: 'DELETE'
                        },
                        success: function (data) {
                            getLocationAttributes();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('LOCATION ATTRIBUTES');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function (args) {
                                    $('#modalLocationAttributes').modal('show');
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            const gridBins = $('#gridBins').dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 1000,
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'batch',
                    // allowUpdating: true,
                    allowDeleting: true,
                },
                onRowClick: function(e) {
                    // console.debug(e);
                },
                onRowDblClick:function(e){
                    var strBin =  e.data.strBin;
                    window.open('{!!url("/printlocationqrcodes")!!}/' +strBin, "Location" +strBin, "location=1,status=1,scrollbars=1, width=1200,height=850");
                },
                onInitNewRow: function(e) {
                    // console.debug(e);
                },
                onRowInserting: function(e) {
                    // console.debug(e);
                },
                onRowInserted: function(e) {
                    // console.debug(e);
                },
                onRowUpdating: function(e) {
                    // console.debug(e);
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('BINS');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function (args) {
                                    $('#modalBins').modal('show');
                                },
                            },
                        }
                    );
                },
                onContentReady: function (e) {
                    // This event is triggered when the content is ready, including the data
                    // You can perform actions here after the data source is loaded
                    // For example, hide the 'intBinId' column
                    e.component.columnOption('intBinId', 'visible', false);
                    e.component.columnOption('intBinId', 'allowEditing', false);
                    e.component.columnOption('strLocationName', 'caption', 'Location Name');
                    e.component.columnOption('strLocationName', 'allowEditing', false);
                    e.component.columnOption('strBin', 'caption', 'Bin Name');
                    e.component.columnOption('strBin', 'allowEditing', false);
                    e.component.columnOption('mnyBinCapacity', 'caption', 'Capacity');
                    e.component.columnOption('mnyBinCapacity', 'dataType', 'number');
                },
                onRowRemoving: function(e) {
                    $.ajax({
                        url: '{!!url("/binCrud")!!}',
                        type: "POST",
                        data: {
                            intBinId: e.data.intBinId,
                            command: 'DELETE'
                        },
                        success: function (data) {
                            getBins();
                        }
                    });
                },
            }).dxDataGrid('instance');

            var binAttributeData = [];
            const gridBinAttributes = $('#gridBinAttributes').dxDataGrid({
                dataSource: binAttributeData, //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 1000,
                },
                selection: {
                    mode: "single",
                },
                editing: {
                    mode: 'batch',
                    allowUpdating: true,
                    allowDeleting: true,
                },
                rowDragging: {
                    allowReordering: true,
                    onReorder(e) {
                        const visibleRows = e.component.getVisibleRows();
                        const toIndex = binAttributeData.findIndex((item) => item.intAutoId === visibleRows[e.toIndex].data.intAutoId);
                        const fromIndex = binAttributeData.findIndex((item) => item.intAutoId === e.itemData.intAutoId);

                        binAttributeData.splice(fromIndex, 1);
                        binAttributeData.splice(toIndex, 0, e.itemData);

                        var successfulRequests = 0;
                        for (let i = 0; i < binAttributeData.length; i++) {
                            binAttributeData[i].intSequence = i + 1;

                            $.ajax({
                                url: '{!!url("/binAttributesCrud")!!}',
                                type: 'POST',
                                data: {
                                    intAutoId: binAttributeData[i].intAutoId,
                                    strAttributeName: binAttributeData[i].strAttributeName,
                                    strDefaultChar: binAttributeData[i].strDefaultChar,
                                    intSequence: binAttributeData[i].intSequence,
                                    command: 'UPDATE',
                                },
                                success: function(data) {
                                    successfulRequests++;

                                    if (successfulRequests === binAttributeData.length) {
                                        getBinAttributes();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Handle the error for each row, if needed
                                }
                            });
                        }

                        

                        e.component.refresh();
                    },
                },
                columns: [
                    {
                        dataField: "intAutoId",
                        caption: "ID",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "strAttributeName",
                        caption: "Bin Attribute Name",
                    },
                    {
                        dataField: "strDefaultChar",
                        caption: "Character",
                    },
                    {
                        dataField: "intSequence",
                        caption: "Seq",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "dtmCreated",
                        caption: "Date Created",
                        allowEditing: false,
                    },

                ] ,
                onRowClick: function(e) {
                    // console.debug(e);
                },
                onRowDblClick: function (e) {
                    // console.debug(e);
                },
                onInitNewRow: function(e) {
                    // console.debug(e);
                },
                onRowInserting: function(e) {
                    // console.debug(e);
                },
                onRowInserted: function(e) {
                    // console.debug(e);
                },
                onRowUpdating: function(e) {
                    $.ajax({
                        url: '{!!url("/binAttributesCrud")!!}',
                        type: "POST",
                        data: {
                            intAutoId: e.oldData.intAutoId,
                            strAttributeName: e.newData.strAttributeName || e.oldData.strAttributeName,
                            strDefaultChar: e.newData.strDefaultChar || e.oldData.strDefaultChar,
                            intSequence: gridBinAttributes.getRowIndexByKey(e.key) + 1,
                            command: 'UPDATE'
                        },
                        success: function (data) {
                            getBinAttributes();
                            getBins();
                        }
                    });
                },
                onRowRemoving: function(e) {
                    $.ajax({
                        url: '{!!url("/binAttributesCrud")!!}',
                        type: "POST",
                        data: {
                            intAutoId: e.data.intAutoId,
                            command: 'DELETE'
                        },
                        success: function (data) {
                            getBinAttributes();
                            getBins();
                        }
                    });
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('BIN ATTRIBUTES');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function (args) {
                                    $('#modalBinAttributes').modal('show');
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            getData();

            function getData(){
                getLocations();
                getLocationTypes();
                getLocationAttributes();
                getBins();
                getBinAttributes();
            };

            function getLocations(){
                $.ajax({
                    url: '{!!url("/stockLocationCrud")!!}',
                    type: "POST",
                    data: {
                        command: 'READ'
                    },
                    success: function (data) {
                        gridLocations.option('dataSource', data);
                        gridLocations.refresh();

                        var locationForBin = $('#locationForBin');
                        locationForBin.empty();

                        // Append a select element with options to locationForBin
                        var select = $('<select>').addClass('form-select mb-2').attr('id', 'selectLocation');

                        // Append an empty option as a default
                        select.append($('<option>').text('-- Select Location --').val(''));

                        // Append options based on the data
                        data.forEach(function (item) {
                            select.append($('<option>').text(item.strLocationName).val(item.intLocationNameId).attr('name', item.strLocationAbv));
                        });

                        // Append the select element to locationForBin
                        locationForBin.append(select);
                    }
                });
            };

            function getLocationTypes(){
                $.ajax({
                    url: '{!!url("/stockLocationTypesCrud")!!}',
                    type: "POST",
                    data: {
                        command: 'READ',
                    },
                    success: function (data) {
                        //Add the data to the grid
                        gridLocationTypes.option('dataSource', data);
                        gridLocationTypes.refresh();

                        LocationTypes= $.map(data, function(item) {
                            return {
                                intLocationTypeId: item.intLocationTypeId,
                                strLocationType: item.strLocationType
                            };
                        });

                        gridLocations.columnOption("intLocationTypeId", "lookup.dataSource", LocationTypes);
                        gridLocations.refresh();

                        //Add the data to the select
                        var selectElement = $("#selLocationType");
                        // Clear existing options and add a blank option
                        selectElement.empty();
                        selectElement.append($("<option>").val("").text(""));
                        // Populate the <select> with data from the JSON array
                        $.each(data, function(index, item) {
                            selectElement.append($("<option>").val(item.intLocationTypeId).text(item.strLocationType));
                        });
                    }
                });
            };

            function getLocationAttributes(){
                $.ajax({
                    url: '{!!url("/stockLocationAttributesCrud")!!}',
                    type: "POST",
                    data: {
                        command: 'READ'
                    },
                    success: function (data) {
                        gridLocationAttributes.option('dataSource', data);
                        gridLocationAttributes.refresh();
                    }
                });
            };

            function getBins(){
                $.ajax({
                    url: '{!!url("/binCrud")!!}',
                    type: "POST",
                    data: {
                        command: 'READ',
                    },
                    success: function (data) {
                        gridBins.option('dataSource', data);
                        gridBins.refresh();
                    }
                });
            };

            function getBinAttributes(){
                $.ajax({
                    url: '{!!url("/binAttributesCrud")!!}',
                    type: "POST",
                    data: {
                        command: 'READ'
                    },
                    success: function (data) {
                        gridBinAttributes.option('dataSource', data);
                        gridBinAttributes.refresh();
                        binAttributeData = gridBinAttributes.option("dataSource");

                        var attributesForBin = $('#attributesForBin');
                        attributesForBin.empty();

                        getLocations();

                        data.forEach(function (item) {
                            var label = $('<label>').addClass('control-label')
                                .text(item.strAttributeName);

                            var input = $('<input>').attr({
                                type: 'number',
                                name: item.strDefaultChar // Set the name attribute
                            }).addClass('form-control mb-2 binInput');

                            attributesForBin.append(label).append(input);
                        });

                        var label = $('<label>').addClass('control-label').text("Bin Capacity");
                        var input = $('<input>').attr({type: 'number', id: 'inputBinCapacity'}).addClass('form-control mb-2');
                        attributesForBin.append(label).append(input);

                        var label = $('<label>').addClass('control-label').text("Bin Name");
                        var input = $('<input>').attr({type: 'text', id: 'inputBinName'}).addClass('form-control mb-2').prop('disabled', true);
                        attributesForBin.append(label).append(input);

                    }
                });
            };

            $("#btnSaveLocation").click(function () {
                $.ajax({
                    url: '{!!url("/stockLocationCrud")!!}',
                    type: "POST",
                    data: {
                        strLocationName: $("#txtLocationName").val(),
                        strLocationAbv: $("#txtLocationAbreviation").val(),
                        intLocationTypeId: $("#selLocationType").val(),
                        command: 'CREATE'
                    },
                    success: function (data) {
                        $('#modalLocations').modal('hide');
                        getLocations();
                    }
                });
            });

            $("#btnSaveLocationType").click(function () {
                $.ajax({
                    url: '{!!url("/stockLocationTypesCrud")!!}',
                    type: "POST",
                    data: {
                        strLocationType: $("#txtLocationType").val(),
                        command: 'CREATE'
                    },
                    success: function (data) {
                        $('#modalLocationTypes').modal('hide');
                        getLocationTypes();
                    }
                });
            });

            $("#btnSaveLocationAttribute").click(function () {
                $.ajax({
                    url: '{!!url("/stockLocationAttributesCrud")!!}',
                    type: "POST",
                    data: {
                        strAttribute: $("#txtLocationAttribute").val(),
                        command: 'CREATE'
                    },
                    success: function (data) {
                        $('#modalLocationAttributes').modal('hide');
                        getLocationAttributes();
                    }
                });
            });

            $("#btnSaveBin").click(function () {
                $.ajax({
                    url: '{!!url("/binCrud")!!}',
                    type: "POST",
                    data: {
                        strBinName: binName,
                        intLocationId: $("#selectLocation").val(),
                        mnyBinCapacity: $("#inputBinCapacity").val(),
                        command: 'CREATE'
                    },
                    success: function (data) {
                        $('#modalBins').modal('hide');
                        getBins();
                    }
                });
            });

            $("#btnSaveBinAttribute").click(function () {
                $.ajax({
                    url: '{!!url("/binAttributesCrud")!!}',
                    type: "POST",
                    data: {
                        strAttributeName: $("#txtBinAttributeName").val(),
                        strDefaultChar: $("#txtBinAttributeChar").val(),
                        command: 'CREATE'
                    },
                    success: function (data) {
                        $('#modalBinAttributes').modal('hide');
                        getBinAttributes();
                        getBins();
                    }
                });
            });

            $('#attributesForBin').on('input', '.binInput', function() {
                binName = '';
                var location = $("#selectLocation option:selected").attr('name');

                $('.binInput').each(function() {
                    
                    var code = $(this).attr('name');
                    var input = $(this).val();

                    if (input !== '') {
                        binName += code + input + '-';
                    }
                });

                binName = binName.slice(0, -1);

                $('#inputBinName').val(location + '-' + binName);
            });

        });
    </script>

@endsection
