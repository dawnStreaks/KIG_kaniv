# Application Submission Changes

## Changes Made

### 1. Removed Unique Validation
- **Before**: Civil ID and Passport No had unique validation that prevented submission
- **After**: Applications can be submitted even with duplicate Civil ID or Passport No
- **Files Modified**: 
  - `ApplicationController.php` - Removed `unique:applications,civil_id` validation
  - Both `store()` and `update()` methods updated

### 2. Added History Functionality
- **New Feature**: History button appears only for applications with duplicate Civil ID or Mobile Number
- **Logic**: Button shows when other applications exist with same Civil ID OR Mobile Number
- **Files Added**:
  - `resources/views/applications/history.blade.php` - History view
- **Files Modified**:
  - `ApplicationController.php` - Added `history()` method
  - `routes/web.php` - Added history route
  - `applications/index.blade.php` - Added conditional history button
  - `applications/review.blade.php` - Added conditional history button

### 3. History View Features
- Shows current application details
- Lists all related applications with same Civil ID or Mobile Number
- Displays application status, submission date, and basic info
- Provides "View" links to see full application details

## Usage

1. **Submitting Applications**: Users can now submit applications without worrying about duplicate Civil ID/Passport validation errors
2. **Viewing History**: 
   - History button appears only when duplicates exist
   - Click "History" to see all related applications
   - Unique applications (no duplicates) won't show the history button

## Technical Details

### Route Added
```php
Route::get('/applications/{application}/history', [ApplicationController::class, 'history'])->name('applications.history');
```

### Controller Method
```php
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
```

### Conditional Button Logic
```php
@php
    $hasDuplicates = \App\Models\Application::where(function($query) use ($application) {
        $query->where('civil_id', $application->civil_id)
              ->orWhere('mobile_number', $application->mobile_number);
    })->where('id', '!=', $application->id)->exists();
@endphp
@if($hasDuplicates)
    <a href="{{ route('applications.history', $application) }}" class="btn btn-sm btn-outline-info">History</a>
@endif
```