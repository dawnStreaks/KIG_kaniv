<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Expense;
use App\Models\Application;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function financialStatement(Request $request)
    {
        $totalCollections = Collection::sum('amount');
        $monthlyCollections = Collection::whereMonth('collection_date', date('m'))
                                      ->whereYear('collection_date', date('Y'))
                                      ->sum('amount');
        
        $totalExpenses = Expense::sum('amount');
        $monthlyExpenses = Expense::whereMonth('expense_date', date('m'))
                                 ->whereYear('expense_date', date('Y'))
                                 ->sum('amount');
        
        // Get detailed transactions
        $collections = Collection::with('unit')->orderBy('collection_date')->get();
        $expenses = Expense::orderBy('expense_date')->get();
        
        // Combine and sort transactions by date
        $transactions = collect();
        
        foreach ($collections as $collection) {
            $transactions->push([
                'date' => $collection->collection_date,
                'type' => 'Collection',
                'description' => 'Collection from ' . ($collection->unit->name ?? 'N/A'),
                'collection' => $collection->amount,
                'expense' => 0,
            ]);
        }
        
        foreach ($expenses as $expense) {
            $transactions->push([
                'date' => $expense->expense_date,
                'type' => 'Expense',
                'description' => $expense->particulars,
                'collection' => 0,
                'expense' => $expense->amount,
            ]);
        }
        
        $transactions = $transactions->sortBy('date');
        
        // Calculate cumulative balance
        $balance = 0;
        $transactions = $transactions->map(function ($transaction) use (&$balance) {
            $balance += $transaction['collection'] - $transaction['expense'];
            $transaction['balance'] = $balance;
            return $transaction;
        });
        
        return view('reports.financial-statement', compact(
            'totalCollections', 'monthlyCollections', 'totalExpenses', 'monthlyExpenses', 'transactions'
        ));
    }

    public function collectionReport(Request $request)
    {
        $query = Collection::with(['unit.area.mekhala', 'enteredBy']);
        
        if ($request->filled('area_id')) {
            $query->whereHas('unit', function($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }
        
        if ($request->filled('date_from')) {
            $query->where('collection_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('collection_date', '<=', $request->date_to);
        }
        
        $collections = $query->latest('collection_date')->get();
        $totalAmount = $collections->sum('amount');
        
        return view('reports.collection', compact('collections', 'totalAmount'));
    }

    public function applicationPaymentReport(Request $request)
    {
        $query = Application::with(['submitter', 'reviewer'])->approved();
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('date_from')) {
            $query->where('approved_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('approved_date', '<=', $request->date_to);
        }
        
        $applications = $query->latest('approved_date')->get();
        $totalAmount = $applications->sum('approved_amount');
        
        return view('reports.application-payment', compact('applications', 'totalAmount'));
    }

    public function exportFinancialStatement(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $startDate = $request->get('start_date', $year . '-01-01');
        $endDate = $request->get('end_date', $year . '-12-31');
        
        $totalReceived = Collection::byDateRange($startDate, $endDate)->sum('amount');
        $applicationExpenses = Expense::applicationExpenses()->byDateRange($startDate, $endDate)->sum('amount');
        $mekhalaExpenses = Expense::mekhalaExpenses()->byDateRange($startDate, $endDate)->sum('amount');
        $balance = $totalReceived - ($applicationExpenses + $mekhalaExpenses);
        
        $data = [
            ['Item', 'Amount'],
            ['Total Amount Received', $totalReceived],
            ['Application Based Expenses', $applicationExpenses],
            ['Mekhala Expenses', $mekhalaExpenses],
            ['Total Expenses', $applicationExpenses + $mekhalaExpenses],
            ['Balance', $balance],
        ];
        
        return response()->streamDownload(function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 'financial-statement-' . date('Y-m-d') . '.csv');
    }
}