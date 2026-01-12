# Walkthrough - User CRUD and Role Management

This walkthrough demonstrates the new User Management features, including role assignment and deletion restrictions based on session activity.

## Changes Verified

### 1. Database and User Model
- Added `last_activity_at` column to `users` table.
- Updated `User` model to handle the new timestamp.

### 2. Activity Tracking
- Implemented `UpdateLastActivity` middleware to track user sessions.
- Middleware registered globally for web routes.

### 3. User Management (CRUD)
- created `UserController` for managing users.
- Implemented listing, creating, editing, and deleting users.
- Added role assignment (Admin, User).
- **Deletion Restriction**: Users cannot be deleted if their last activity was within the last 3 months.

### 4. Access Control
- Protected user management routes with `role:admin` middleware.
- Added "Usuarios" link to the navigation menu, visible only to administrators.

## Verification Steps

### Prerequisite
Ensure you have an admin user. If not, you can create one via tinker or seeders (assuming `RoleSeeder` has been run and you assign the role).

### Test Case 1: Admin Access
1. Log in as an administrator.
2. Verify the "Usuarios" link appears in the navigation menu.
3. Click "Usuarios" to access the user list.

### Test Case 2: Create User
1. Click "Crear Usuario".
2. Fill in the form:
   - Name: Test User
   - Email: testuser@example.com
   - Password: password
   - Role: User
3. Submit and verify the user is created and listed.

### Test Case 3: Deletion Restriction (Recent Activity)
1. Log out and log in as the new "Test User" (this sets `last_activity_at` to now).
2. Log out and log back in as Admin.
3. Go to "Usuarios".
4. Try to delete "Test User".
5. **Expected Result**: An error message "No se puede eliminar el usuario porque tiene una sesión activa en los últimos 3 meses." should appear.

### Test Case 4: Deletion Allowed (Old Activity)
1. Open database (or use Tinker) and update `last_activity_at` for "Test User" to 4 months ago.
   ```php
   // php artisan tinker
   $user = User::where('email', 'testuser@example.com')->first();
   $user->last_activity_at = now()->subMonths(4);
   $user->save();
   ```
2. As Admin, try to delete "Test User" again.
3. **Expected Result**: The user should be deleted successfully.

### Test Case 5: Unauthorized Access
1. Log in as a regular user (non-admin).
2. Verify "Usuarios" link is NOT in the navigation.
3. Try to access `/users` directly in the browser URL.
4. **Expected Result**: 403 Forbidden or redirection.

---

## Product Management Verification

### 1. Database and Model
- `products` table created with correct columns.
- `Product` model configured with fillables and casts.

### 2. Access Control
- "Productos" link visible in navigation for Admins.
- Routes protected by `role:admin` and `ProductPolicy`.

### 3. Usage
1. **Navigate**: Login as Admin -> Click "Productos".
2. **List**: Verify products seeded by `ProductSeeder` appear (image placeholders logic is in place).
3. **Create**: Click "Crear Producto", fill form (incl. image), submit. Verify validation rules (unique name, numeric price).
4. **Edit**: Edit an existing product.
5. **Delete**: Delete a product.
