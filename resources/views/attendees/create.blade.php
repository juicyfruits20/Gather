@extends('layouts.app')

@section('title', 'Add attendee')
@section('breadcrumb', 'Add attendee')

@section('content')
    <div class="mb-8">
        <a href="{{ route('attendees.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">← Back to attendees</a>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-gray-900">Add an attendee</h1>
        <p class="mt-2 text-sm text-gray-500">Create an attendee account and optionally register them for an event.</p>
    </div>

    <form method="POST" action="{{ route('attendees.store') }}" data-disable-on-submit class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Full name <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" autocomplete="name" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="Jordan Lee">
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email address <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="jordan@example.com">
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Temporary password <span class="text-red-500">*</span></label>
                <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="At least 8 characters">
            </div>
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password <span class="text-red-500">*</span></label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" placeholder="Enter the password again">
            </div>
            <div class="sm:col-span-2">
                <label for="event_id" class="mb-1.5 block text-sm font-medium text-gray-700">Register for an event <span class="font-normal text-gray-400">· optional</span></label>
                <select id="event_id" name="event_id" @disabled($events->isEmpty()) class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 disabled:bg-gray-50 disabled:text-gray-400">
                    <option value="">Do not register yet</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->name }} · {{ $event->starts_at->format('M j, Y') }}</option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-gray-500">{{ $events->isEmpty() ? 'Create an event first to register attendees.' : 'The attendee will be added to the event registration list.' }}</p>
            </div>
        </div>
        <div class="mt-8 flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="{{ route('attendees.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Cancel</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save attendee</button>
        </div>
    </form>
@endsection
