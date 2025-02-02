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
                    <button wire:click="sortBy('code')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Ref Code</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'code' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'code' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>
                <th  data-column="external_ref">

                    <button wire:click="sortBy('status')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start"> Status</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'status' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'status' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>
                <th data-column="client_group_id">
                    <button wire:click="sortBy('details')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Details</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'details' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'details' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th  data-column="flag">
                    <button wire:click="sortBy('flag')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Flag</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'flag' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'flag' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>



                <th class="no-print">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }} </td>
                    <td data-column="code">{{ $item->code }}</td>
                    <td data-column="status">{{ $item->status }}</td>
                    <td data-column="details">{{ $item->details ?? '' }}</td>
                    <td data-column="flag" align="center">
                        <i class="fa fa-flag" style="color: {{ $item->flag->color_code ?? ''}}"></i>
                    </td>
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
                                        @can('view-client')
                                            <li><a href="{{ route('timesheet_status.show', $item->id) }}" class="dropdown-item view-item-btn"
                                                   title="View"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                        @endcan
                                        @can('update-client')
                                            <li><a href="{{ route('timesheet_status.edit', $item->id) }}" class="dropdown-item edit-item-btn"
                                                   title="Edit"> <i  class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                </a></li>

                                        @endcan

                                        @can('delete-client')
                                            <li>
                                                <form method="POST" action="{{ route('timesheet_status.destroy', $item->id) }}"
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
                    <td colspan="9" class="text-center">No data available</td>
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize flatpickr for date pickers
        flatpickr("#created_to, #created_from", {
            dateFormat: "d/m/Y", // Use the d/m/Y format
            onChange: function(selectedDates, dateStr, instance) {
                if (instance.input.id === 'created_to') {
                @this.set('created_to', dateStr); // Update 'created_to' Livewire property
                } else if (instance.input.id === 'created_from') {
                @this.set('created_from', dateStr); // Update 'created_from' Livewire property
                }
            }
        });
    });

    // Listen for the 'print-email-template' event from Livewire
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('print-client', function () {
            let contentToPrint = document.querySelector('.printable-section').innerHTML;

            if (!contentToPrint) {
                console.log('No content to print');
                return; // Exit if no content is found
            }

            // Define the desired window size
            let width = 800;
            let height = 600;

            // Get the current browser window's position and size
            let screenX = window.screenX || window.screenLeft; // X-coordinate of the browser
            let screenY = window.screenY || window.screenTop;  // Y-coordinate of the browser
            let outerWidth = window.outerWidth || document.documentElement.clientWidth; // Browser's width
            let outerHeight = window.outerHeight || document.documentElement.clientHeight; // Browser's height

            // Calculate the popup's position relative to the current screen
            let left = screenX + (outerWidth - width) / 2;
            let top = screenY + (outerHeight - height) / 2;

            // Open the print window with the calculated position
            let printWindow = window.open(
                '',
                '',
                `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=yes`
            );

            if (printWindow) {
                // Inject content and Bootstrap styles
                printWindow.document.write('<html><head><title>Print</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
                printWindow.document.write('</head><body>');
                printWindow.document.write(contentToPrint);
                printWindow.document.write('</body></html>');

                // Close the document to apply styles
                printWindow.document.close();

                // Focus and trigger the print dialog
                printWindow.focus();
                printWindow.print();
            } else {
                console.error("Failed to open the print window");
            }
        });
    });


</script>

