@extends('layouts.guest')

@section('title', 'Create account')

@section('content')
    <section class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm sm:p-9">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Create your account</h1>
        <p class="mt-2 text-sm text-gray-500">Get started managing events with Gather.</p>

        <form method="POST" action="{{ route('register.store') }}" data-disable-on-submit class="mt-7 space-y-5">
            @csrf
            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" autocomplete="name" autofocus class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create account</button>
        </form>
    </section>

    <p class="mt-6 text-center text-sm text-white/80">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-white hover:text-emerald-100">Log in</a></p>
@endsection
