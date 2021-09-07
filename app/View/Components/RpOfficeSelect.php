<?php

namespace App\View\Components;

use App\Traits\UserInfoCollector;
use Illuminate\View\Component;

class RpOfficeSelect extends Component
{
    use UserInfoCollector;

    public $ministries = [];
    public $view_grid;
    public $is_unit_show;
    public $only_office;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($grid, $unit, $onlyoffice = false)
    {
        $this->view_grid = $grid;
        $this->is_unit_show = $unit;
        $this->only_office = $onlyoffice;

        $ministries = $this->initRPUHttp()->post(config('cag_rpu_api.get-office-ministry-list'), ['all' => 1])->json();
        $ministries = isSuccess($ministries) ? $ministries['data'] : [];

        $this->ministries = $ministries;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $ministries = $this->ministries;

        return view('components.rp-office-select', compact('ministries'));
    }
}