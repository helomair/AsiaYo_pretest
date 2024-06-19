FROM php:8.3.0

RUN apt-get update -y && apt-get install -y git zip unzip curl 
COPY --from=composer:2.7.2 /usr/bin/composer /usr/local/bin/composer
RUN git clone https://github.com/helomair/AsiaYo_pretest.git /AsiaYo_pretest

WORKDIR /AsiaYo_pretest

RUN cp .env.example .env
RUN composer install
RUN php artisan key:generate
RUN touch database/database.sqlite && php artisan migrate -n
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]