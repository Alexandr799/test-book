# Каталог книг на Yii2

Тестовое задание - небольшой каталог книг с использованием Yii2 и MySQL.

## Требования

- Docker
- Docker Compose

## Установка и запуск

1. Клонируйте репозиторий

2. Настройте права доступа (ВАЖНО для корректной работы с файлами):
```bash
./setup-permissions.sh
```
Этот скрипт создаст `docker.env` с UID/GID текущего пользователя.

Альтернативный вариант (ручная настройка):
```bash
cp docker.env.example docker.env
# Отредактируйте USER_ID и GROUP_ID на значения из команд:
# id -u  # ваш USER_ID
# id -g  # ваш GROUP_ID
```

3. Запустите Docker-контейнеры:
```bash
docker-compose up -d --build
```

4. Установите зависимости Composer:
```bash
docker-compose exec php composer install
```

5. Выполните миграции:
```bash
docker-compose exec php php yii migrate
```

6. Приложение будет доступно по адресу: http://localhost:8080

## Структура проекта

- `web/` - публичная директория
- `controllers/` - контроллеры
- `models/` - модели
- `views/` - представления
- `config/` - конфигурационные файлы
- `migrations/` - миграции базы данных
- `docker/` - Docker-конфигурация

## Полезные команды

```bash
# Остановить контейнеры
docker-compose down

# Просмотр логов
docker-compose logs -f

# Войти в контейнер PHP
docker-compose exec php sh

# Выполнить команды Yii
docker-compose exec php php yii <command>
```

## Порты

- **8080** - Веб-интерфейс (nginx)
- **3306** - MySQL

## База данных

- **Хост**: localhost (из хоста) или mysql (внутри контейнера)
- **Порт**: 3306
- **База данных**: yii2_books
- **Пользователь**: yii2_user
- **Пароль**: yii2_password

## Права доступа

Проект настроен для работы с правами вашего локального пользователя:
- Все файлы, создаваемые в контейнере, будут иметь ваши UID/GID
- Вы сможете свободно редактировать файлы на хосте без проблем с правами
- При переносе на другой компьютер просто запустите `./setup-permissions.sh`

**Важно**: Файл `docker.env` содержит ваши USER_ID и GROUP_ID. 
При клонировании проекта на другой компьютер обязательно запустите `./setup-permissions.sh` заново!

