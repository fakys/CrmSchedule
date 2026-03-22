<?php

namespace App\Src\Html;

use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use App\Src\Html\assets\SelectSearchBundle;
use App\Src\Html\assets\SelectSearchMultipleBundle;
use App\Src\Html\assets\TableJsBundle;

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
        /** @var AssetsBundleManagerInterface $asset */
        $asset = app(AssetsBundleManagerInterface::class);
        $asset->appendBundle(new TableJsBundle());
        return view('Html::tables.js_table', ['fields'=>$fields, 'data'=>$data, 'url'=>$url]);
    }

    public static function nav_tabs($arr)
    {
        return view('Html::nav_tabs', ['arr'=>$arr]);
    }

    public static function select_search($label, $name, $data = [], $value = [], $class = '', $multiple = true, $addJsCssFiles = true, $disabled = false)
    {
        /** @var AssetsBundleManagerInterface $asset */
        $asset = app(AssetsBundleManagerInterface::class);
        $asset->appendBundle(new SelectSearchBundle());
        return view('Html::form_inputs.select_search', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value, 'class'=>$class, 'multiple'=>$multiple, 'addJsCssFiles'=>$addJsCssFiles, 'disabled'=>$disabled]);
    }

    public static function select_duallistbox_multiple($label, $name,$data = [] , $value = [], $class = '')
    {
        /** @var AssetsBundleManagerInterface $asset */
        $asset = app(AssetsBundleManagerInterface::class);
        $asset->appendBundle(new SelectSearchMultipleBundle());
        return view('Html::form_inputs.select_search_multiple', ['name'=>$name, 'label'=>$label, 'data'=>$data, 'value'=>$value, 'class'=>$class]);
    }

    public static function checkbox_2($name, $label,  $value='', $class = '')
    {
        return view('Html::form_inputs.check_box_2', ['name'=>$name, 'label'=>$label, 'value'=>$value, 'class'=>$class]);
    }
}
