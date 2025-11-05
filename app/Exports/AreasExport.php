<?php

namespace App\Exports;

use App\Models\Area;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class AreasExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Area::with('mekhala');
        
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
            'Mekhala',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($area): array
    {
        return [
            $area->id,
            $area->name,
            $area->mekhala->name ?? 'N/A',
            ucfirst($area->status),
            $area->created_at,
            $area->updated_at
        ];
    }
}