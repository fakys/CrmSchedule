{{\App\Src\Html\Html::select_search('Группы', 'groups', $groups, $cash_data?is_array($cash_data)?$cash_data['groups']:[$cash_data['groups']]:[], 'select_group', true, true, $cash_data)}}
{{\App\Src\Html\Html::select_search('Тип недель', 'plan_type', $plan_types, $cash_data?[$cash_data['plan_type']]:[], 'plan_type', false, true, $cash_data)}}
