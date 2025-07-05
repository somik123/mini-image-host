#!/bin/sh

# Default fallback values
: "${APP_PROTOCOL:=https://}"
: "${APP_DOMAIN:=example.com}"

: "${IMAGE_PATH:=./i/}"
: "${IMAGE_URL:=/i/}"

: "${THUMB_PATH:=./t/}"
: "${THUMB_URL:=/t/}"

: "${MAX_FILE_SIZE:=26214400}"
: "${MAX_IMAGE_SIZE:=800}"
: "${ALLOWED_TYPES:=image/jpeg,image/png,image/gif,image/webp}"

# Initialize mirror list with APP_DOMAIN
mirror_list="    \"${APP_DOMAIN}\" => \"\""

# Only process MIRROR_DOMAINS if it's non-empty
if [ -n "$MIRROR_DOMAINS" ]; then
    OLD_IFS="$IFS"
    IFS=","
    for mirror in $MIRROR_DOMAINS; do
        mirror_trimmed=$(echo "$mirror" | xargs)
        if [ "$mirror_trimmed" != "$APP_DOMAIN" ] && [ -n "$mirror_trimmed" ]; then
            mirror_list="$mirror_list
    \"$mirror_trimmed\" => \"$mirror_trimmed\""
        fi
    done
    IFS="$OLD_IFS"
fi

# Build allowed types
allowed_types=""
IFS=","
for type in $ALLOWED_TYPES; do
    type_trimmed=$(echo "$type" | xargs)
    [ -n "$type_trimmed" ] && allowed_types="$allowed_types
    '$type_trimmed',"
done
IFS="$OLD_IFS"

# Output the config.php
cat > /var/www/html/config.php <<EOF
<?php

\$protocol = "${APP_PROTOCOL}";
\$domain = "${APP_DOMAIN}";

\$image_path = "${IMAGE_PATH}"; // path to image upload folder in filesystem
\$image_url = "${IMAGE_URL}";   // url to image

\$thumb_path = "${THUMB_PATH}"; // path to image thumbnail upload folder in filesystem
\$thumb_url = "${THUMB_URL}";   // url to image thumbnail

\$mirror_list = array(
$mirror_list
);

\$max_file_size = ${MAX_FILE_SIZE}; // In bytes, for file uploads

\$max_image_size = ${MAX_IMAGE_SIZE}; // In Pixles, images bigger then this will be resized

\$allowed_types = array(
$allowed_types
);
EOF

echo "config.php generated at /var/www/html/config.php"


echo "Starting services..."
service php8.3-fpm start
nginx -g "daemon off;" &
echo "Ready."
chown -R www-data:www-data /var/www/html
tail -s 1 /var/log/nginx/*.log -f