@extends('layouts.auth')
@section('title','Forgot Password')
@section('content')
<div class="flex flex-col items-center justify-center h-screen px-6 text-center dark:bg-gray-900">
  <h1 class="text-xl font-semibold">Forgot Password</h1>

  @if(session('status') || session('success'))
    <div class="p-3 rounded bg-green-100 text-green-700">{{ session('status') ?? session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="p-3 rounded bg-red-50 text-red-600">{{ $errors->first() }}</div>
  @endif

  <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
    @csrf
    <label class="block text-sm font-medium">Email</label>
    <input type="email" name="email" placeholder="Enter your email" class="w-full border rounded px-3 py-2" required>
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Send Reset Link</button>
  </form>
</div>
@endsection