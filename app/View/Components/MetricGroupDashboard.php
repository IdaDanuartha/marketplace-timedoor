<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MetricGroupDashboard extends Component
{
    public $metrics;
    /**
     * Create a new component instance.
     */
    public function __construct($metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.metric-group-dashboard');
    }
}
