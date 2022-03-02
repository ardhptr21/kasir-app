<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public string $type;
    public string $value;
    public string $placeholder;
    public bool $isEdit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $placeholder, string $name = '',  bool $isEdit = false, string $type = "text", string $value = "",)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->isEdit = $isEdit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
