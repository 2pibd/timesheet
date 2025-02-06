<?php

namespace App\Livewire\MyOffice;

use App\Exports\EmailTemplateExport;
use App\Helpers\Helper;
use App\Models\my_office;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTableMyOffice extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $created_from = '';
    public $created_to = '';
    public $perPage  ;

    public $sortField = 'clients.company_name'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction


    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Set the default perPage value from the configuration
        $this->perPage = config('config.frontend_pagination', 10);// Default to 10 if not set in the config file
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when the search field is updated

    }


    public function render()
    {
        //$perPage =   config('config.frontend_pagination');
        $query = my_office::join('clients','clients.external_ref','=','my_offices.client_ref') ;

        if (!empty($this->search)) {
            $query->where('clients.company_name', 'like', '%' . $this->search . '%')
                ->orWhere('my_offices.client_ref', 'like', '%' . $this->search . '%')
                ->orWhere('my_offices.division_ref', 'like', '%' . $this->search . '%')
                ->orWhere('my_offices.department_ref', 'like', '%' . $this->search . '%');
        }



        $query->orderBy($this->sortField, $this->sortDirection) ;// Apply sorting

        $data  = $query->orderBy('my_offices.created_at', 'desc') ->paginate($this->perPage);

      /*  // Debug log
        \Log::info('Livewire Query', [
            'search' => $this->search,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);*/


        return view('livewire.my_office.data-table-my_office' ,   [ 'data' => $data  ]);


    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }


    public function exportToExcel(Request $request)
    {
        // Capture the filters for logging
        $filters = [
            'search' => $this->search,
            'status' => $this->status,
            'created_from' => $this->created_from,
            'created_to' => $this->created_to
        ];
        // Export data to Excel
        return Excel::download(new EmailTemplateExport($filters), time().'_my_office.xlsx');
    }


    public function exportToPDF(Request $request){

        $data = my_office::all(); // Fetch all data
        $pdf = Pdf::loadView('admin.my_office.export', compact('data'));

        // Return PDF download response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            time().'_my_office.pdf'
        );
    }


    public function printContent()
    {
        // Log to check if the method is invoked
        \Log::info('Printing content triggered');
        $this->dispatch('print-my_office');
    }

}
