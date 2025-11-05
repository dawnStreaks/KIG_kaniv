# Role-Based Access Control Implementation

## Overview
Implemented role-based access control system with specific permissions for different user types and roles.

## User Types and Roles

### 1. Center Level Users
- **User Type**: `center`
- **Role**: `admin` (automatically assigned)
- **Permissions**: Full admin access to all features

### 2. Mekhala Level Users
- **User Type**: `mekhala`
- **Roles**: 
  - `chairman` - Can approve/reject applications
  - `treasurer` - Can add/manage expenses

### 3. Area Level Users
- **User Type**: `area`
- **Role**: None (no specific role needed)
- **Permissions**: Standard area user permissions

## Key Features

### Role Assignment
- **Center users**: Automatically get `admin` role
- **Mekhala users**: Must be assigned either `chairman` or `treasurer` role
- **Area users**: No role assignment needed

### Permission Matrix

| Action | Center (Admin) | Chairman | Treasurer | Area User |
|--------|---------------|----------|-----------|-----------|
| Approve Applications | ✅ | ✅ | ❌ | ❌ |
| Reject Applications | ✅ | ✅ | ❌ | ❌ |
| Add Expenses | ✅ | ❌ | ✅ | ❌ |
| Manage Users | ✅ | ❌ | ❌ | ❌ |
| View Reports | ✅ | ✅ | ✅ | ❌ |

## Implementation Details

### Database Changes
- Added `role` column to `users` table
- Enum values: `admin`, `chairman`, `treasurer`

### Model Methods Added
```php
public function isChairman()
public function isTreasurer() 
public function canApproveApplications()
public function canAddExpenses()
```

### Controller Updates
- **ApplicationController**: Added permission checks for approve/reject
- **ExpenseController**: Added permission checks for create/store
- **AdminController**: Added role validation in user management

### View Updates
- **User Forms**: Added role selection with dynamic options
- **Navigation**: Shows role-specific menu items
- **Application Review**: Approve/reject buttons only for chairmen
- **Expenses**: Add expense button only for treasurers

### Route Changes
- Removed blanket middleware from some routes
- Added individual permission checks in controllers

## Usage

### Creating Users
1. Select user type (area/mekhala/center)
2. For center users: Role automatically set to admin
3. For mekhala users: Choose chairman or treasurer
4. For area users: No role selection needed

### Navigation
- Navigation menu adapts based on user role
- Shows role in sidebar for mekhala users
- Only displays accessible features

### Permissions
- System automatically checks permissions before allowing actions
- Returns 403 error if user lacks required permissions
- UI elements hidden for unauthorized users

## Security
- Server-side permission checks in controllers
- UI elements conditionally displayed
- Proper error handling for unauthorized access
- Role validation in forms and database

## Files Modified

### Database
- `2025_11_05_171519_add_role_to_users_table.php`

### Models
- `app/Models/User.php`

### Controllers
- `app/Http/Controllers/AdminController.php`
- `app/Http/Controllers/ApplicationController.php`
- `app/Http/Controllers/ExpenseController.php`

### Views
- `resources/views/admin/users/create.blade.php`
- `resources/views/admin/users/edit.blade.php`
- `resources/views/admin/users/index.blade.php`
- `resources/views/applications/review.blade.php`
- `resources/views/expenses/index.blade.php`
- `resources/views/layouts/app.blade.php`

### Routes
- `routes/web.php`