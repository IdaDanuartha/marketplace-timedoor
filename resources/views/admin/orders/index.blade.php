@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div x-data="orderPage()" x-cloak>
    
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-500">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
            <li>/</li>
            <li class="text-gray-700 dark:text-gray-300">Orders</li>
        </ol>
    </nav>

    <!-- Flash Messages -->
    @include('partials.flash-messages')

    <!-- Filters -->
    @include('admin.orders.partials.filters')

    <!-- Action Buttons -->
    <div class="flex justify-between items-center gap-4 mb-4">

        <!-- Button Send Invoice -->
        <button 
            x-show="selectedOrders.length > 0"
            @click="openSendInvoiceModal()"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition whitespace-nowrap flex items-center gap-2"
        >
            Send Invoices (<span x-text="selectedOrders.length"></span>)
        </button>

        <!-- Export / Create -->
        <div class="flex gap-4 ml-auto">
            <a href="{{ route('orders.export', request()->query()) }}" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition whitespace-nowrap">
                Export Excel
            </a>

            @if (auth()->user()?->admin)
                <a href="{{ route('orders.create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap text-center">
                    + Add Order
                </a>
            @endif
        </div>

    </div>

    <!-- Table -->
    @include('admin.orders.partials.table')

    {{-- Confirm Modal (Send Invoice) --}}
    <x-modal.send-invoice-modal 
        confirmText="Send Now"
        cancelText="Back"
    />

    {{-- Delete Modal --}}
    <x-modal.modal-delete />

</div>
@endsection


@push('js')
<script>
function orderPage() {
    return {
        // Global confirm modal
        isConfirmModalOpen: false,
        confirmTitle: '',
        confirmMessage: '',
        confirmAction: null,

        // Selected orders
        selectedOrders: [],
        selectedCount: 0,
        selectAll: false,

        toggleAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');

            if (this.selectAll) {
                this.selectedOrders = Array.from(checkboxes).map(el => el.value);
            } else {
                this.selectedOrders = [];
            }
        },

        updateSelectAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            this.selectAll = checkboxes.length > 0 && this.selectedOrders.length === checkboxes.length;
        },

        // Send Invoice Modal
        openSendInvoiceModal() {
            this.selectedCount = this.selectedOrders.length;
            this.confirmTitle = "Send Invoices";
            this.confirmMessage = `
                You are about to send invoice emails for 
                <b>${this.selectedCount}</b> selected order(s).<br>This action cannot be undone.
            `;

            this.confirmAction = () => this.submitSendInvoices();
            this.isConfirmModalOpen = true;
        },

        submitSendInvoices() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('orders.send-invoices') }}";

            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                ${this.selectedOrders.map(id =>
                    `<input type="hidden" name="order_ids[]" value="${id}">`
                ).join('')}
                <input type="hidden" name="send_pdf" value="1">
            `;

            document.body.appendChild(form);
            form.submit();
        },
    };
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
        width: 'resolve',
        minimumResultsForSearch: Infinity,
        dropdownAutoWidth: true,
    });
});
</script>
@endpush