<?php

namespace App\Exports;

use App\Models\Mekhala;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class MekhalasExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Mekhala::query();
        
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
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($mekhala): array
    {
        return [
            $mekhala->id,
            $mekhala->name,
            ucfirst($mekhala->status),
            $mekhala->created_at,
            $mekhala->updated_at
        ];
    }
}