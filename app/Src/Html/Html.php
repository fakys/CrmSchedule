<?php

namespace App\Src\Html;

use App\Assets\SelectSearchBundle;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;

class Html
{
    public static function checkbox($name, $label = false,  $value='', $class=''){
        return view('Html::form_inputs.checkbox', ['name'=>$name, 'label'=>$label, 'value'=>$value, 'class'=>$class]);
    }
    public static function js_table($fields, $data, $url='')
    {
        return view('Html::tables.js_table', ['fields'=>$fields, 'data'=>$data, 'url'=>$url]);
    }

    public static function select_search($label, $name, $data = [], $value = [], $class = '', $multiple = true, $addJsCssFiles = true, $disabled = false)
    {
        return view('Html::form_inputs.select_search', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value, 'class'=>$class, 'multiple'=>$multiple, 'addJsCssFiles'=>$addJsCssFiles, 'disabled'=>$disabled]);
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
