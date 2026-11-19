@extends('layouts.app')

@section('title', 'Add ticket')
@section('breadcrumb', 'Add ticket')

@section('content')
    <div class="mb-8">
        <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">← Back to tickets</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-gray-900">Add a ticket</h1>
        <p class="mt-2 text-sm text-gray-500">Set up a ticket type and price for one of your events.</p>
    </div>

    @if ($events->isEmpty())
        <section class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm">
            <h2 class="text-base font-semibold text-gray-900">Create an event first</h2>
            <p class="mt-1 text-sm text-gray-500">Tickets need to be attached to an event.</p>
            <a href="{{ route('events.create') }}" class="mt-5 inline-flex rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Create event</a>
        </section>
    @else
        <form method="POST" action="{{ route('tickets.store') }}" data-disable-on-submit class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="event_id" class="mb-1.5 block text-sm font-medium text-gray-700">Event <span class="text-red-500">*</span></label>
                    <select id="event_id" name="event_id" required class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        <option value="">Select an event</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->name }} · {{ $event->starts_at->format('M j, Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ticket_type" class="mb-1.5 block text-sm font-medium text-gray-700">Ticket type <span class="text-red-500">*</span></label>
                    <input id="ticket_type" name="ticket_type" type="text" value="{{ old('ticket_type') }}" required maxlength="255" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="e.g. VIP">
                </div>
                <div>
                    <label for="price" class="mb-1.5 block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-sm text-gray-500">$</span>
                        <input id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('price') }}" required class="w-full rounded-lg border border-gray-300 py-2.5 pl-8 pr-3.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        <option value="available" @selected(old('status', 'available') === 'available')>Available</option>
                        <option value="sold_out" @selected(old('status') === 'sold_out')>Sold out</option>
                        <option value="cancelled" @selected(old('status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 sm:flex-row">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save ticket</button>
            </div>
        </form>
    @endif
@endsection
