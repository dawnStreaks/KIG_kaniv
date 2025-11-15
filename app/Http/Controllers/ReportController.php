<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Expense;
use App\Models\Application;
use App\Models\Investment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function financialStatement(Request $request)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $user = auth()->user();
        
        // Get mekhala name for title
        $mekhalaName = null;
        if ($user->isMekhalaUser() && $user->mekhala) {
            $mekhalaName = $user->mekhala->name;
        }
        
        // Collections Summary (only received collections)
        $collectionsQuery = Collection::received()->whereYear('collection_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $collectionsQuery->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyCollections = $collectionsQuery->sum('amount');
        
        $monthlyCollectionsQuery = Collection::received()->whereMonth('collection_date', $currentMonth)
                                      ->whereYear('collection_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $monthlyCollectionsQuery->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $monthlyCollections = $monthlyCollectionsQuery->sum('amount');
        
        // Expenses Summary
        $expensesQuery = Expense::whereYear('expense_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $expensesQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyExpenses = $expensesQuery->sum('amount');
        
        $monthlyExpensesQuery = Expense::whereMonth('expense_date', $currentMonth)
                                 ->whereYear('expense_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $monthlyExpensesQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $monthlyExpenses = $monthlyExpensesQuery->sum('amount');
        
        // Applications Summary
        $applicationsQuery = Application::whereYear('approved_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $applicationsQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyApplications = $applicationsQuery->sum('approved_amount');
        
        $monthlyApplicationsQuery = Application::whereMonth('approved_date', $currentMonth)
                                         ->whereYear('approved_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $monthlyApplicationsQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $monthlyApplications = $monthlyApplicationsQuery->sum('approved_amount');
        
        // Investment Summary - restrict for mekhala users
        $investmentsQuery = Investment::whereYear('investment_date', $currentYear);
        $monthlyInvestmentsQuery = Investment::whereMonth('investment_date', $currentMonth)
                                            ->whereYear('investment_date', $currentYear);
        $incomeQuery = Investment::whereYear('investment_date', $currentYear);
        $monthlyIncomeQuery = Investment::whereMonth('investment_date', $currentMonth)
                                       ->whereYear('investment_date', $currentYear);
        $returnedQuery = Investment::whereYear('investment_date', $currentYear);
        $monthlyReturnedQuery = Investment::whereMonth('investment_date', $currentMonth)
                                         ->whereYear('investment_date', $currentYear);
        
        // For mekhala users, only show investments if they are center-level users
        if ($user->isMekhalaUser()) {
            $yearlyInvestments = 0;
            $monthlyInvestments = 0;
            $yearlyIncome = 0;
            $monthlyIncome = 0;
            $yearlyReturned = 0;
            $monthlyReturned = 0;
        } else {
            $yearlyInvestments = $investmentsQuery->sum('amount');
            $monthlyInvestments = $monthlyInvestmentsQuery->sum('amount');
            $yearlyIncome = $incomeQuery->sum('income_generated');
            $monthlyIncome = $monthlyIncomeQuery->sum('income_generated');
            $yearlyReturned = $returnedQuery->sum('returned_amount');
            $monthlyReturned = $monthlyReturnedQuery->sum('returned_amount');
        }
        
        // Get detailed transactions (only received collections)
        $collectionsDetailQuery = Collection::received()->with('unit')->orderBy('collection_date');
        if ($user->isMekhalaUser()) {
            $collectionsDetailQuery->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $collections = $collectionsDetailQuery->get();
        
        $expensesDetailQuery = Expense::orderBy('expense_date');
        if ($user->isMekhalaUser()) {
            $expensesDetailQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $expenses = $expensesDetailQuery->get();
        
        $applicationsDetailQuery = Application::where('status', 'approved')->orderBy('approved_date');
        if ($user->isMekhalaUser()) {
            $applicationsDetailQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $applications = $applicationsDetailQuery->get();
        
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
        
        foreach ($applications as $application) {
            $transactions->push([
                'date' => $application->approved_date,
                'type' => 'Application Payment',
                'description' => 'Payment to ' . $application->name . ' (' . ucfirst($application->category) . ')',
                'collection' => 0,
                'expense' => $application->approved_amount,
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
            'yearlyCollections', 'monthlyCollections', 'yearlyExpenses', 'monthlyExpenses',
            'yearlyApplications', 'monthlyApplications', 'yearlyInvestments', 'monthlyInvestments',
            'yearlyIncome', 'monthlyIncome', 'yearlyReturned', 'monthlyReturned', 'transactions', 'mekhalaName'
        ));
    }

    public function collectionReport(Request $request)
    {
        $user = auth()->user();
        
        $query = Collection::with(['unit.area.mekhala', 'enteredBy']);
        
        // Filter by user's mekhala if they are a mekhala user
        if ($user->isMekhalaUser()) {
            $query->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
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
        
        // Get mekhala-wise data for center users
        $mekhalaData = [];
        if ($user->isCenterUser()) {
            $mekhalaData = \App\Models\Mekhala::with('areas.units.collections')
                ->get()
                ->map(function($mekhala) {
                    $total = $mekhala->areas->sum(function($area) {
                        return $area->units->sum(function($unit) {
                            return $unit->collections->sum('amount');
                        });
                    });
                    return [
                        'id' => $mekhala->id,
                        'name' => $mekhala->name,
                        'total' => $total
                    ];
                })->toArray();
        }
        
        return view('reports.collection', compact('collections', 'totalAmount', 'mekhalaData'));
    }

    public function applicationPaymentReport(Request $request)
    {
        $user = auth()->user();
        
        $query = Application::with(['submitter', 'reviewer'])->approved();
        
        // Filter by user's mekhala if they are a mekhala user
        if ($user->isMekhalaUser()) {
            $query->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
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

    public function mekhalaReport(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $data = \App\Models\Mekhala::with(['areas.units'])->get()->map(function($mekhala) use ($year) {
            $collections = Collection::whereYear('collection_date', $year)
                ->whereHas('unit.area', function($q) use ($mekhala) {
                    $q->where('mekhala_id', $mekhala->id);
                })->sum('amount');
                
            $applications = Application::whereYear('approved_date', $year)
                ->whereHas('submitter.area', function($q) use ($mekhala) {
                    $q->where('mekhala_id', $mekhala->id);
                })->sum('approved_amount');
                
            $expenses = Expense::whereYear('expense_date', $year)
                ->whereHas('enteredBy', function($q) use ($mekhala) {
                    $q->where('mekhala_id', $mekhala->id);
                })->sum('amount');
                
            $balance = $collections - $applications - $expenses;
            
            return [
                'mekhala_id' => $mekhala->id,
                'name' => $mekhala->name,
                'collections' => $collections,
                'applications' => $applications,
                'expenses' => $expenses,
                'balance' => $balance
            ];
        });
        
        return view('reports.mekhala', compact('data', 'year'));
    }

    public function mekhalaReportDrillDown(Request $request)
    {
        $mekhalaId = $request->get('mekhala_id');
        $year = $request->get('year', date('Y'));
        $type = $request->get('type');
        
        if ($type === 'collections') {
            $data = \App\Models\Area::where('mekhala_id', $mekhalaId)
                ->with('units')
                ->get()
                ->map(function($area) use ($year) {
                    $amount = Collection::whereYear('collection_date', $year)
                        ->whereHas('unit', function($q) use ($area) {
                            $q->where('area_id', $area->id);
                        })->sum('amount');
                    return ['name' => $area->name, 'amount' => $amount];
                });
        } elseif ($type === 'applications') {
            $data = \App\Models\Area::where('mekhala_id', $mekhalaId)
                ->get()
                ->map(function($area) use ($year) {
                    $amount = Application::whereYear('approved_date', $year)
                        ->whereHas('submitter', function($q) use ($area) {
                            $q->where('area_id', $area->id);
                        })->sum('approved_amount');
                    return ['name' => $area->name, 'amount' => $amount];
                });
        } else {
            $data = collect([]);
        }
        
        return response()->json($data);
    }

    public function eastMekhalaFinancial(Request $request)
    {
        return $this->getMekhalaFinancialStatement($request, 'east');
    }

    public function westMekhalaFinancial(Request $request)
    {
        return $this->getMekhalaFinancialStatement($request, 'west');
    }

    public function combinedFinancial(Request $request)
    {
        return $this->getMekhalaFinancialStatement($request, 'combined');
    }

    private function getMekhalaFinancialStatement(Request $request, $type)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        // Get mekhala IDs
        $eastMekhala = \App\Models\Mekhala::where('name', 'LIKE', '%east%')->first();
        $westMekhala = \App\Models\Mekhala::where('name', 'LIKE', '%west%')->first();
        
        $mekhalaIds = [];
        if ($type === 'east' && $eastMekhala) {
            $mekhalaIds = [$eastMekhala->id];
        } elseif ($type === 'west' && $westMekhala) {
            $mekhalaIds = [$westMekhala->id];
        } elseif ($type === 'combined') {
            $mekhalaIds = array_filter([$eastMekhala?->id, $westMekhala?->id]);
        }
        
        // Collections Summary
        $collectionsQuery = Collection::received()->whereYear('collection_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $collectionsQuery->whereHas('unit.area', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $yearlyCollections = $collectionsQuery->sum('amount');
        
        $monthlyCollectionsQuery = Collection::received()->whereMonth('collection_date', $currentMonth)
                                      ->whereYear('collection_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $monthlyCollectionsQuery->whereHas('unit.area', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $monthlyCollections = $monthlyCollectionsQuery->sum('amount');
        
        // Expenses Summary
        $expensesQuery = Expense::whereYear('expense_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $expensesQuery->whereHas('enteredBy', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $yearlyExpenses = $expensesQuery->sum('amount');
        
        $monthlyExpensesQuery = Expense::whereMonth('expense_date', $currentMonth)
                                 ->whereYear('expense_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $monthlyExpensesQuery->whereHas('enteredBy', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $monthlyExpenses = $monthlyExpensesQuery->sum('amount');
        
        // Applications Summary
        $applicationsQuery = Application::whereYear('approved_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $applicationsQuery->whereHas('submitter', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $yearlyApplications = $applicationsQuery->sum('approved_amount');
        
        $monthlyApplicationsQuery = Application::whereMonth('approved_date', $currentMonth)
                                         ->whereYear('approved_date', $currentYear);
        if (!empty($mekhalaIds)) {
            $monthlyApplicationsQuery->whereHas('submitter', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $monthlyApplications = $monthlyApplicationsQuery->sum('approved_amount');
        
        // Investment Summary (same as before)
        $yearlyInvestments = Investment::whereYear('investment_date', $currentYear)->sum('amount');
        $monthlyInvestments = Investment::whereMonth('investment_date', $currentMonth)
                                       ->whereYear('investment_date', $currentYear)
                                       ->sum('amount');
        $yearlyIncome = Investment::whereYear('investment_date', $currentYear)->sum('income_generated');
        $monthlyIncome = Investment::whereMonth('investment_date', $currentMonth)
                                  ->whereYear('investment_date', $currentYear)
                                  ->sum('income_generated');
        $yearlyReturned = Investment::whereYear('investment_date', $currentYear)->sum('returned_amount');
        $monthlyReturned = Investment::whereMonth('investment_date', $currentMonth)
                                   ->whereYear('investment_date', $currentYear)
                                   ->sum('returned_amount');
        
        // Get detailed transactions
        $collectionsDetailQuery = Collection::received()->with('unit')->orderBy('collection_date');
        if (!empty($mekhalaIds)) {
            $collectionsDetailQuery->whereHas('unit.area', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $collections = $collectionsDetailQuery->get();
        
        $expensesDetailQuery = Expense::orderBy('expense_date');
        if (!empty($mekhalaIds)) {
            $expensesDetailQuery->whereHas('enteredBy', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $expenses = $expensesDetailQuery->get();
        
        $applicationsDetailQuery = Application::where('status', 'approved')->orderBy('approved_date');
        if (!empty($mekhalaIds)) {
            $applicationsDetailQuery->whereHas('submitter', function($q) use ($mekhalaIds) {
                $q->whereIn('mekhala_id', $mekhalaIds);
            });
        }
        $applications = $applicationsDetailQuery->get();
        
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
        
        foreach ($applications as $application) {
            $transactions->push([
                'date' => $application->approved_date,
                'type' => 'Application Payment',
                'description' => 'Payment to ' . $application->name . ' (' . ucfirst($application->category) . ')',
                'collection' => 0,
                'expense' => $application->approved_amount,
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
        
        $reportType = ucfirst($type) . ' Mekhala';
        if ($type === 'combined') {
            $reportType = 'Combined';
        }
        
        $mekhalaName = $type !== 'combined' ? ucfirst($type) . ' Mekhala' : null;
        
        return view('reports.financial-statement', compact(
            'yearlyCollections', 'monthlyCollections', 'yearlyExpenses', 'monthlyExpenses',
            'yearlyApplications', 'monthlyApplications', 'yearlyInvestments', 'monthlyInvestments',
            'yearlyIncome', 'monthlyIncome', 'yearlyReturned', 'monthlyReturned', 'transactions', 'reportType', 'mekhalaName'
        ));
    }

    public function collectionMekhalaDrillDown(Request $request)
    {
        $mekhalaId = $request->get('mekhala_id');
        
        $data = \App\Models\Area::where('mekhala_id', $mekhalaId)
            ->with('units.collections')
            ->get()
            ->map(function($area) {
                $total = $area->units->sum(function($unit) {
                    return $unit->collections->sum('amount');
                });
                return [
                    'id' => $area->id,
                    'name' => $area->name,
                    'total' => $total
                ];
            });
        
        return response()->json($data);
    }
    
    public function collectionAreaDrillDown(Request $request)
    {
        $areaId = $request->get('area_id');
        
        $data = \App\Models\Unit::where('area_id', $areaId)
            ->with('collections')
            ->get()
            ->map(function($unit) {
                return [
                    'id' => $unit->id,
                    'name' => $unit->name,
                    'total' => $unit->collections->sum('amount')
                ];
            });
        
        return response()->json($data);
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