@extends('layouts.app')

@section('title', 'Attendees')
@section('breadcrumb', 'Attendees')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-semibold text-indigo-600">YOUR WORKSPACE</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Attendees</h1>
            <p class="mt-2 text-sm text-slate-500">Get to know the people joining your events.</p>
        </div>
        <a href="{{ route('attendees.create') }}" class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:self-auto"><span aria-hidden="true" class="text-lg leading-none">+</span> Add attendee</a>
    </div>

    <section data-filter-scope data-filter-label="attendees" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50" aria-labelledby="attendees-heading">
        <div class="flex flex-col gap-5 border-b border-slate-100 px-5 py-5 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 id="attendees-heading" class="text-base font-semibold text-slate-950">All attendees</h2>
                <p class="mt-1 text-sm text-slate-500">Find a person by name, email, or event.</p>
            </div>
            @if ($attendees->isNotEmpty())
                <div class="flex w-full gap-2 sm:w-auto">
                    <label class="relative min-w-0 flex-1 sm:min-w-64">
                        <span class="sr-only">Search attendees</span>
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.5 3a5.5 5.5 0 1 0 3.42 9.81l3.63 3.64a.75.75 0 1 0 1.06-1.06l-3.64-3.63A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"></path></svg>
                        <input type="search" data-filter-search class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50" placeholder="Search attendees">
                    </label>
                    <button type="button" data-filter-clear hidden class="rounded-xl px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">Clear</button>
                </div>
            @endif
        </div>

        @if ($attendees->isNotEmpty())
            <div class="px-5 py-3 sm:px-6">
                <p class="text-xs font-medium text-slate-500" data-filter-count></p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="border-y border-slate-100 bg-slate-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Attendee</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Registered events</th>
                            <th scope="col" class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500">Events</th>
                        </tr>
                    </thead>
                    <tbody data-filter-list class="divide-y divide-slate-100">
                        @foreach ($attendees as $attendee)
                            <tr data-filter-item class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">{{ strtoupper(substr($attendee->name, 0, 1)) }}</span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $attendee->name }}</p>
                                            <p class="mt-0.5 text-sm text-gray-500">{{ $attendee->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $attendee->events->count() }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $attendee->events->pluck('name')->take(3)->join(', ') ?: 'No event registrations' }}
                                    @if ($attendee->events->count() > 3)
                                        <span class="text-gray-400"> +{{ $attendee->events->count() - 3 }} more</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div data-filter-empty hidden class="px-6 py-12 text-center">
                <p class="text-sm font-semibold text-slate-900">No matching attendees</p>
                <p class="mt-1 text-sm text-slate-500">Try another name, email, or event.</p>
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="10" cy="7" r="4"></circle><path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No attendees yet</h3>
                <p class="mt-1 text-sm text-gray-500">Add an attendee here, or register attendees while creating an account.</p>
                <a href="{{ route('attendees.create') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add your first attendee</a>
            </div>
        @endif
    </section>
@endsection
