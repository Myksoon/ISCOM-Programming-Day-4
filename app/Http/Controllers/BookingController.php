<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
            'nama'    => 'required|string|max:255',
            'no_hp'   => 'required|string|max:20',
            'tanggal' => 'required|date',
            'jam'     => 'required',
            'catatan' => 'nullable|string',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Reservasi sewa moge berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking): View
    {
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'no_hp'   => 'required|string|max:20',
            'tanggal' => 'required|date',
            'jam'     => 'required',
            'catatan' => 'nullable|string',
            'status'  => 'required|in:menunggu,selesai,batal',
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
