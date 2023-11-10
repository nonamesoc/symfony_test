# symfony_test

<h2>Запуск проекта:</h2>

1. Запустить контейнеры:

```docker-compose up -d```

2. Установить composer зависимости:

```docker-compose exec app composer install```

3. Выполнить миграции для базы данных:

```docker-compose exec app php bin/console doctrine:migrations:migrate```

<h2>Api:</h2>

<ul>
<li>GET http://localhost/api/user/ - Получить список пользователей</li>
<li>GET http://localhost/api/user/{id} - Получить пользователя по id</li>
<li>POST http://localhost/api/user/ - Создать пользователя. Параметры через form data (email, name, age, sex, birthday, phone)</li>
<li>PUT http://localhost/api/user/{id} - Обновить поля пользователя по id. Обновляются поля, которые переданы в запрос</li>
<li>DELETE http://localhost/api/user/{id} - Удалить пользователя id</li>
</ul>