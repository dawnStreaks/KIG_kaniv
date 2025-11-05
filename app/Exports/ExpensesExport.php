<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class ExpensesExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Expense::with(['enteredBy', 'application']);
        
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
            'Expense Date',
            'Particulars',
            'Amount',
            'Type',
            'Application ID',
            'Entered By',
            'Created At',
            'Updated At'
        ];
    }

    public function map($expense): array
    {
        return [
            $expense->id,
            $expense->expense_date,
            $expense->particulars,
            $expense->amount,
            ucfirst($expense->type),
            $expense->application_id,
            $expense->enteredBy->name ?? 'N/A',
            $expense->created_at,
            $expense->updated_at
        ];
    }
}