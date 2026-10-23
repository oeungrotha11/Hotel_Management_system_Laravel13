@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
    <h1>User accounts</h1>
    <p class="muted">Customers can register themselves. Only an administrator can change account roles.</p>
    <div class="card">
        <form method="GET" class="row">
            <div><label>Search name or email<input name="search" value="{{ request('search') }}"
                        placeholder="Search users"></label></div>
            <div><label>Role<select name="role">
                        <option value="">All roles</option>
                        <option value="customer" @selected(request('role') === 'customer')>Customer</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    </select></label></div>
            <div style="flex:0 0 auto"><button class="btn">Search</button> <a class="btn gray"
                    href="{{ route('admin.users.index') }}">Reset</a></div>
        </form>
    </div>
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current role</th>
                    <th>Change role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <form class="row" method="POST" action="{{ route('admin.users.role', $user) }}"
                                style="min-width:260px">@csrf @method('PATCH')
                                <div><select name="role">
                                        <option value="customer" @selected($user->role === 'customer')>Customer</option>
                                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    </select></div>
                                <div style="flex:0 0 auto"><button class="btn green">Save</button></div>
                            </form>
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>@empty<tr>
                    <td colspan="5">No users found.</td>
                </tr>@endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $users->links() }}</div>
    </div>
@endsection