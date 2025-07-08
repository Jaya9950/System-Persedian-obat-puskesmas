<?php

// app/View/Components/DashboardCard.php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $type, $value, $label, $icon;

    public function __construct($type, $value, $label, $icon)
    {
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard-card'); // pastikan nama view juga benar
    }
}