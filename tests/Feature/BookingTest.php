<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ruangan;
use App\Models\Bed;
use App\Models\MasterSesi;
use App\Models\WaktuLayanan;
use App\Models\ServiceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    // We don't use RefreshDatabase directly if we want to run against the current local DB state,
    // but using DatabaseTransactions is safer to rollback changes.
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test room-scoped bed uniqueness validation.
     */
    public function test_bed_name_uniqueness_is_scoped_per_room()
    {
        $admin = User::where('role_users', 'admin')->first();
        if (!$admin) {
            $admin = User::factory()->create(['role_users' => 'admin']);
        }

        $room1 = Ruangan::create(['nama_ruangan' => 'Test Room A', 'gender' => 'laki-laki', 'maximal' => 3, 'active' => true]);
        $room2 = Ruangan::create(['nama_ruangan' => 'Test Room B', 'gender' => 'laki-laki', 'maximal' => 3, 'active' => true]);

        // Create Bed in Room A
        $bed1 = Bed::create(['id_ruangan' => $room1->id, 'nama_bed' => 'Bed X', 'active' => true]);

        // Attempting to create duplicate Bed in Room A should fail
        $response = $this->actingAs($admin)
            ->from(route('admin.ruangans.show', $room1->id))
            ->post(route('admin.beds.store'), [
                'id_ruangan' => $room1->id,
                'nama_bed' => 'Bed X',
            ]);

        $response->assertRedirect(route('admin.ruangans.show', $room1->id));
        $response->assertSessionHasErrors('nama_bed');

        // Creating Bed with same name in Room B should succeed
        $response2 = $this->actingAs($admin)
            ->from(route('admin.ruangans.show', $room2->id))
            ->post(route('admin.beds.store'), [
                'id_ruangan' => $room2->id,
                'nama_bed' => 'Bed X',
            ]);

        $response2->assertRedirect(route('admin.ruangans.show', $room2->id));
        $this->assertTrue(Bed::where('id_ruangan', $room2->id)->where('nama_bed', 'Bed X')->exists());
    }

    /**
     * Test holiday Exception logic.
     */
    public function test_booking_on_holiday_shows_closed_validation()
    {
        $customer = User::where('role_users', 'customer')->first();
        if (!$customer) {
            $customer = User::factory()->create(['role_users' => 'customer']);
        }

        $service = ServiceCategory::first() ?: ServiceCategory::create(['name' => 'Bekam', 'price' => 100000, 'is_active' => true]);

        // Mark 2026-12-25 as holiday (active = false)
        WaktuLayanan::updateOrCreate(
            ['tanggal' => '2026-12-25'],
            [
                'waktu_buka'  => '08:00',
                'waktu_tutup' => '17:00',
                'maximal'     => 10,
                'active'      => false,
            ]
        );

        $response = $this->actingAs($customer)->getJson(route('customer.bookings.slots', [
            'service_id' => $service->id,
            'date' => '2026-12-25',
        ]));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'slots' => [],
            'message' => 'Klinik libur/tutup pada tanggal ini.'
        ]);
    }

    /**
     * Test dynamic sessions rendering and booking.
     */
    public function test_dynamic_session_rendering_and_successful_booking()
    {
        $customer = User::where('role_users', 'customer')->first();
        if (!$customer) {
            $customer = User::factory()->create(['role_users' => 'customer', 'gender' => 'laki-laki']);
        } elseif (!$customer->gender) {
            $customer->gender = 'laki-laki';
            $customer->save();
        }

        $service = ServiceCategory::first();
        if (!$service) {
            $service = ServiceCategory::create(['name' => 'Bekam', 'slug' => 'bekam', 'price' => 150000]);
        }
        $room = Ruangan::where('active', true)->where('gender', $customer->gender)->first();
        if (!$room) {
            $room = Ruangan::create(['nama_ruangan' => 'Test Room C', 'gender' => 'laki-laki', 'maximal' => 3, 'active' => true]);
        }
        $bed = Bed::where('id_ruangan', $room->id)->where('active', true)->first();
        if (!$bed) {
            $bed = Bed::create(['id_ruangan' => $room->id, 'nama_bed' => 'Bed Z', 'active' => true]);
        }

        // Create a custom master session
        $masterSession = MasterSesi::updateOrCreate(
            ['jam_mulai' => '23:00', 'jam_selesai' => '23:45'],
            ['nama_sesi' => 'Sesi Malam', 'active' => true]
        );

        // Call slots API for a future date (e.g. 2026-08-10)
        $date = '2026-08-10';
        $response = $this->actingAs($customer)->getJson(route('customer.bookings.slots', [
            'service_id' => $service->id,
            'date' => $date,
        ]));

        $response->assertStatus(200);
        
        // Assert Sesi Malam is present in response
        $slots = $response->json('slots');
        $found = false;
        foreach ($slots as $s) {
            if ($s['jam'] === '23:00' && $s['jam_selesai'] === '23:45' && $s['nama_sesi'] === 'Sesi Malam') {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Custom Master Session was not rendered dynamically in slot list");

        // Get Room slot ID generated for Sesi Malam on 2026-08-10
        $waktuLayanan = WaktuLayanan::where('tanggal', $date)->first();
        $waktuBoking = \App\Models\WaktuBoking::where('id_waktu_layanan', $waktuLayanan->id)
            ->where('id_ruangan', $room->id)
            ->where('kode_waktu_boking', '23:00')
            ->first();

        $this->assertNotNull($waktuBoking, "WaktuBoking was not dynamically created for custom session");

        // Submit a booking for this slot
        $bookingResponse = $this->actingAs($customer)
            ->post(route('customer.bookings.store'), [
                'id_service' => $service->id,
                'id_waktu_boking' => $waktuBoking->id,
                'id_ruangan' => $room->id,
                'id_bed' => $bed->id,
                'payment_method' => 'cash',
                'booking_for' => 'self',
            ]);

        $bookingResponse->assertRedirect();
        
        // Verify booking recorded in database
        $this->assertTrue(\App\Models\Booking::where('id_customer', $customer->id)
            ->where('id_waktu_boking', $waktuBoking->id)
            ->where('id_bed', $bed->id)
            ->exists());
    }

    /**
     * Test creating a room with a bed list and check dynamic capacity.
     */
    public function test_create_room_with_beds_list_has_dynamic_capacity()
    {
        $admin = User::where('role_users', 'admin')->first();
        if (!$admin) {
            $admin = User::factory()->create(['role_users' => 'admin']);
        }

        $response = $this->actingAs($admin)
            ->post(route('admin.ruangans.store'), [
                'nama_ruangan' => 'Room Dynamic',
                'gender' => 'laki-laki',
                'active' => '1',
                'beds_list' => "Bed Alpha\nBed Beta\nBed Gamma",
            ]);

        $response->assertRedirect(route('admin.ruangans.index'));

        $ruangan = Ruangan::where('nama_ruangan', 'Room Dynamic')->first();
        $this->assertNotNull($ruangan);
        $this->assertEquals(3, $ruangan->beds()->count());
        $this->assertEquals(3, $ruangan->maximal); // capacity dynamically calculated as 3 active beds
    }
}
