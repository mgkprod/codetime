<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public $label;
    public $name;
    public $required;
    public $type;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $required = false, $type = 'text', $value = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-input');
    }
}
