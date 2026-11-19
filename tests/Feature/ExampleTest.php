<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_homepage_displays_the_events_dashboard(): void
    {
        $this->withoutVite();

        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertOk()
            ->assertSee('All events')
            ->assertSee('No events yet');
    }
}
