<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.rooms.index');
    }
}
