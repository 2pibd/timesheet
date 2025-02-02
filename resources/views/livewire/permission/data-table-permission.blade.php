<div  class="">

    <div class="d-flex mb-3" >
        <div class="me-2">
            <select wire:model.lazy="perPage" id="page_size" class="form-select form-select-sm form-control w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>


    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <input type="text" wire:model.live.debounce="search"  placeholder="Search..." class="form-control">

        </div>

    </div>
    <div class="table-bordered table-responsive printable-section">

        <table class="table table-striped">
            <thead class="bg-light">
            <tr>
                <th>#</th>
                <th data-column="company_name">
                    <button wire:click="sortBy('name')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Name</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'name' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'name' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th  data-column="external_ref">
                    <button wire:click="sortBy('title')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Label</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'title' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'title' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>
                <th  data-column="external_ref">

                    <button wire:click="sortBy('guard_name')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Guard name</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'guard_name' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'guard_name' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th data-column="client_group_id">
                    <button wire:click="sortBy('created_at')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Date</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'created_at' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>


                <th class="no-print">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td data-column="name">{{ $item->name }}</td>
                    <td data-column="title">{{ $item->title }}</td>
                    <td data-column="guard_name">{{ $item->guard_name ?? '' }}</td>
                    <td data-column="created_at">{{ $item->created_at ?? '' }}</td>
                    <td nowrap class="no-print">
                        <ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item no-print">
                                <div class="dropdown">
                                    <button class="btn btn-soft-secondary btn-sm dropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @can('view-permission')
                                            <li><a href="{{ route('permission.show', $item->id) }}" class="dropdown-item view-item-btn"
                                                   title="View"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                        @endcan
                                        @can('update-permission')
                                            <li><a href="{{ route('permission.edit', $item->id) }}" class="dropdown-item edit-item-btn"
                                                   title="Edit"> <i  class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                </a></li>

                                        @endcan

                                        @can('delete-permission')
                                            <li>
                                                <form method="POST" action="{{ url('permission.destroy', $item->id) }}"
                                                      accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    @csrf()
                                                    <button type="submit"
                                                            class="dropdown-item  btn-link text-black btn-xs"
                                                            title="Delete Client"
                                                            onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i>  Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No data available</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-between no-print">
        <div>
            <label for="page_size">Items per page:</label>
            <select wire:model.lazy="perPage" id="page_size" class="form-select form-select-sm form-control w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <!-- Pagination Controls -->
        <div class="col-md-7">
            {{ $data->links() }}
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important; /* Ensure elements are hidden during printing */
            }
        }

    </style>


    <style>
        .sort-icons {
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Align icons to the right */
            justify-content: center; /* Center the icons vertically */
        }

        .sort-icons .fa {
            font-size: 12px;
            margin: -2px 0; /* Reduce gap between up and down arrows */
        }

        .active-icon {
            color: #007bff; /* Highlighted color for active arrows */
            font-weight: bold;
        }

        .light-icon {
            color: #ccc; /* Dimmed color for inactive arrows */
        }

        th button {
            width: 100%; /* Ensure button takes up full header width */
            text-align: left; /* Align title to the left */
        }

        th .text-start {
            flex: 1; /* Allow title to take up space on the left */
        }
    </style>

    {{-- {!! $data->appends(request()->query())->render() !!}--}}

</div>


<script>
    function toggleColumn(columnName) {

        const column = document.querySelectorAll(`td[data-column="${columnName}"], th[data-column="${columnName}"]`);


        const isChecked = document.getElementById(`col${columnName.charAt(0).toUpperCase() + columnName.slice(1)}`).checked;

        column.forEach(cell => {
            if (isChecked) {
                cell.style.display = '';
            } else {
                cell.style.display = 'none';
            }
        });
    }
</script>

