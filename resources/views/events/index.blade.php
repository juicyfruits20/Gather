@extends('layouts.app')

@section('title', 'Events')
@section('breadcrumb', 'Events')

@section('content')
    @php
        $publishedEvents = $events->where('status', 'published')->count();
        $upcomingEvents = $events->filter(fn ($event) => $event->starts_at->isFuture())->count();
        $registrationCount = $events->sum(fn ($event) => $event->users->count());
    @endphp

    <div class="relative mb-8 flex flex-col justify-between gap-5 overflow-hidden rounded-3xl bg-gradient-to-r from-teal-950 via-teal-700 to-emerald-400 p-6 text-white shadow-xl shadow-teal-900/10 sm:flex-row sm:items-end sm:p-8">
        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[24px] border-white/10"></div>
        <div class="relative z-10">
            <p class="text-sm font-semibold text-emerald-100">YOUR WORKSPACE</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Events</h1>
            <p class="mt-2 text-sm text-white/80">A clear view of what’s happening across your events.</p>
        </div>
        <a href="{{ route('events.create') }}" class="relative z-10 inline-flex items-center justify-center gap-2 self-start rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-teal-800 shadow-lg shadow-teal-950/10 transition hover:-translate-y-0.5 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-teal-700 sm:self-auto">
            <span aria-hidden="true" class="text-lg leading-none">+</span>
            Create event
        </a>
    </div>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total events</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ $events->count() }}</p>
            <p class="mt-1 text-xs text-slate-400">Across your workspace</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Published</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ $publishedEvents }}</p>
            <p class="mt-1 text-xs text-slate-400">Visible to your audience</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Upcoming</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">{{ $upcomingEvents }}</p>
            <p class="mt-1 text-xs text-slate-400">Scheduled for the future</p>
        </article>
        <article class="rounded-2xl border border-indigo-100 bg-indigo-600 p-5 text-white shadow-sm shadow-indigo-200">
            <p class="text-sm font-medium text-indigo-100">Registrations</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight">{{ number_format($registrationCount) }}</p>
            <p class="mt-1 text-xs text-indigo-200">Across all your events</p>
        </article>
    </div>

    <section data-filter-scope data-filter-label="events" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50" aria-labelledby="events-heading">
        <div class="flex flex-col gap-5 border-b border-slate-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 id="events-heading" class="text-base font-semibold text-slate-950">All events</h2>
                <p class="mt-1 text-sm text-slate-500">Search and filter your events at a glance.</p>
            </div>
            @if ($events->isNotEmpty())
                <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                    <label class="relative min-w-0 flex-1 sm:min-w-64">
                        <span class="sr-only">Search events</span>
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.5 3a5.5 5.5 0 1 0 3.42 9.81l3.63 3.64a.75.75 0 1 0 1.06-1.06l-3.64-3.63A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"></path></svg>
                        <input type="search" data-filter-search class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50" placeholder="Search events">
                    </label>
                    <label>
                        <span class="sr-only">Filter events by status</span>
                        <select data-filter-status class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 sm:w-40">
                            <option value="all">All statuses</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </label>
                    <button type="button" data-filter-clear hidden class="rounded-xl px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">Clear</button>
                </div>
            @endif
        </div>

        @if ($events->isNotEmpty())
            <div class="flex items-center justify-between px-5 py-3 sm:px-6">
                <p class="text-xs font-medium text-slate-500" data-filter-count></p>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Workspace active
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead class="border-y border-slate-100 bg-slate-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Event</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Venue capacity</th>
                            <th id="tickets" scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Tickets</th>
                            <th id="attendees" scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Attendees</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Date</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody data-filter-list class="divide-y divide-slate-100">
                        @foreach ($events as $event)
                            @php
                                $statusClasses = match (strtolower($event->status)) {
                                    'published', 'live' => 'bg-green-50 text-green-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                    'completed' => 'bg-gray-100 text-gray-600',
                                    default => 'bg-amber-50 text-amber-700',
                                };
                            @endphp
                            <tr data-filter-item data-status="{{ strtolower($event->status) }}" class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3.5" y="5" width="17" height="16" rx="3"></rect><path d="M7.5 3v4M16.5 3v4M3.5 10h17"></path></svg>
                                        </span>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $event->name }}</p>
                                            <p class="mt-0.5 max-w-xs truncate text-xs text-slate-500">{{ $event->venueDetail?->specific_address ?? 'Venue details not added' }}</p>
                                            @if ($event->venueDetail?->layout_map_url)
                                                <a href="{{ $event->venueDetail->layout_map_url }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block text-xs font-medium text-indigo-600 hover:text-indigo-700">View venue map <span aria-hidden="true">↗</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                    @if ($event->venueDetail)
                                        <span class="font-medium">{{ number_format($event->venueDetail->capacity) }}</span>
                                        <span class="text-gray-500"> seats</span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse ($event->tickets->take(2) as $ticket)
                                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">{{ $ticket->ticket_type }}</span>
                                        @empty
                                            <span class="text-sm text-slate-400">No tickets</span>
                                        @endforelse
                                        @if ($event->tickets->count() > 2)
                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">+{{ $event->tickets->count() - 2 }}</span>
                                        @endif
                                    </div>
                                    @if ($event->tickets->isNotEmpty())
                                        <p class="mt-1.5 text-xs text-gray-500">{{ $event->tickets->count() }} ticket {{ \Illuminate\Support\Str::plural('type', $event->tickets->count()) }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900">{{ number_format($event->users->count()) }}</span>
                                    <span class="text-sm text-gray-500"> registered</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">
                                    {{ $event->starts_at->format('M j, Y') }}
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $event->starts_at->format('g:i A') }}</p>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium capitalize {{ $statusClasses }}">{{ str_replace('_', ' ', $event->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div data-filter-empty hidden class="px-6 py-12 text-center">
                <p class="text-sm font-semibold text-slate-900">No matching events</p>
                <p class="mt-1 text-sm text-slate-500">Try another search or clear your filters.</p>
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3.5" y="5" width="17" height="16" rx="3"></rect><path d="M7.5 3v4M16.5 3v4M3.5 10h17"></path></svg>
                </span>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No events yet</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first event to keep all the important details in one place.</p>
                <a href="{{ route('events.create') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create your first event</a>
            </div>
        @endif
    </section>

    <p class="mt-5 text-xs text-gray-400">Event data is kept in sync with venue, ticket, and registration records.</p>
@endsection
