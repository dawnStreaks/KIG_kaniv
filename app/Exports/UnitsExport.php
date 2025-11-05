<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class UnitsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Unit::with('area');
        
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
            'Area',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($unit): array
    {
        return [
            $unit->id,
            $unit->name,
            $unit->area->name ?? 'N/A',
            ucfirst($unit->status),
            $unit->created_at,
            $unit->updated_at
        ];
    }
}