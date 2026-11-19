<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with(['venueDetail', 'tickets', 'users'])
            ->latest('starts_at')
            ->get();

        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'capacity' => ['nullable', 'required_with:specific_address', 'integer', 'min:1'],
            'specific_address' => ['nullable', 'required_with:capacity', 'string'],
            'layout_map_url' => ['nullable', 'url', 'max:255'],
            'ticket_type' => ['nullable', 'required_with:ticket_price', 'string', 'max:255'],
            'ticket_price' => ['nullable', 'required_with:ticket_type', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        DB::transaction(function () use ($validated): void {
            $event = Event::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'starts_at' => $validated['starts_at'],
                'ends_at' => $validated['ends_at'] ?? null,
                'status' => $validated['status'],
            ]);

            if (isset($validated['capacity'], $validated['specific_address'])) {
                $event->venueDetail()->create([
                    'capacity' => $validated['capacity'],
                    'specific_address' => $validated['specific_address'],
                    'layout_map_url' => $validated['layout_map_url'] ?? null,
                ]);
            }

            if (isset($validated['ticket_type'], $validated['ticket_price'])) {
                $event->tickets()->create([
                    'ticket_type' => $validated['ticket_type'],
                    'price' => $validated['ticket_price'],
                    'status' => 'available',
                ]);
            }
        });

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function attendees(): View
    {
        $attendees = User::with('events')->orderBy('name')->get();

        return view('attendees.index', compact('attendees'));
    }

    public function createAttendee(): View
    {
        $events = Event::orderBy('starts_at')->get(['id', 'name', 'starts_at']);

        return view('attendees.create', compact('events'));
    }

    public function storeAttendee(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'event_id' => ['nullable', 'integer', 'exists:events,id'],
        ]);

        DB::transaction(function () use ($validated): void {
            $attendee = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            if (isset($validated['event_id'])) {
                $attendee->events()->attach($validated['event_id'], [
                    'registration_date' => now(),
                ]);
            }
        });

        return redirect()->route('attendees.index')->with('success', 'Attendee created successfully.');
    }

    public function tickets(): View
    {
        $tickets = Ticket::with('event')->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function createTicket(): View
    {
        $events = Event::orderBy('starts_at')->get(['id', 'name', 'starts_at']);

        return view('tickets.create', compact('events'));
    }

    public function storeTicket(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'ticket_type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'status' => ['required', Rule::in(['available', 'sold_out', 'cancelled'])],
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }
}
