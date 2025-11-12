<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecentOrdersTable extends Component
{
    public $recentOrders;

    /**
     * Create a new component instance.
     */
    public function __construct($recentOrders)
    {
        $this->recentOrders = $recentOrders;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.recent-orders-table');
    }
}
