<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ItemImageUploder extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $units;
    public function __construct($units_var)
    {
        $this->units = $units_var;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ItemImageUploader1');
    }
}
