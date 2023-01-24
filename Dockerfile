FROM alpine:latest

RUN apk update && apk add \
    php \
    php-dom \
    php-xml \
    php-xmlwriter \
    php-tokenizer \
    php-pdo_mysql \
    composer \
    mysql-client

COPY . /app

WORKDIR /app

RUN composer install

CMD ["./bin/start.sh"]