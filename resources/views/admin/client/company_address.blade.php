<a class="btn btn-primary btn-sm pull-right addEditAddress mb-3" title="Add New Address"><i class="fa fa-plus" aria-hidden="true"></i>
    Add New</a>
 								<table class="table table-bordered">
 									<thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th><strong>Address 1</strong></th>
                                        <th><strong>Address 2</strong></th>
                                        <th><strong>Address 3</strong></th>
                                        <th><strong>Address 4</strong></th>
                                        <th><strong>Address 5</strong></th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Postcode</th>
                                        <th>Country</th>
                                        <th>Address Type</th>
                                        <th width="12%">Default</th>
                                        <th>*</th>
                                    </tr>
                                </thead>
                                <tbody>

                                	@foreach($address as $address_val)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$address_val->address1}}</td>
                                        <td>{!!   isset($address_val->address2)? $address_val->address2 : ''!!}</td>
                                        <td>{!!   isset($address_val->address3)? $address_val->address3 : ''!!}</td>
                                        <td>{!!   isset($address_val->address4)? $address_val->address4 : ''!!}</td>
                                        <td>{!!   isset($address_val->address5)? $address_val->address5 : ''!!}</td>
                                        <td>{{$address_val->CityLoad->city ?? ''}}</td>
                                        <td>{{$address_val->StateLoad->state ?? ''}}</td>
                                        <td>{{$address_val->postcode ?? ''}}</td>
                                        <td>{{$address_val->CountryLoad->country ?? ''}}</td>
                                        <td>{{$address_val->address_type ?? ''}}</td>
                                        <td>{!!    ($address_val->is_default == 1) ? '<i class="fa fa-check"></i>' : '' !!}</td>
                                        <td nowrap="true">
                                            <button type="button" data-id="{{$address_val->id}}" class="btn btn-danger btn-sm deleteAddressbtn" title="Delete Address"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                         <a  title="Edit Address"><button
                                          data-id="{{$address_val->id}}"
                                          class="btn btn-primary btn-sm addEditAddress"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a></td>
                                    </tr>

                                    @endforeach

                                </tbody>


                            </table>

<script type="text/javascript">

    $(document).ready(function () {
////////////////////////////////////////Add edit Address////////////////////////////////////////////////////////////////////////////////

        $(document).on('click', '.addEditAddress', function (e) {

            e.preventDefault();

            var id = $(this).data('id');
            com_id = '{{ $client->id ?? ''  }}';
            $('#ajaxModal .modal-dialog').removeClass('modal-xl');
            $('#ajaxModal .modal-dialog').addClass('modal-lg');


            $.ajax({
                url: "{{URL::to('/admin/loadAddressForm')}}",
                dataType: "text",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id, 'id': id},
                success: function (responce) {

                    if (id) $('#ajaxModalLabel').html('Edit Address')
                    else $('#ajaxModalLabel').html('Add Address')
                    $('#ajaxModalContent').html(responce)
                    $('#ajaxModal').data('id', id).modal('show');
                    // alert(data)
                }
            })


        });

/////////////////////////////////Contact Address//////////////////////////////////////////////////////

        //////////////load address table////////////////////
        $.fn.loadAddressData = function () {
            com_id = '{{ $client->id ?? ''  }}';

            $('#addressContent').html("<img src={{url('images/ajax-loader.gif')}}>");
            $.ajax({
                url: "{{URL::to('/admin/company-address')}}",
                dataType: "html",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id},
                success: function (responce) {
                    $('#addressContent').html(responce);
                }
            })
        }
        $.fn.loadAddressData();


        $(document).on('click', ' .deleteContactbtn ', function () {
            if (!confirm('Confirm delete?')) {
                return false
            }
            var id = $(this).data('id');

            com_id = '{{ $client->id ?? ''  }}';

            url = '{{ url('/admin/delete_comContact' ) }}/' + id;

            $.ajax({
                url: url,
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'company_id': com_id},
                success: function (data) {
                    $.fn.loadContactData();
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

                    // $.snackbar({content: "Removed Successfully", timeout: 3000});
                    // alert(data)
                }
            })

        })
    })
 </script>
