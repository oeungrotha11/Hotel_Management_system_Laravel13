# Upgrade guide: Admin + Customer separation

This update extends the existing Laravel project; it does not require a new database.

## Existing files changed
- `routes/web.php`: customer routes and admin-only `/admin/*` routes.
- `app/Models/User.php`: helper methods for role checks; role excluded from mass assignment.
- `app/Http/Controllers/AuthController.php`: registration continues to create customer accounts only.
- `app/Http/Controllers/RoomController.php` and `BookingController.php`: existing CRUD now belongs to the admin route group.
- `resources/views/layouts/app.blade.php`: role-specific navigation.
- Existing room and booking views now use `admin.*` route names.

## New files
- `database/migrations/2026_10_21_000001_add_role_to_users_table.php`: adds `users.role`, default `customer`.
- `app/Http/Middleware/RoleMiddleware.php`: enforces admin/customer role access.
- `app/Console/Commands/MakeAdmin.php`: securely promotes an existing account through the local CLI.
- `app/Http/Controllers/AdminDashboardController.php`, `AdminUserController.php`, `CustomerRoomController.php`, and `CustomerBookingController.php`.
- `resources/views/admin/*` and `resources/views/customer/*`: separate UI areas.

## Apply to your existing Windows project
1. Make a backup of the current project folder.
2. Extract this ZIP. Copy the contents of the inner `HotelManagementLaravel13` folder into your existing project folder and allow source files to be overwritten. Keep your existing `.env` and `vendor` folder.
3. Open PowerShell in your existing project folder and run:

```powershell
php artisan optimize:clear
php artisan migrate
php artisan db:seed
```

Do **not** run `migrate:fresh` on a database containing data; it deletes and recreates tables. `db:seed` is safe here because sample rooms use `firstOrCreate`.

4. Start the server with `php artisan serve`, register your account normally, and then in a second terminal run (replace with the email you registered):

```powershell
php artisan hotel:make-admin you@example.com
```

5. Confirm the promotion, log out and log in again. Admins go to `/admin/dashboard`; customer accounts go to `/rooms`.

## Role/security behavior
- `/register` always creates a customer; a posted `role=admin` value is ignored.
- Only an admin can access `/admin/dashboard`, `/admin/rooms`, `/admin/bookings`, and `/admin/users`.
- Customers can only view their own booking records. Room capacity and overlapping booking dates are checked on submission.
- An existing admin can promote or demote accounts at `/admin/users`, but cannot demote themselves or the last remaining admin.
