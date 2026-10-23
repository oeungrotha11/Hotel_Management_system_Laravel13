# StayEase Hotel Management System — Laravel 13

A Blade-based Laravel 13 student project with separate customer and administrator experiences in one application and one MySQL database.

## Roles and security
- Public registration always creates a `customer`; the registration form and controller do not accept a role field.
- Admin pages are protected by `auth` plus `role:admin` middleware.
- Customer pages are protected by `auth` plus `role:customer` middleware.
- Customers can browse available rooms, request reservations, see only their own bookings, and cancel eligible pending/confirmed future bookings.
- Admins can manage rooms, all bookings, and account roles. The UI prevents an admin from removing their own admin role and prevents demoting the last admin.
- Initial administrator creation is CLI-only: register the account, then run `php artisan hotel:make-admin admin@example.com` and confirm the prompt. This command is intentionally not exposed as a public web route.

## Features
- Login, registration, remember-me, logout and session regeneration.
- Role-aware redirects: admins go to the admin dashboard; customers go to the room catalogue.
- Admin dashboard metrics and recent bookings.
- Admin room CRUD, search/filter and pagination.
- Admin booking CRUD, guest/room search, status filter and pagination.
- Customer room catalogue with search and capacity filter.
- Customer booking history and detail pages; ownership is checked on the server.
- Booking total calculated from price per night × number of nights.
- Basic room capacity and overlapping-date checks for reservations.
- Eloquent relationships: User hasMany Booking; Room hasMany Booking; Booking belongsTo User and Room.

## Requirements and setup (Windows / Laragon / XAMPP)
1. Extract the ZIP and open the `HotelManagementLaravel13` folder.
2. Create a MySQL database named `hotel_management` in phpMyAdmin.
3. Copy `.env.example` to `.env` and set your database credentials. For a simple local setup, use `SESSION_DRIVER=file`, `CACHE_STORE=file`, and `QUEUE_CONNECTION=sync` unless you have created the relevant database tables.
4. Run these commands in the project terminal:

```powershell
composer install
Copy-Item .env.example .env   # only if .env does not already exist
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

5. Open `http://127.0.0.1:8000` and register your own account.
6. In another terminal, promote your account to admin (replace the email):

```powershell
php artisan hotel:make-admin you@example.com
```

7. Log out and log in again. You should now see the Admin Dashboard and management links. Customer registrations continue to receive the `customer` role.

## Main routes
| Area | URL | Access |
|---|---|---|
| Login | `/login` | Guest |
| Customer registration | `/register` | Guest; creates customer only |
| Customer room catalogue | `/rooms` | Customer |
| Customer room details | `/rooms/{room}` | Customer |
| My bookings | `/my-bookings` | Customer; own records only |
| Admin dashboard | `/admin/dashboard` | Admin |
| Admin room CRUD | `/admin/rooms` | Admin |
| Admin booking CRUD | `/admin/bookings` | Admin |
| Admin account/role management | `/admin/users` | Admin |

## Database
```text
users (role: admin/customer) 1 ─── * bookings * ─── 1 rooms
```
The role migration gives existing accounts `customer` by default. Use the CLI promotion command to create the first administrator. Run migrations before using the command.

## Important limitation
This is an educational starter, not a production booking engine. Before public deployment, add automated tests, email verification, payment integration, audit logs, stronger availability/locking for concurrent bookings, and review operational policies for check-in/check-out.
