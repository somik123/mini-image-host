<?php

$protocol = "https://";
$domain = "example.com";

$site_name = "Mini Image Host"; // Site name

$contact = "mailto:mail@example.com"; // Contact email

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
    'image/webp',
    'image/avif'
);

$admin_key = "aQqpJghcYS9Q6T3Lqw3vhQj6dQRHmcCa"; // Change this to a strong key

$imgbb_api_key = ""; // ImgBB API key for remote uploads (optional)

$enable_external_hosts = false; // Enable hotlinking from other sites

$enable_short_links_for_external_hosts = true; // Enable short links for external links

$files_per_page = 20; // Number of images to show per page

$imageperl_api_key = ""; // ImagePerl CDN API key (optional)

$debug = false; // Enable debug mode