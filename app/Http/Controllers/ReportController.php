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
    private function getFinancialData(Request $request, $scopeFilter = null)
    {
        $dateFrom = $request->get('date_from', date('Y-m-01'));
        $dateTo = $request->get('date_to', date('Y-m-d'));

        // Build scope closures based on filter type
        $collectionScope = function($query) use ($scopeFilter) {
            if ($scopeFilter === 'center') {
                // no extra filter needed, handled by collection_status
            } elseif (is_array($scopeFilter)) {
                $query->whereHas('unit.area', function($q) use ($scopeFilter) {
                    $q->whereIn('mekhala_id', $scopeFilter);
                });
            } elseif ($scopeFilter === 'mekhala') {
                $query->whereHas('unit.area', function($q) {
                    $q->where('mekhala_id', auth()->user()->mekhala_id);
                });
            }
        };

        $userScope = function($query, $relation = 'enteredBy') use ($scopeFilter) {
            if ($scopeFilter === 'center') {
                $query->whereHas($relation, function($q) {
                    $q->where('user_type', 'center');
                });
            } elseif (is_array($scopeFilter)) {
                $query->whereHas($relation, function($q) use ($scopeFilter) {
                    $q->whereIn('mekhala_id', $scopeFilter);
                });
            } elseif ($scopeFilter === 'mekhala') {
                $query->whereHas($relation, function($q) {
                    $q->where('mekhala_id', auth()->user()->mekhala_id);
                });
            }
        };

        $investmentScope = function($query) use ($scopeFilter) {
            if ($scopeFilter === 'center') {
                $query->whereHas('creator', function($q) {
                    $q->where('user_type', 'center');
                });
            } elseif (is_array($scopeFilter)) {
                $query->whereHas('creator', function($q) use ($scopeFilter) {
                    $q->whereIn('mekhala_id', $scopeFilter)->where('user_type', '!=', 'center');
                });
            } elseif ($scopeFilter === 'mekhala') {
                $query->whereHas('creator', function($q) {
                    $q->where('mekhala_id', auth()->user()->mekhala_id);
                });
            }
        };

        // Opening Balance (everything before dateFrom)
        $obCollections = Collection::where('collection_status', $scopeFilter === 'center' ? 'center_received' : 'received')
            ->where('collection_date', '<', $dateFrom);
        $collectionScope($obCollections);
        $obCollectionsTotal = $obCollections->sum('amount');

        $obExpenses = Expense::where('expense_date', '<', $dateFrom);
        $userScope($obExpenses, 'enteredBy');
        $obExpensesTotal = $obExpenses->sum('amount');

        $obApplications = Application::where('status', 'paid')->where('approved_date', '<', $dateFrom);
        $userScope($obApplications, 'submitter');
        $obApplicationsTotal = $obApplications->sum('approved_amount');

        $obInvestments = Investment::where('investment_date', '<', $dateFrom);
        $investmentScope($obInvestments);
        $obInvestmentsTotal = $obInvestments->sum('amount');

        $obIncome = Investment::where('investment_date', '<', $dateFrom);
        $investmentScope($obIncome);
        $obIncomeTotal = $obIncome->sum('income_generated');

        $obReturned = Investment::where('investment_date', '<', $dateFrom);
        $investmentScope($obReturned);
        $obReturnedTotal = $obReturned->sum('returned_amount');

        $openingBalance = $obCollectionsTotal + $obIncomeTotal - $obExpensesTotal - $obApplicationsTotal - ($obInvestmentsTotal - $obReturnedTotal);

        // Add manual opening balance (one-time entry - pick the latest one before dateFrom)
        $manualObQuery = \App\Models\OpeningBalance::query();
        if (is_array($scopeFilter)) {
            $manualObQuery->whereIn('mekhala_id', $scopeFilter);
        } elseif ($scopeFilter === 'mekhala') {
            $manualObQuery->where('mekhala_id', auth()->user()->mekhala_id);
        } elseif ($scopeFilter === 'center') {
            $manualObQuery->where('mekhala_id', 0);
        }
        $manualObQuery->where(function($q) use ($dateFrom) {
            $fromYear = (int) date('Y', strtotime($dateFrom));
            $fromMonth = (int) date('m', strtotime($dateFrom));
            $q->where('year', '<', $fromYear)
              ->orWhere(function($q2) use ($fromYear, $fromMonth) {
                  $q2->where('year', $fromYear)->where('month', '<=', $fromMonth);
              });
        });
        $manualOb = $manualObQuery->orderBy('year', 'desc')->orderBy('month', 'desc')->first();
        if ($manualOb) {
            $openingBalance += $manualOb->amount;
        }

        // Period totals (between dateFrom and dateTo)
        $collectionsQ = Collection::where('collection_status', $scopeFilter === 'center' ? 'center_received' : 'received')
            ->whereBetween('collection_date', [$dateFrom, $dateTo]);
        $collectionScope($collectionsQ);
        $totalCollections = $collectionsQ->sum('amount');

        $forwardedQ = Collection::where('collection_status', 'forwarded')
            ->whereBetween('collection_date', [$dateFrom, $dateTo]);
        $collectionScope($forwardedQ);
        $totalForwarded = $forwardedQ->sum('amount');

        $expensesQ = Expense::whereBetween('expense_date', [$dateFrom, $dateTo]);
        $userScope($expensesQ, 'enteredBy');
        $totalExpenses = $expensesQ->sum('amount');

        $applicationsQ = Application::where('status', 'paid')
            ->whereBetween('approved_date', [$dateFrom, $dateTo]);
        $userScope($applicationsQ, 'submitter');
        $totalApplications = $applicationsQ->sum('approved_amount');

        $investmentsQ = Investment::whereBetween('investment_date', [$dateFrom, $dateTo]);
        $investmentScope($investmentsQ);
        $totalInvestments = $investmentsQ->sum('amount');

        $incomeQ = Investment::whereBetween('investment_date', [$dateFrom, $dateTo]);
        $investmentScope($incomeQ);
        $totalIncome = $incomeQ->sum('income_generated');

        $returnedQ = Investment::whereBetween('investment_date', [$dateFrom, $dateTo]);
        $investmentScope($returnedQ);
        $totalReturned = $returnedQ->sum('returned_amount');

        return compact(
            'dateFrom', 'dateTo', 'openingBalance',
            'totalCollections', 'totalForwarded', 'totalExpenses',
            'totalApplications', 'totalInvestments', 'totalIncome', 'totalReturned'
        );
    }

    public function financialStatement(Request $request)
    {
        $user = auth()->user();
        $scopeFilter = $user->isMekhalaUser() ? 'mekhala' : null;

        $data = $this->getFinancialData($request, $scopeFilter);

        $mekhalaName = null;
        if ($user->isMekhalaUser() && $user->mekhala) {
            $mekhalaName = $user->mekhala->name;
        }

        return view('reports.financial-statement', array_merge($data, [
            'mekhalaName' => $mekhalaName,
        ]));
    }

    public function centerFinancial(Request $request)
    {
        $data = $this->getFinancialData($request, 'center');

        return view('reports.financial-statement', array_merge($data, [
            'reportType' => 'Center',
            'mekhalaName' => 'Center Office',
        ]));
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
        $mekhalaIds = match($type) {
            'east' => [1],
            'west' => [2],
            'combined' => [1, 2],
            default => [],
        };

        $data = $this->getFinancialData($request, $mekhalaIds);

        $reportType = $type === 'combined' ? 'Combined' : ucfirst($type) . ' Mekhala';
        $mekhalaName = $type !== 'combined' ? ucfirst($type) . ' Mekhala' : null;

        return view('reports.financial-statement', array_merge($data, [
            'reportType' => $reportType,
            'mekhalaName' => $mekhalaName,
        ]));
    }

    public function centerFinancialStatement(Request $request)
    {
        return $this->centerFinancial($request);
    }

    public function collectionReport(Request $request)
    {
        $user = auth()->user();
        
        $query = Collection::with(['unit.area.mekhala', 'enteredBy']);
        
        if ($request->filled('date_from')) {
            $query->where('collection_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('collection_date', '<=', $request->date_to);
        }
        
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
        
        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $collections = $query->latest('collection_date')->get();
        $totalAmount = $collections->sum('amount');
        
        $areas = \App\Models\Area::when($user->isMekhalaUser(), function($q) use ($user) {
            $q->where('mekhala_id', $user->mekhala_id);
        })->get();
        
        $terms = \App\Models\CollectionTerm::all();
        $types = \App\Models\CollectionType::all();
        
        $collectionsByArea = $collections->groupBy(function($collection) {
            return $collection->unit->area->name ?? 'Unknown Area';
        })->map(function($areaCollections, $areaName) {
            $termTypeGroups = $areaCollections->groupBy(function($collection) {
                return $collection->term . ' - ' . $collection->type;
            })->map(function($termTypeCollections, $termType) {
                return [
                    'term_type' => $termType,
                    'total' => $termTypeCollections->sum('amount'),
                    'count' => $termTypeCollections->count(),
                    'collections' => $termTypeCollections
                ];
            });
            
            return [
                'area' => $areaName,
                'total' => $areaCollections->sum('amount'),
                'count' => $areaCollections->count(),
                'term_type_groups' => $termTypeGroups,
                'collections' => $areaCollections
            ];
        });
        
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
        
        return view('reports.collection', compact('collections', 'totalAmount', 'mekhalaData', 'collectionsByArea', 'areas', 'terms', 'types'));
    }

    public function applicationPaymentReport(Request $request)
    {
        $currentYear = $request->get('year', date('Y'));
        $currentMonth = $request->get('month', date('m'));
        $user = auth()->user();
        
        $query = Application::with(['submitter', 'reviewer'])
            ->where('status', 'paid')
            ->whereYear('approved_date', $currentYear)
            ->whereMonth('approved_date', $currentMonth);
        
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
        
        return view('reports.application-payment', compact('applications', 'totalAmount', 'currentYear', 'currentMonth'));
    }

    public function mekhalaReport(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        
        $data = \App\Models\Mekhala::with(['areas.units'])->get()->map(function($mekhala) use ($year, $month) {
            $collections = Collection::whereYear('collection_date', $year)
                ->whereMonth('collection_date', $month)
                ->whereHas('unit.area', function($q) use ($mekhala) {
                    $q->where('mekhala_id', $mekhala->id);
                })->sum('amount');
                
            $applications = Application::where('status', 'paid')
                ->whereYear('approved_date', $year)
                ->whereMonth('approved_date', $month)
                ->whereHas('submitter.area', function($q) use ($mekhala) {
                    $q->where('mekhala_id', $mekhala->id);
                })->sum('approved_amount');
                
            $expenses = Expense::whereYear('expense_date', $year)
                ->whereMonth('expense_date', $month)
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
        
        return view('reports.mekhala', compact('data', 'year', 'month'));
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
                    $amount = Application::where('status', 'paid')->whereYear('approved_date', $year)
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

    public function comparisonReport(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $data = \App\Models\Unit::with(['collections' => function($q) use ($year) {
            $q->whereYear('collection_date', $year);
        }])
        ->get()
        ->groupBy('type')
        ->map(function($units, $type) {
            $total = $units->sum(function($unit) {
                return $unit->collections->sum('amount');
            });
            return [
                'type' => $type ?: 'IWA',
                'total' => $total,
                'count' => $units->count()
            ];
        })->values();
        
        return view('reports.comparison', compact('data', 'year'));
    }

    public function areaSummary(Request $request)
    {
        $dateFrom = $request->get('date_from', date('Y') . '-01-01');
        $dateTo = $request->get('date_to', date('Y') . '-12-31');
        $user = auth()->user();
        
        $filteredCollections = Collection::with('unit.area')
            ->whereBetween('collection_date', [$dateFrom, $dateTo]);
            
        if ($user->isMekhalaUser()) {
            $filteredCollections->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
        $filteredCollections = $filteredCollections->get();
        
        // Received by mekhala collections per area
        $receivedByArea = $filteredCollections->where('collection_status', 'received')
            ->groupBy(fn($c) => $c->unit->area->name ?? 'Unknown Area')
            ->map(fn($items) => $items->sum('amount'));
        
        $expensesDetailQuery = Expense::whereBetween('expense_date', [$dateFrom, $dateTo])->orderBy('expense_date');
        if ($user->isMekhalaUser()) {
            $expensesDetailQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $expenses = $expensesDetailQuery->get();
        
        $applicationsDetailQuery = Application::where('status', 'paid')
            ->whereBetween('approved_date', [$dateFrom, $dateTo])
            ->orderBy('approved_date');
        if ($user->isMekhalaUser()) {
            $applicationsDetailQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $applications = $applicationsDetailQuery->get();
        
        $transactionsByArea = collect();
        
        foreach ($filteredCollections as $collection) {
            $areaName = $collection->unit->area->name ?? 'Unknown Area';
            $transactionsByArea->push([
                'area' => $areaName,
                'date' => $collection->collection_date,
                'type' => 'Collection',
                'description' => 'Collection from ' . ($collection->unit->name ?? 'N/A'),
                'collection' => $collection->amount,
                'expense' => 0,
                'term' => $collection->term,
                'collection_type' => $collection->type,
                'status' => $collection->collection_status,
            ]);
        }
        
        foreach ($expenses as $expense) {
            $areaName = $expense->enteredBy->area->name ?? 'General';
            $transactionsByArea->push([
                'area' => $areaName,
                'date' => $expense->expense_date,
                'type' => 'Expense',
                'description' => $expense->particulars,
                'collection' => 0,
                'expense' => $expense->amount,
                'term' => '-',
                'collection_type' => $expense->type ?? '-',
                'status' => '-',
            ]);
        }
        
        foreach ($applications as $application) {
            $areaName = $application->area->name ?? 'Unknown Area';
            $transactionsByArea->push([
                'area' => $areaName,
                'date' => $application->approved_date,
                'type' => 'Application Payment',
                'description' => 'Payment to ' . $application->name . ' (' . ucfirst($application->category) . ')',
                'collection' => 0,
                'expense' => $application->approved_amount,
                'term' => '-',
                'collection_type' => '-',
                'status' => $application->status,
            ]);
        }
        
        $groupedTransactions = $transactionsByArea->groupBy('area')->map(function($areaTransactions) {
            return $areaTransactions->sortBy('date');
        });
        
        // Paid applications per area
        $paidByArea = $applications->groupBy(fn($a) => $a->area->name ?? 'Unknown Area')
            ->map(fn($items) => $items->sum('approved_amount'));
        
        $areaSummary = $groupedTransactions->map(function($areaTransactions, $areaName) use ($receivedByArea, $paidByArea) {
            $totalCollections = $areaTransactions->sum('collection');
            $totalExpenses = $areaTransactions->sum('expense');
            return [
                'area' => $areaName,
                'collections' => $totalCollections,
                'received' => $receivedByArea->get($areaName, 0),
                'expenses' => $totalExpenses,
                'paid' => $paidByArea->get($areaName, 0),
                'balance' => $totalCollections - $totalExpenses
            ];
        });
        
        return view('reports.area-summary', compact(
            'groupedTransactions', 'areaSummary', 'dateFrom', 'dateTo'
        ));
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
