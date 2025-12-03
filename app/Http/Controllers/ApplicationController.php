<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    public function index()
    {
        $query = Application::with(['submitter', 'reviewer', 'applicationType', 'unit', 'area']);
        
        if (auth()->user()->isAreaUser()) {
            $query->where('submitted_by', auth()->id());
        } elseif (auth()->user()->isMekhalaUser()) {
            $query->whereHas('submitter', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });
        }
        
        $applications = $query->latest()->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $applicationTypes = \App\Models\ApplicationType::active()->get();
        $areas = \App\Models\Area::all();
        return view('applications.create', compact('applicationTypes', 'areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'front_page_photo' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'passport_no' => 'required|string|max:50',
            'civil_id' => 'required|string|max:50',
            'mobile_number' => 'required|string|max:20',
            'category' => 'required|in:medical_support,financial_support,iqama_visa_residency,ticket',
            'application_type_id' => 'nullable|exists:application_types,id',
            'unit_id' => 'required|exists:units,id',
            'area_id' => 'required|exists:areas,id',
            'description' => 'nullable|string',
        ]);

        $validated['front_page_photo'] = $request->file('front_page_photo')->store('applications', 'public');
        $validated['submitted_by'] = auth()->id();

        Application::create($validated);
        return redirect()->route('applications.index')->with('success', 'Application submitted successfully');
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        if ($application->submitted_by !== auth()->id() && !auth()->user()->isMekhalaUser()) {
            abort(403);
        }
        $applicationTypes = \App\Models\ApplicationType::active()->get();
        $units = \App\Models\Unit::with('area')->get();
        $areas = \App\Models\Area::all();
        return view('applications.edit', compact('application', 'applicationTypes', 'units', 'areas'));
    }

    public function update(Request $request, Application $application)
    {
        if ($application->submitted_by !== auth()->id() && !auth()->user()->isMekhalaUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'front_page_photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'passport_no' => 'required|string|max:50',
            'civil_id' => 'required|string|max:50',
            'mobile_number' => 'required|string|max:20',
            'category' => 'required|in:medical_support,financial_support,iqama_visa_residency,ticket',
            'application_type_id' => 'nullable|exists:application_types,id',
            'unit_id' => 'required|exists:units,id',
            'area_id' => 'required|exists:areas,id',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('front_page_photo')) {
            Storage::disk('public')->delete($application->front_page_photo);
            $validated['front_page_photo'] = $request->file('front_page_photo')->store('applications', 'public');
        }

        $application->update($validated);
        return redirect()->route('applications.index')->with('success', 'Application updated successfully');
    }

    public function destroy(Application $application)
    {
        if ($application->submitted_by !== auth()->id() && !auth()->user()->isMekhalaUser()) {
            abort(403);
        }

        Storage::disk('public')->delete($application->front_page_photo);
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Application deleted successfully');
    }

    public function review()
    {
        $query = Application::with('submitter');
        
        if (auth()->user()->isMekhalaUser()) {
            $query->whereHas('submitter', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });
        }
        
        $applications = $query->latest()->paginate(10);
        return view('applications.review', compact('applications'));
    }

    public function approve(Request $request, Application $application)
    {
        if (!auth()->user()->canApproveApplications()) {
            abort(403, 'Only chairmen can approve applications');
        }

        $validated = $request->validate([
            'approved_amount' => 'required|numeric|min:0',
            'approved_date' => 'nullable|date',
        ]);

        $application->update([
            'approved_amount' => $validated['approved_amount'],
            'approved_date' => $validated['approved_date'] ?? now(),
            'status' => 'payable',
            'reviewed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Application approved successfully');
    }

    public function reject(Application $application)
    {
        if (!auth()->user()->canApproveApplications()) {
            abort(403, 'Only chairmen can reject applications');
        }

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
        ]);
        return back()->with('success', 'Application rejected');
    }

    public function pay(Application $application)
    {
        if (!auth()->user()->isTreasurer()) {
            abort(403, 'Only treasurers can mark applications as paid');
        }

        $application->update([
            'status' => 'paid',
        ]);
        return back()->with('success', 'Application marked as paid');
    }

    public function download(Application $application)
    {
        if (!$application->front_page_photo || !Storage::disk('public')->exists($application->front_page_photo)) {
            abort(404, 'File not found');
        }

        $filename = 'application_' . $application->id . '_photo.' . pathinfo($application->front_page_photo, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($application->front_page_photo, $filename);
    }

    public function validateField(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $id = $request->input('id'); // For edit mode
        
        $exists = false;
        
        if ($field === 'civil_id') {
            $query = Application::where('civil_id', $value);
            if ($id) {
                $query->where('id', '!=', $id);
            }
            $exists = $query->exists();
        } elseif ($field === 'passport_no') {
            $query = Application::where('passport_no', $value);
            if ($id) {
                $query->where('id', '!=', $id);
            }
            $exists = $query->exists();
        }
        
        return response()->json(['exists' => $exists]);
    }

    public function history(Application $application)
    {
        $duplicates = Application::where(function($query) use ($application) {
            $query->where('civil_id', $application->civil_id)
                  ->orWhere('mobile_number', $application->mobile_number);
        })
        ->where('id', '!=', $application->id)
        ->with(['submitter', 'reviewer'])
        ->get();
        
        return view('applications.history', compact('application', 'duplicates'));
    }

    public function export(Request $request)
    {
        return Excel::download(new ApplicationsExport($request), 'applications.xlsx');
    }
}