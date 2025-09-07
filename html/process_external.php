<?php

require_once("config.php");



if ($_POST['textblk']) {
    // Convert text block to image
    $text = $_POST['textblk'];
    text2image($text);
    exit;
} elseif ($_FILES['file']['error'] === UPLOAD_ERR_OK && $enable_external_hosts) {

    // Move the uploaded file to a temporary location
    $file = $_FILES['file'];
    $file_host = isset($_POST['file_host']) ? intval($_POST['file_host']) : 1;

    $hotlink = "";
    $error = "";

    $debug = isset($_POST['debug']) ? true : false;

    // Add random bytes to the filename to avoid issues with same filename uploads
    file_put_contents($file['tmp_name'], random_bytes(16), FILE_APPEND);

    // Prepare the file and cookie for upload
    $curlfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
    $cookie_file = tempnam(sys_get_temp_dir(), 'cookie');

    // Handle different file hosts
    if ($file_host == 1) {
        // PostImages upload logic
        $upload_url = 'https://postimages.org/json/upload';
        // Generate a unique session ID
        $session = (string)(int)(microtime(true) * 1000) . substr((string)mt_rand() / mt_getrandmax(), 1);
        $data = array('file' => $curlfile, 'mode' => 'phpbb3', 'numfiles' => 1, 'upload_session' => $session);
        $page = get_page($upload_url, $data);
        $response = json_decode($page, true);

        if ($response['status'] == "OK") {
            $page = get_page($response['url']);
            preg_match_all('#\[img\](.*?)\[\/img\]#si', $page, $matches);
            $hotlink = $matches[1][1]; // Direct link is the second [img] tag
        }
    } elseif ($file_host == 2) {
        // CatBox upload logic
        $upload_url = 'https://catbox.moe/user/api.php';
        $data = array('reqtype' => 'fileupload', 'fileToUpload' => $curlfile);
        $page = get_page($upload_url, $data);

        if (strpos($page, 'files.catbox.moe') !== false) {
            $hotlink = trim($page);
        } else {
            $error = "Error uploading to CatBox" . $debug ? "\n" . htmlspecialchars($page) : "";
        }
    } elseif ($file_host == 3) {
        // pomf2.lain.la upload logic
        $upload_url = 'https://pomf2.lain.la/upload.php';
        $data = array('files[]' => $curlfile);
        $page = get_page($upload_url, $data);
        $response = json_decode($page, true);

        if ($response['success'] == "true") {
            $hotlink = $response['files'][0]['url'];
        } else {
            $error = "Error uploading to pomf2.lain.la" . $debug ? "\n" . htmlspecialchars($page) : "";
        }
    } elseif ($file_host == 4) {
        // 0x0.st upload logic
        $upload_url = 'https://0x0.st';
        $data = array('file' => $curlfile);

        // Using basic curl to handle 0x0.st specific requirements
        $ch = curl_init($upload_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'curl/8.5.0');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $page = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);

        if (empty($error)) {
            if (strpos($page, '0x0.st') !== false) {
                $hotlink = trim($page);
            } else {
                $error = "Error uploading to 0x0.st" . $debug ? "\n" . htmlspecialchars($page) : "";
            }
        }
    } elseif ($file_host == 5) {
        // UploadImgur upload logic
        $upload_url = "https://uploadimgur.com/api/upload";
        $data = array('image' => $curlfile);
        $page = get_page($upload_url, $data);
        $response = json_decode($page, true);
        if ($response['link'])
            $hotlink = $response['link'];
        else {
            $error = "Error uploading to UploadImgur" . $debug ? "\n" . htmlspecialchars($page) : "";
        }
    } elseif ($file_host == 6) {
        $url = "http://myimgs.org/";
        $upload_url = "https://myimgs.org/";
        $page = get_page($url, false, $url, true);
        preg_match('#name="_token" value="([^"]+)"#si', $page, $matches);

        $token = $matches[1];
        if (empty($token)) {
            $error = "Error retrieving token from myimgs.org.";
            cleanup();
        }
        if (empty($error)) {
            $data = array(
                "_token" => $token,
                "image" => $curlfile,
                "alt" => "",
                "submit" => "Upload"
            );
            $page = get_page($upload_url, $data, $url, true);
            preg_match('#"(https\:\/\/myimgs\.org\/storage\/images/.*?)"#si', $page, $matches);
            if ($matches[1]) {
                $hotlink = $matches[1];
            } else {
                $error = "Error uploading to myimgs.org" . $debug ? "\n" . htmlspecialchars($page) : "";
            }
        }
    } elseif ($file_host >= 7 && $file_host <= 19) {
        // Chevereto-based hosts 
        // (ImgBB, FreeImage.host, HostImage.org, PasteImg, Imgbb.ws, img.in.th, Dodaj.rs, 
        // Inspirats, FxPics.ru, Poop.pictures, Site.pictures, SnappyPic, Eikona.info)
        if ($file_host == 7) {
            // Imgbb
            $url = "https://imgbb.com/";
            $name = "ImgBB";
        } elseif ($file_host == 8) {
            // FreeImage.host
            $url = "https://freeimage.host/";
            $name = "FreeImage.host";
        } else if ($file_host == 9) {
            // HostImage.org
            $url = "https://hostimage.org/";
            $name = "HostImage.org";
        } elseif ($file_host == 10) {
            // PasteImg
            $url = "https://pasteimg.com/";
            $name = "PasteImg";
        } elseif ($file_host == 11) {
            // Imgbb.ws
            $url = "https://imgbb.ws/";
            $name = "ImgBB.ws";
        } elseif ($file_host == 12) {
            // img.in.th
            $url = "https://www.img.in.th/";
            $name = "img.in.th";
        } elseif ($file_host == 13) {
            // Dodaj.rs
            $url = "https://dodaj.rs/";
            $name = "Dodaj.rs";
        } elseif ($file_host == 14) {
            // Inspirats
            $url = "https://inspirats.com/";
            $name = "Inspirats";
        } elseif ($file_host == 15) {
            // FxPics.ru
            $url = "https://fxpics.ru/";
            $name = "FxPics.ru";
        } elseif ($file_host == 16) {
            // Poop.pictures
            $url = "https://poop.pictures/";
            $name = "Poop.pictures";
        } elseif ($file_host == 17) {
            // Site.pictures
            $url = "https://site.pictures/";
            $name = "Site.pictures";
        } elseif ($file_host == 18) {
            // SnappyPic
            $url = "https://snappypic.com/";
            $name = "SnappyPic";
        } elseif ($file_host == 19) {
            // Eikona.info
            $url = "https://eikona.info/";
            $name = "Eikona.info";
        } else {
            $error = "Invalid Chevereto host selected.";
            echo json_encode(array('status' => 'ERROR', 'message' => $error));
            cleanup();
        }


        $upload_url = $url . "json";

        // Chevereto upload logic
        $page = get_page($url, false, $url, true);

        preg_match('#auth_token\s?\=\s?"([^"]+)"#si', $page, $matches);
        $auth_token = $matches[1];
        if (empty($auth_token)) {
            $error = "Error retrieving auth_token from {$name}." . $debug ? "\n" . htmlspecialchars($page) : "";
            echo json_encode(array('status' => 'ERROR', 'message' => $error));
            cleanup();
        }


        $data = array(
            "source" => $curlfile,
            "type" => "file",
            "action" => "upload",
            "timestamp" => time(),
            "auth_token" => $auth_token,
            "expiration" => "",
            "nsfw" => "0",
            "mimetype" => $file['type']
        );

        $page = get_page($upload_url, $data, $url, true);
        $response = json_decode($page, true);

        if ($response['status_code'] == 200) {
            $hotlink = $response['image']['url'];
        } else {
            $error = "Error uploading to {$name}." . $debug ? "\n" . htmlspecialchars($page) : "";
        }
    } else {
        $error = "Invalid file host selected.";
    }
    header('Content-Type: application/json');
    if ($error) {
        echo json_encode(array('status' => 'ERROR', 'message' => $error));
    } else {
        echo json_encode(array('status' => 'OK', 'url' => $hotlink));
    }

    # Clean up the temporary file and exit
    cleanup();
}






// Function to perform HTTP requests using cURL
function get_page($upload_url, $data = false, $reffer = false, $cookie = false, $head = false)
{
    global $cookie_file;

    $headers = [
        'sec-ch-ua: "Chromium";v="116", "Not)A;Brand";v="24", "Google Chrome";v="116"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'Sec-Fetch-Site: none',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-User: ?1',
        'Sec-Fetch-Dest: document',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
    ];

    $ch = curl_init($upload_url);

    curl_setopt($ch, CURLOPT_REFERER, $upload_url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLS_AES_128_GCM_SHA256:TLS_AES_256_GCM_SHA384:TLS_CHACHA20_POLY1305_SHA256:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-RSA-AES128-SHA:ECDHE-RSA-AES256-SHA:AES128-GCM-SHA256:AES256-GCM-SHA384:AES128-SHA:AES256-SHA');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);

    if ($data)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    if ($head)
        curl_setopt($ch, CURLOPT_HEADER, true);
    if ($reffer)
        curl_setopt($ch, CURLOPT_REFERER, $reffer);

    if ($cookie) {
        //$cookie_file = tempnam(sys_get_temp_dir(), 'cookie');
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    }

    $response = curl_exec($ch);
    // Check for errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);

    return $response;
}


// Function to draw text with custom spacing between characters
function imagettftextSpaced($im, $size, $angle, $x, $y, $color, $font, $text, $spacing = 0)
{
    $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY); // handle UTF-8 too
    foreach ($chars as $char) {
        // Draw one character
        imagettftext($im, $size, $angle, $x, $y, $color, $font, $char);

        // Calculate width of this char
        $bbox = imagettfbbox($size, $angle, $font, $char);
        $char_width = $bbox[2] - $bbox[0];

        // Move X forward with extra spacing
        $x += $char_width + $spacing;
    }
}

// Convert hex color to RGB array
function hex2rgb($hex)
{
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    return [
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    ];
}


// Convert text block to image
function text2image($text)
{
    // Settings
    $font_size = 14;
    $font_file = __DIR__ . "/static/calibri-regular.ttf"; // Make sure this font file exists
    $max_width = 800;
    $line_height = 20;

    // Word wrap text to fit max width
    $wrapped = '';
    $width = intval($max_width / 10); // Approximate character width
    foreach (explode("\n", $text) as $line) {
        $wrapped .= wordwrap($line, $width, "\n", true) . "\n";
    }

    $lines = explode("\n", trim($wrapped));
    $height = max(100, count($lines) * $line_height + 20);

    // Create image
    $im = imagecreatetruecolor($max_width, $height);

    // Colors
    list($r, $g, $b) = hex2rgb("#303030"); // Dark gray background
    $background = imagecolorallocate($im, $r, $g, $b);

    $white = imagecolorallocate($im, 255, 255, 255); // White text

    imagefill($im, 0, 0, $background);


    // Draw text line by line
    $y = 30;
    foreach ($lines as $line) {
        //imagettftext($im, $font_size, 0, 10, $y, $black, $font_file, $line);
        imagettftextSpaced($im, $font_size, 10, 10, $y, $white, $font_file, $line, 2.5); // spacing = 2px

        $y += $line_height;
    }

    // Output image
    $output_file = __DIR__ . "/output.png";
    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);

    exit;
}


// Clean up temporary files and exit
function cleanup()
{
    global $cookie_file, $file;
    @unlink($cookie_file);
    @unlink($file['tmp_name']);
    exit;
}
