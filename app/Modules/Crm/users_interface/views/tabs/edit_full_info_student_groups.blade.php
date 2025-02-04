<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о группе и специальности</div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    Информация о группе
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col">{{$user_group->number}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Название</div>
                        <div class="col">{{$user_group->name}}</div>
                    </div>

                </div>
            </div>
            @if($specialty)
                <div class="card">
                    <div class="card-header">
                        Cпециальность
                    </div>
                    <div class="card-body">
                        <div class="row pb-3">
                            <div class="col">Номер</div>
                            <div class="col">{{$specialty[0]->number?$specialty[0]->number:"Нет данных"}}</div>
                        </div>
                        <div class="row pb-3">
                            <div class="col">Название</div>
                            <div class="col">{{$specialty[0]->name?$specialty[0]->name:"Нет данных"}}</div>
                        </div>
                        <div class="row pb-3">
                            <div class="col">Описание</div>
                            <div class="col">{{$specialty[0]->description?$specialty[0]->description:'Нет данных'}}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
