<?php

namespace App\Src\Html;

class Html
{
    public static function miniSelect($name, $label, $data, $value='')
    {
        return view('Html::form_inputs.mini_select', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value]);
    }
    public static function baseSelect($name, $label, $data, $value='')
    {
        return view('Html::form_inputs.base_select', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value]);
    }
    public static function textInput($name, $label,  $value='')
    {
        return view('Html::form_inputs.text_input', ['name'=>$name, 'label'=>$label, 'value'=>$value]);
    }
    public static function checkbox($name, $label,  $value=''){
        return view('Html::form_inputs.checkbox', ['name'=>$name, 'label'=>$label, 'value'=>$value]);
    }
    public static function js_table($fields, $data)
    {
        return view('Html::tables.js_table', ['fields'=>$fields, 'data'=>$data]);
    }

}
