<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_bookings_index(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/bookings');
    }

    public function test_index_displays_bookings(): void
    {
        Booking::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'tanggal' => '2026-10-20',
            'jam' => '10:00:00',
            'catatan' => 'Kawasaki ZX-6R',
            'status' => 'menunggu',
        ]);

        $response = $this->get(route('bookings.index'));
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('081234567890');
        $response->assertSee('Menunggu');
    }

    public function test_create_page_loads_successfully(): void
    {
        $response = $this->get(route('bookings.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Reservasi Booking Baru');
    }

    public function test_store_creates_booking_and_redirects(): void
    {
        $data = [
            'nama' => 'Ahmad Dani',
            'no_hp' => '081987654321',
            'tanggal' => '2026-10-22',
            'jam' => '14:30',
            'catatan' => 'Harley Iron 883 Surabaya Barat',
        ];

        $response = $this->post(route('bookings.store'), $data);

        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'nama' => 'Ahmad Dani',
            'no_hp' => '081987654321',
            'status' => 'menunggu',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->post(route('bookings.store'), []);

        $response->assertSessionHasErrors(['nama', 'no_hp', 'tanggal', 'jam']);
    }

    public function test_edit_page_loads_with_booking_data(): void
    {
        $booking = Booking::create([
            'nama' => 'Citra Kirana',
            'no_hp' => '08551234567',
            'tanggal' => '2026-10-25',
            'jam' => '09:00:00',
            'catatan' => 'Ducati Panigale V2',
            'status' => 'menunggu',
        ]);

        $response = $this->get(route('bookings.edit', $booking));
        $response->assertStatus(200);
        $response->assertSee('Citra Kirana');
        $response->assertSee('08551234567');
    }

    public function test_update_modifies_booking_and_status(): void
    {
        $booking = Booking::create([
            'nama' => 'Citra Kirana',
            'no_hp' => '08551234567',
            'tanggal' => '2026-10-25',
            'jam' => '09:00:00',
            'catatan' => 'Ducati Panigale V2',
            'status' => 'menunggu',
        ]);

        $updateData = [
            'nama' => 'Citra Kirana Updated',
            'no_hp' => '08551234567',
            'tanggal' => '2026-10-25',
            'jam' => '11:00',
            'catatan' => 'Ducati Panigale V2 + Full Gear',
            'status' => 'selesai',
        ];

        $response = $this->put(route('bookings.update', $booking), $updateData);

        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'nama' => 'Citra Kirana Updated',
            'status' => 'selesai',
        ]);
    }

    public function test_destroy_deletes_booking(): void
    {
        $booking = Booking::create([
            'nama' => 'Eko Prasetyo',
            'no_hp' => '08123444555',
            'tanggal' => '2026-10-26',
            'jam' => '16:00:00',
            'catatan' => 'Honda CBR1000RR-R',
            'status' => 'menunggu',
        ]);

        $response = $this->delete(route('bookings.destroy', $booking));

        $response->assertRedirect(route('bookings.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }
}
