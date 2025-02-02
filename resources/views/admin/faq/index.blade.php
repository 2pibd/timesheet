@extends('admin.layouts.master')
@section('title')
    Consultant
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Timesheet
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">FAQ (Frequently Asked Questions)</h4>
                    <div class="flex-shrink-0">
                        @can('create-client')
                            <a href="{{url('admin/faq/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body" >

                  {{--  @livewire('faq.data-table-faq')--}}


                    <form method="GET" action="{{ url('/admin/faq') }}" accept-charset="UTF-8"
                              class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..."
                                       value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <br/>


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="5%">SRL No.</th>
                                    <th  width="20%">Question</th>
                                    <th  width="5%">Client</th>
                                    <th  width="5%">Worker</th>
                                    <th  width="5%">Supplier</th>
                                    <th  width="5%">Hide</th>
                                    <th  width="5%">Viewed</th>
                                    <th  width="5%">Language</th>
                                    <th  width="5%">Employer</th>
                                    <th width="10%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($faq))
                                    @foreach($faq as $item)
                                        <tr>
                                            <td width="5%">{{ $loop->iteration + ($faq->currentPage() - 1) * $faq->perPage() }}</td>
                                            <td  width="20%">{{$item->faq_title ?? ''}}</td>
                                            <td  width="5%" align="center">
                                                <input class="form-check-input updateFlag" data-area="client" data-id="{{$item->id}}" type="checkbox"  @if(isset($item->client) && $item->client==1) checked @endif>
                                            </td>
                                            <td  width="5%" align="center">
                                                <input class="form-check-input updateFlag" data-area="worker" data-id="{{$item->id}}" type="checkbox"  @if(isset($item->worker) && $item->worker==1) checked @endif>
                                            </td>
                                            <td  width="5%" align="center">
                                                <input class="form-check-input updateFlag" data-area="supplier" data-id="{{$item->id}}"  type="checkbox" @if(isset($item->supplier) && $item->supplier==1) checked @endif>
                                            </td>

                                            <td  width="5%" align="center">
                                                <input class="form-check-input updateFlag" data-area="hide" data-id="{{$item->id}}"  type="checkbox" id="hide" name="hide"  @if(isset($item->hide) && $item->hide==1) checked @endif>
                                            </td>
                                            <td  width="10%">
                                                {{$item->viewed ?? ''}}
                                            </td>
                                            <td  width="10%">
                                                {{$item->language->lang ?? ''}}
                                            </td>
                                            <td  width="10%">
                                                {{$item->employer->emp_ref ?? ''}}
                                            </td>
                                            <td nowrap>
                                                <a href="{{ url('admin/faq/'. $item->id . '/edit') }}"
                                                title="Edit FAQ">
                                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                                   aria-hidden="true"></i> Edit
                                                    </button>
                                                </a>
                                            <form method="POST" action="{{ url('admin/faq'.'/'. $item->id) }}"
                                                  accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete faq"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                            class="fa fa-trash" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> @if(isset($faq)) {!! $faq->appends(['search' => Request::get('search')])->render() !!} @endif</div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>

        $(function () {

            $(document).on('click', '.updateFlag', function () {
                let value=0;
                var id = $(this).data('id');
                var area = $(this).data('area');
                const isChecked = $(this).is(':checked');
                if(isChecked) value=1; else value=0;

                $.ajax({
                    url: "{{URL::to('admin/update-FAQ-flag')}}",
                    dataType: "JSON",
                    type: 'POST',
                    data: {'_token': $('meta[name=csrf-token]').attr('content') , 'area':area , 'id':id,'value':value },
                    success: function (data) {


                    }
                })
            })


            //////////////////////////////////////////////////////////


        });
    </script>

@endsection
