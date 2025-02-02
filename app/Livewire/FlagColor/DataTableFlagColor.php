<?php

namespace App\Livewire\FlagColor;

use App\Exports\EmailTemplateExport;
use App\Helpers\Helper;
use App\Models\flag_color;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTableFlagColor extends Component
{
    use WithPagination;

    public $search = '';
    public $created_from = '';
    public $created_to = '';
    public $perPage  ;

    public $sortField = 'color_code'; // Default sort field
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
        $query = flag_color::query();

        if (!empty($this->search)) {
            $query->where('code', 'like', '%' . $this->search . '%') ;
            $query->oRwhere('status', 'like', '%' . $this->search . '%') ;
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
        return view('livewire.flag-color.data-table-flag-color' ,   [ 'data' => $data  ]);

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
        return Excel::download(new EmailTemplateExport($filters), time().'_flag_mapping.xlsx');
    }


    public function exportToPDF(Request $request){

        $data = flag_mapping::all(); // Fetch all data
        $pdf = Pdf::loadView('admin.flag_mapping.export', compact('data'));

        // Return PDF download response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            time().'_flag_mapping.pdf'
        );
    }


    public function printContent()
    {
        // Log to check if the method is invoked
        \Log::info('Printing content triggered');
        $this->dispatch('print-flag_mapping');
    }


}
