@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="flex flex-col items-center justify-center h-screen px-6 text-center dark:bg-gray-900">
    <h1 class="mb-3 text-2xl font-semibold text-gray-800 dark:text-white">Verify your email address</h1>
    <p class="max-w-md mb-6 text-gray-600 dark:text-gray-400">
        We've sent a verification link to your email. Please check your inbox to continue.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg dark:bg-green-900/20 dark:text-green-400">
            A new verification link has been sent to your email!
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit"
            class="px-5 py-2 text-sm font-medium text-white rounded-md bg-brand-500 hover:bg-brand-600">
            Resend verification email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit"
            class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-800 dark:text-white">
            Log out
        </button>
    </form>
</div>
@endsection