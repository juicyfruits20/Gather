<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Events') · Gather</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 font-sans text-slate-900 antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="flex w-full shrink-0 flex-col border-b border-slate-200 bg-white lg:sticky lg:top-0 lg:h-screen lg:min-h-screen lg:w-64 lg:border-b-0 lg:border-r">
            <a href="{{ route('events.index') }}" class="flex h-16 items-center gap-3 border-b border-slate-100 px-6">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-sm shadow-indigo-200">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <rect x="3.5" y="5" width="17" height="16" rx="3"></rect>
                        <path d="M7.5 3v4M16.5 3v4M3.5 10h17M8 14h3m-3 3h7"></path>
                    </svg>
                </span>
                <span class="text-lg font-semibold tracking-tight">Gather<span class="text-indigo-600">.</span></span>
            </a>

            <div class="px-4 py-6">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Workspace</p>
                <nav class="mt-3 flex gap-1 overflow-x-auto lg:flex-col" aria-label="Main navigation">
                    <a href="{{ route('events.index') }}"
                       @class([
                           'flex shrink-0 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                           'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-100' => request()->routeIs('home', 'events.*'),
                           'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('home', 'events.*'),
                       ]) @if (request()->routeIs('home', 'events.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="16" rx="3"></rect>
                            <path d="M7.5 3v4M16.5 3v4M3.5 10h17"></path>
                        </svg>
                        Events
                    </a>
                    <a href="{{ route('attendees.index') }}"
                       @class([
                           'flex shrink-0 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                           'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-100' => request()->routeIs('attendees.*'),
                           'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('attendees.*'),
                       ]) @if (request()->routeIs('attendees.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="10" cy="7" r="4"></circle>
                            <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Attendees
                    </a>
                    <a href="{{ route('tickets.index') }}"
                       @class([
                           'flex shrink-0 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                           'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-100' => request()->routeIs('tickets.*'),
                           'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('tickets.*'),
                       ]) @if (request()->routeIs('tickets.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7Z"></path>
                            <path d="M13 5v2m0 3v2m0 3v2m0 2v1"></path>
                        </svg>
                        Tickets
                    </a>
                </nav>
            </div>

            <div class="mt-auto hidden border-t border-slate-100 p-4 lg:block">
                <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-violet-50 p-4">
                    <p class="text-sm font-semibold text-gray-900">Need a hand?</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Our support team is here to help you run your next event.</p>
                    <a href="mailto:support@example.com" class="mt-3 inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-700">Contact support <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-5 backdrop-blur-xl sm:px-8">
                <div class="flex min-w-0 items-center gap-2 text-sm">
                    <span class="hidden text-slate-400 sm:inline">Workspace</span>
                    <svg class="hidden h-4 w-4 text-gray-300 sm:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.25 4.24a.75.75 0 0 1 0 1.06l-4.25 4.24a.75.75 0 0 1-1.08 0Z" clip-rule="evenodd"></path></svg>
                    <span class="truncate font-medium text-slate-700">@yield('breadcrumb', 'Events')</span>
                </div>

                <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false" @click.outside="open = false">
                    <button type="button" class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="open = ! open" :aria-expanded="open" aria-controls="profile-menu">
                        <span class="hidden text-right sm:block">
                            <span class="block text-sm font-medium text-slate-800">{{ auth()->user()?->name ?? 'Workspace admin' }}</span>
                            <span class="block text-xs text-slate-500">{{ auth()->user()?->email ?? 'Administrator' }}</span>
                        </span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700 ring-2 ring-white shadow-sm">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                        </span>
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div id="profile-menu" x-cloak x-show="open" x-transition class="absolute right-0 mt-2 w-64 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-200/70">
                        <div class="border-b border-slate-100 px-3 py-2">
                            <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()?->name ?? 'Workspace admin' }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()?->email ?? 'Administrator account' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" data-disable-on-submit>
                            @csrf
                            <button type="submit" class="mt-1 w-full rounded-lg px-3 py-2 text-left text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900">Log out</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-8 lg:px-10">
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 shadow-sm" role="status">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700" aria-hidden="true">✓</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900 shadow-sm" role="alert">
                        <p class="font-semibold">Please review the following:</p>
                        <ul class="mt-1 list-inside list-disc space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
