FROM php:7.4-cli

COPY . /usr/src/backend-news-laravel-api

WORKDIR /usr/src/backend-news-laravel-api

CMD [ "/bin/bash" ]

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

#Create system user to run Composer and Artisan Commands
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


