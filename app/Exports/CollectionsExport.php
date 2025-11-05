<?php

namespace App\Exports;

use App\Models\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class CollectionsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Collection::with(['unit.area', 'enteredBy']);
        
        if (auth()->user()->isAreaUser()) {
            $query->whereHas('unit', function($q) {
                $q->where('area_id', auth()->user()->area_id);
            });
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
            'Amount',
            'Collection Date',
            'Unit',
            'Area',
            'Notes',
            'Entered By',
            'Created At',
            'Updated At'
        ];
    }

    public function map($collection): array
    {
        return [
            $collection->id,
            $collection->amount,
            $collection->collection_date,
            $collection->unit->name ?? 'N/A',
            $collection->unit->area->name ?? 'N/A',
            $collection->notes,
            $collection->enteredBy->name ?? 'N/A',
            $collection->created_at,
            $collection->updated_at
        ];
    }
}