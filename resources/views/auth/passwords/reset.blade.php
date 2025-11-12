@extends('layouts.auth')
@section('title','Forgot Password')
@section('content')
<div class="flex flex-col items-center justify-center h-screen px-6 text-center dark:bg-gray-900">
  <h1 class="text-xl font-semibold">Reset Password</h1>

  @if($errors->any())
    <div class="p-3 rounded bg-red-50 text-red-600">{{ $errors->first() }}</div>
  @endif

  <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ request('email', $email ?? '') }}">

    <label class="block text-sm font-medium">New Password</label>
    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>

    <label class="block text-sm font-medium">Confirm Password</label>
    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Change Password</button>
  </form>
</div>
@endsection