<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::all();
        $schedules = Schedule::where('status', 'available')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        return view('user.booking', compact('services', 'schedules'));
    }

    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user->phone_number) {
            return redirect()->route('profile.edit')
                ->with('error', 'Silahkan lengkapi nomor HP Anda sebelum melakukan booking.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::find($validated['schedule_id']);

        if (!$schedule->isAvailable()) {
            return back()->with('error', 'Jadwal yang dipilih sudah tidak tersedia!');
        }

        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        Booking::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil! Kami akan segera menghubungi Anda.');
    }
}
