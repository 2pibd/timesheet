<?php

namespace App\Livewire\BusinessAccount;

use App\Exports\EmailTemplateExport;
use App\Helpers\Helper;
use App\Models\business_account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataTableBusinessAccount extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $created_from = '';
    public $created_to = '';
    public $perPage  ;

    public $sortField = 'business_name'; // Default sort field
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
        $query = business_account::query();

        if (!empty($this->search)) {
            $query->where('business_account', 'like', '%' . $this->search . '%') ;
            $query->oRwhere('phone', 'like', '%' . $this->search . '%') ;
        }



        $query->orderBy($this->sortField, $this->sortDirection) ;// Apply sorting

        $data  = $query->latest()->paginate($this->perPage);


        return view('livewire.business-account.data-table-business-account' ,   [ 'data' => $data  ]);

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
        return Excel::download(new EmailTemplateExport($filters), time().'_business_account.xlsx');
    }


    public function exportToPDF(Request $request){

        $data = business_account::all(); // Fetch all data
        $pdf = Pdf::loadView('admin.business_account.export', compact('data'));

        // Return PDF download response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            time().'_business_account.pdf'
        );
    }


    public function printContent()
    {
        // Log to check if the method is invoked
        \Log::info('Printing content triggered');
        $this->dispatch('print-business_account');
    }

}
