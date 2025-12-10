#!/bin/bash

# Скрипт для автоматической настройки прав доступа
# Создаёт docker.env с UID/GID текущего пользователя

echo "Настройка прав доступа для Docker..."

USER_ID=$(id -u)
GROUP_ID=$(id -g)

cat > docker.env << EOF
# Database Configuration
DB_NAME=yii2_books
DB_USER=yii2_user
DB_PASSWORD=yii2_password
MYSQL_ROOT_PASSWORD=root_password

# User permissions (auto-detected)
USER_ID=${USER_ID}
GROUP_ID=${GROUP_ID}

# SMSPilot API (оставьте пустым для использования эмулятора)
# Получить ключ: https://smspilot.ru/my-settings.php
SMSPILOT_API_KEY=
EOF

echo "✓ Файл docker.env создан"
echo "  USER_ID=${USER_ID}"
echo "  GROUP_ID=${GROUP_ID}"
echo ""
echo "Теперь можно запустить: docker-compose up -d --build"

