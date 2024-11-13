<div class="modal-header">
    <h1 class="modal-title fs-5" id="newuserLabel">Update System Modules</h1>
    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('system-modules.update', $systemModule->intAutoId) }}" class="update-system-module-form">
        @csrf
        <div id="general-error"></div>
    
        <div class="form-group" id="addCustomerDiv">
            <label class="control-label" for="strName" style="margin-bottom: 0px; font-weight: 700; font-size: 15px;">Name</label>
            <input type="text" class="form-control input-sm col-xs-1" id="strName" name="strName" value="{{ $systemModule->strName }}">
        </div>
    
        <div class="form-group">
            <label for="parent" class="col-form-label" style="font-weight: 700; font-size: 15px;">Select Parent</label>
            <select class="form-select dims-select2" id="intParentId" name="intParentId" required>
                <option value="">Select Parent</option>
                @foreach ($parentSystemModules as $val)
                    <option value="{{ $val->intAutoId }}" 
                        {{ $val->intAutoId == $systemModule->intParentId ? 'selected' : '' }}>
                        {{ $val->strName }}
                    </option>
                @endforeach
            </select>
        </div>
        
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="close">Close</button>
    <button type="button" id="update-system-module" class="btn btn-success">Update</button>
</div>