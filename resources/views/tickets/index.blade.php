@extends('layouts.app')

@section('title', 'Tickets')
@section('breadcrumb', 'Tickets')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-semibold text-indigo-600">YOUR WORKSPACE</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Tickets</h1>
            <p class="mt-2 text-sm text-slate-500">Keep ticket types, pricing, and availability in view.</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:self-auto"><span aria-hidden="true" class="text-lg leading-none">+</span> Add ticket</a>
    </div>

    <section data-filter-scope data-filter-label="tickets" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50" aria-labelledby="tickets-heading">
        <div class="flex flex-col gap-5 border-b border-slate-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 id="tickets-heading" class="text-base font-semibold text-slate-950">All tickets</h2>
                <p class="mt-1 text-sm text-slate-500">Search by ticket, event, or price and filter by availability.</p>
            </div>
            @if ($tickets->isNotEmpty())
                <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                    <label class="relative min-w-0 flex-1 sm:min-w-64">
                        <span class="sr-only">Search tickets</span>
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.5 3a5.5 5.5 0 1 0 3.42 9.81l3.63 3.64a.75.75 0 1 0 1.06-1.06l-3.64-3.63A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"></path></svg>
                        <input type="search" data-filter-search class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50" placeholder="Search tickets">
                    </label>
                    <label>
                        <span class="sr-only">Filter tickets by status</span>
                        <select data-filter-status class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 sm:w-40">
                            <option value="all">All statuses</option>
                            <option value="available">Available</option>
                            <option value="sold_out">Sold out</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </label>
                    <button type="button" data-filter-clear hidden class="rounded-xl px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">Clear</button>
                </div>
            @endif
        </div>

        @if ($tickets->isNotEmpty())
            <div class="px-5 py-3 sm:px-6">
                <p class="text-xs font-medium text-slate-500" data-filter-count></p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="border-y border-slate-100 bg-slate-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Ticket type</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Event</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Price</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody data-filter-list class="divide-y divide-slate-100">
                        @foreach ($tickets as $ticket)
                            @php
                                $statusClasses = match (strtolower($ticket->status)) {
                                    'available', 'active' => 'bg-green-50 text-green-700',
                                    'sold_out', 'sold out' => 'bg-red-50 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-600',
                                    default => 'bg-amber-50 text-amber-700',
                                };
                            @endphp
                            <tr data-filter-item data-status="{{ strtolower($ticket->status) }}" class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">{{ $ticket->ticket_type }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $ticket->event?->name ?? 'Event removed' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">${{ number_format((float) $ticket->price, 2) }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium capitalize {{ $statusClasses }}">{{ str_replace('_', ' ', $ticket->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div data-filter-empty hidden class="px-6 py-12 text-center">
                <p class="text-sm font-semibold text-slate-900">No matching tickets</p>
                <p class="mt-1 text-sm text-slate-500">Try another search or clear your filters.</p>
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7Z"></path><path d="M13 5v2m0 3v2m0 3v2m0 2v1"></path></svg>
                </span>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No tickets yet</h3>
                <p class="mt-1 text-sm text-gray-500">Create an event first, then add ticket types and prices to it.</p>
                <a href="{{ route('events.create') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create an event</a>
            </div>
        @endif
    </section>
@endsection
