<div class="mb-3">
    <label for="title" class="block font-medium text-sm text-gray-700">{{ 'Label*' }}</label>
    <input class="form-control" id="title" name="title" type="text" value="{{ isset($flag_color->title) ? $flag_color->title : ''}}" >
    {!! $errors->first('title', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="color_code" class="block font-medium text-sm text-gray-700">{{ 'Color Code*' }}</label>
    <div class=" input-append d-flex">
        <input class="input-group-text p-1" id="mask_color" name="color_code" type="color" opacity rgba cmyk hsla   value="{{ isset($flag_color->ref_code) ? $flag_color->ref_code : ''}}" required>
        <input type="hidden" id="rgbaCol" name="color_rgba" value="{{$flag_color->color_rgba ?? ''}}"  aria-label="Color Code" aria-describedby="basic-addon1">
        <input type="range" class="d-none" min="0" max="1" step="0.1" value="{{$flag_color->color_opacity ?? '1.0'}}" name="color_opacity" id="mask_opacity">
        {!! $errors->first('color_code', '<p>:message</p>') !!}
    </div>
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>



@push('scripts')
    <script language="javascript">
        $(document).ready(function () {

            $(document).on('change', '#mask_color, #mask_opacity', function (event) {

                event.stopImmediatePropagation();
                event.preventDefault();
                var opacity = $("#mask_opacity").val();
                var color = $("#mask_color").val();

                var rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';

                $('#rgbaCol').val(rgbaCol);

                //  $('#viewMask').css('background-color', rgbaCol)
            });
        })
    </script>
@endpush
