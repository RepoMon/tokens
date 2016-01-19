FROM php:latest

MAINTAINER Tim Rodger <tim.rodger@gmail.com>

EXPOSE 80

RUN apt-get update -qq && \
    apt-get install -y \
    curl \
    libicu-dev \
    zip \
    unzip \
    git

# install bcmath and mbstring for videlalvaro/php-amqplib
RUN docker-php-ext-install bcmath mbstring

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/bin/composer

CMD ["/home/app/run-all.sh"]

# Move application files into place
COPY src/ /home/app/

WORKDIR /home/app

# Install dependencies
RUN composer install --prefer-dist && \
    apt-get clean

WORKDIR /home/app/public

RUN chmod +x /home/app/run.sh
RUN chmod +x /home/app/run-all.sh

# RUN /home/app/run.sh &

USER root

