<a class="btn btn-primary btn-sm pull-right addEditContactbtn mb-3" title="Add New Contact"><i class="fa fa-plus"
                                                                                          aria-hidden="true"></i>
    Add New</a>
<table class="table table-bordered">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th ><strong>Name</strong></th>
        <th >Designation</th>
        <th>Phone </th>
        <th>Email</th>
        <th width="12%">Default</th>
        <th>*</th>
    </tr>
    </thead>
    <tbody>

    @foreach($contact_info as $contacts_val)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$contacts_val->contact_name}}  </td>
            <td>{{$contacts_val->contact_designation}}</td>
            <td>{{ @implode(', ',$contacts_val->phones->pluck('phone_number')->toArray() ?? '')}}</td>
            <td>{{ @implode(', ',$contacts_val->emails->pluck('email')->toArray() ?? '')}}</td>
            <td>{!!    ($contacts_val->is_default == 1) ? '<i class="fa fa-check"></i>' : '' !!}</td>
            <td nowrap>
                <button type="button" data-id="{{$contacts_val->id}}" class="btn btn-danger btn-sm deleteContactbtn" title="Delete Address" ><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                <a  title="Edit Address"><button
                            data-id="{{$contacts_val->id}}"
                            class="btn btn-primary btn-sm addEditContactbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a></td>
        </tr>

    @endforeach

    </tbody>


</table>


<script type="text/javascript">

    $(document).ready(function () {

////////////////////////////////////////Add edit Address////////////////////////////////////////////////////////////////////////////////

        $(document).on('click', '.addEditContactbtn', function (e) {

            e.preventDefault();

            var id = $(this).data('id');
            var com_id = '{{ $client->id ?? ''  }}';
           // $('#ajaxModal .modal-dialog').removeClass('modal-xl');
            $('#ajaxModal .modal-dialog').addClass('modal-xl');
            $.ajax({
                url: "{{URL::to('admin/loadContactForm')}}",
                dataType: "text",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id, 'id': id},
                success: function (responce) {

                    if (id) $('#ajaxModalLabel').html('Edit Contact')
                    else $('#ajaxModalLabel').html('Add Contact')

                    $('#ajaxModalContent').html(responce)
                    $('#ajaxModal').data('id', id).modal('show');
                    // alert(data)
                }
            })


        });


/////////////////////////////////Contact Address//////////////////////////////////////////////////////

        //////////////load address table////////////////////
        $.fn.loadContactData = function () {
            var com_id = '{{ $client->id ?? ''  }}';

            $('#contactInfo').html("<img src={{url('images/ajax-loader.gif')}}>");
            $.ajax({
                url: "{{URL::to('/admin/company-contacts')}}",
                dataType: "html",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id},
                success: function (responce) {
                    $('#contactInfo').html(responce);
                }
            })
        }


        $.fn.loadContactData();




        $(document).on('click', ' .deleteAddressbtn ', function () {
            if (!confirm('Confirm delete?')) {
                return false
            }
            var id = $(this).data('id');

            com_id = '{{ $client->id ?? ''  }}';

            url = '{{ url('/admin/delete_comAddress' ) }}/' + id;

            $.ajax({
                url: url,
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id},
                success: function (data) {

                    $.fn.loadAddressData();

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

                    // alert(data)
                }
            })

        })

    })
</script>
