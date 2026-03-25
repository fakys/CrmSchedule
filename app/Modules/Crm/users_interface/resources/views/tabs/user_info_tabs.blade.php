<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о пользователе</div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    Общая информация
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Фамилия</div>
                        <div class="col">{{isset($data['info']->last_name)?$data['info']->last_name:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Имя</div>
                        <div class="col">{{isset($data['info']->first_name)?$data['info']->first_name:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Отчество</div>
                        <div class="col">{{isset($data['info']->patronymic)?$data['info']->patronymic:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Email</div>
                        <div class="col">{{isset($data['info']->email)?$data['info']->email:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер телефона</div>
                        <div class="col">+7 {{isset($data['info']->number_phone)?$data['info']->number_phone:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Дата рождения</div>
                        <div class="col">{{isset($data['info']->birthday)?$data['info']->birthday:"Нет данных"}}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Документы
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">ИНН</div>
                        <div class="col">{{isset($data['documents']->inn)?$data['documents']->inn:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Серия</div>
                        <div class="col">{{isset($data['documents']->passport_series)?$data['documents']->passport_series:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col">{{isset($data['documents']->passport_number)?$data['documents']->passport_number:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">СНИЛС</div>
                        <div class="col">{{isset($data['documents']->snils)?$data['documents']->snils:"Нет данных"}}</div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Адрес</div>
                        <div class="col">{{isset($data['documents']->address)?$data['documents']->address:"Нет данных"}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
