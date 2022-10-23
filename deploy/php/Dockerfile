FROM php:7.4-apache

ENV APACHE_RUN_DIR=/app
ENV APACHE_LOG_DIR=/var/log
ENV APACHE_RUN_USER=www-data
ENV APACHE_PID_FILE=apache.pid
ENV APACHE_RUN_GROUP=www-data
#RUN  apt update && apt install \
#	git  \
#	curl \
#	freetype \
#	libintl  \
#	libxml2   \
#  docker-php-ext-configure gd --with-freetype --with-jpeg
#        php7.4-gd php7.4-zip php7.4-soap php7.4-curl \
#        php7.4-mbstring php7.4-exif php7.4-intl \ 
#	      php7.4-session php7.4-xmlwriter php7.4-openssl\
#        php7.4-bcmath php7.4-opcache php7.4-iconv \
#        php7.4-soap php7.4-pdo  php7.4-ctype php7.4-xml \
#	#necesarios para instalar composer
#	php7.4-json php7.4-phar bash bash-completion \
#	# modulo para mysql
#	php7.4-pdo_mysql mysql-client 
#	#php7.4-pdo_pgsql postgresql-client
RUN  apt update && apt install -y \
	git  \
	curl \
	libxml2 zlib1g zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip mbstring

#RUN ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf
#RUN chmod 700 \
#	/usr/local/bin/docker-php-entrypoint \
#        /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin 

ENV PHP_ENABLE_XDEBUG=0 \
    PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    TERM=linux \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.7 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    APACHE_LOG_DIR=/var/log/apache2

WORKDIR /app	

#RUN mkdir /bootstrap && chown apache.apache /app && chmod 755 /app \
	#&& chown -R apache.apache /var/log/apache2
#ADD start.sh /bootstrap/start.sh
#RUN chmod +x /bootstrap/start.sh 

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

EXPOSE 9880 9881

COPY ./apache2 /etc/apache2

RUN a2enmod rewrite


#USER apache

#ENTRYPOINT ["/bootstrap/start.sh"]

