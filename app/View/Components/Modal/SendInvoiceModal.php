<?php

namespace App\View\Components\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SendInvoiceModal extends Component
{
    public $confirmText;
    public $cancelText;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $confirmText = 'Confirm',
        $cancelText = 'Cancel'
    ) {
        $this->confirmText = $confirmText;
        $this->cancelText = $cancelText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.send-invoice-modal');
    }
}
