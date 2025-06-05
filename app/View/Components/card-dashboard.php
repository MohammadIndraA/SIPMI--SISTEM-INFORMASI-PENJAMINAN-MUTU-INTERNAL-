<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class cardDashboard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public $title,  public $count)
    {
        $this->title = $title;
        $this->count = $count;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-dashboard');
    }
}
