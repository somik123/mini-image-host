<?php

$protocol = "https://";
$domain = "example.com";

$image_path = "./i/"; // path to image upload folder in filesystem
$image_url = "/i/";   // url to image

$thumb_path = "./t/"; // path to image thumbnail upload folder in filesystem
$thumb_url = "/t/";   // url to image thumbnail

$mirror_list = array(
    $domain => "",
    "example.net" => "example.net" // domain for second mini-image-host site (remove if not needed)
);

$max_file_size = 25 * 1024 * 1024; // In bytes, for file uploads

$max_image_size = 800; // In Pixles, images bigger then this will be resized

$allowed_types = array(
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp'
);

$admin_key = "aQqpJghcYS9Q6T3Lqw3vhQj6dQRHmcCa"; // Change this to a strong key

$enable_external_hosts = false; // Enable hotlinking from other sites

