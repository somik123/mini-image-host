<?php

$protocol = "https://";
$domain = "img.l5.ca";

$image_path = "/var/www/{$domain}/public_html/i/";
$image_url = "/i/";

$thumb_path = "/var/www/{$domain}/public_html/t/";
$thumb_url = "/t/";

$mirror_list = array($domain=>"");

$max_filesize = 5 * 1024 * 1024;

$allowed_types = array( 'image/jpeg', 'image/png', 'image/gif', 'image/webp' );

