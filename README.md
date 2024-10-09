**Fullstack test**


Создать таблицу
```SQL
CREATE TABLE comments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
Устанавливаем Docker c официального сайта и Docker Compose;

Собираем контейнер командой в папке проекта ```docker-compose up -d```;

Инициализируем сервер:

При запущенном контейнере в папке проекта запускаем команду ```docker-compose exec web bash```;

Запускаем сборку ```composer install```.

Выполненную работу можно увидеть здесь ```http://localhost/comments```.



Email: banlock29@gmail.com
Pavel Kovalev
