<div class="mb-3">
    <label for="message_type" class="block font-medium text-sm text-gray-700">{{ 'Message Type' }}</label><br>

    <!-- Radio Buttons -->
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="message_type" id="Offline" value="Offline" autocomplete="off"
               @if(isset($online_message) && $online_message->message_type == 'Offline' || !isset($online_message) ) checked @endif>
        <label class="btn btn-outline-secondary" for="Offline">Offline</label>

        <input type="radio" class="btn-check" name="message_type" id="Online" value="Online" autocomplete="off"
               @if(isset($online_message) && $online_message->message_type == 'Online') checked @endif>
        <label class="btn btn-outline-secondary" for="Online">Online</label>

    </div>
     {!! $errors->first('message_type', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="offline_title" class="block font-medium text-sm text-gray-700">{{ 'Offline Title' }}</label>
    <input class="form-control" id="offline_title" name="offline_title" type="text" value="{{ isset($online_message->offline_title) ? $online_message->offline_title : ''}}" >
    {!! $errors->first('offline_title', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="offline_message" class="block font-medium text-sm text-gray-700">{{ 'Offline Message' }}</label>
    <textarea class="form-control" id="offline_message" name="offline_message"  >{!! $online_message->offline_message ?? ''!!}</textarea>
    {!! $errors->first('offline_message', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="message" class="block font-medium text-sm text-gray-700">{{ 'Message' }}</label>
    <textarea class="form-control" id="message" name="message"  >{!! $online_message->message ?? ''!!}</textarea>
  {!! $errors->first('message', '<p>:message</p>') !!}
</div>


    <div class=" {{ $errors->has('status') ? 'has-error' : ''}} mb-3 col-md-4 col-sm-12">
        <label for="status" class="control-label">{{ 'User' }} </label>
        <!-- Base Example -->
        <div class="d-flex">
        <div class="form-check mx-2">
            <input class="form-check-input" type="checkbox" id="client" name="client"  value="1" @if(isset($online_message->client) && $online_message->client==1) checked @endif>
            <label class="form-check-label" for="client">
                Client
            </label>
        </div>

        <div class="form-check mx-2">
            <input class="form-check-input" type="checkbox" id="worker" name="worker"  value="1" @if(isset($online_message->worker) && $online_message->worker==1) checked @endif>
            <label class="form-check-label" for="worker">
                Worker
            </label>
        </div>

        <div class="form-check mx-2">
            <input class="form-check-input" type="checkbox" id="supplier" name="supplier" value="1"  @if(isset($online_message->supplier) && $online_message->supplier==1) checked @endif>
            <label class="form-check-label" for="supplier" >
                Supplier
            </label>
        </div>

        </div>
    </div>

<div class="mb-2">
    <label class="block font-medium text-sm text-gray-700" for="supplier" >
        Employer
    </label>
    <select class="form-select w-25">
        <option>All Employers</option>
    </select>
</div>

<div class="flex items-center text-end gap-4">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>



<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {

        var editor = CKEDITOR.replace( 'message', {height:['200px'],
            filebrowserUploadUrl: '{{ asset('uploadImage/') }}',
            filebrowserBrowseUrl: '{{ asset('filebrowser/') }}'

        } );

        CKFinder.setupCKEditor( editor, 'ckfinder/' );


    });
</script>
