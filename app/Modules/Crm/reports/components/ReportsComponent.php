<?php

namespace App\Modules\Crm\reports\components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportsComponent extends Component
{
    public $fields;
    public $data;
    public $required_fields;
    public $task_name;

    public function __construct($fields, $data, $required_fields, $task_name = '')
    {
        $this->fields = $fields;
        $this->data = $data;
        $this->required_fields = $required_fields;
        $this->task_name = $task_name;
    }


    public function render(): View|Closure|string
    {
        return view('reports::components.reports_component',
            [
                'fields'=>$this->fields,
                'data'=>$this->data,
                'required_fields' => $this->required_fields,
                'task_name' => $this->task_name
            ]
        );
    }
}
