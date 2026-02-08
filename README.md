
1. Копируем шаблон .env:
```shell script
cp .env.example .env
```
2. Запустить контейнеры приложения:
```shell script
docker-compose -f docker/docker-compose.yml up -d
```
3. Устанавливаем зависимости и конфигурируем приложения
```shell script
docker compose -f docker/docker-compose.yml exec app bash -c "composer install && php artisan migrate && php artisan key:generate && php artisan app:build-modules"
```
4. Засев бд данными:
```shell script
docker exec -i schedule_pgsql psql -U schedule -d schedule < docker/postgres/seeder_base_data/seeder_base_data.sql
```
