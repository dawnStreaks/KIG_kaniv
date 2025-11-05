<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class ApplicationsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Application::with(['submitter', 'reviewer']);
        
        if (auth()->user()->isAreaUser()) {
            $query->where('submitted_by', auth()->id());
        }
        
        // Handle filtered IDs if provided
        if ($this->request->has('ids')) {
            $ids = explode(',', $this->request->get('ids'));
            $query->whereIn('id', $ids);
        }
        
        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Passport No',
            'Civil ID',
            'Mobile Number',
            'Category',
            'Status',
            'Approved Amount',
            'Approved Date',
            'Submitted By',
            'Reviewed By',
            'Created At',
            'Updated At'
        ];
    }

    public function map($application): array
    {
        return [
            $application->id,
            $application->name,
            $application->passport_no,
            $application->civil_id,
            $application->mobile_number,
            ucfirst($application->category),
            ucfirst($application->status),
            $application->approved_amount,
            $application->approved_date,
            $application->submitter->name ?? 'N/A',
            $application->reviewer->name ?? 'N/A',
            $application->created_at,
            $application->updated_at
        ];
    }
}