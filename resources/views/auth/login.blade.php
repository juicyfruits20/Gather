@extends('layouts.guest')

@section('title', 'Log in')

@section('content')
    <section class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm sm:p-9">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Welcome back</h1>
        <p class="mt-2 text-sm text-gray-500">Log in to manage your events and attendees.</p>

        <form method="POST" action="{{ route('login.store') }}" data-disable-on-submit class="mt-7 space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input name="remember" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                Remember me
            </label>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Log in</button>
        </form>
    </section>

    <p class="mt-6 text-center text-sm text-white/80">New to Gather? <a href="{{ route('register') }}" class="font-semibold text-white hover:text-emerald-100">Create an account</a></p>
@endsection
