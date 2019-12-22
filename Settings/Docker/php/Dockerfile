FROM php:7.2-fpm-stretch

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libmcrypt-dev \
        libpng-dev \
        libjpeg-dev \
        libxml2-dev \
        git \
        zip \
        unzip \
        cron \
        nano \
        mcedit \
        supervisor \
    && docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-freetype-dir=/usr/include/freetype2 \
        --with-png-dir=/usr/include \
        --with-jpeg-dir=/usr/include \
    && docker-php-ext-install gd \
    && docker-php-ext-install mbstring \
    && docker-php-ext-enable gd \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip \
    && docker-php-ext-install soap \
    && docker-php-ext-enable soap

RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
	&& docker-php-ext-enable imagick

RUN apt-get update && docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

#ADD supervisor/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

#ADD cron.d/ludoman /etc/cron.d/ludoman

WORKDIR /usr/local/var/www/otus/social.network

RUN chown -R www-data:www-data /usr/local/var/www/
RUN chmod 755 /usr/local/var/www/

#RUN chown -R www-data:www-data /usr/local/var/www/otus/social.network/vendor
#RUN chown -R www-data:www-data /usr/local/var/www/otus/social.network/storage

#CMD ["/usr/bin/supervisord", "-n"]

