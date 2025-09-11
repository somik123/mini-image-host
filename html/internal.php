<?php

// Read functions file for helper functions
require_once("inc/functions.php");

// Allow cross site posting
header("Access-Control-Allow-Origin: *");

// To print the max file size in human readable format
$max_filesize_msg = human_readable_size($max_file_size, 0);

// If file has been posted
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    try {
        if (!file_exists($image_path))
            mkdir($image_path, 0777, true);
        if (!file_exists($thumb_path))
            mkdir($thumb_path, 0777, true);
        //getting file name
        $file_name = $_FILES['file']['name'];
        //getting temp_name of file
        $tmp_name = $_FILES['file']['tmp_name'];

        // Ensure the file has image size parameters
        $image_info = @getimagesize($tmp_name);

        if ($image_info == false)
            throw new Exception('Please upload valid image file.');

        // Check the types of files that are allowed to be uploaded
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
        // Resize image if it's JPEG and more then 1200px in any side
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

        // Generate thumbnails
        $source = $image_path . $new_file_name;
        $dest = $thumb_path . $new_thumb_name;
        resizeAndSaveImage($source, $dest, 150);

        // Generate the file url and reply
        $url = $protocol . $domain . $image_url . $new_file_name;

        $out = array("status" => "OK", "url" => $url);

        header('Content-Type: application/json');
        echo json_encode($out);
    }
    // Catch and print the exception
    catch (Exception $e) {
        $out = array("status" => "FAIL", "msg" => $e->getMessage());

        header('Content-Type: application/json');
        echo json_encode($out);
    }
} elseif ($_REQUEST['delete'] && $_REQUEST['key']) {
    // Delete image and thumbnail if admin key is correct
    $file = $_REQUEST['delete'];
    $key = $_REQUEST['key'];
    if ($key === $admin_key) {

        // Normalize and resolve paths
        $base_dir   = realpath($image_path);      // your safe directory
        $file_path  = realpath($base_dir . DIRECTORY_SEPARATOR . $file);

        if ($file_path === false) {
            die("Invalid file path.");
        }

        // Ensure file is inside baseDir (prevent traversal attacks)
        if (strpos($file_path, $base_dir) !== 0) {
            echo $base_dir ."\n";
            echo $file_path ."\n";
            echo strpos($file_path, $base_dir) ."\n";
            die("Access denied.");
        }

        if (file_exists($file_path) && !is_dir($file_path)) {
            @unlink($file_path);
            $parts = explode(".", $file);
            $thumb_name = $parts[0] . "_thumb." . $parts[1];
            $thumb_path_full = $thumb_path . $thumb_name;
            if (file_exists($thumb_path_full) && !is_dir($thumb_path_full)) {
                @unlink($thumb_path_full);
            }
            echo "Image and thumbnail deleted.";
        } else {
            echo "Image not found.";
        }
    } else {
        echo "Invalid ADMIN_KEY.";
    }
}



