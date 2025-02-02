<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\worker;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkerExport implements FromCollection, WithHeadings
{

    protected $filters;
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Fetch all email templates to export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = worker::leftJoin('template_types','email_templates.template_type_id','=','template_types.id')->select([
            'email_templates.id',
            'tplname',
            'subject',
            'template_types.type as template_type',
            'email_templates.status',
            'email_templates.created_at',
            'email_templates.updated_at'
        ]);

        if (isset($this->filters['search']) && !empty($this->filters['search'])) {
            $query->where(function ($q) {
                $q->where('worker.emp_ref', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('worker.personal_ref', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        if (isset($this->filters['status']) && !empty($this->filters['status'])) {
            $query->where('worker.status', $this->filters['status']);
        }

        if (isset($this->filters['created_from']) &&  isset($this->filters['created_to']) &&  !empty($this->filters['created_from']) && !empty($this->filters['created_to'])) {
            $query->whereBetween('worker.created_at', [
                date('Y-m-d', strtotime($this->filters['created_from'])),
                date('Y-m-d', strtotime($this->filters['created_to']))
            ]);
        }


        return $data  = $query->latest()->get();


    }

    /**
     * Define column headings for the exported file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Employer Ref',
            'Personal Ref',
            'Employee Name',
            'Address',
            'Post Code',
            'DOB',
            'Worker Type',
            'Location',
        ];
    }
}
