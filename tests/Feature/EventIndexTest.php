<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\VenueDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_index_displays_eager_loaded_event_relationships(): void
    {
        $event = Event::create([
            'name' => 'Product Summit',
            'starts_at' => '2026-11-15 09:00:00',
            'status' => 'published',
        ]);

        VenueDetail::create([
            'event_id' => $event->id,
            'capacity' => 450,
            'specific_address' => '100 Market Street, San Francisco',
            'layout_map_url' => 'https://example.com/layout',
        ]);

        Ticket::create([
            'event_id' => $event->id,
            'ticket_type' => 'VIP',
            'price' => 199.00,
            'status' => 'available',
        ]);

        $attendee = User::factory()->create();
        $attendee->events()->attach($event, ['registration_date' => now()]);

        $this->actingAs(User::factory()->create())
            ->withoutVite();

        $this->get(route('events.index'))
            ->assertOk()
            ->assertSee('Product Summit')
            ->assertSee('100 Market Street, San Francisco')
            ->assertSee('href="https://example.com/layout"', false)
            ->assertSee('View venue map')
            ->assertSee('450')
            ->assertSee('VIP')
            ->assertSee('1')
            ->assertSee('published');

        $event->delete();

        $this->assertDatabaseMissing('venue_details', ['event_id' => $event->id]);
        $this->assertDatabaseMissing('tickets', ['event_id' => $event->id]);
        $this->assertDatabaseMissing('event_user', ['event_id' => $event->id]);
    }

    public function test_attendees_sidebar_page_lists_registered_attendees(): void
    {
        $event = Event::create([
            'name' => 'Design Conference',
            'starts_at' => '2026-12-01 09:00:00',
            'status' => 'published',
        ]);
        $attendee = User::factory()->create(['name' => 'Jordan Lee']);
        $attendee->events()->attach($event, ['registration_date' => now()]);

        $this->actingAs(User::factory()->create())
            ->withoutVite()
            ->get(route('attendees.index'))
            ->assertOk()
            ->assertSee('Attendees')
            ->assertSee('Jordan Lee')
            ->assertSee('Design Conference');
    }

    public function test_tickets_sidebar_page_lists_tickets_and_their_events(): void
    {
        $event = Event::create([
            'name' => 'Design Conference',
            'starts_at' => '2026-12-01 09:00:00',
            'status' => 'published',
        ]);
        Ticket::create([
            'event_id' => $event->id,
            'ticket_type' => 'General Admission',
            'price' => 75,
            'status' => 'available',
        ]);

        $this->actingAs(User::factory()->create())
            ->withoutVite()
            ->get(route('tickets.index'))
            ->assertOk()
            ->assertSee('Tickets')
            ->assertSee('General Admission')
            ->assertSee('Design Conference')
            ->assertSee('$75.00');
    }

    public function test_event_form_creates_event_venue_and_first_ticket(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('events.store'), [
                'name' => 'Community Summit',
                'description' => 'A day for the community.',
                'starts_at' => '2026-12-10T09:00',
                'ends_at' => '2026-12-10T17:00',
                'status' => 'published',
                'capacity' => 300,
                'specific_address' => '88 King Street',
                'layout_map_url' => 'https://example.com/layout',
                'ticket_type' => 'General Admission',
                'ticket_price' => '49.00',
            ])->assertRedirect(route('events.index'));

        $event = Event::where('name', 'Community Summit')->firstOrFail();

        $this->assertDatabaseHas('venue_details', [
            'event_id' => $event->id,
            'capacity' => 300,
            'specific_address' => '88 King Street',
        ]);
        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
            'ticket_type' => 'General Admission',
            'price' => '49.00',
        ]);
    }

    public function test_create_forms_are_available_from_each_workspace_section(): void
    {
        $this->actingAs(User::factory()->create())
            ->withoutVite();

        $this->get(route('events.create'))
            ->assertOk()
            ->assertSee('Create an event')
            ->assertSee('Venue details');

        $this->get(route('attendees.create'))
            ->assertOk()
            ->assertSee('Add an attendee')
            ->assertSee('Temporary password');

        $this->get(route('tickets.create'))
            ->assertOk()
            ->assertSee('Create an event first');
    }

    public function test_attendee_form_creates_an_account_and_event_registration(): void
    {
        $event = Event::create([
            'name' => 'Community Summit',
            'starts_at' => '2026-12-10 09:00:00',
            'status' => 'published',
        ]);

        $this->actingAs(User::factory()->create())
            ->post(route('attendees.store'), [
                'name' => 'Casey Morgan',
                'email' => 'casey@example.com',
                'password' => 'secure-pass-123',
                'password_confirmation' => 'secure-pass-123',
                'event_id' => $event->id,
            ])->assertRedirect(route('attendees.index'));

        $attendee = User::where('email', 'casey@example.com')->firstOrFail();
        $this->assertTrue(password_verify('secure-pass-123', $attendee->password));
        $this->assertDatabaseHas('event_user', [
            'user_id' => $attendee->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_ticket_form_creates_a_ticket_for_an_event(): void
    {
        $event = Event::create([
            'name' => 'Community Summit',
            'starts_at' => '2026-12-10 09:00:00',
            'status' => 'published',
        ]);

        $this->actingAs(User::factory()->create())
            ->post(route('tickets.store'), [
                'event_id' => $event->id,
                'ticket_type' => 'VIP',
                'price' => '125.00',
                'status' => 'available',
            ])->assertRedirect(route('tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
            'ticket_type' => 'VIP',
            'price' => '125.00',
            'status' => 'available',
        ]);
    }
}
