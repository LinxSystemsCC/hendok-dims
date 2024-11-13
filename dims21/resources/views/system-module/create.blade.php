<div class="modal-header">
    <h1 class="modal-title fs-5" id="newuserLabel">Add System Modules</h1>
    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('system-modules.store') }}" method="post" class="save-system-module">
        <!-- General error message will be displayed here if needed -->
        <div id="general-error"></div>
    
        <div class="form-group" id="addCustomerDiv">
            <label class="control-label" for="strName"
                style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Name</label>
            <input type="text" class="form-control input-sm col-xs-1" id="strName" name="strName">
            <!-- Error message will be appended here -->
        </div>
        <div class="form-group">
            <label for="parent" class="col-form-label" style="font-weight: 700;font-size: 15px;">Select Parent</label>
            <select class="form-select dims-select2" id="intParentId" name="intParentId" required>
                <option value="" selected>Select Parent</option>
                @foreach ($parentSystemModules as $val)
                    <option value="{{ $val->intAutoId }}">{{ $val->strName }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="close">Close</button>
    <button type="button" id="save-system-module" class="btn btn-success">Save</button>
</div>