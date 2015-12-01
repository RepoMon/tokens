FROM ubuntu:latest

MAINTAINER Tim Rodger <tim.rodger@gmail.com>

EXPOSE 80

RUN apt-get update -qq && \
    apt-get install -y \
    php5 \
    php5-cli \
    php5-intl \
    php5-fpm \
    git

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/bin/composer

CMD ["php", "-S", "0.0.0.0:80"]

# Move application files into place
COPY src/ /home/app/

# remove any development cruft
RUN rm -rf /home/app/vendor/*

# create the directory to store the checked out repositories
RUN mkdir /tmp/repositories

WORKDIR /home/app

# Install dependencies
RUN composer install --prefer-dist && \
    apt-get clean

WORKDIR /home/app/public

USER root

