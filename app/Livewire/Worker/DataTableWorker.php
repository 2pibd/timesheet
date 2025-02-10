<?php

namespace App\Livewire\Worker;

use App\Exports\WorkerExport;
use App\Helpers\Helper;
use App\Models\worker;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTableWorker extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $created_from = '';
    public $created_to = '';
    public $perPage  ;

    public $sortField = 'first_name'; // Default sort field
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
        $query = worker::query();

        if (!empty($this->search)) {
            $query->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name, surname) LIKE ?", ["%{$this->search }%"])
                ->orWhere('employer_id', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('tel_number', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->created_from) && !empty($this->created_to)) {
            $created_to = @Helper::dateForDB($this->created_to);
            $created_from = @Helper::dateForDB($this->created_from);
            $query->whereBetween('created_at', [$created_from, $created_to]);
        }

        $query->selectRaw("*, CONCAT_WS(' ', first_name, middle_name, last_name, surname) as name")->orderBy($this->sortField, $this->sortDirection) ;// Apply sorting

        $data  = $query->latest()->paginate($this->perPage);

        // Debug log
        \Log::info('Livewire Worker', [
            'search' => $this->search,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);

        return view('livewire.worker.data-table-worker',   [ 'data' => $data  ]);

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
        return Excel::download(new EmailTemplateExport($filters), time().'_worker.xlsx');
    }


    public function exportToPDF(Request $request){

        $data = worker::all(); // Fetch all data
        $pdf = Pdf::loadView('admin.worker.export', compact('data'));

        // Return PDF download response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            time().'_worker.pdf'
        );
    }


    public function printContent()
    {
        // Log to check if the method is invoked
        \Log::info('Printing content triggered');
        $this->dispatch('print-worker');
    }


}
