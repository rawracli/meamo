<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with(['service', 'schedule'])->latest()->get();

        return view('user.dashboard', compact('user', 'bookings'));
    }
}
