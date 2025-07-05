# Use ubuntu 24.04
FROM ubuntu:24.04 AS base

# Set required environmental variables
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Singapore
ENV PHP_VERSION=8.3

# Install dependencies
RUN apt update \
    && apt install -y software-properties-common curl zip nginx nano sqlite3 \
    && apt install -y \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-imagick \
        php${PHP_VERSION}-xmlrpc \
        php${PHP_VERSION}-sqlite3 \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-fpm \
    && apt clean all \
    && rm -rf /var/lib/apt/lists/* /var/tmp/*

# Copy startup file
COPY start.sh /start.sh
# Copy/create html dir
ADD  html /var/www/html

WORKDIR /var/www/html

RUN chmod +x /start.sh \
    && chown -R www-data:www-data /var/www/html \
    && sed -i -e "s/server_tokens off\;/server_tokens off\;\\n        client_max_body_size 500M\;/g" /etc/nginx/nginx.conf \
    && echo \
"server { \n\
    listen 80 default_server; \n\
    listen [::]:80 default_server; \n\
    root /var/www/html; \n\
    index index.php index.html index.htm index.nginx-debian.html; \n\
    server_name _; \n\
    location / { \n\
            try_files \$uri \$uri/ =404; \n\
    } \n\
    location ~ \.php$ { \n\
           include snippets/fastcgi-php.conf; \n\
           fastcgi_pass unix:/run/php/php${PHP_VERSION}-fpm.sock; \n\
    } \n\
}" > /etc/nginx/sites-available/default \
    && echo "\n\n\
short_open_tag = On \n\
display_errors = on \n\
error_reporting = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING \n\
error_log = error_log \n\
output_buffering = Off \n\
date.timezone = \"Asia/Singapore\" \n\
upload_max_filesize = 50M \n\
post_max_size = 50M \n\
memory_limit = 128M \n" >> /etc/php/${PHP_VERSION}/fpm/php.ini

EXPOSE 80

CMD ["sh", "/start.sh"]