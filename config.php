<?php

$protocol = "https://";
$domain = "img.l5.ca";

$image_path = "/var/www/{$domain}/public_html/i/";
$image_url = "/i/";

$thumb_path = "/var/www/{$domain}/public_html/t/";
$thumb_url = "/t/";

$mirror_list = array(
    $domain => "",
    "thinpcb.com" => "thinpcb.com"
);

$max_file_size = 25 * 1024 * 1024; // In bytes, for file uploads

$max_image_size = 800; // In Pixles, images bigger then this will be resized

$allowed_types = array(
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp'
);
