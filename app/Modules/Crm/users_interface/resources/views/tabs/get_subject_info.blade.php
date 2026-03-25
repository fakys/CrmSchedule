<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о предмете</div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <div class="row pb-3">
                    <div class="col">Название</div>
                    <div class="col">{{$subject->name}}</div>
                </div>
                <div class="row pb-3">
                    <div class="col">Полное название</div>
                    <div class="col">{{$subject->full_name}}</div>
                </div>
                <div class="row pb-3">
                    <div class="col">Описание</div>
                    <div class="col">{{$subject->description??'Нет данных'}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
