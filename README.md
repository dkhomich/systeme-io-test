## Тестовое задание Systeme.io

<details>
    <summary>Задача</summary>

Написать symfony приложение для рассчета цены продукта для покупателя

Пример:
Продавец продает два продукта
- наушники (100 евро)
- чехол для телефона (20евро)


  в трёх странах:
- Германия
- Италия
- Греция

При покупке получатель сверх цены продукта должен уплатить налог за него (аналог Российского НДС),
Налог в Германии - 19%
Италии - 22%
Греции - 24%

В итоге для покупателя из Греции цена наушников составляет 124 евро (цена продукта + налог).

У каждого покупателя есть свой tax номер следующего формата:\
DEXXXXXXXXX - для жителей Германии\
ITXXXXXXXXXXX - для жителей Италии\
GRXXXXXXXXX - для жителей Греции\
где первые два символа - это код страны, а X - это любая цифра от 0 до 9

Страница рассчёта цены продукта для покупателя должна состоять из двух полей:
1. select со списком продуктов
2. input для ввода tax номера покупателя
3. кнопка отправки формы

После отправки формы, по tax номеру нужно определить страну покупателя и рассчитать конечную стоимость выбранного продукта

Для обработки форм нужно использовать symfony form\
Для валидации - validation constraints\
При написании тестового используйте гит, после выполнения пришлите ссылку на репозиторий
</details>



### Требования к окружению
- PHP >=8.1
- docker compose

### Установка
1. ```docker compose up -d```
1. ```symfony serve -d```
1. ```symfony console doctrine:migrations:migrate```
1. ```symfony console doctrine:fixtures:load``` - для загрузки тестовых данных, указанных в задаче


### Описание
Задача реализована на основе базовой заготовки приложения Symfony 6.2\
База данных для приложения - в docker-контейнере PostgreSQL\
Отдельный веб-сервер не настраивался, предполагается запуск через встроенный веб-сервер Symfony\
Для редактирования набора тестовых данных дополнительно установлена админка EasyAdmin
