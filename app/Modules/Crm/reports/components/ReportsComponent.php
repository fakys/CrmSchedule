<?php

namespace App\Modules\Crm\reports\components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportsComponent extends Component
{
    public $fields;
    public $data;
    public $search_url;
    public $export_url;
    public $required_fields;

    public function __construct($fields, $data, $required_fields, $search_url, $export_url = '')
    {
        $this->fields = $fields;
        $this->data = $data;
        $this->search_url = $search_url;
        $this->export_url = $export_url;
        $this->required_fields = $required_fields;
    }


    public function render(): View|Closure|string
    {
        return view('components.reports_component',
            [
                'fields'=>$this->fields,
                'data'=>$this->data,
                'search_url'=>$this->search_url,
                'export_url'=>$this->export_url,
                'required_fields' => $this->required_fields,
            ]
        );
    }
}
