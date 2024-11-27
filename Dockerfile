# Используем официальный образ PHP с нужной версией
FROM php:8.2-fpm

# Устанавливаем необходимые системные зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем Node.js и npm для фронтенд-зависимостей
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Копируем проект в контейнер
COPY . /var/www/html

# Настроим рабочую директорию
WORKDIR /var/www/html

# Устанавливаем зависимости с помощью Composer
RUN composer install --no-dev --optimize-autoloader

# Устанавливаем фронтенд зависимости
RUN npm install
RUN npm run prod

# Копируем конфиг для Nginx (если нужно, создайте свой nginx.conf)
COPY ./nginx.conf /etc/nginx/nginx.conf

# Устанавливаем права на папки Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Открываем порт для PHP
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
