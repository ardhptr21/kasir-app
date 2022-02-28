<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class ActionData extends Component
{
    public string $detailAction;
    public string $editAction;
    public string $removeAction;
    public string $withDetail;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $detailAction, string $editAction, string $removeAction, bool $withDetail = true)
    {
        $this->detailAction = $detailAction;
        $this->editAction = $editAction;
        $this->removeAction = $removeAction;
        $this->withDetail = $withDetail;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.action-data');
    }
}
