<?php

namespace App\View\Components;

use Illuminate\View\Component;

class formElements extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $qoute;
    public $units;
    public $currencies;
    
    public function __construct($qoute, $units, $currencies)
    {
            $this->qoute = $qoute;
            $this->units = $units;
            $this->currencies = $currencies;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-elements');
    }
}
