FROM php:8.1-fpm-alpine

# Аргументы для UID/GID пользователя хоста
ARG USER_ID=1000
ARG GROUP_ID=1000

# Устанавливаем зависимости
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    bash \
    git \
    unzip \
    shadow

# Устанавливаем расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mysqli \
        zip \
        intl \
        mbstring \
        opcache

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаём пользователя с UID/GID хоста
RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    if getent group ${GROUP_ID} >/dev/null; then \
        GROUP_NAME=$(getent group ${GROUP_ID} | cut -d: -f1); \
    else \
        addgroup -g ${GROUP_ID} hostgroup && GROUP_NAME=hostgroup; \
    fi && \
    if getent passwd ${USER_ID} >/dev/null; then \
        deluser $(getent passwd ${USER_ID} | cut -d: -f1); \
    fi && \
    adduser -D -u ${USER_ID} -G ${GROUP_NAME} hostuser; \
fi

# Настраиваем рабочую директорию
WORKDIR /var/www/html

CMD ["php-fpm"]

