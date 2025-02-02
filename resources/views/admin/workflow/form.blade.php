<div class="mb-3">
    <label for="description" class="block font-medium text-sm text-gray-700">{{ 'Description' }}</label>
    <input class="form-control" id="description" name="description" type="text" value="{{ isset($workflow->description) ? $workflow->description : ''}}" required>
    {!! $errors->first('description', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="escalation_frequency_id" class="block font-medium text-sm text-gray-700">{{ 'Escalation Frequency' }}</label>
    <select class="form-select" id="escalation_frequency_id" name="escalation_frequency_id">
        @foreach($escalation_frequencies as $item)
            <option
                value="{{$item->id}}" {{(isset($workflow->escalation_frequency_id) && ($workflow->escalation_frequency_id == $item->id) )? 'selected': ''}} >{{$item->description}}</option>
        @endforeach
    </select>
      {!! $errors->first('escalation_frequency_id', '<p>:message</p>') !!}
</div>
<div class="mb-3">

    <div class="form-check">
        <label   for="email_wet_signature">
            {{ 'Email As PDF For Wet Signature' }}  <input class="form-check-input" type="checkbox" id="email_wet_signature" name="email_wet_signature" value="1"
                                                           @if(isset($user_manual->email_wet_signature) && $user_manual->email_wet_signature==1) checked @endif>
        </label>
    </div>

    <div class="form-check">
        <label   for="email_approval_signature">
            {{ 'Email As PDF For Wet Signature' }}  <input class="form-check-input" type="checkbox" id="email_approval_signature" name="email_approval_signature" value="1"
                                                           @if(isset($workflow->email_approval_signature) && $workflow->email_approval_signature==1) checked @endif>
        </label>
    </div>

     {!! $errors->first('email_wet_signature', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="sso_link_expiry_days" class="block font-medium text-sm text-gray-700">{{ 'SSO Default Link Expiry(Days)' }}</label>
    <input class="form-control" id="sso_link_expiry_days" name="sso_link_expiry_days" type="text" value="{{ isset($workflow->sso_link_expiry_days) ? $workflow->sso_link_expiry_days : ''}}" >
    {!! $errors->first('sso_link_expiry_days', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <select class="form-select" id="status" name="status">
        @foreach($status as $item)
            <option
                value="{{$item}}" {{(isset($workflow->status) && ($workflow->status == $item) )? 'selected': ''}} >{{$item}}</option>
        @endforeach
    </select>

    {!! $errors->first('status', '<p>:message</p>') !!}
</div>

<div class="flex items-center text-end gap-4">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
