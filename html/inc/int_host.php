<?php

function upload_image()
{
    global $image_path, $thumb_path, $image_url, $protocol, $domain;
    global $allowed_types, $max_file_size, $max_filesize_msg, $max_image_size;


    // Check if upload directory exists, if not create it
    if (!file_exists($image_path))
        mkdir($image_path, 0777, true);
    // Check if thumbnail directory exists, if not create it
    if (!file_exists($thumb_path))
        mkdir($thumb_path, 0777, true);
    // Get the original name of the file from the client
    $file_name = $_FILES['file']['name'];

    // Temporary name of the file in the server
    $tmp_name = $_FILES['file']['tmp_name'];

    // Ensure the file has image size parameters
    $image_info = @getimagesize($tmp_name);

    // Validate it's a real image
    if ($image_info == false)
        throw new Exception('Please upload valid image file.');

    // Validate file type is allowed
    $type = $_FILES['file']['type'];
    if (!in_array($type, $allowed_types))
        throw new Exception("Only jpg, jpeg, png, webp, and gif image type supported.");

    // Check the file size is acceptable
    if (filesize($tmp_name) > $max_file_size)
        throw new Exception("File over allowed size of {$max_filesize_msg}");

    // Get the extension of the file
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_id = rand_str(6);

    // Convert webp files into jpg image
    if ($type == 'image/webp') {
        $new_file_name = "{$file_id}.jpg";
        $new_thumb_name = "{$file_id}_thumb.jpg";

        // Convert webp to jpeg with 80% quality and save to save path
        $im = imagecreatefromwebp($tmp_name);
        imagejpeg($im, $image_path . $new_file_name, 80);
        imagedestroy($im);
    }
    // Resize image if it's JPEG and more then max_image_size in any side
    elseif ($type == 'image/jpeg' && ($image_info[0] > $max_image_size || $image_info[1] > $max_image_size)) {
        $new_file_name = "{$file_id}.jpg";
        $new_thumb_name = "{$file_id}_thumb.jpg";

        // Resize image to a smaller size
        $source = $tmp_name;
        $dest = $image_path . $new_file_name;
        resizeAndSaveImage($source, $dest, $max_image_size);
    }
    // Move the uploaded file to save path
    else {
        $new_file_name = "{$file_id}.{$file_ext}";
        $new_thumb_name = "{$file_id}_thumb.{$file_ext}";

        // Move the uploaded file to save path (for all other formats)
        move_uploaded_file($tmp_name, $image_path . $new_file_name);
    }

    // Generate thumbnails for all image types
    $source = $image_path . $new_file_name;
    $dest = $thumb_path . $new_thumb_name;
    resizeAndSaveImage($source, $dest, 150);

    // Return the image URL to the client
    $url = $protocol . $domain . $image_url . $new_file_name;
    $out = array("status" => "OK", "url" => $url);

    // Reply with JSON
    header('Content-Type: application/json');
    echo json_encode($out);
}
