@extends('admin.master')

@section('content')

    <div class="wrapper-md">
        <div class="row">

            <div class="col-md-3 col-xs-12">
                <div class="panel panel-default" id="ibox_panel">
                    <div class="panel-body">
                        <h5 class="text-muted">Options</h5>
                    </div>
                    <div class="panel-body list-group border-bottom m-t-n-lg">
                        <a href="javascript:;" id="All" href="javascript:;" data-rid="rows"
                           service="rows" class="list-group-item active"><span
                                    class="fa fa-file-o"></span> All </a>
                        @foreach($options as $key=>$value )
                            <a href="javascript:;" id="{{$value->head}}" href="javascript:;" data-rid="row_{{$value->id}}"
                               service="{{$value->head}}" class="list-group-item"><span
                                        class="fa fa-file-o"></span> {{$value->head}} </a>
                        @endforeach
<br><br>
                        <a href="{{url('comm_attr/'.$cid )}}" class="btn btn-success btn-block mt-5"><i class="fa fa-plus"></i> Add Attributes/Head </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9  col-xs-12">


                <div class="panel panel-default" id="ibox_panel">
                    <div class="panel-body">
                        <div class="card-body">
                            <div class="col-md-6">
                                <!--form method="GET" action="{{ url('/company_profile') }}" accept-charset="UTF-8"
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
                                </form-->
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:;" class="btn btn-success btn-sm pull-right addBtn" title="Add New">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a>
                            </div>
                            <br/>
                            <br/>

                            <div class="table-responsive" id="loaddata">


                            </div>


                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add options</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="option-form" action="{{ url('/save_head_options') }}"
                          accept-charset="UTF-8" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}  col-md-8 ">
                                <label for="title" class="control-label">{{ 'Title' }}</label>
                                <input class="form-control" name="title" type="text" id="title" value="" required>
                                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}   col-md-4 ">
                                <label for="title" class="control-label">{{ 'Code' }}
                                    (Length: {{ $company_profile->code_length }})</label>
                                <input class="form-control" name="code" type="text" max="{{ $company_profile->code_length }}" id="code" value=""
                                       required min="{{ $company_profile->code_length }}"
                                       maxlength="{{ $company_profile->code_length }}" pattern="[0-9, A-Z]*">
                                {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('com_head_id') ? 'has-error' : ''}}  col-md-12">
                                <label for="com_head_id" class="control-label">{{ 'Option Group' }}</label>

                                <select class="form-control" name="com_head_id" id="com_head_id" required>
                                    @foreach($options as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->head}}</option>
                                    @endforeach
                                </select>

                                {!! $errors->first('com_head_id', '<p class="help-block">:message</p>') !!}
                            </div>
                            <input type="hidden" name="company_id" value="{{$cid}}">
                            <input type="hidden" name="id" id="id" value="">
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">Cancel</a>
                            <button type="submit" id="submitbtn" class="btn btn-danger">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <script>


            $(document).ready(function () {
               $('#code').keyup(function(){
                   $(this).val($(this).val().toUpperCase())
               })
//////////////////////////////////////////////////////////////////////////
                $('.addBtn').on('click', function (e) {
                    e.preventDefault();

                    var id = $(this).data('id');

                    // $('#myModal .modal-body').html('...')

                    $('#myModal').data('id', id).modal('show');
                });


                //////////////////////////////////
                $('.list-group-item').click(function () {

                    $('.list-group a').removeClass('active');
                    $(this).addClass('active');

                    $('.rows').hide();
                    $('.'+$(this).data('rid')).fadeIn();


                })
                $(".list-group  a").eq(1).addClass("active");
                // $("#example1").dataTable();

                var optionForm = $('#option-form');
                optionForm.submit(function (event) {

                    event.preventDefault();
                    $('#submitbtn').prop('disabled', true);
                    $.ajax({
                        url: optionForm.attr('action'), //$(this).attr('action'),
                        dataType: "JSON",
                        method: 'POST',
                        data: optionForm.serialize(),
                        success: function (response) {

                            $('.successMsg').html(response.msg);

                            $('.successMsg').fadeOut(2000);
                            $('#myModal').modal('hide');
                            $(optionForm)[0].reset();
                            $.fn.loadData();


                            $('.list-group a').removeClass('active');
                            $('#All').addClass('active');

                            $('#submitbtn').prop('disabled', false);
                        }
                    })

                });


                $.fn.loadData = function () {

                    cid = '{{ $cid }}';

                    $.ajax({
                        url: "{{URL::to('/load_company_options')}}",
                        dataType: "text",
                        type: 'POST',
                        data: {'_token': $('meta[name=csrf-token]').attr('content'), 'cid': cid},
                        success: function (responce) {  // alert(data.sid) ;
                            $('#loaddata').html(responce)

                        }
                    })
                }


                $.fn.loadData();

            });


        </script>
@endsection
