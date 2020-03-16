FROM phpdockerio/php73-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update

# Install selected extensions and other stuff
RUN apt-get -y --no-install-recommends install \
    php-xdebug \
    php7.3-gd \
    php7.3-gmp \
    php-imagick \
    php7.3-intl \
    php7.3-xmlrpc \
    php-yaml

# Install git
RUN apt-get -y install git

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Composer install
#ARG COMPOSER_ALLOW_SUPERUSER=1
#RUN /usr/local/bin/composer install --no-interaction --working-dir=/application/docs-generator

#RUN /usr/bin/php /application/docs-generator/generator.php
