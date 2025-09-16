<?php


// Index #1
function upload_to_postimages($curlfile)
{
    global $debug;

    // PostImages upload logic
    $upload_url = 'https://postimages.org/json/upload';
    // Generate a unique session ID
    $session = (string)(int)(microtime(true) * 1000) . substr((string)mt_rand() / mt_getrandmax(), 1);
    $data = array('file' => $curlfile, 'mode' => 'phpbb3', 'numfiles' => 1, 'upload_session' => $session);
    $page = get_page($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['status'] == "OK") {
        $page = get_page($response['url']);
        preg_match_all('#\[img\](.*?)\[\/img\]#si', $page, $matches);
        $hotlink = $matches[1][1]; // Direct link is the second [img] tag
        return $hotlink;
    } else {
        throw new Exception("Error uploading to PostImages" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #2
function upload_to_catbox($curlfile)
{
    global $debug;

    // CatBox upload logic
    $upload_url = 'https://catbox.moe/user/api.php';
    $data = array('reqtype' => 'fileupload', 'fileToUpload' => $curlfile);
    $page = get_page($upload_url, $data);

    // Check if upload was successful
    if (strpos($page, 'files.catbox.moe') !== false) {
        $hotlink = trim($page);
        return $hotlink;
    } else {
        throw new Exception("Error uploading to CatBox" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #3
function upload_to_pomf2_lain_la($curlfile)
{
    global $debug;

    // pomf2.lain.la upload logic
    $upload_url = 'https://pomf2.lain.la/upload.php';
    $data = array('files[]' => $curlfile);
    $page = get_page($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success'] == "true") {
        $hotlink = $response['files'][0]['url'];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to pomf2.lain.la" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #4
function upload_to_0x0_st($curlfile)
{
    global $debug;

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

    // Check for curl errors
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);

    // Check if upload was successful
    if (strpos($page, '0x0.st') !== false) {
        $hotlink = trim($page);
        return $hotlink;
    } else {
        throw new Exception("Error uploading to 0x0.st" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #5
function upload_to_imgur($curlfile)
{
    global $debug;

    // UploadImgur upload logic
    $upload_url = "https://uploadimgur.com/api/upload";
    $data = array('image' => $curlfile);
    $page = get_page($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['link']) {
        $hotlink = $response['link'];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to UploadImgur" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #6
function upload_to_myimgs($curlfile)
{
    global $debug;

    // myimgs.org upload logic
    $url = "http://myimgs.org/";
    $upload_url = "https://myimgs.org/";
    $page = get_page($url, false, $url, true);
    preg_match('#name="_token" value="([^"]+)"#si', $page, $matches);

    // Check if token was found
    $token = $matches[1];
    if (empty($token)) {
        throw new Exception("Error retrieving token from myimgs.org." . $debug ? "\n" . htmlspecialchars($page) : "");
        cleanup();
    }

    $data = array(
        "_token" => $token,
        "image" => $curlfile,
        "alt" => "",
        "submit" => "Upload"
    );
    $page = get_page($upload_url, $data, $url, true);
    // Extract the image URL from the response
    preg_match('#"(https\:\/\/myimgs\.org\/storage\/images/.*?)"#si', $page, $matches);

    // Check if upload was successful
    if ($matches[1]) {
        $hotlink = $matches[1];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to myimgs.org" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #7
function upload_to_imghost($curlfile)
{
    global $debug;

    // imghost.cc upload logic
    $upload_url = "https://imghost.cc/upload";
    $data = array('file' => $curlfile);
    $page = get_page($upload_url, $data);

    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['filename']) {
        $hotlink = "https://i.imghost.cc/" . $response['filename'];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to imghost.cc" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #8
function upload_to_upimg($curlfile)
{
    global $debug;

    // UpImg upload logic
    $url = "https://upimg.com/";
    $upload_url = "https://api.upimg.com/images";
    $data = array('images' => $curlfile);

    // Using basic curl to handle UpImg specific requirements

    $headers = [
        'Accept: application/json',
        'Origin: https://upimg.com'
    ];

    $ch = curl_init($upload_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'curl/8.5.0');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $page = curl_exec($ch);

    // Check for curl errors
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);

    $response = json_decode($page, true);

    // Check if upload was successful
    if (!empty($response['images'])) {
        $hotlink = $response['images'][0]['url'];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to upimg.com" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index 100+ are all chevereto hosts
function upload_to_chevereto($curlfile, $file_host, $mime_type)
{
    global $debug, $imgbb_api_key;

    // Chevereto-based hosts 
    // (ImgBB, FreeImage.host, HostImage.org, PasteImg, Imgbb.ws, img.in.th, Dodaj.rs, 
    // Inspirats, FxPics.ru, Poop.pictures, Site.pictures, SnappyPic, Eikona.info)

    switch ($file_host) {
        case 101:
            // Imgbb
            if($imgbb_api_key){
                return upload_to_imgbb($curlfile);
            }
            // Fallback to Chevereto if no API key is set
            $url = "https://imgbb.com/";
            $name = "ImgBB";
            break;
        case 102:
            // FreeImage.host
            $url = "https://freeimage.host/";
            $name = "FreeImage.host";
            break;
        case 103:
            // HostImage.org
            $url = "https://hostimage.org/";
            $name = "HostImage.org";
            break;
        case 104:
            // PasteImg
            $url = "https://pasteimg.com/";
            $name = "PasteImg";
            break;
        case 105:
            // Imgbb.ws
            $url = "https://imgbb.ws/";
            $name = "ImgBB.ws";
            break;
        case 106:
            // img.in.th
            $url = "https://www.img.in.th/";
            $name = "img.in.th";
            break;
        case 107:
            // Dodaj.rs
            $url = "https://dodaj.rs/";
            $name = "Dodaj.rs";
            break;
        case 108:
            // Inspirats
            $url = "https://inspirats.com/";
            $name = "Inspirats";
            break;
        case 109:
            // FxPics.ru
            $url = "https://fxpics.ru/";
            $name = "FxPics.ru";
            break;
        case 110:
            // Poop.pictures
            $url = "https://poop.pictures/";
            $name = "Poop.pictures";
            break;
        case 111:
            // Site.pictures
            $url = "https://site.pictures/";
            $name = "Site.pictures";
            break;
        case 112:
            // SnappyPic
            $url = "https://snappypic.com/";
            $name = "SnappyPic";
            break;
        case 113:
            // Eikona.info
            $url = "https://eikona.info/";
            $name = "Eikona.info";
            break;
        default:
            throw new Exception("Invalid Chevereto host selected.");
    }

    // Prepare upload URL
    $upload_url = $url . "json";

    // Chevereto upload logic
    $page = get_page($url, false, $url, true);

    // Extract the auth_token from the page
    preg_match('#auth_token\s?\=\s?"([^"]+)"#si', $page, $matches);
    $auth_token = $matches[1];
    if (empty($auth_token))
        throw new Exception("Error retrieving auth_token from {$name}." . $debug ? "\n" . htmlspecialchars($page) : "");

    // Prepare data for upload
    $data = array(
        "source" => $curlfile,
        "type" => "file",
        "action" => "upload",
        "timestamp" => time(),
        "auth_token" => $auth_token,
        "expiration" => "",
        "nsfw" => "0",
        "mimetype" => $mime_type
    );

    $page = get_page($upload_url, $data, $url, true);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['status_code'] == 200) {
        $hotlink = $response['image']['url'];
        return $hotlink;
    } else
        throw new Exception("Error uploading to {$name}." . $debug ? "\n" . htmlspecialchars($page) : "");
}


function upload_to_imgbb($curlfile){
    global $debug;

    // Imgbb API upload logic
    $api_key = "8af21c832df0f748ca001ffa0a3b6d53"; // Free API key from imgbb.com
    $upload_url = "https://api.imgbb.com/1/upload?key=" . $api_key;
    $data = array('image' => $curlfile);
    $page = get_page($upload_url, $data);
    $response = json_decode($page, true);
    
    // Check if upload was successful
    if ($response['success']) {
        $hotlink = $response['data']['url'];
        return $hotlink;
    } else {
        throw new Exception("Error uploading to Imgbb via API" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}