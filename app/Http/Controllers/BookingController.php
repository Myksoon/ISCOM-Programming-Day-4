<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Booking::updateExpiredStatus();

        $bookings = Booking::latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'no_hp'           => 'required|string|max:20',
            'tanggal'         => 'required|date',
            'jam'             => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal',
            'jam_selesai'     => 'required',
            'catatan'         => 'nullable|string',
        ]);

        $startDateTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['jam']);
        $endDateTime = Carbon::parse($validated['tanggal_selesai'] . ' ' . $validated['jam_selesai']);
        $now = Carbon::now();

        if ($now->gte($endDateTime)) {
            $validated['status'] = 'selesai';
        } elseif ($now->gte($startDateTime)) {
            $validated['status'] = 'disewa';
        } else {
            $validated['status'] = 'menunggu';
        }

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Reservasi sewa moge berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking): View
    {
        Booking::updateExpiredStatus();
        $booking->refresh();

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'no_hp'           => 'required|string|max:20',
            'tanggal'         => 'required|date',
            'jam'             => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal',
            'jam_selesai'     => 'required',
            'catatan'         => 'nullable|string',
            'status'          => 'required|in:menunggu,disewa,delay,reschedule,selesai,batal',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Data reservasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Data reservasi berhasil dihapus!');
    }
}
