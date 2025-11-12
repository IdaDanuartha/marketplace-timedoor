@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="max-w-3xl mx-auto py-8 text-center">
  <h1 class="text-xl font-bold text-gray-800 dark:text-white mb-3">Payment for Order {{ $order->code }}</h1>
  <p class="text-gray-500 dark:text-gray-400 mb-6">Complete your payment securely using Midtrans</p>

  <button id="pay-button" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
    Pay Now
  </button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
document.getElementById('pay-button').addEventListener('click', function () {
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            window.location.href = "{{ route('shop.checkout.success', $order) }}";
        },
        onPending: function(result){ console.log('Waiting for payment confirmation.'); },
        onError: function(result){ console.log('Payment failed. Please try again.'); },
        onClose: function(){ console.log('Payment popup closed without finishing.'); }
    });
});
</script>
@endsection