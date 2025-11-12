@extends('layouts.app')
@section('title', 'Payment Success')

@section('content')
<div class="max-w-xl mx-auto text-center py-10">
  <h1 class="text-2xl font-bold text-green-600 mb-4">Payment Successful!</h1>
  <p class="text-gray-700 dark:text-gray-300">Thank you for your purchase. Your order <strong>{{ $order->code }}</strong> is being processed.</p>
  <a href="{{ route('shop.products.index') }}" class="mt-6 inline-block px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Continue Shopping</a>
</div>
@endsection