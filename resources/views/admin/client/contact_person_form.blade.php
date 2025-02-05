<div class="row">
    <form method="POST" id="contact-form" action="{{ url('/admin/save_contact_person') }}"   accept-charset="UTF-8"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="id" name="id" value="{{ isset($contacts->id) ? $contacts->id : ''}}">
        <input type="hidden" name="company_id" value="{{ $company_id ?? ''}}">

        <div class="row mb-3">
            <div class="form-group col-md-3">
                <label for="contact_name" class="control-label">Name Title*</label>

                <select class="form-select" name="name_title" type="text" id="name_title" required="required">
                    <option value="">--</option>
                    @foreach($name_titles as  $item)
                        <option value="{{ $item->title }}"
                                @if(isset($contacts->contact_name) && $contacts->name_title ==  $item->title) selected @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-3">

                <label for="first_name" class="control-label">First Name*</label>
                <input class="form-control" name="first_name" type="text" id="first_name" required="required"
                       value="{{ isset($contacts->first_name) ? $contacts->first_name : ''}}">
            </div>
            <div class="form-group col-md-3">

                <label for="middle_name" class="control-label">Middle Name </label>
                <input class="form-control" name="middle_name" type="text" id="middle_name"
                       value="{{ isset($contacts->middle_name) ? $contacts->middle_name : ''}}">
            </div>

            <div class="form-group col-md-3">

                <label for="last_name" class="control-label">Last Name*</label>
                <input class="form-control" name="last_name" type="text" id="last_name" required="required"
                       value="{{ isset($contacts->last_name) ? $contacts->last_name : ''}}">
            </div>
        </div>




        <div class="form-group col-md-12 mb-3">
            <label for="contact_designation" class="control-label">Job Title</label>
            <input class="form-control" name="contact_designation" type="text" id="contact_designation"
                   value="{{ isset($contacts->contact_designation) ? $contacts->contact_designation : ''}}">
        </div>

 {{--       <div class="form-group col-md-6">
            <label for="contact_phone1" class="control-label">Phone 1*</label>
            <input class="form-control" name="contact_phone1" type="text" id="contact_phone1" required="required"
                   value="{{ isset($contacts->contact_phone1) ? $contacts->contact_phone1 : ''}}">
        </div>
        <div class="form-group col-md-6">
            <label for="contact_phone2" class="control-label">Phone 2 </label>
            <input class="form-control" name="contact_phone2" type="text" id="contact_phone2"
                   value="{{ isset($contacts->contact_phone2) ? $contacts->contact_phone2 : ''}}">

        </div>--}}

        <div class="form-group col-md-12">
            <table class="table table-striped table-bordered small">
                <thead>
                <tr>
                    <th style="width:60%"><strong>Email</strong></th>
                    <th>Default</th>
                    <th>Add</th>
                </tr>
                </thead>
                <tbody id="text">

                @if(isset($contacts->emails))
                    <?php
                    $headers = (!empty($contacts->emails)) ? $contacts->emails : '';

                    $field = (!empty($headers)) ? sizeof($headers) : '0';

                    foreach($headers as $key=>$value){
                    ?>
                    <input type='hidden' name="head[{{$key}}][id]" value="<?=$value->id?>" class="form-control"/>
                    <tr>

                        <td>
                            <input type='text' name="head[{{$key}}][email]" value="<?=$value->email?>"
                                   class="form-control email"/>
                        </td>
                        <td>
                            <input type='radio'  name="email_default"  value="<?=$key?>" class="email_default" @if($value->email == $contacts->contact_email ) checked="checked" @endif />

                        </td>

                        <td>
                            <button type="button" class="btn btn-danger btn-flat ng-scope deletebtn  btn-sm"
                                    data-id="{{$value->id}}"><i class="fa fa-trash-o" data-toggle="tooltip"
                                                                data-original-title="Remove"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                @else
                    @php $field  = 0; @endphp
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="text-left">
                        <button type="button" onClick="addInput(),addErase()" id="addHead" data-toggle="tooltip"
                                title="Add Item Option" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                        </button>
                    </td>
                </tr>
                </tfoot>
            </table>

            <input class="form-control" name="contact_email" type="hidden" id="contact_email"
                   value="{{ isset($contacts->contact_email) ? $contacts->contact_email : ''}}">

        </div>


        <div class="form-group col-md-12">
            <table class="table table-striped table-bordered small">
                <thead>
                <tr>
                    <th style="width:60%"><strong>Phone</strong></th>

                    <th nowrap>Contact Type</th>
                    <th>Default</th>
                    <th>Add</th>
                </tr>
                </thead>
                <tbody id="textphone">

                @if(isset($contacts->phones))
                    <?php
                    $headers = (!empty($contacts->phones)) ? $contacts->phones : '';

                    $field = (!empty($headers)) ? sizeof($headers) : '0';

                    foreach($headers as $key=>$value){
                    ?>
                    <input type='hidden' name="phone[{{$key}}][id]" value="<?=$value->id?>" class="form-control"/>
                    <tr>

                        <td>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="phone[{{$key}}][phone_code]" value="<?=$value->phone_code?>"
                                           class="form-control phone_code">
                                </div>
                                <div class="col-md-8">
                                    <input type='text' name="phone[{{$key}}][phone]" value="<?=$value->phone?>"
                                           class="form-control phone"/>
                                </div>
                            </div>

                        </td>
                        <td>
                            <input type='text' name="phone[{{$key}}][type]" value="<?=$value->type?>"
                                   class="form-control type"/>
                        </td>

                        <td>
                            <input type='radio'  name="phone_default"  value="<?=$key?>" class="phone_default" @if($value->is_default == 1 ) checked="checked" @endif />

                        </td>

                        <td>
                            <button type="button" class="btn btn-danger btn-flat ng-scope deletePhonebtn  btn-sm"
                                    data-id="{{$value->id}}"><i class="fa fa-trash-o" data-toggle="tooltip"
                                                                data-original-title="Remove"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                @else
                    @php $field  = 0; @endphp
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="text-left">
                        <button type="button" id="addPhone" data-toggle="tooltip" title="Add Item Option"
                                class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                    </td>
                </tr>
                </tfoot>
            </table>

            <input class="form-control" name="contact_phone1" type="hidden" id="contact_phone1"
                   value="{{ isset($contacts->contact_phone1) ? $contacts->contact_phone1 : ''}}">
        </div>

        <div class="form-group col-md-12">
            <label for="contact_name" class="control-label">Address*</label>
            <div class="input-group">
                <select class="form-control" name="address_id" type="text" id="address_id" required="required">
                    <option value="">--Select Company Address --</option>
                    @foreach($addresses as $item)
                        <option value="{{$item->id}}"
                                @if(isset($contacts->address_id) && $contacts->address_id == $item->id) selected @endif>
                            {{$item->address}}
                        </option>
                    @endforeach
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default addEditAddress" type="button"><i class="fa fa-plus-circle"></i></button>
              </span>
            </div>

        </div>


        <div class="form-group col-md-12" id="addressDetails">

        </div>


        <div class="form-group {{ $errors->has('Product Image') ? 'has-error' : ''}}">

            <div class="file-upload">
                <button class="file-upload-btn btn-primary" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Business Card</button>

                <div class="image-upload-wrap">
                    <input class="file-upload-input" name="business_card" type='file' value="{{ asset($contacts->business_card ?? '#') }}"  onchange="readURL(this);" accept="image/*" />
                    <div class="drag-text">
                        <h3>Drag and drop a file or select add Image</h3>
                    </div>
                </div>
                <div class="file-upload-content">
                    @if(!empty($contacts->business_card))
                        <img src="{{  App\basic::AWS_S3Storage($contacts->business_card)  }}" class="file-upload-image">
                    @else
                  <img class="file-upload-image" src="{{ asset($contacts->business_card ?? '#') }}" alt="your image" />
                        @endif
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                    </div>
                </div>
            </div>



            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
        </div>

        <link rel="stylesheet" href="{{asset('plugins/drug_upload_image/style.css')}}">
        <script src="{{asset('plugins/drug_upload_image/script.js')}}"></script>

        <div class="form-group col-md-6">
            <label for="postcode" class="control-label">Default Contact</label>
            <div>
                <input type="radio" name="is_default"
                       {{  (isset($contacts->is_default) && $contacts->is_default == 1) ? 'checked="checked" ' : ''}} value="1">
                Yes
                <input type="radio" name="is_default"
                       {{  (isset($contacts->is_default) && $contacts->is_default == 0 || !isset($contacts->is_default)) ? 'checked="checked" ' : ''}} value="0">
                No
            </div>
        </div>


        <div class="form-group col-md-6  ">

            <button class="btn btn-primary pull-right" type="submit" id="contactSavebtn"><i class="fa fa-save"></i>
                Save
            </button>

        </div>


    </form>
</div>
<link rel="stylesheet" href="{{asset('plugins')}}/select2/bootstrap-select.min.css" type="text/css"/>
<script src="{{asset('plugins')}}/select2/bootstrap-select.min.js"></script>
<script language="javascript">
    $(document).ready(function () {

        $('.selectpicker').selectpicker();

        $(document).on('change', '#address_id', function (event) {
            var address = $('#address_id option:selected').text();
             if(address != '') $('#addressDetails').html(address)
        })

        $('#address_id').trigger('change');
        $(document).on('change', '.email_default', function (event) {
            // $('.email_default checked:checked').val()
            // email = this.parentNode.find('.email').val();
           // id = $('.email_default :checked').val();
            email = $(this).parents('tr').find('.email').val()
            $('#contact_email').val(email)
        })


        $(document).on('change', '.phone_default', function (event) {
            event.stopImmediatePropagation();
            phone_code = $(this).parents('tr').find('.phone_code').val()
            phone = $(this).parents('tr').find('.phone').val()
            $('#contact_phone1').val(phone_code + phone)
        })


        $(document).on('change', '.email', function (event) {
            if ($(this).parents('tr').find('.email_default').prop('checked')) $('#contact_email').val($(this).val())
        })



         $('.deletePhonebtn').click(function (event) {
         event.stopImmediatePropagation();
            if (!confirm('Confirm delete?')) {
                return false
            }
            id = $(this).data('id');

            $.ajax({
                url: "{{URL::to('/del_contact_person_phone')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {


                }
            })
            this.parentNode.parentNode.remove(this.parentNode);
        })
/////////////////////////////////////////////////////////////////
        $('.deletebtn').click(function (event) {
            event.stopImmediatePropagation();
            if (!confirm('Confirm delete?')) {
                return false
            }
            id = $(this).data('id');

            $.ajax({
                url: "{{URL::to('/del_com_person_email')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {


                }
            })
            this.parentNode.parentNode.remove(this.parentNode);
        })

        // fields = Number('{{ $field }}');

        $('#addHead').click(function () {

            html = "";
            var fields = $('#textphone tr').length;
            if (fields != 10) {


                // html+=se;
                html = '<tr><td><input type="email"  name="head[' + fields + '][email]"  value="" class="form-control email" required /><input type="hidden"  name="head[' + fields + '][id]"  value="" class="form-control"  /> </td><td><input type="radio"  name="email_default" value="' + fields + '" class="email_default" /></td> <td><button  type="button" class="btn btn-danger btn-flat btn-sm ng-scope deletebtn" onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button></td></tr>';
                fields += Number(1);

                //$('#openoptions table').addClass('.table');
            } else {
                html = "<br />Only 10 data entries allowed.";
                $('#addInput').attr('disabled', 'disabled');
                //document.form.add.disabled=true;
            }

            $('#text').append(html);
        })

        $('#addPhone').click(function () {

            html = "";
            var fields = $('#textphone tr').length;

            if (fields != 10) {

                var phone = '<div class="row"><div class="col-md-4"><input type="text" name="phone[' + fields + '][phone_code]" value=""  class="form-control phone_code" placeholder="Phone Code"></div>' +
                    '<div class="col-md-8"><input type="text" name="phone[' + fields + '][phone]" value=""  placeholder="Phone Number" class="form-control phone "/></div></div>'

                // html+=se;
                html = '<tr><td>' + phone + '<input type="hidden"  name="phone[' + fields + '][id]"  value="" class="form-control"  /> </td>' +
                    '<td><input type="type"  name="phone[' + fields + '][type]"  value="" class="form-control type" /></td> ' +
                    '<td><input type="radio"  name="phone_default" value="' + fields + '" class="phone_default" /></td> ' +
                    '<td><button  type="button" class="btn btn-danger btn-flat btn-sm ng-scope deletePhonebtn" onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button></td></tr>';
                fields += Number(1);

                //$('#openoptions table').addClass('.table');
            } else {
                html = "<br />Only 10 data entries allowed.";
                $('#addInput').attr('disabled', 'disabled');
                //document.form.add.disabled=true;
            }

            $('#textphone').append(html);
        })

    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        var contactForm = $('#contact-form');
// $(document).on('submit', '#addressbtn', function (event) {
        contactForm.submit(function (event) {

            event.preventDefault();

            $('#contactSavebtn').prop('disabled', true);


            formData = new FormData(),
                params   = contactForm.serializeArray(),
                files    = contactForm.find('[name="business_card"]')[0].files;
            if(files.length > 0 ) {
                formData.append('business_card', files[0]);
            }

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });


            $.ajax({
                url: contactForm.attr('action'),
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                data: formData,
                success: function (data) {
                    $(contactForm)[0].reset();
                    $('#ajaxModal').modal('hide');
                    $('#contactSavebtn').prop('disabled', false);

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

                    // $.snackbar({content: "Save Successfully", timeout: 10000});
                    $.fn.loadContactData();
                }
            })
        });




    });

</script>
