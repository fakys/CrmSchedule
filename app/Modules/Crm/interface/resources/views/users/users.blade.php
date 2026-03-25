@extends('layout::base_layout')

@section('content')
    {{\App\Src\Html\Html::js_table($fields, $data)}}
@endsection
