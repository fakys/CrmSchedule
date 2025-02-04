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
    public static function checkbox($name, $label = false,  $value='', $class=''){
        return view('Html::form_inputs.checkbox', ['name'=>$name, 'label'=>$label, 'value'=>$value, 'class'=>$class]);
    }
    public static function js_table($fields, $data, $url='')
    {
        return view('Html::tables.js_table', ['fields'=>$fields, 'data'=>$data, 'url'=>$url]);
    }

    public static function nav_tabs($arr)
    {
        return view('Html::nav_tabs', ['arr'=>$arr]);
    }

    public static function select_search($label, $name,$data = [] , $value = [], $class = '')
    {
        return view('Html::form_inputs.select_search', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value, 'class'=>$class]);
    }

    public static function select_duallistbox_multiple($label, $name,$data = [] , $value = [], $class = '')
    {
        return view('Html::form_inputs.select_search_multiple', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value, 'class'=>$class]);
    }

    public static function checkbox_2($name, $label,  $value='', $class = '')
    {
        return view('Html::form_inputs.check_box_2', ['name'=>$name, 'label'=>$label, 'value'=>$value, 'class'=>$class]);
    }
}
