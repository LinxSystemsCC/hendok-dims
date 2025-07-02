<div class="modal fade" id="modalJobCard" tabindex="-1" aria-labelledby="modalJobCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable rounded-0">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJobCardTitle">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" id="jobCardTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-details-tab" data-bs-toggle="tab" data-bs-target="#tab-details" type="button" role="tab" aria-controls="tab-details" aria-selected="true">
                            Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-jobs-tab" data-bs-toggle="tab" data-bs-target="#tab-jobs" type="button" role="tab" aria-controls="tab-jobs" aria-selected="false">
                            Jobs
                        </button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content" id="jobCardTabContent">
                    <!-- Details Tab -->
                    <div class="tab-pane fade show active" id="tab-details" role="tabpanel" aria-labelledby="tab-details-tab">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputJobStatus">Job Status</label>
                                    <select class="form-select w-100" id="selectStatus">
                                        <option></option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->intStatusId }}">{{ $status->strStatus }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputPropStart">Proposed Start Date</label>
                                    <input class="form-control w-100" id="inputPropStart" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputStart">Started</label>
                                    <input class="form-control w-100" id="inputStart" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputEnd">Ended</label>
                                    <input class="form-control w-100" id="inputEnd" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputSequence">Sequence</label>
                                    <input class="form-control w-100" id="inputSequence" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputDepartment">Department</label>
                                    <input class="form-control w-100" id="inputDepartment" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputProductCode">Product Code</label>
                                    <input class="form-control w-100" id="inputProductCode" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputProductDescription">Product Description</label>
                                    <input class="form-control w-100" id="inputProductDescription" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputMachine">Machine</label>
                                    <input class="form-control w-100" id="inputMachine" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputQty">Qty</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded-end-0" id="inputQty" disabled>
                                        <button class="btn btn-secondary rounded-start-0 btn-rounded-end" type="button" id="btnEditQty">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-success rounded-start-0" type="button" id="btnSaveQty" hidden>
                                            <i class="bi bi-check-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputConfigurationType">Configuration Type</label>
                                    <input class="form-control w-100" id="inputConfigurationType" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputConfigurationQty">Configuration Qty</label>
                                    <input class="form-control w-100" id="inputConfigurationQty" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jobs Tab -->
                    <div class="tab-pane fade" id="tab-jobs" role="tabpanel" aria-labelledby="tab-jobs-tab">
                        <div id="gridMachineJobs" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
