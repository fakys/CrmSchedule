Начало работы
====================================

1. Копируем шаблон .env:
```shell script
cp .env.example .env
```

3. Собираем образ
```shell script
docker compose -f docker/docker-compose.yml up -d
```

4. Устанавливаем зависимости и конфигурируем приложения
```shell script
docker compose -f docker/docker-compose.yml exec app bash -c "composer install && php artisan key:generate && php artisan migrate"
```
5. Заполняем базу данных необходимыми данными
```shell script
`docker compose -f docker/docker-compose.yml exec -T db psql -U schedule -d schedule < docker/postgres/seeder_base_data/seeder_base_data.sql `
``` 

6. Создаём директории кэша затёртые при подключении volume
```shell script
docker compose -f docker/docker-compose.yml exec app sh -c \
"mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views"
``` 


Тестирование
====================================

1. Настройка тестовой среды
```shell script
cp .env.example .env && docker compose -f docker/docker-compose.yml exec test-app sh -c \
"php artisan migrate"
``` 
