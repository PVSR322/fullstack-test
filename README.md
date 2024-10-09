**Fullstack test**



Устанавливаем Docker c официального сайта и Docker Compose;

Собираем контейнер командой в папке проекта ```docker-compose up -d```;

Инициализируем сервер:

При запущенном контейнере в папке проекта запускаем команду ```docker-compose exec web bash```;

Запускаем сборку ```composer install```.

Создать таблицу
```SQL
CREATE TABLE comments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Выполненную работу можно увидеть здесь ```http://localhost/comments```.

Использовать при ошибке записи ```chmod -R 777 src/writable``` 

Работу выполнял на выделенном сервере Ubuntu 22.04, пришлю рабочую ссылку при необходимости

Email: banlock29@gmail.com
Pavel Kovalev
