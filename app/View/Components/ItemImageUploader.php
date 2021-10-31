<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ItemImageUploader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $units;
    public function __construct($units)
    {
        $this->units = $units;  
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item-image-uploader');
    }
}
