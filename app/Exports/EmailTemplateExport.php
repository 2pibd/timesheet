<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\email_template;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmailTemplateExport implements FromCollection, WithHeadings
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
        $query = email_template::leftJoin('template_types','email_templates.template_type_id','=','template_types.id')->select([
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
                $q->where('email_templates.tplname', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('email_templates.subject', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        if (isset($this->filters['status']) && !empty($this->filters['status'])) {
            $query->where('email_templates.status', $this->filters['status']);
        }

        if (isset($this->filters['created_from']) &&  isset($this->filters['created_to']) &&  !empty($this->filters['created_from']) && !empty($this->filters['created_to'])) {
            $query->whereBetween('email_templates.created_at', [
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
            'Template Name',
            'Subject',
            'Template Type',
            'Status',
            'Created At',
            'Updated At',
        ];
    }
}
