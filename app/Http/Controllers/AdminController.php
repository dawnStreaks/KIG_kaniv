<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Area;
use App\Models\Mekhala;
use App\Models\Unit;
use App\Models\CollectionTerm;
use App\Models\CollectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use App\Exports\AreasExport;
use App\Exports\MekhalasExport;
use App\Exports\UnitsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users(Request $request)
    {
        $query = User::with(['area', 'mekhala']);
        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->paginate(10)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $areas = Area::active()->get();
        $mekhalas = Mekhala::active()->get();
        return view('admin.users.create', compact('areas', 'mekhalas'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'required|in:area,mekhala,center',
            'role' => 'nullable|in:admin,chairman,treasurer',
            'area_id' => 'nullable|exists:areas,id',
            'mekhala_id' => 'nullable|exists:mekhalas,id',
        ];

        if ($request->user_type === 'mekhala') {
            $rules['mekhala_id'] = 'required|exists:mekhalas,id';
            $rules['role'] = 'required|in:chairman,treasurer';
        }

        $validated = $request->validate($rules);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function editUser(User $user)
    {
        $areas = Area::active()->get();
        $mekhalas = Mekhala::active()->get();
        return view('admin.users.edit', compact('user', 'areas', 'mekhalas'));
    }

    public function updateUser(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'user_type' => 'required|in:area,mekhala,center',
            'role' => 'nullable|in:admin,chairman,treasurer',
            'area_id' => 'nullable|exists:areas,id',
            'mekhala_id' => 'nullable|exists:mekhalas,id',
        ];

        if ($request->user_type === 'mekhala') {
            $rules['mekhala_id'] = 'required|exists:mekhalas,id';
            $rules['role'] = 'required|in:chairman,treasurer';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function areas()
    {
        $areas = Area::with('mekhala')->paginate(10);
        return view('admin.areas.index', compact('areas'));
    }

    public function createArea()
    {
        $mekhalas = Mekhala::active()->get();
        return view('admin.areas.create', compact('mekhalas'));
    }

    public function storeArea(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mekhala_id' => 'required|exists:mekhalas,id',
            'description' => 'nullable|string',
        ]);

        Area::create($validated);
        return redirect()->route('admin.areas.index')->with('success', 'Area created successfully');
    }

    public function editArea(Area $area)
    {
        $mekhalas = Mekhala::active()->get();
        return view('admin.areas.edit', compact('area', 'mekhalas'));
    }

    public function updateArea(Request $request, Area $area)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mekhala_id' => 'required|exists:mekhalas,id',
            'description' => 'nullable|string',
        ]);

        $area->update($validated);
        return redirect()->route('admin.areas.index')->with('success', 'Area updated successfully');
    }

    public function mekhalas()
    {
        $mekhalas = Mekhala::paginate(10);
        return view('admin.mekhalas.index', compact('mekhalas'));
    }

    public function createMekhala()
    {
        return view('admin.mekhalas.create');
    }

    public function storeMekhala(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Mekhala::create($validated);
        return redirect()->route('admin.mekhalas.index')->with('success', 'Mekhala created successfully');
    }

    public function editMekhala(Mekhala $mekhala)
    {
        return view('admin.mekhalas.edit', compact('mekhala'));
    }

    public function updateMekhala(Request $request, Mekhala $mekhala)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mekhala->update($validated);
        return redirect()->route('admin.mekhalas.index')->with('success', 'Mekhala updated successfully');
    }

    public function units(Request $request)
    {
        $query = Unit::with('area.mekhala');
        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->filled('area')) {
            $query->whereHas('area', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->area . '%');
            });
        }
        
        if ($request->filled('mekhala')) {
            $query->whereHas('area.mekhala', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->mekhala . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $units = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        return view('admin.units.index', compact('units'));
    }

    public function createUnit()
    {
        $areas = Area::active()->get();
        return view('admin.units.create', compact('areas'));
    }

    public function storeUnit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'type' => 'required|in:IWA,YI,KIG',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Unit::create($validated);
        return redirect()->route('admin.units.index')->with('success', 'Unit created successfully');
    }

    public function editUnit(Unit $unit)
    {
        $unit->load('area');
        $areas = Area::active()->get();
        return view('admin.units.edit', compact('unit', 'areas'));
    }

    public function updateUnit(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'type' => 'required|in:IWA,YI,KIG',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $unit->update($validated);
        return redirect()->route('admin.units.index')->with('success', 'Unit updated successfully');
    }

    public function destroyUnit(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Unit deleted successfully');
    }

    public function terms()
    {
        $terms = CollectionTerm::all();
        return view('admin.terms.index', compact('terms'));
    }

    public function storeTerm(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        CollectionTerm::create(['name' => $request->name]);
        return redirect()->route('admin.terms.index')->with('success', 'Term added successfully');
    }

    public function updateTerm(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $term = CollectionTerm::findOrFail($id);
        $term->update(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroyTerm($id)
    {
        CollectionTerm::findOrFail($id)->delete();
        return redirect()->route('admin.terms.index')->with('success', 'Term deleted successfully');
    }

    public function types()
    {
        $types = CollectionType::all();
        return view('admin.types.index', compact('types'));
    }

    public function storeType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        CollectionType::create(['name' => $request->name]);
        return redirect()->route('admin.types.index')->with('success', 'Type added successfully');
    }

    public function updateType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $type = CollectionType::findOrFail($id);
        $type->update(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroyType($id)
    {
        CollectionType::findOrFail($id)->delete();
        return redirect()->route('admin.types.index')->with('success', 'Type deleted successfully');
    }

    public function exportUsers(Request $request)
    {
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }

    public function exportAreas(Request $request)
    {
        return Excel::download(new AreasExport($request), 'areas.xlsx');
    }

    public function exportMekhalas(Request $request)
    {
        return Excel::download(new MekhalasExport($request), 'mekhalas.xlsx');
    }

    public function exportUnits(Request $request)
    {
        return Excel::download(new UnitsExport($request), 'units.xlsx');
    }

    public function applicationTypes()
    {
        $applicationTypes = \App\Models\ApplicationType::all();
        return view('admin.application-types.index', compact('applicationTypes'));
    }

    public function storeApplicationType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        \App\Models\ApplicationType::create(['name' => $request->name]);
        return redirect()->route('admin.application-types.index')->with('success', 'Application term added successfully');
    }

    public function updateApplicationType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $applicationType = \App\Models\ApplicationType::findOrFail($id);
        $applicationType->update(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroyApplicationType($id)
    {
        \App\Models\ApplicationType::findOrFail($id)->delete();
        return redirect()->route('admin.application-types.index')->with('success', 'Application term deleted successfully');
    }
    
    public function toggleApplicationTypeStatus(Request $request, $id)
    {
        $request->validate(['is_active' => 'required|boolean']);
        $applicationType = \App\Models\ApplicationType::findOrFail($id);
        $applicationType->update(['is_active' => $request->is_active]);
        return response()->json(['success' => true]);
    }
}