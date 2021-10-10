
# Laravel CRUD REST API (Without authentication)

## Необходимо выполнить команды по порядку!
1) service mysql stop (если включен mysql локально и порт равен 3306)
2) git clone https://github.com/dan1keen/laravel-crud-rest-api.git
3) docker-compose up -d
4) docker exec -it app bash

В app контейнере выполнить эти команды:
1) cp .env.example .env (docker-compose exec app cp .env.example .env)
2) composer install (docker-compose exec app composer install)
3) php artisan key:generate (docker-compose exec app php artisan key:generate)

## Создание таблиц и заполнение ее данными: php artisan migrate --seed

## Тестирование api можно выполнить прописав команду: php artisan test --filter NewsTest

## Создание новости:
Необходимые параметры:
```     
public function rules()
{
    return [
        'name'         => 'required|string|max:100',
        'description'  => 'required|string|max:255',
        'text'         => 'required',
        'image'        => 'required_without:image_url|image|mimes:jpg,jpeg,png', // Сам файл
        'image_url'    => 'required_without:image|string', // Если нет image, то нужно указать рабочую ссылку на файл
        'status'       => 'required|boolean',
        'published_at' => 'required|date',

    ];
}
```

## Редактирование новости:
Есть два метода POST и PUT/PATCH
Необходимые параметры:
```
curl -H "Content-Type: application/json" -X PUT -d '{"name": "Updated"}'  http://localhost:8090/api/news/1
curl -H "Content-Type: application/json" -d '{"name": "Updated"}'  http://localhost:8090/api/news/1

public function rules()
{
    return [
        'name'         => 'sometimes|string|max:100',
        'description'  => 'sometimes|string|max:255',
        'text'         => 'sometimes',
        'image'        => 'sometimes|image|mimes:jpg,jpeg,png', // если указать параметр, то нужно использовать метод POST
        'image_url'    => 'sometimes|string', // при использовании методов PUT/PATCH используйте ссылку на файл вместо параметра image
        'status'       => 'sometimes|boolean',
    ];
}
```

## Просмотр отдельной новости
```curl -H "Content-Type: application/json" http://localhost:8090/api/news/1```

## Просмотр всех новостей
```curl -H "Content-Type: application/json" http://localhost:8090/api/news```
## Для более подробного списка маршрутов: docker-compose exec app php artisan route:list
