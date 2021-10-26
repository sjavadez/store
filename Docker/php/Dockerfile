FROM php:7.4-fpm
ENV TZ=Asia/Tehran
ENV ACCEPT_EULA=Y
WORKDIR /var/www

RUN apt-get -y update && apt-get -y install libssl-dev libcurl4-openssl-dev wget zip apt-utils libzip-dev libxml2-dev \
                                            libssh-dev git supervisor cron zlib1g-dev libjpeg62-turbo-dev libpng-dev \
                                            libxpm-dev libfreetype6-dev iputils-ping redis-server
RUN apt-get -y install nodejs npm
RUN apt-get update -yqq \
    && apt-get install -y --no-install-recommends openssl \
    && sed -i 's,^\(MinProtocol[ ]=\).,\1'TLSv1.0',g' /etc/ssl/openssl.cnf \
    && sed -i 's,^\(CipherString[ ]=\).,\1'DEFAULT@SECLEVEL=1',g' /etc/ssl/openssl.cnf\
    && rm -rf /var/lib/apt/lists/*

RUN pecl config-set php_ini $PHP_INI_DIR/php.ini
RUN docker-php-ext-install  curl bcmath zip iconv xml soap sockets pcntl pdo pdo_mysql simplexml gd
#gd2 iconv simplexml zlib

COPY supervisor/horizon.conf /etc/supervisor/conf.d
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN printf '[PHP]\ndate.timezone="Asia/Tehran"\n' > /usr/local/etc/php/conf.d/tzone.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer --1
RUN rm -rf composer-setup.php && composer config --global repos.packagist composer https://packagist.org

RUN npm install -g n
RUN n stable