# Быстрое развертывание на новом сервере

## Проблема с правами Docker

Если при запуске `docker compose up -d --build` возникает ошибка:
```
permission denied while trying to connect to the Docker daemon socket
```

### Решение:

```bash
# 1. Добавьте пользователя в группу docker
sudo usermod -aG docker $USER

# 2. Примените изменения (выберите один из вариантов):

# Вариант А: Перезайдите в систему (выйдите и войдите снова)
exit

# Вариант Б: Или используйте newgrp (без перелогина)
newgrp docker

# 3. Проверьте что права применились
docker ps

# 4. Теперь можно запускать проект
docker compose up -d --build
```

## Пошаговая установка

```bash
# 1. Клонируйте репозиторий
git clone <url> test-book
cd test-book

# 2. Создайте .env файл
cp .env.example .env
nano .env  # Укажите SMSPILOT_API_KEY если нужно

# 3. Настройте права
./setup-permissions.sh

# 4. Решите проблему с Docker (см. выше)
sudo usermod -aG docker $USER
newgrp docker

# 5. Запустите контейнеры
docker compose up -d --build

# 6. Дождитесь запуска (30-60 сек)
docker compose ps

# 7. Выполните миграции
docker compose exec php php yii migrate --interactive=0

# 8. Откройте в браузере
# http://your-server-ip:8080
```

## Проверка работы

```bash
# Статус контейнеров
docker compose ps

# Логи
docker compose logs -f php
docker compose logs -f mysql

# Перезапуск
docker compose restart

# Остановка
docker compose down

# Полная очистка с данными
docker compose down -v
```

## Учётные данные по умолчанию

- **Логин:** admin
- **Пароль:** admin123

## Порты

- **Веб-интерфейс:** 8080
- **MySQL:** 3306

