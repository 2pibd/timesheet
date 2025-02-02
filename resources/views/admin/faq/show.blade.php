@extends('admin.layout')
@section('content')
       <div class="wrapper-md">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-md-6">
                           <p class="m-n font-thin h3">account {{ $account->id }}</p>
                       </div>
                       <div class="col-md-6  text-right">
                           <a href="{{ url('/account') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                                 <a href="{{ url('/account/' . $account->id . '/edit') }}" title="Edit account"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                 <form method="POST" action="{{ url('account' . '/' . $account->id) }}" accept-charset="UTF-8" style="display:inline">
                                                     {{ method_field('DELETE') }}
                                                     {{ csrf_field() }}
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Delete account" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                 </form>

                       </div>
                   </div>
               </div>


               <div class="panel-body">
                   <div class="col-md-12">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $account->id }}</td>
                                    </tr>
                                    <tr><th> Account Name </th><td> {{ $account->account_name }} </td></tr><tr><th> Details </th><td> {{ $account->details }} </td></tr><tr><th> Amount </th><td> {{ $account->amount }} </td></tr>
                                    <tr><th> Status </th><td> {{ $account->status }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
