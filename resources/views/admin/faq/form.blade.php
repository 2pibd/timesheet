
<div class=" {{ $errors->has('faq') ? 'has-error' : ''}} mb-3">
    <label for="faq" class="control-label">{{ 'Faq Question' }}</label>
    <input type="text" class="form-control" name="faq_title" value="{{$faq->faq_title ?? ''}}" required>
    {!! $errors->first('faq', '<p class="help-block">:message</p>') !!}
</div>
<div class=" {{ $errors->has('chamber_id') ? 'has-error' : ''}} mb-3">
    <label for="chamber_id" class="control-label">{{ 'Answer' }} </label>
    <textarea class="form-control" name="faq_desc" id="faq_desc" rows=15 cols=50 required>{{$faq->faq_desc ?? ''}}</textarea>
    {!! $errors->first('chamber_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="row">
<div class=" {{ $errors->has('employer_id') ? 'has-error' : ''}} mb-3 col-md-6  col-sm-12">
    <label for="employer_id" class="control-label">{{ 'Employer Ref*' }} </label>
    <select class="form-select" name="employer_id">
        <option value="">--Select--</option>
        @foreach($employers as $item)
            <option @if((isset($faq->employer_id) && $faq->employer_id==$item->id)  ) selected @endif value="{{$item->id}}">{{$item->emp_ref}}</option>
        @endforeach
    </select>
</div>

<div class=" {{ $errors->has('chamber_id') ? 'has-error' : ''}} mb-3  col-md-6  col-sm-12">
    <label for="hide" class="control-label">{{ 'Hide' }} </label><br>
    <!-- Radio Buttons -->
    <div class="btn-group  btn-group-sm" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="hide" id="hide1" value="1" autocomplete="off" @if(isset($faq) && $faq->hide == '1' || !isset($faq) ) checked="checked" @endif>
        <label class="btn btn-outline-secondary" for="hide1">Yes</label>

        <input type="radio" class="btn-check btn-sm" name="hide" id="hide2" value="0" autocomplete="off"  @if(isset($faq) && $faq->hide == '0' ) checked="checked" @endif>
        <label class="btn btn-outline-secondary" for="hide2">No</label>
    </div>
    {!! $errors->first('chamber_id', '<p class="help-block">:message</p>') !!}
</div>
<div class=" {{ $errors->has('category') ? 'has-error' : ''}} mb-3 col-md-4  col-sm-12">
    <label for="category" class="control-label">{{ 'Category*' }} </label>
    <select class="form-select" name="category" required>
        <option value="">--Select--</option>
        @foreach($statusField as $val)
            <option @if(isset($faq->category) && $faq->category==$val) selected @endif value="{{$val}}">{{$val}}</option>
        @endforeach
   </select>
</div>


<div class=" {{ $errors->has('language_id') ? 'has-error' : ''}} mb-3 col-md-4  col-sm-12">
    <label for="chamber_id" class="control-label">{{ 'Language*' }} </label>
    <select class="form-select" name="language_id" required>
        <option value="">--Select--</option>
        @foreach($languages as $item)
            <option @if((isset($faq->language_id) && $faq->language_id==$item->id) || (!isset($faq) && $item->is_default == '1')) selected @endif value="{{$item->id}}">{{$item->lang}}</option>
        @endforeach
    </select>
</div>


<div class=" {{ $errors->has('status') ? 'has-error' : ''}} mb-3 col-md-4 col-sm-12">
    <label for="status" class="control-label">{{ 'Status*' }} </label>
   <select class="form-select" name="status" required>
        <option @if(isset($faq->status) && $faq->status==1) selected @endif value="1">Active</option>
        <option @if(isset($faq->status) && $faq->status==2) selected @endif value="2">InActive</option>
   </select>
</div>
</div>


<div class=" {{ $errors->has('status') ? 'has-error' : ''}} mb-3 col-md-4 col-sm-12">
    <label for="status" class="control-label">{{ 'Viewable In' }} </label>
    <!-- Base Example -->
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="client" name="client"  value="1" @if(isset($faq->client) && $faq->client==1) checked @endif>
        <label class="form-check-label" for="client">
            Client Portal
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="worker" name="worker"  value="1" @if(isset($faq->worker) && $faq->worker==1) checked @endif>
        <label class="form-check-label" for="worker">
            Worker Portal
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="supplier" name="supplier" value="1"  @if(isset($faq->supplier) && $faq->supplier==1) checked @endif>
        <label class="form-check-label" for="supplier" >
            Supplier Portal
        </label>
    </div>

</div>


<div class="mb-3 text-end">
    <input class="btn btn-primary" type="submit" value="{{$formMode}}">
</div>


<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>




<script type="text/javascript">
    $(document).ready(function() {

        var editor = CKEDITOR.replace( 'faq_desc', {height:['200px'],
            filebrowserUploadUrl: '{{ asset('uploadImage/') }}',
            filebrowserBrowseUrl: '{{ asset('filebrowser/') }}'

        } );

        CKFinder.setupCKEditor( editor, 'ckfinder/' );


    });
</script>
