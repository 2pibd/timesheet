<?php

namespace App\Livewire\BoundaryValidation;

use App\Exports\EmailTemplateExport;
use App\Helpers\Helper;
use App\Models\boundary_validation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTableBoundaryValidation extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $created_from = '';
    public $created_to = '';
    public $perPage  ;

    public $sortField = 'division_id'; // Default sort field
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
        $query = boundary_validation::query();

        if (!empty($this->search)) {
            $query->where('division_id', 'like', '%' . $this->search . '%') ;
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->created_from) && !empty($this->created_to)) {
            $created_to = @Helper::dateForDB($this->created_to);
            $created_from = @Helper::dateForDB($this->created_from);
            $query->whereBetween('created_at', [$created_from, $created_to]);
        }
        $query->orderBy($this->sortField, $this->sortDirection) ;// Apply sorting

        $data  = $query->latest()->paginate($this->perPage);

        // Debug log
        \Log::info('Livewire Query', [
            'search' => $this->search,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);

        return view('livewire.boundary-validation.data-table-boundary-validation',   [ 'data' => $data  ]);
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
        return Excel::download(new EmailTemplateExport($filters), time().'_boundary-validation.xlsx');
    }


    public function exportToPDF(Request $request){

        $data = boundary_validation::all(); // Fetch all data
        $pdf = Pdf::loadView('admin.boundary-validation.export', compact('data'));

        // Return PDF download response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            time().'_boundary-validation.pdf'
        );
    }


    public function printContent()
    {
        // Log to check if the method is invoked
        \Log::info('Printing content triggered');
        $this->dispatch('print-boundary-validation');
    }


}
