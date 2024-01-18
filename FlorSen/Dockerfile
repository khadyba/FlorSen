FROM webdevops/php-nginx:8.3-alpine



RUN apk add oniguruma-dev libxml2-dev
# . Installation des dépendances PHP
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        mbstring \
        pdo_mysql \
        xml
  #  Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add nodejs npm


ENV WEB_DOCUMENT_ROOT /app/public

ENV APP_ENV production

WORKDIR /app


COPY . .

RUN cp -n .env.example .env
#  Configuration de Laravel pour la production
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Installer MySQL et les extensions PHP nécessaires
# Installer les dépendances pour MySQL et les extensions PHP nécessaires
RUN apk update && \
    apk add --no-cache \
        mysql-client \
        mysql-dev \
        && docker-php-ext-install pdo_mysql

# Installer l'extension PHP pdo_mysql
RUN docker-php-ext-install pdo_mysql


RUN npm install

RUN npm run build


RUN chmod -R 777 /app/storage/


EXPOSE 9000 