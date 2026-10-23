<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')))
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate(['role' => ['required', Rule::in(['admin', 'customer'])]]);

        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own administrator role.');
        }

        if ($user->role === 'admin' && $data['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'The system must keep at least one administrator.');
        }

        $user->role = $data['role'];
        $user->save();

        return back()->with('success', 'User role updated.');
    }
}
