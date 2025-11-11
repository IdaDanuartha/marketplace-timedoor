@extends('layouts.auth')

@section('title', 'Choose Role')

@section('content')
<div class="flex flex-col justify-center items-center h-screen bg-white dark:bg-gray-900">
    <div class="w-full max-w-md text-center">
        <img src="{{ $googleUser['avatar'] }}" class="w-20 h-20 mx-auto rounded-full mb-4" alt="Avatar">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
            Welcome, {{ $googleUser['name'] }}!
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Choose how you want to register your account.</p>

        <form method="POST" action="{{ route('google.completeRegister') }}">
            @csrf
            <div class="space-y-4">
                <button type="submit" name="role" value="vendor"
                    class="w-full px-4 py-3 rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                    Register as Vendor
                </button>
                <button type="submit" name="role" value="customer"
                    class="w-full px-4 py-3 rounded-lg text-white bg-green-600 hover:bg-green-700">
                    Register as Customer
                </button>
            </div>
        </form>

        <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
            Not you? <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600">Sign in again</a>
        </p>
    </div>
</div>
@endsection