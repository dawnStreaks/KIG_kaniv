<?php

namespace App\Http\Controllers;

use App\Models\HistoricalApplication;
use App\Imports\HistoricalApplicationsImport;
use App\Exports\HistoricalApplicationsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HistoricalApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = HistoricalApplication::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('passport')) {
            $query->where('passport_no', 'like', '%' . $request->passport . '%');
        }
        if ($request->filled('civil_id')) {
            $query->where('civil_id', 'like', '%' . $request->civil_id . '%');
        }
        if ($request->filled('mobile')) {
            $query->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }
        if ($request->filled('application_type')) {
            $query->where('application_type', 'like', '%' . $request->application_type . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->status . '%');
        }

        $records = $query->latest()->paginate(20)->appends($request->query());
        $total = HistoricalApplication::count();

        return view('historical-applications.index', compact('records', 'total'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240',
        ]);

        $import = new HistoricalApplicationsImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->errors();
        if (count($failures) > 0) {
            return back()->with('warning', 'Import completed with ' . count($failures) . ' skipped rows.');
        }

        return back()->with('success', 'Historical records imported successfully.');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="historical_applications_template.csv"',
        ];

        $columns = ['name', 'passport_no', 'civil_id', 'mobile_number', 'category', 'application_type', 'area', 'unit', 'status', 'approved_amount', 'applied_date', 'notes'];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            fputcsv($handle, ['John Doe', 'A1234567', '123456789012', '96512345678', 'financial_support', 'Term 2024', 'Area Name', 'Unit Name', 'paid', '50.000', '2024-03-15', 'Sample note']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(HistoricalApplication $historicalApplication)
    {
        $historicalApplication->delete();
        return back()->with('success', 'Record deleted.');
    }

    public function destroyAll()
    {
        HistoricalApplication::truncate();
        return back()->with('success', 'All historical records cleared.');
    }
}
