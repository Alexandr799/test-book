# Каталог книг на Yii2

Тестовое задание - небольшой каталог книг с использованием Yii2 и MySQL.

## Требования

- Docker
- Docker Compose

## Установка и запуск

### 1. Клонируйте репозиторий

```bash
git clone <repository-url>
cd test_task_yii2
```

### 2. Создайте .env файл

```bash
cp .env.example .env
```

Отредактируйте `.env` и укажите свои настройки (при необходимости):

```env
# Application
YII_DEBUG=true
YII_ENV=dev

# Database
DB_HOST=mysql
DB_NAME=yii2_books
DB_USER=yii2_user
DB_PASSWORD=yii2_password

# SMSPilot API (вставьте свой ключ или оставьте пустым для эмулятора)
SMSPILOT_API_KEY=
```

### 3. Настройте права доступа (ВАЖНО для корректной работы с файлами)

```bash
./setup-permissions.sh
```

Этот скрипт создаст `docker.env` с UID/GID текущего пользователя.

**Альтернативный вариант (ручная настройка):**
```bash
cp docker.env.example docker.env
# Отредактируйте USER_ID и GROUP_ID на значения из команд:
id -u  # ваш USER_ID
id -g  # ваш GROUP_ID
```

### 4. Запустите Docker-контейнеры

```bash
docker-compose up -d --build
```

### 5. Проверьте работу

Откройте в браузере: **http://localhost:8080**

## Данные для входа

- **Логин:** admin
- **Пароль:** admin123

## Функциональность

### Для всех пользователей (неавторизованных):
- ✅ Просмотр каталога книг
- ✅ Просмотр авторов
- ✅ Просмотр отчёта по авторам за год
- ✅ Подписка на SMS-уведомления о новых книгах

### Для авторизованных пользователей:
- ✅ Все возможности гостя +
- ✅ Создание книг с загрузкой обложек
- ✅ Редактирование книг
- ✅ Удаление книг
- ✅ Создание/редактирование/удаление авторов

## Структура проекта

```
test_task_yii2/
├── components/           # Компоненты приложения
│   └── sms/              # SMS сервисы
│       ├── SmsSendableInterface.php      # Интерфейс отправки
│       ├── SmsPilotService.php           # SMSPilot реализация
│       ├── SmsEmulatorService.php        # Эмулятор для разработки
│       └── SmsNotificationService.php    # Основной сервис уведомлений
├── controllers/          # Контроллеры
│   ├── AuthorController  # CRUD авторов
│   ├── BookController    # CRUD книг
│   ├── ReportController  # Отчёты
│   └── SiteController    # Главная, подписка
├── models/               # Модели
│   ├── User.php          # Пользователь
│   ├── Author.php        # Автор
│   ├── Book.php          # Книга (использует smsService через DI)
│   └── Subscription.php  # Подписка
├── migrations/           # Миграции БД
├── views/                # Представления
│   ├── author/           # Страницы авторов
│   ├── book/             # Страницы книг
│   ├── report/           # Отчёты
│   └── site/             # Главная и подписка
├── web/uploads/          # Загруженные обложки книг
├── .env                  # Переменные окружения (как в Laravel)
└── docker/               # Docker-конфигурация
```

## Полезные команды

### Docker

```bash
# Остановить контейнеры
docker-compose down

# Перезапустить
docker-compose restart

# Просмотр логов
docker-compose logs -f

# Войти в контейнер PHP
docker-compose exec php sh
```

### Yii2 Console

```bash
# Выполнить миграции
docker-compose exec php php yii migrate

# Откатить миграцию
docker-compose exec php php yii migrate/down

# Создать новую миграцию
docker-compose exec php php yii migrate/create <name>
```

## Основные страницы

- **Главная:** http://localhost:8080
- **Книги:** http://localhost:8080/book/index
- **Авторы:** http://localhost:8080/author/index
- **Отчёт:** http://localhost:8080/report/top-authors
- **Подписка:** http://localhost:8080/site/subscribe
- **Вход:** http://localhost:8080/site/login

## Технические детали

### База данных

- **Хост:** localhost (из хоста) или mysql (внутри контейнера)
- **Порт:** 3306
- **База данных:** yii2_books
- **Пользователь:** yii2_user
- **Пароль:** yii2_password

### Порты

- **8080** - Веб-интерфейс (nginx)
- **3306** - MySQL

### Структура БД

- **user** - пользователи системы
- **author** - авторы книг (ФИО)
- **book** - книги (название, год, описание, ISBN, обложка)
- **book_author** - связь many-to-many между книгами и авторами
- **subscription** - подписки на SMS-уведомления

## Права доступа

Проект настроен для работы с правами вашего локального пользователя:
- Все файлы, создаваемые в контейнере, будут иметь ваши UID/GID
- Вы сможете свободно редактировать файлы на хосте без проблем с правами
- При переносе на другой компьютер просто запустите `./setup-permissions.sh`

**Важно**: Файл `docker.env` содержит ваши USER_ID и GROUP_ID. 
При клонировании проекта на другой компьютер обязательно запустите `./setup-permissions.sh` заново!

## SMS-уведомления

### Как это работает

При создании новой книги система автоматически отправляет SMS-уведомления всем активным подписчикам.

**Процесс:**
1. Пользователь подписывается на уведомления через страницу `/site/subscribe`
2. Номер телефона сохраняется в таблице `subscription`
3. При создании книги (метод `afterSave` модели `Book`) вызывается `sendNotifications()`
4. Система находит всех активных подписчиков и отправляет им SMS

### Текущая реализация (эмулятор)

В текущей версии используется эмулятор - сообщения логируются в файл `runtime/logs/app.log`:

```php
Yii::info("SMS to {$subscription->phone}: Новая книга добавлена: {$this->title}", 'sms');
```

**Просмотр логов SMS:**
```bash
docker-compose exec php tail -f runtime/logs/app.log | grep "SMS to"
```

### Интеграция с реальным SMS-сервисом (SMSPilot)

Система уже интегрирована с [SMSPilot API](https://smspilot.ru/apikey.php?tab=api1)! Для активации реальной отправки SMS:

**1. Получите API-ключ:**
- Зарегистрируйтесь на [smspilot.ru](https://smspilot.ru)
- Получите API-ключ в [личном кабинете](https://smspilot.ru/my-settings.php)

**2. Добавьте API-ключ в `.env`:**
```env
SMSPILOT_API_KEY=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

**3. Готово!** Изменения применятся автоматически при следующем запросе.

**Готово!** Теперь при создании новой книги SMS будут отправляться реально через SMSPilot.

**Проверка работы:**
1. Подпишитесь на уведомления: http://localhost:8080/site/subscribe
2. Создайте новую книгу (нужна авторизация)
3. Проверьте логи: `docker-compose exec php tail runtime/logs/app.log`

**Без API-ключа** система работает в режиме эмулятора - SMS логируются в `runtime/logs/app.log`.

**Конфигурация через .env:**
Проект использует `.env` файл для всех настроек (как в Laravel). Все переменные из `.env` доступны через `$_ENV['VARIABLE_NAME']`.

### Архитектура SMS-сервисов

Система использует **Dependency Injection** и **Strategy Pattern** для гибкой работы с SMS:

**Компоненты:**
- `SmsSendableInterface` - интерфейс для любого SMS провайдера
- `SmsPilotService` - реализация для SMSPilot API
- `SmsEmulatorService` - эмулятор для разработки
- `SmsNotificationService` - основной сервис уведомлений

**Использование в коде:**
```php
// Отправка SMS через DI контейнер
Yii::$app->smsService->send('+79001234567', 'Тестовое сообщение');

// Уведомление всех подписчиков
Yii::$app->smsService->notifyNewBook('Война и мир');
```

**Автоматический выбор провайдера:**
- Если `SMSPILOT_API_KEY` в `.env` задан → используется реальная отправка через SMSPilot
- Если пустой → используется эмулятор (логирование)

**Добавление нового SMS провайдера:**
1. Создайте класс, реализующий `SmsSendableInterface`
2. Зарегистрируйте в `config/web.php`

Пример для SMS.ru:
```php
class SmsRuService implements SmsSendableInterface {
    public function send(string $phone, string $message): array {
        // Реализация для SMS.ru API
    }
}
```

**Стоимость:** Согласно [тарифам SMSPilot](https://smspilot.ru/price.php), стоимость SMS в России от 1.5₽ за сообщение.

### Альтернативные SMS-сервисы

Вы также можете использовать другие сервисы:
- **Twilio** - международный сервис
- **SMS.ru** - российский сервис
- **SMSC.ru** - российский сервис
- **Любой API** - адаптируйте метод под ваш API

### Формат телефона

Система принимает номера в формате: `+79XXXXXXXXX` (международный формат)

Валидация настроена в модели `Subscription`:
```php
['phone', 'match', 'pattern' => '/^\+?[0-9]{10,15}$/', 'message' => 'Некорректный формат телефона']
```

## Отчёт "Топ-10 авторов"

Показывает список 10 авторов, выпустивших наибольшее количество книг за указанный год.
Год можно выбрать через форму на странице отчёта.

## Тестовые данные

В проекте уже добавлены:
- 1 пользователь: admin/admin123
- 10 авторов русской классики
- 10 книг (некоторые за 2024-2025 года для демонстрации отчёта)

## Разработка

### Добавление новых миграций

```bash
docker-compose exec php php yii migrate/create <migration_name>
```

### Работа с Gii (генератор кода)

Gii доступен по адресу: http://localhost:8080/gii

## Лицензия

MIT

## Автор

Разработано в рамках тестового задания
