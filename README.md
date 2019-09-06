## Цель задачи
Запуск командой `./vendor/bin/codecept run` 3-х тестов должен завершиться без ошибок.

### Дано
Пользователь посылает запрос поиска свободного доменного имени.

Система должна перебрать варианты в поддерживаемых доменных зонах (TLD - .com/.net/.club), 
установить возможность регистрации и предоставить цены на каждую зону.

Домен считается доступным для регистрации, если его нет в таблице `domain` в базе.

Цены устанавливаются на TLD в отдельной таблице `tld` в базе.

Формат запроса: `/domains/check?search=new-domain`

Формат ответа в json:
```
[
{domain: "new-domain.com", tld: "com", available: false, "price": 8.99},
{domain: "new-domain.net", tld: "net", available: true, "price": 9.99},
{domain: "new-domain.club", tld: "club", available: true, "price": 15.99}
]
```
### Установка пакетов
~~~
composer install
~~~

### Создание таблиц
~~~
./yii migrate
~~~

### Запуск тестов
~~~
./vendor/bin/codecept run
~~~
