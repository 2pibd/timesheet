<div class="row">
                <div class="col-md-9">
                    <h3>{{$company_profile->company_name ?? ''}}</h3>
                    <ul class="list-unstyled">
                        <li>Company Reference : {{$company_profile->company_name ?? ''}}</li>

                        <li>Company Reference : {{ isset($company_profile->external_ref) ? $company_profile->external_ref : ''}}</li>
                        <li>Company Email : {{  $company_profile->company_email ?? ''}}</li>
                        <li>Company Phone : {{ isset($company_profile->company_phone) ? $company_profile->company_phone : ''}}</li>
                        <li>Industry Type : {{$company_profile->company_name ?? ''}}</li>
                        <li>Company Id/Reg. No. : {{ isset($company_profile->company_id) ? $company_profile->company_id : ''}}</li>
                        <li>VAT Reg ID   : {{ isset($company_profile->vat_reg) ? $company_profile->vat_reg : ''}}</li>

                        <li>Website : {{ isset($company_profile->website) ? $company_profile->website : ''}}</li>
                        <li>Default currency : {{$company_profile->default_currency ?? ''}}</li>
                        <li>Default Language : {{$company_profile->language->name ?? ''}}</li>
                        <li>Compliance (Default Group) : {{$company_profile->default_compliance_group?? ''}}</li>
                        <li><strong>Status</strong> : {{$company_profile->status?? ''}}</li>
                    </ul>

                </div>

                <div class="col-md-3">

                    <img src="{{(!empty($company_profile->company_logo) ? $company_profile->base_url . '/' . $company_profile->company_logo : '')}}" class="img img-responsive">

                </div>

              <div class="col-md-12">{!! isset($company_profile->company_profile) ? $company_profile->company_profile : '' !!}</div>

@if(isset($address))
    <div class="table-responsive col-md-12">
        <h4>Contact Address</h4>
        <table class="table table-bordered" id="Datatable">
            <thead>
            <tr>
                <th width="5%">#</th>
                <th ><strong>Address 1</strong></th>
                <th ><strong>Address 2</strong></th>
                <th ><strong>Address 3</strong></th>
                <th ><strong>Address 4</strong></th>
                <th ><strong>Address 5</strong></th>
                <th >City</th>
                <th>State</th>
                <th>Postcode</th>
                <th>Country</th>
                <th>Address Type</th>
                <th width="12%">Default</th>

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

                </tr>

            @endforeach

            </tbody>


        </table>
    </div>
    @endif

    @if(isset($contact_info))
        <div class="table-responsive col-md-12">
<h4>Contact Person</h4>
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th ><strong>Name</strong></th>
                    <th >Designation</th>
                    <th>Phone 1</th>
                    <th>Phone 2</th>
                    <th>Email</th>
                    <th width="12%">Default</th>
                </tr>
                </thead>
                <tbody>

                @foreach($contact_info as $contacts_val)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$contacts_val->contact_name}}  </td>
                        <td>{{$contacts_val->contact_designation}}</td>
                        <td>{{$contacts_val->contact_phone1}}</td>
                        <td>{{$contacts_val->contact_phone2}}</td>
                        <td>{{$contacts_val->contact_email}}</td>
                        <td>{!!    ($contacts_val->is_default == 1) ? '<i class="fa fa-check"></i>' : '' !!}</td>
                
                    </tr>

                @endforeach

                </tbody>


            </table>
        {{--<div
            class="pagination-wrapper"> {!! $user_target->appends(['search' => Request::get('search')])->render() !!} </div>--}}
    </div>
@endif

    </div>
