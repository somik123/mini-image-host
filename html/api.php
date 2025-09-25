<?php

// Read functions file for helper functions
require_once("inc/functions.php");

// Read config file for configuration parameters
require_once("inc/config.php");

// Cross site requests disabled
header("Access-Control-Allow-Origin: *");

// To print the max file size in human readable format
$max_filesize_msg = human_readable_size($max_file_size, 0);

try {
    if ($_REQUEST['textblk']) { // Convert text block to image
        // Convert text block to image
        $text = $_REQUEST['textblk'];
        text2image($text);
        exit;
    } elseif ($_REQUEST['code'] && $_REQUEST['f']) { // Redirect to external link
        require_once("inc/ext_hosts.php");
        // Get the external link and redirect
        $short_code = $_REQUEST['code'];
        $ext_link = get_ext_link($short_code);

        // Redirect to the external link if found
        if ($ext_link) {
            header("Location: $ext_link");
            exit;
        } else {
            $img_404 = $protocol . $domain . dirname($image_url) . "/static/image_404.png";
            header("Location: $img_404");
            exit;
        }
    } elseif (isset($_REQUEST['delete']) && $_REQUEST['key'] && ($_REQUEST['file'] || $_REQUEST['short_code'])) {

        // If admin key is provided, delete the image or external link
        $key = $_REQUEST['key'];
        if ($key === $admin_key) {

            if ($_REQUEST['file']) { // Delete image and thumbnail if admin key is correct
                $file = $_REQUEST['file'];

                // Normalize and resolve paths
                $base_dir   = realpath($image_path);      // your safe directory
                $file_path  = realpath($base_dir . DIRECTORY_SEPARATOR . $file);

                if ($file_path === false) {
                    die("Invalid file path.");
                }

                // Ensure file is inside baseDir (prevent traversal attacks)
                if (strpos($file_path, $base_dir) !== 0) {
                    echo $base_dir . "\n";
                    echo $file_path . "\n";
                    echo strpos($file_path, $base_dir) . "\n";
                    die("Access denied.");
                }

                // Delete the file and its thumbnail
                if (file_exists($file_path) && !is_dir($file_path)) {
                    @unlink($file_path); // Delete main file
                    $parts = explode(".", $file); // Split filename and extension
                    $thumb_name = $parts[0] . "_thumb." . $parts[1]; // Construct thumbnail name
                    $thumb_path_full = $thumb_path . $thumb_name; // Full path to thumbnail
                    if (file_exists($thumb_path_full) && !is_dir($thumb_path_full)) {
                        @unlink($thumb_path_full); // Delete thumbnail if it exists
                    }
                    echo "Image and thumbnail deleted.";
                } else {
                    echo "Image not found.";
                }
            } elseif ($_REQUEST['short_code']) { // Delete external link if admin key is correct
                $short_code = $_REQUEST['short_code'];
                // Read filehosts file for external file host functions
                require_once("inc/ext_hosts.php");
                $res = delete_ext_link($short_code); // Delete the external link
                if ($res) {
                    echo "External link deleted.";
                } else {
                    echo "External link not found.";
                }
            } else {
                echo "Nothing to delete.";
            }
        } else {
            echo "Invalid ADMIN_KEY.";
        }
    } elseif ($_REQUEST['delete_code']) { // Delete external link with delete code
        require_once("inc/ext_hosts.php");
        $delete_code = $_REQUEST['delete_code'];
        $res = delete_ext_link_by_delete_code($delete_code); // Delete the external link
        if ($res) {
            text2image("External link deleted.");
        } else {
            text2image("External link not found or invalid delete code.");
        }
    } elseif ($_FILES['file']['error'] === UPLOAD_ERR_OK) { // If file has been posted

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
        $file_id = rand_str(10);

        $file_host = isset($_POST['file_host']) ? $_POST['file_host'] : "internal";

        // If internal host selected, save file to local server
        if (!is_numeric($file_host)) { // Upload image to internal host

            // Check if upload directory exists, if not create it
            if (!file_exists($image_path))
                mkdir($image_path, 0777, true);
            // Check if thumbnail directory exists, if not create it
            if (!file_exists($thumb_path))
                mkdir($thumb_path, 0777, true);

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

            // Clean up the temporary file and exit
            cleanup();
        } elseif (intval($file_host) > 0 &&  $enable_external_hosts) {

            // Read filehosts file for external file host upload functions
            require_once("inc/ext_hosts.php");

            // Initialize variables
            $hotlink = "";
            $delete_link = "";

            // Generate a new filename
            $new_filename = "{$file_id}.{$file_ext}";

            // Add random bytes to the filename to avoid issues with same filename uploads
            file_put_contents($tmp_name, random_bytes(16), FILE_APPEND);

            // Get the selected file host
            $file_host = isset($_POST['file_host']) ? intval($_POST['file_host']) : 1;

            // Prepare the file and cookie for upload
            $curlfile = new CURLFile($tmp_name, $type, $new_filename);
            $cookie_file = tempnam(sys_get_temp_dir(), 'php_img_cookie_');

            // Call the appropriate upload function based on the selected host
            if ($file_host > 100) { // Chevereto-based hosts
                $hotlink = upload_to_chevereto($curlfile, $file_host, $type);
            } else { // Other external hosts
                foreach ($external_hosts as $host) { // Find the host function
                    if ($host['index'] == $file_host) {
                        $hotlink = $host['function']($curlfile); // Call the upload function
                        break;
                    }
                }
            }

            // Check if upload was successful
            if (empty($hotlink))
                throw new Exception("Error uploading image." . $debug ? "\n" . htmlspecialchars($page) : "");

            // Create a short link for the external link if enabled
            if ($enable_short_links_for_external_hosts) {
                $delete_code = add_ext_link($hotlink, $file_id, $file_ext);

                // Generate the hotlink URL
                $hotlink = "{$protocol}{$domain}/ext/{$new_filename}";

                // Generate the delete link URL
                $delete_link = "{$protocol}{$domain}/del/{$delete_code}";
            }

            // Reply with JSON
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'OK', 'url' => $hotlink, 'delete_link' => $delete_link));

            // Clean up the temporary file and exit
            cleanup();
        }
    } else {
        throw new Exception("No file uploaded.");
    }
} catch (Exception $e) {
    $out = array("status" => "FAIL", "msg" => $e->getMessage());

    header('Content-Type: application/json');
    echo json_encode($out);

    // Clean up the temporary file and exit
    cleanup();
}
