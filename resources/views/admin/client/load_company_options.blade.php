

    <table id="example1"   class="table table-striped table-bordered table-sm">
        <thead>
        <tr>
            <th><strong>SI#</strong></th>
            <th width="40%"><strong>Title</strong></th>
            <th>Code</th>
            <th>Group</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($results as $item)

            <tr id="row_{{$item->id}}" class="row_{{ $item->options->id  }} rows">
                <td>{{ $loop->iteration }}</td>
                <td><em>{{ $item->title ?? '' }}</em>  </td>
                <td> {{ $item->code ?? '' }}   </td>
                <td> {{ $item->options->head ?? '' }}  </td>
                <td>

                    <button  data-id="{{ $item->id }}"  data-title="{{ $item->title }}"     data-headid="{{ $item->com_head_id ?? '' }}"   data-code="{{ $item->code }}" title="Edit"  class="btn btn-primary btn-sm EditBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                        <button type="button" data-id="{{$item->id}}" class="btn btn-danger btn-sm  Delbtn" title="Delete agent_jobs_candidate_todo_list"  ><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th><strong>SI#</strong></th>
            <th width="40%"><strong>Title</strong></th>
            <th>Code</th>
            <th>Group</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>



<script>

    $(document).ready(function () {

        $('.EditBtn').click(function(){
            id = $(this).data('id');
            $('#id').val( $(this).data('id') );
            $('#title').val( $(this).data('title') );
            $('#code').val( $(this).data('code') );
            headid = $(this).data('headid')

            $('[name=com_head_id] option').filter(function () {
                return ($(this).val() == headid); //To select Blue
            }).prop('selected', true);

            $('#myModal').data('id', id).modal('show');

        })

       // $("#example1").dataTable();


     //$(document).on('click', ' .todoDelbtn ', function () {
        $('.Delbtn').click(function(){
                if(!confirm('Confirm delete?')){
                return false
            }
            var id= $(this).data('id');


            url ='{{ url('/destroy_options') }}/'+id;

            $.ajax({
                url: url,
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content')  },
                success: function( data ) {

                    $.fn.loadData();
                }
            })

        })


    });


</script>