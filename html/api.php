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

    if ($_POST['textblk']) {
        // Convert text block to image
        $text = $_POST['textblk'];
        text2image($text);
        exit;
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
                echo $base_dir . "\n";
                echo $file_path . "\n";
                echo strpos($file_path, $base_dir) . "\n";
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
    } elseif ($_FILES['file']['error'] === UPLOAD_ERR_OK) { // If file has been posted

        $file_host = isset($_POST['file_host']) ? $_POST['file_host'] : "internal";

        // If internal host selected, save file to local server
        if (!is_numeric($file_host)) { // internal host
            // Upload image to internal host
            require_once("inc/int_host.php");

            // Call the upload image function
            upload_image();
        } elseif (intval($file_host) > 0 &&  $enable_external_hosts) {

            // Read filehosts file for external file host upload functions
            require_once("inc/ext_hosts.php");

            // Upload image to external host
            $hotlink = "";

            // Move the uploaded file to a temporary location
            $file = $_FILES['file'];
            $file_host = isset($_POST['file_host']) ? intval($_POST['file_host']) : 1;

            // Ensure the file has image size parameters
            $image_info = @getimagesize($file['tmp_name']);

            if ($image_info == false)
                throw new Exception('Please upload valid image file.');

            // Validate file type is allowed
            if (!in_array($file['type'], $allowed_types))
                throw new Exception("Only jpg, jpeg, png, webp, and gif image type supported.");

            // Add random bytes to the filename to avoid issues with same filename uploads
            file_put_contents($file['tmp_name'], random_bytes(16), FILE_APPEND);

            // Generate a new filename
            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_id = rand_str(6);
            $new_filename = "{$file_id}.{$file_ext}";

            // Prepare the file and cookie for upload
            $curlfile = new CURLFile($file['tmp_name'], $file['type'], $new_filename);
            $cookie_file = tempnam(sys_get_temp_dir(), 'cookie');

            // Call the appropriate upload function based on the selected host
            if ($file_host > 100) { // Chevereto-based hosts
                $hotlink = upload_to_chevereto($curlfile, $file_host, $file['type']);
            } else { // Other external hosts
                foreach ($external_hosts as $host) { // Find the host function
                    if ($host['index'] == $file_host) {
                        $hotlink = $host['function']($curlfile); // Call the upload function
                        break;
                    }
                }
            }


            // Ensure we have a valid hotlink
            if (empty($hotlink))
                throw new Exception("Error uploading image." . $debug ? "\n" . htmlspecialchars($page) : "");

            // Reply with JSON
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'OK', 'url' => $hotlink));

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
