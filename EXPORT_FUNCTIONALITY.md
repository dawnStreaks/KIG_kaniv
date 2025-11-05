# Excel Export Functionality

This document describes the Excel export functionality added to all tables in the Multi-Level Management System.

## Features

- **Export to Excel**: All tables now have an "Export Excel" button that downloads the data in Excel format (.xlsx)
- **Filtered Export**: The export respects any filters applied to the table, exporting only the visible/filtered rows
- **Comprehensive Coverage**: Export functionality is available for:
  - Applications
  - Collections
  - Expenses
  - Users (Admin)
  - Areas (Admin)
  - Units (Admin)
  - Mekhalas (Admin)

## How It Works

### 1. Export Classes
Each table has a dedicated export class in `app/Exports/`:
- `ApplicationsExport.php`
- `CollectionsExport.php`
- `ExpensesExport.php`
- `UsersExport.php`
- `AreasExport.php`
- `UnitsExport.php`
- `MekhalasExport.php`

### 2. Controller Methods
Each controller has an `export()` method that handles the Excel generation:
```php
public function export(Request $request)
{
    return Excel::download(new ExportClass($request), 'filename.xlsx');
}
```

### 3. Routes
Export routes are defined for each table:
- `/applications/export`
- `/collections/export`
- `/expenses/export`
- `/admin/users/export`
- `/admin/areas/export`
- `/admin/units/export`
- `/admin/mekhalas/export`

### 4. Frontend Integration
- Green "Export Excel" buttons are added to all table views
- JavaScript handles filtered exports using `filtered-export.js`
- Exports respect table filters and only export visible rows

## Usage

1. **Simple Export**: Click the "Export Excel" button to download all data
2. **Filtered Export**: Apply filters to the table, then click "Export Excel" to download only filtered data
3. **Clear Filters**: Use the "Clear Filters" button to reset all filters

## Technical Details

### Dependencies
- `maatwebsite/excel` package for Excel generation
- Laravel Excel facades for easy integration

### File Structure
```
app/
├── Exports/
│   ├── ApplicationsExport.php
│   ├── CollectionsExport.php
│   ├── ExpensesExport.php
│   ├── UsersExport.php
│   ├── AreasExport.php
│   ├── UnitsExport.php
│   └── MekhalasExport.php
├── Http/Controllers/
│   ├── ApplicationController.php (export method added)
│   ├── CollectionController.php (export method added)
│   ├── ExpenseController.php (export method added)
│   └── AdminController.php (export methods added)
public/js/
└── filtered-export.js
```

### Security
- All exports respect user permissions and role-based access
- Area users can only export their own data
- Admin functions require appropriate middleware

## Customization

To modify export columns or formatting:
1. Edit the respective export class in `app/Exports/`
2. Modify the `headings()` method for column headers
3. Modify the `map()` method for data formatting

Example:
```php
public function headings(): array
{
    return ['ID', 'Name', 'Email', 'Created At'];
}

public function map($user): array
{
    return [
        $user->id,
        $user->name,
        $user->email,
        $user->created_at->format('Y-m-d')
    ];
}
```