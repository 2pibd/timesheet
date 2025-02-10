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

        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Export
            </button>
            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                <li>
                    <button wire:click="exportToExcel" class="dropdown-item">
                        <i class="fa fa-file-excel me-2 text-success"></i> Export to Excel
                    </button>
                </li>
                <li>
                    <button wire:click="exportToPDF" class="dropdown-item">
                        <i class="fa fa-file-pdf me-2 text-danger"></i> Export to PDF
                    </button>
                </li>
            </ul>
        </div>

        <button  wire:click="printContent" class="btn btn-sm btn-light  mx-2">
            <i class="fa fa-print me-2 text-info"></i> Print
        </button>

        <!-- New Column Visibility Button -->
        <div class="dropdown">
            <button class="btn btn-sm btn-soft-info dropdown-toggle" type="button" id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tasks me-2 text-info"></i>  Column Visibility
            </button>
            <ul class="dropdown-menu" aria-labelledby="columnVisibilityDropdown">
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colEmp_ref" checked onclick="toggleColumn('emp_ref')"> Employer Ref
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colPersonal_ref" checked onclick="toggleColumn('personal_ref')"> Personal Ref
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colFirst_forename" checked onclick="toggleColumn('first_forename')"> Employee Name
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colAddress_line1" checked onclick="toggleColumn('address_line1')"> Address
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colPost_code" checked onclick="toggleColumn('post_code')"> Post Code
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colUser_login_id" checked onclick="toggleColumn('user_login_id')"> User Login ID
                    </label>
                </li>

                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colDob" checked onclick="toggleColumn('dob')"> Date of Birth
                    </label>
                </li>
                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colWorker_type" checked onclick="toggleColumn('worker_type')"> Work Type
                    </label>
                </li>

                <li>
                    <label class="dropdown-item">
                        <input type="checkbox" class="form-check-input" id="colStatus" checked onclick="toggleColumn('status')"> Location
                    </label>
                </li>

            </ul>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <input type="text" wire:model.live.debounce="search"  placeholder="Search..." class="form-control">

        </div>
        <div class="col-md-3">
            <select  wire:model.lazy="status" class="form-control form-select">
                <option value="">Select Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" wire:model.lazy="created_from" id="created_from" class="form-control" placeholder="From Date">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model.lazy="created_to" id="created_to" class="form-control" placeholder="To Date">
        </div>
    </div>
    <div class="table-bordered table-responsive printable-section">

        <table class="table table-striped">
            <thead class="bg-light">
            <tr>
                <th>#</th>
                <th data-column="emp_ref">
                    <button wire:click="sortBy('employer_id')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Employer Ref</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'employer_id' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'employer_id' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th  data-column="personal_ref">
                    <button wire:click="sortBy('personal_ref')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Personal Ref</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'personal_ref' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'personal_ref' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th data-column="first_forename">
                    <button wire:click="sortBy('first_forename')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Employee Name</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'first_forename' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'first_forename' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th data-column="address_line1">
                    <button wire:click="sortBy('address_line1')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Address</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'address_line1' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'address_line1' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th data-column="post_code">
                    <button wire:click="sortBy('post_code')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Post Code</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'post_code' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'post_code' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>


                <th data-column="dob">
                    <button wire:click="sortBy('dob')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Date of Birth</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'dob' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'dob' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th data-column="worker_type">
                    <button wire:click="sortBy('worker_type')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Worker Type</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'worker_type' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'worker_type' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>


                <th data-column="status">
                    <button wire:click="sortBy('status')" class="btn btn-link p-0 d-flex justify-content-between align-items-center w-100">
                        <span class="text-start">Location</span>
                        <span class="sort-icons">
                       <i class="fa fa-sort-up {{ $sortField === 'status' && $sortDirection === 'asc' ? 'active-icon' : 'light-icon' }}"></i>
                       <i class="fa fa-sort-down {{ $sortField === 'status' && $sortDirection === 'desc' ? 'active-icon' : 'light-icon' }}"></i>
                    </span>
                    </button>
                </th>

                <th class="no-print">Actions</th>
            </tr>
            </thead>


            <tbody>
            @forelse ($data as $key=>$item)
                <tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td data-column="employer_id">{{ $item->client->external_ref ?? '' }}</td>
                    <td data-column="personal_ref">{{ $item->personal_ref }}</td>
                    <td data-column="first_forename">{{ $item->name ?? '' }}</td>
                    <td data-column="address_line1">{{ $item->address_line1 }}</td>
                    <td data-column="post_code">{{ $item->post_code }}</td>
                    <td data-column="dob">{{ $item->dob }}</td>
                    <td data-column="worker_type">{{ $item->worktype->type ?? '' }}</td>
                    <td data-column="status">{{ $item->status }}</td>
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
                                        @can('view-email_template')
                                            <li><a href="{{ route('worker.show', $item->id) }}" class="dropdown-item view-item-btn"
                                                   title="View"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                        @endcan
                                        @can('update-email_template')
                                            <li><a href="{{ route('worker.edit', $item->id) }}" class="dropdown-item edit-item-btn"
                                                   title="Edit"> <i  class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                </a></li>

                                        @endcan

                                        @can('delete-worker')
                                            <li>
                                                <form method="POST" action="{{ route('worker.destroy', $item->id) }}"
                                                      accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    @csrf()
                                                    <button type="submit"
                                                            class="dropdown-item  btn-link text-black btn-xs"
                                                            title="Delete worker"
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
                    <td colspan="11" class="text-center">No data available</td>
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
        Livewire.on('print-worker', function () {
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

