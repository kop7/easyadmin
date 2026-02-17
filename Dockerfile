FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app
RUN chmod +x /app/docker/entrypoint.sh /app/bin/console

ENV APP_ENV=dev
ENV APP_DEBUG=1

EXPOSE 8000

ENTRYPOINT ["/app/docker/entrypoint.sh"]
