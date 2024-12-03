<?php

namespace App\View\Components;

use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormStandar extends Component
{
    /**
     * Create a new component instance.
     */
    public $tahunPeriodes;
    public $lembagaAkreditasis;
    public function __construct()
    {
        $this->tahunPeriodes = TahunPeriode::all();
        $this->lembagaAkreditasis = LembagaAkreditasi::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-standar', [
            'tahunPeriodes' => $this->tahunPeriodes,
            'lembagaAkreditasis' => $this->lembagaAkreditasis
        ]);
    }
}
