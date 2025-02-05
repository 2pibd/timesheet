
    <form method="POST" id="ComAddress-form" action="{{ url('/admin/save_company_address_info') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <input type="hidden" id="id" name="id" value="{{ isset($address->id) ? $address->id : ''}}">
        <input type="hidden" name="company_id" value="{{ $company_id ?? ''}}">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group mb-3 ">
            <label for="address1" class="control-label">Address Line 1*</label>
            <input class="form-control" name="address1" type="text" id="address1" required="required"
                   value="{{ isset($address->address1) ? $address->address1 : ''}}">
        </div>
        <div class="form-group mb-3 ">
            <label for="address2" class="control-label">Address  Line 2</label>
            <input class="form-control" name="address2" type="text" id="address2"
                   value="{{ isset($address->address2) ? $address->address2 : ''}}">
        </div>
        <div class="form-group mb-3 ">
            <label for="address3" class="control-label">Address  Line 3</label>
            <input class="form-control" name="address3" type="text" id="address2"
                   value="{{ isset($address->address3) ? $address->address3 : ''}}">
        </div>
        <div class="form-group mb-3 ">
            <label for="address4" class="control-label">Address  Line 4</label>
            <input class="form-control" name="address4" type="text" id="address2"
                   value="{{ isset($address->address4) ? $address->address4 : ''}}">
        </div>
        <div class="form-group mb-3 ">
            <label for="address5" class="control-label">Address  Line 5</label>
            <input class="form-control" name="address5" type="text" id="address2"
                   value="{{ isset($address->address5) ? $address->address5 : ''}}">
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3 ">
                <label for="client_id" class="control-label">Country*</label>
                <select class="form-select countryName" name="country" id="country" required="required">
                    <option value="">--Select Country--</option>
                    @foreach($country as $key=>$value)
                        <option value="{{$value->country_id}}"
                                @if(isset($address->country) && $address->country == $value->country_id) selected="selected" @endif>{{$value->country}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3 ">
                <label for="state" class="control-label">State*</label>

                <select class="form-select stateopt" name="state">
                    <option value="">Select</option>
                </select>
            </div>
        <div class="form-group mb-3 ">
            <label for="city" class="control-label">City*</label>

             <select class="form-select cityopt" required='required' name="city">
                  <option value="">Select</option>
                </select>
           <!--  <input class="form-control" name="city" type="text" id="city" required="required"
                   value="{{ isset($address->city) ? $address->city : ''}}"> -->
        </div>

        <div class="form-group mb-3 ">
            <label for="postcode" class="control-label">Postcode</label>
            <input class="form-control" name="postcode" type="text" id="postcode"
                   value="{{ isset($address->postcode) ? $address->postcode : ''}}">
        </div>

        <div class="row">
        <div class="form-group col-md-6 mb-3 ">
            <label for="postcode" class="control-label">Default Address</label>
            <br>
            <input type="radio" name="is_default"
                   {{  (isset($address->is_default) && $address->is_default == 1) ? 'checked="checked" ' : ''}} value="1">
            Yes
            <input type="radio" name="is_default"
                   {{  (isset($address->is_default) && $address->is_default == 0 || !isset($address->is_default)) ? 'checked="checked" ' : ''}} value="0">
            No
        </div>

            <div class="form-group  col-md-6  mb-3 ">
                <label for="address_type" class="control-label">Address Type</label>
                <input class="form-control" name="address_type" type="text" id="address_type"
                       value="{{ isset($address->address_type) ? $address->address_type : ''}}">
            </div>


        <div class="form-group col-md-12 mb-3 ">

            <button class="btn btn-primary pull-right" type="submit" id="addressSavebtn"><i class="fa fa-save"></i>
                Save
            </button>

        </div>
        </div>

        </div>
        </div>
    </form>


<script type="text/javascript">

$(document).ready(function(){

 $(document).on('change','.countryName', function(event){
     event.preventDefault();
     event.stopPropagation();
      var id = $(this).val();

      var  stateid =  {{$address->state ?? '' }}

      /*Country Load Start*/
      $.ajax({
             url: "{{URL::to('/admin/load-state')}}",
             type: 'GET',
             data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id },
             dataType: 'json',
             success: function( response ) {

                $('.stateopt').empty();
                $('.stateopt').append('<option value="">Select State</option>');
                $.each(response, function (key, obj) {

                if(obj.state_id == stateid) selectopt = 'selected = "selected"'; else selectopt='';

               // alert(stateid);
                $('.stateopt').append('<option value="'+obj.state_id+'" '+selectopt+'>'+obj.state+'</option>');
                });

                $('.stateopt').trigger('change');
             }
         })
        /*Country Load End*/
    });

$('.countryName').trigger('change');

 $(document).on('change','.stateopt', function(event){
     event.preventDefault();
     event.stopPropagation();
      var id = $(this).val();

      var cityid = {{$address->city ?? '' }}

      /*City Load Start*/
      $.ajax({
             url: "{{URL::to('/admin/load-city')}}",
             type: 'GET',
             data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id },
             dataType: 'json',
             success: function( response ) {
                $('.cityopt').empty();
                $('.cityopt').append('<option value="">Select City</option>');
                $.each(response, function (key, obj) {
                     if(obj.city_id == cityid) selectopt = 'selected = "selected"'; else selectopt='';
                $('.cityopt').append('<option value="'+obj.city_id+'" '+selectopt+'>'+obj.city+'</option>');
                });
             }
         })

        /*City Load End*/
    });




    });


   </script>


<script type="text/javascript">

    $(document).ready(function () {
        var addressForm = $('#ComAddress-form');

        addressForm.submit(function (event) {

            event.preventDefault();

            $.ajax({
                url: addressForm.attr('action'),
                dataType: "text",
                method: 'POST',
                data: addressForm.serialize(),
                success: function (data) {
                    $(addressForm)[0].reset();
                    $('#ajaxModal').modal('hide');
// $('#addressbtn').prop('disabled', false);
                    if (data.status == 'success'){
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title:  data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    //  $.snackbar({content: "Save Successfully", timeout: 1000});
                     $.fn.loadAddressData();
                }
            })
        });

    });

</script>
