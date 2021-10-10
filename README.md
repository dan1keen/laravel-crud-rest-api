
## Laravel CRUD REST API (Without authentication)

1) service mysql stop
2) git clone https://github.com/dan1keen/laravel-crud-rest-api.git
3) docker-compose up -d
4) docker exec -it app bash
В app контейнере выполнить эти команды:
1) cp .env.example .env
2) composer install
3) php artisan key:generate

Создание таблиц и заполнение ее данными: php artisan migrate --seed

Тестирование api можно выполнить прописав команду: php artisan test --filter NewsTest

Есть два варианта загрузки файла
1) Через POST. Необходимо прикрепить файл. пример:


