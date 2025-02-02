<div class="mb-3">
    <label for="description" class="block font-medium text-sm text-gray-700">{{ 'Description' }}</label>
    <input class="form-control" id="description" name="description" type="text" value="{{ isset($escalation_frequency->description) ? $escalation_frequency->description : ''}}" required>
    {!! $errors->first('description', '<p>:message</p>') !!}
</div>


<div class=" {{ $errors->has('status') ? 'has-error' : ''}} mb-3 col-md-4 col-sm-12">
    <label for="EscalateOn" class="control-label">{{ 'Escalate On' }} </label>
    <!-- Base Example -->
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="monday" name="monday"  value="1" @if(isset($escalation_frequency->monday) && $escalation_frequency->monday==1) checked @endif>
        <label class="form-check-label" for="monday">
            Monday
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="tuesday" name="tuesday"  value="1" @if(isset($escalation_frequency->tuesday) && $escalation_frequency->tuesday==1) checked @endif>
        <label class="form-check-label" for="tuesday">
           Tuesday
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="wednesday" name="wednesday" value="1"  @if(isset($escalation_frequency->wednesday) && $escalation_frequency->supplier==1) checked @endif>
        <label class="form-check-label" for="wednesday" >
            Wednesday
        </label>
    </div>


    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="thursday" name="thursday" value="1"  @if(isset($escalation_frequency->thursday) && $escalation_frequency->thursday==1) checked @endif>
        <label class="form-check-label" for="thursday" >
            Thursday
        </label>
    </div>


    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="friday" name="friday" value="1"  @if(isset($escalation_frequency->friday) && $escalation_frequency->friday==1) checked @endif>
        <label class="form-check-label" for="friday" >
            Friday
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="saturday" name="saturday" value="1"  @if(isset($escalation_frequency->saturday) && $escalation_frequency->saturday==1) checked @endif>
        <label class="form-check-label" for="saturday" >
            Saturday
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="sunday" name="sunday" value="1"  @if(isset($escalation_frequency->sunday) && $escalation_frequency->sunday==1) checked @endif>
        <label class="form-check-label" for="sunday" >
            Sunday
        </label>
    </div>

</div>

<div class="  d-flex gap-3">
<div class="mb-3">
    <label for="start_time" class="block font-medium text-sm text-gray-700">{{ 'Start Time' }}</label>
    <input class="form-control" id="start_time" name="start_time" type="time" value="{{ isset($escalation_frequency->start_time) ? $escalation_frequency->start_time : ''}}" >
    {!! $errors->first('start_time', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="end_time" class="block font-medium text-sm text-gray-700">{{ 'End Time' }}</label>
    <input class="form-control" id="end_time" name="end_time" type="time" value="{{ isset($escalation_frequency->end_time) ? $escalation_frequency->end_time : ''}}" >
    {!! $errors->first('end_time', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="interval" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Summary Interval(mins)' }}</label>
    <input class="form-control" id="interval" name="interval" type="number" value="{{ isset($escalation_frequency->interval) ? $escalation_frequency->interval : ''}}" >
    {!! $errors->first('interval', '<p>:message</p>') !!}
</div>
</div>

<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
