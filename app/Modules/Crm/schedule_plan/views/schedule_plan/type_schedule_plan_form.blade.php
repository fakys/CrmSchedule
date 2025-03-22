<div class="form-group">
    <label>Тип плана расписания</label>
    <select class="semester-select form-control" name="type_schedule_plan" id="type_schedule_plan">
        @foreach($types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
        @endforeach
    </select>
    <div class="text-sm">План для данной группы не составлен, выберите его тип</div>
</div>
