FROM php:7.3.19-fpm-stretch

RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev tidy csstidy vim gnupg unzip libzip-dev \
    apt-transport-https ca-certificates wget

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache

RUN pecl install xdebug-2.7.1 apcu memcached-3.1.3
RUN docker-php-ext-enable apcu && docker-php-ext-enable memcached && docker-php-ext-enable xdebug

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update && apt-get install -y yarn

RUN mkdir /project
WORKDIR /project

RUN php -r 'readfile("https://getcomposer.org/installer");' > composer-setup.php \
	&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& rm -f composer-setup.php \
    && chown www-data.www-data /project

# Speedup composer
RUN composer global require hirak/prestissimo
