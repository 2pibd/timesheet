<div class="row">
    <div class="mb-3 col-12">
    <label for="division_id" class="block font-medium text-sm text-gray-700">{{ 'Division*' }}</label>
    <select class="form-select" id="division_id" name="division_id" required >
        <option value="*">--All Division--</option>
        @foreach($divisions as $key=>$item)
            <option value="{{$item->id}}" {{(isset($boundary_validation->division_id) && ($boundary_validation->division_id == $item->id) )? 'selected': ''}} >{{$item->name}}</option>
        @endforeach
    </select>

   {!! $errors->first('division_id', '<p>:message</p>') !!}
</div>

    <div class="mb-3 col-12">
  <table>
      <thead>
      <tr>
          <td></td>
          <td>Minimum</td>
          <td>Maximum</td>
      </tr>
      </thead>

      <tbody>
      <tr>
          <td width="20%">Hour/Day:</td>
          <td>  <input class="form-control" id="hour_day_min" name="hour_day_min" type="number" min="0" value="{{  $boundary_validation->hour_day_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="hour_day_max" name="hour_day_max" type="number" min="0"  value="{{  $boundary_validation->hour_day_max ?? '0'}}" >
          </td>
      </tr>

      <tr>
          <td>Days/Day:</td>
          <td>  <input class="form-control" id="days_day_min" name="days_day_min"  type="number" min="0"  value="{{  $boundary_validation->days_day_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="days_day_max" name="days_day_max"  type="number" min="0"  value="{{  $boundary_validation->days_day_max ?? '0'}}" >
          </td>
      </tr>

      <tr>
          <td>Hour/Week:</td>
          <td>  <input class="form-control" id="hour_week_min" name="hour_week_min"  type="number" min="0"  value="{{  $boundary_validation->hour_week_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="hour_week_max" name="hour_week_max"  type="number" min="0"  value="{{  $boundary_validation->hour_week_max ?? '0'}}" >
          </td>
      </tr>
      <tr>
          <td>Days/Week:</td>
          <td>  <input class="form-control" id="days_week_min" name="days_week_min"  type="number" min="0"  value="{{  $boundary_validation->days_week_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="days_week_max" name="days_week_max"  type="number" min="0"  value="{{  $boundary_validation->days_week_max ?? '0'}}" >
          </td>
      </tr>
      <tr>
          <td>Hour/Month:</td>
          <td>  <input class="form-control" id="hour_month_min" name="hour_month_min"  type="number" min="0"  value="{{  $boundary_validation->hour_month_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="hour_month_max" name="hour_month_max"  type="number" min="0"  value="{{  $boundary_validation->hour_month_max ?? '0'}}" >
          </td>
      </tr>
      <tr>
          <td>Days/Month:</td>
          <td>  <input class="form-control" id="days_month_min" name="days_month_min"  type="number" min="0"  value="{{  $boundary_validation->days_month_min ?? '0'}}" >
          </td>
          <td>  <input class="form-control" id="days_month_max" name="days_month_max"  type="number" min="0"  value="{{  $boundary_validation->days_month_max ?? '0'}}" >
          </td>
      </tr>


      </tbody>

  </table>
    </div>

    <div class="mb-3 col-6">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
        <select class="form-select" id="status" name="status" >
            @foreach($status as $key=>$item)
                <option value="{{$item}}" {{(isset($boundary_validation->status) && ($boundary_validation->status == $item) )? 'selected': ''}} >{{$item}}</option>
            @endforeach
        </select>

    {!! $errors->first('status', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
</div>
