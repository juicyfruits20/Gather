@extends('layouts.app')

@section('title', 'Create event')
@section('breadcrumb', 'Create event')

@section('content')
    <div class="mb-8">
        <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">← Back to events</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-gray-900">Create an event</h1>
        <p class="mt-2 text-sm text-gray-500">Add the event details, venue, and an optional first ticket type.</p>
    </div>

    <form method="POST" action="{{ route('events.store') }}" data-disable-on-submit class="space-y-6">
        @csrf

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-base font-semibold text-gray-900">Event details</h2>
            <p class="mt-1 text-sm text-gray-500">The basics attendees will need to know.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Event name <span class="text-red-500">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="e.g. Product & Design Summit">
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="What is this event about?">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label for="starts_at" class="mb-1.5 block text-sm font-medium text-gray-700">Starts at <span class="text-red-500">*</span></label>
                    <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at') }}" required class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                </div>
                <div>
                    <label for="ends_at" class="mb-1.5 block text-sm font-medium text-gray-700">Ends at</label>
                    <input id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at') }}" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                </div>
                <div>
                    <label for="status" class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                        <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                        <option value="published" @selected(old('status') === 'published')>Published</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-base font-semibold text-gray-900">Venue details <span class="font-normal text-gray-400">· optional</span></h2>
            <p class="mt-1 text-sm text-gray-500">Add both a capacity and address to attach a venue to this event.</p>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="capacity" class="mb-1.5 block text-sm font-medium text-gray-700">Venue capacity</label>
                    <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity') }}" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="e.g. 250">
                </div>
                <div>
                    <label for="layout_map_url" class="mb-1.5 block text-sm font-medium text-gray-700">Layout map URL</label>
                    <input id="layout_map_url" name="layout_map_url" type="url" value="{{ old('layout_map_url') }}" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="https://example.com/map">
                </div>
                <div class="sm:col-span-2">
                    <label for="specific_address" class="mb-1.5 block text-sm font-medium text-gray-700">Specific address</label>
                    <textarea id="specific_address" name="specific_address" rows="2" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="Street address, city, and any arrival details">{{ old('specific_address') }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-base font-semibold text-gray-900">First ticket type <span class="font-normal text-gray-400">· optional</span></h2>
            <p class="mt-1 text-sm text-gray-500">You can add more tickets later from the Tickets page.</p>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="ticket_type" class="mb-1.5 block text-sm font-medium text-gray-700">Ticket type</label>
                    <input id="ticket_type" name="ticket_type" type="text" value="{{ old('ticket_type') }}" maxlength="255" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="e.g. General Admission">
                </div>
                <div>
                    <label for="ticket_price" class="mb-1.5 block text-sm font-medium text-gray-700">Price</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-sm text-gray-500">$</span>
                        <input id="ticket_price" name="ticket_price" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('ticket_price') }}" class="w-full rounded-lg border border-gray-300 py-2.5 pl-8 pr-3.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="0.00">
                    </div>
                </div>
            </div>
        </section>

        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Cancel</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create event</button>
        </div>
    </form>
@endsection
