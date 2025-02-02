
<div class="form-group mb-3">
    <label class="col-lg-4 control-label">Name</label>
    <div class="col-lg-8">
        <input name="name" value="{{ $permission->name ?? old('name')}}" required type="text"
               class="form-control" placeholder="Please Enter Ride Name">
        {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
    </div>
</div>


<div class="form-group mb-3">
    <label class="col-lg-4 control-label">Reference Code Name</label>
    <div class="col-lg-8">
        <input name="name" value="{{ $permission->name ?? old('name')}}" required type="text"
               class="form-control" placeholder="Please Enter Ride Name" >
        {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
    </div>
</div>

<div class="col-md-12">
    <hr>
    <div class="form-group">
        <div class="text-center">
            <input class="btn btn-primary" type="submit" value="{{ $submitButtonText ?? 'Create' }}">
        </div>
    </div>
</div>


