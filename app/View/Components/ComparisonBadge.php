<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComparisonBadge extends Component
{
    public $diff;
    public $prefix;
    public $suffix;
    public $label;
    public $rate;

    /**
     * Create a new component instance.
     */
    public function __construct($diff, $prefix = '', $suffix = '', $label = '前月比', $rate = 0)
    {
        $this->diff = $diff;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->label = $label;
        $this->rate = $rate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comparison-badge');
    }
}
