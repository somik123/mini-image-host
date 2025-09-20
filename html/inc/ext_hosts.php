<?php


$external_hosts = array();
$chevereto_hosts = array();

init_external_hosts();


// Initialize external hosts
function init_external_hosts()
{
    global $external_hosts, $chevereto_hosts;

    if (!empty($external_hosts) || !empty($chevereto_hosts)) {
        // Already initialized
        return;
    }

    // Define external hosts
    $external_hosts[] = array(
        'name' => 'PostImages',
        'function' => 'upload_to_postimages',
        'url' => 'https://postimages.org/',
        "index" => 1
    );

    $external_hosts[] = array(
        'name' => 'CatBox',
        'function' => 'upload_to_catbox',
        'url' => 'https://catbox.moe/',
        "index" => 2
    );

    $external_hosts[] = array(
        'name' => 'pomf2.lain.la',
        'function' => 'upload_to_pomf2_lain_la',
        'url' => 'https://pomf2.lain.la/',
        "index" => 3
    );

    $external_hosts[] = array(
        'name' => '0x0.st',
        'function' => 'upload_to_0x0_st',
        'url' => 'https://0x0.st/',
        "index" => 4
    );

    $external_hosts[] = array(
        'name' => 'UploadImgur',
        'function' => 'upload_to_imgur',
        'url' => 'https://uploadimgur.com/',
        "index" => 5
    );

    $external_hosts[] = array(
        'name' => 'myimgs.org',
        'function' => 'upload_to_myimgs',
        'url' => 'https://myimgs.org/',
        "index" => 6
    );

    $external_hosts[] = array(
        'name' => 'imghost.cc',
        'function' => 'upload_to_imghost',
        'url' => 'https://imghost.cc/',
        "index" => 7
    );

    $external_hosts[] = array(
        'name' => 'UpImg',
        'function' => 'upload_to_upimg',
        'url' => 'https://upimg.com/',
        "index" => 8
    );

    $external_hosts[] = array(
        'name' => 'ImgBox',
        'function' => 'upload_to_imgbox',
        'url' => 'https://imgbox.com/',
        "index" => 9
    );

    $external_hosts[] = array(
        'name' => 'ImgBB (API)',
        'function' => 'upload_to_imgbb',
        'url' => 'https://imgbb.com/',
        "index" => 10
    );

    $external_hosts[] = array(
        'name' => 'ImgPaste',
        'function' => 'upload_to_imgpaste',
        'url' => 'https://imgpaste.net/',
        "index" => 11
    );

    $external_hosts[] = array(
        'name' => 'PngUp',
        'function' => 'upload_to_pngup',
        'url' => 'https://pngup.org/',
        "index" => 12
    );

    $external_hosts[] = array(
        'name' => 'SnipShot.io',
        'function' => 'upload_to_snipshot',
        'url' => 'https://snipshot.io/',
        "index" => 13
    );

    $external_hosts[] = array(
        'name' => 'ImgIU',
        'function' => 'upload_to_imgiu',
        'url' => 'https://imgiu.com/',
        "index" => 14
    );

    $external_hosts[] = array(
        'name' => 'FileShare.ing',
        'function' => 'upload_to_fileshare_ing',
        'url' => 'https://fileshare.ing/',
        "index" => 15
    );

    $external_hosts[] = array(
        'name' => 'Xilt.net',
        'function' => 'upload_to_xilt_net',
        'url' => 'https://xilt.net/',
        "index" => 16
    );

    $external_hosts[] = array(
        'name' => 'WindyPix',
        'function' => 'upload_to_windypix',
        'url' => 'https://windypix.com/',
        "index" => 17
    );

    $external_hosts[] = array(
        'name' => '8upload',
        'function' => 'upload_to_8upload',
        'url' => 'https://8upload.com/',
        "index" => 18
    );

    $external_hosts[] = array(
        'name' => 'ImgLink.io',
        'function' => 'upload_to_imglink_io',
        'url' => 'https://imglink.io/',
        "index" => 19
    );

    $external_hosts[] = array(
        'name' => 'BigByte.no',
        'function' => 'upload_to_bigbyte_no',
        'url' => 'http://img.bigbyte.no/',
        "index" => 20
    );

    $external_hosts[] = array(
        'name' => 'Image2url',
        'function' => 'upload_to_image2url',
        'url' => 'https://image2url.com/',
        "index" => 21
    );

    $external_hosts[] = array(
        'name' => 'DragNdropZ',
        'function' => 'upload_to_dragndropz',
        'url' => 'https://dragndropz.com/',
        "index" => 22
    );

    $external_hosts[] = array(
        'name' => 'AnonPic.org',
        'function' => 'upload_to_anonpic_org',
        'url' => 'https://anonpic.org/',
        "index" => 23
    );

    $external_hosts[] = array(
        'name' => 'PicSer.Pages.dev',
        'function' => 'upload_to_picser_pages_dev',
        'url' => 'https://picser.pages.dev/',
        "index" => 24
    );









    // Define Chevereto-based hosts
    $chevereto_hosts[] = array(
        'name' => 'ImgBB',
        'function' => 'upload_to_imgbb',
        'function_alt' => 'upload_to_chevereto',
        'url' => 'https://imgbb.com/',
        "index" => 101,
    );

    $chevereto_hosts[] = array(
        'name' => 'FreeImage.host',
        'function' => 'upload_to_chevereto',
        'url' => 'https://freeimage.host/',
        "index" => 102
    );

    $chevereto_hosts[] = array(
        'name' => 'HostImage.org',
        'function' => 'upload_to_chevereto',
        'url' => 'https://hostimage.org/',
        "index" => 103
    );

    $chevereto_hosts[] = array(
        'name' => 'PasteImg',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pasteimg.com/',
        "index" => 104
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgBB.ws',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgbb.ws/',
        "index" => 105
    );

    $chevereto_hosts[] = array(
        'name' => 'Img.in.th',
        'function' => 'upload_to_chevereto',
        'url' => 'https://www.img.in.th/',
        "index" => 106
    );

    $chevereto_hosts[] = array(
        'name' => 'Inspirats',
        'function' => 'upload_to_chevereto',
        'url' => 'https://inspirats.com/',
        "index" => 108
    );

    $chevereto_hosts[] = array(
        'name' => 'FxPics.ru',
        'function' => 'upload_to_chevereto',
        'url' => 'https://fxpics.ru/',
        "index" => 109
    );

    $chevereto_hosts[] = array(
        'name' => 'Poop.pictures',
        'function' => 'upload_to_chevereto',
        'url' => 'https://poop.pictures/',
        "index" => 110
    );

    $chevereto_hosts[] = array(
        'name' => 'Site.pictures',
        'function' => 'upload_to_chevereto',
        'url' => 'https://site.pictures/',
        "index" => 111
    );

    $chevereto_hosts[] = array(
        'name' => 'SnappyPic',
        'function' => 'upload_to_chevereto',
        'url' => 'https://snappypic.com/',
        "index" => 112
    );

    $chevereto_hosts[] = array(
        'name' => 'Eikona.info',
        'function' => 'upload_to_chevereto',
        'url' => 'https://eikona.info/',
        "index" => 113
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgCDN.dev',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgcdn.dev/',
        "index" => 114
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgUh',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imguh.com/',
        "index" => 115
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgShare.pl',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgshare.pl/',
        "index" => 116
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgKub',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgkub.com/',
        "index" => 117
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgHive',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imghive.com/',
        "index" => 118
    );

    $chevereto_hosts[] = array(
        'name' => 'JpgJet',
        'function' => 'upload_to_chevereto',
        'url' => 'https://jpgjet.com/',
        "index" => 119
    );

    $chevereto_hosts[] = array(
        'name' => 'PostImage.me',
        'function' => 'upload_to_chevereto',
        'url' => 'https://postimage.me/',
        "index" => 120
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgTap',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgtap.com/',
        "index" => 121
    );

    $chevereto_hosts[] = array(
        'name' => 'ZippyImage',
        'function' => 'upload_to_chevereto',
        'url' => 'https://zippyimage.com/',
        "index" => 122
    );

    $chevereto_hosts[] = array(
        'name' => 'PixShare.de',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pixshare.de/',
        "index" => 123
    );

    $chevereto_hosts[] = array(
        'name' => 'PixelStash.co',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pixelstash.co/',
        "index" => 124
    );

    $chevereto_hosts[] = array(
        'name' => 'ImageCC.net',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imagecc.net/',
        "index" => 125
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgHit',
        'function' => 'upload_to_chevereto',
        'url' => 'https://www.imghit.com/',
        "index" => 126
    );

    $chevereto_hosts[] = array(
        'name' => 'TinyPic.host (1 day)',
        'function' => 'upload_to_chevereto',
        'url' => 'https://tinypic.host/',
        "index" => 127
    );
}


// Index #1
function upload_to_postimages($curlfile)
{
    global $debug;

    // PostImages upload logic
    $upload_url = 'https://postimages.org/json/upload';
    // Generate a unique session ID
    $session = (string)(int)(microtime(true) * 1000) . substr((string)mt_rand() / mt_getrandmax(), 1);
    $data = array('file' => $curlfile, 'mode' => 'phpbb3', 'numfiles' => 1, 'upload_session' => $session);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['status'] == "OK") {
        $page = mimic_browser($response['url']);
        preg_match_all('#\[img\](.*?)\[\/img\]#si', $page, $matches);

        return $matches[1][1]; // Direct link is the second [img] tag
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
    $page = mimic_browser($upload_url, $data);

    // Check if upload was successful
    if (strpos($page, 'files.catbox.moe') !== false) {
        return trim($page);
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
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success'] == "true") {
        return $response['files'][0]['url'];
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
    $page = basic_curl_call($upload_url, "post", $data, [], 'curl/8.5.0');

    // Check if upload was successful
    if (strpos($page, '0x0.st') !== false) {
        return trim($page);
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
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['link']) {
        return $response['link'];
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
    $page = mimic_browser($url, false, $url, true);
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
    $page = mimic_browser($upload_url, $data, $url, true);
    // Extract the image URL from the response
    preg_match('#"(https\:\/\/myimgs\.org\/storage\/images/.*?)"#si', $page, $matches);

    // Check if upload was successful
    if ($matches[1]) {
        return $matches[1];
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
    $page = mimic_browser($upload_url, $data);

    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['filename']) {
        return "https://i.imghost.cc/" . $response['filename'];
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

    // Set required headers for UpImg
    $headers = [
        'Accept: application/json',
        'Origin: https://upimg.com'
    ];

    // Using basic curl to handle UpImg specific requirements
    $page = basic_curl_call($upload_url, "post", $data, $headers, 'curl/8.5.0');

    $response = json_decode($page, true);

    // Check if upload was successful
    if (!empty($response['images'])) {
        return $response['images'][0]['url'];
    } else {
        throw new Exception("Error uploading to upimg.com" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #9
function upload_to_imgbox($curlfile)
{
    global $debug, $cookie_file;

    // ImgBox upload logic
    $url = "https://imgbox.com/";
    $session_url = $url . "/ajax/token/generate";
    $upload_url = $url . "/upload/process";

    // Get X-CSRF-Token
    $page = mimic_browser($url, false, '', true);

    preg_match('#<input name="authenticity_token" type="hidden" value="([^"]+)"#si', $page, $matches);
    $csrf_token = $matches[1];
    if (empty($csrf_token)) {
        throw new Exception("Error retrieving CSRF token from ImgBox." . $debug ? "\n" . htmlspecialchars($page) : "");
        cleanup();
    }

    // Set required headers for ImgBox
    $headers = ['X-CSRF-Token: ' . $csrf_token];
    // Get session token
    $page = basic_curl_call($session_url, "post", "", $headers, "", $cookie_file);

    if (stristr($page, "token_secret") === FALSE) {
        throw new Exception("Error retrieving session token from ImgBox." . $debug ? "\n" . htmlspecialchars($page) : "");
        cleanup();
    }
    $response = json_decode($page, true);
    $token_id = $response['token_id'];
    $token_secret = $response['token_secret'];


    // Prepare data for upload
    $data = array(
        "token_id" => $token_id,
        "token_secret" => $token_secret,
        "files[]" => $curlfile,
        "content_type" => 1,
        "thumbnail_size" => "100c",
        "gallery_id" => null,
        "comments_enabled" => 0
    );
    // Upload the file
    $page = basic_curl_call($upload_url, "post", $data, $headers, "", $cookie_file);

    if (stristr($page, "original_url") === FALSE) {
        throw new Exception("Error uploading to ImgBox." . $debug ? "\n" . htmlspecialchars($page) : "");
        cleanup();
    }
    $response = json_decode($page, true);
    return $response['files'][0]['original_url'];
}


// Index #10
function upload_to_imgbb($curlfile)
{
    global $debug, $imgbb_api_key;

    if (empty($imgbb_api_key)) {
        throw new Exception("ImgBB API key not configured.");
    }

    // Imgbb API upload logic
    $upload_url = "https://api.imgbb.com/1/upload?key=" . $imgbb_api_key;
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['data']['url'];
    } else {
        throw new Exception("Error uploading to Imgbb via API" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #11
function upload_to_imgpaste($curlfile)
{
    global $debug;

    // ImgPaste upload logic
    $upload_url = 'https://api.imgpaste.net/upload';
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['url']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to ImgPaste" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #12
function upload_to_pngup($curlfile)
{
    global $debug;

    // PngUp upload logic
    $upload_url = 'https://pngup.com/api/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['id']) {
        // Get file name from $curlfile
        $name = $curlfile->getPostFilename();
        return "https://pngup.com/" . $response['id'] . "/" . $name;
    } else {
        throw new Exception("Error uploading to PngUp" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #13
function upload_to_snipshot($curlfile)
{
    global $debug;

    // Snipshot upload logic
    $upload_url = 'https://snipshot.io/upload';
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['status'] == 'success') {
        return $response['image_path'];
    } else {
        throw new Exception("Error uploading to Snipshot" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #14
function upload_to_imgiu($curlfile)
{
    global $debug;

    // ImgiU upload logic
    $upload_url = 'https://imgiu.com/upload.php';
    $data = array('file[0]' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['success']) {
        return $response['files'][0]['url'];
    } else {
        throw new Exception("Error uploading to ImgiU" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #15
function upload_to_fileshare_ing($curlfile)
{
    global $debug;

    // fileshare.ing upload logic
    $upload_url = 'https://api.fileshare.ing/upload';
    $data = array(
        'image' => $curlfile,
        'expirationDate' => ''
    );

    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['id']) {
        // Get $curlFile extension
        $ext = pathinfo($curlfile->getPostFilename(), PATHINFO_EXTENSION);
        return "https://cdn.fileshare.ing/production/{$response['id']}.{$ext}";
    } else {
        throw new Exception("Error uploading to fileshare.ing" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}

// Index #16
function upload_to_xilt_net($curlfile)
{
    global $debug;

    // Xilt.net upload logic
    $upload_url = 'https://xilt.net/inc/upload.php';
    $data = array('file[]' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response[0]) {
        return $response[0];
    } else {
        throw new Exception("Error uploading to Xilt.net" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #17
function upload_to_windypix($curlfile)
{
    global $debug;

    // WindyPix upload logic
    $upload_url = 'https://windypix.com/upload.php';
    $data = array('file[]' => $curlfile);
    $page = mimic_browser($upload_url, $data, 'https://windypix.com/', true);

    // Check if upload was successful
    preg_match_all('#\[IMG\]([^\[]+)\[\/IMG\]#si', $page, $matches);

    foreach ($matches[1] as $match) {
        if (strpos($match, '?di=') !== false) {
            return $match; // Return the first direct link without '?di='
        }
    }
    throw new Exception("Error uploading to AnonPic.org" . $debug ? "\n" . htmlspecialchars($page) : "");
}


// Index #18
function upload_to_8upload($curlfile)
{
    global $debug;

    // 8upload upload logic
    $upload_url = 'https://8upload.com/upload/mt/';
    $data = array('upload[]' => $curlfile);
    $page = mimic_browser($upload_url, $data);

    $parts = explode('\\/', str_replace('"', '', $page));

    // Check if upload was successful
    if ($parts[1] == "uploaded" && $parts[2]) {
        $link_url = "https://8upload.com/" . join("/", $parts);
        $page = mimic_browser($link_url);

        preg_match_all('#\[IMG\]([^\[]+)\[\/IMG\]#si', $page, $matches);

        foreach ($matches[1] as $match) {
            if (strpos($match, '/image/') !== false) {
                return $match; // Return the first direct link without '?di='
            }
        }
        throw new Exception("Error uploading to AnonPic.org" . $debug ? "\n" . htmlspecialchars($page) : "");
    } else {
        throw new Exception("Error uploading to 8upload" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #19
function upload_to_imglink_io($curlfile)
{
    global $debug;

    // Imglink.io upload logic
    $upload_url = 'https://imglink.io/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['success']) {
        return $response['images'][0]['direct_link'];
    } else {
        throw new Exception("Error uploading to Imglink.io" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #20
function upload_to_bigbyte_no($curlfile)
{
    global $debug;

    // BigByte.no upload logic
    $upload_url = 'http://img.bigbyte.no/upload.php';
    $data = array('file[]' => $curlfile, 'imgUrl' => '');
    $page = mimic_browser($upload_url, $data, 'http://img.bigbyte.no/', true);

    // Check if upload was successful
    preg_match_all('#\[IMG\]([^\[]+)\[\/IMG\]#si', $page, $matches);

    foreach ($matches[1] as $match) {
        if (strpos($match, '?di=') !== false) {
            return $match; // Return the first direct link without '?di='
        }
    }
    throw new Exception("Error uploading to AnonPic.org" . $debug ? "\n" . htmlspecialchars($page) : "");
}


// Index #21
function upload_to_image2url($curlfile)
{
    global $debug;

    // Image2url upload logic
    $upload_url = 'https://www.image2url.com/api/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to Image2url" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #22
function upload_to_dragndropz($curlfile)
{
    global $debug;

    // DragNdropZ upload logic
    $upload_url = 'https://serv1.dragndropz.com/image_uploader.php';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['image_path']) {
        return $response['image_path'];
    } else {
        throw new Exception("Error uploading to DragNdropZ" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}


// Index #23
function upload_to_anonpic_org($curlfile)
{
    global $debug;

    // AnonPic.org upload logic
    $upload_url = 'https://anonpic.org/upload.php';
    $data = array('file[]' => $curlfile, 'imgUrl' => '');
    $page = mimic_browser($upload_url, $data, 'https://anonpic.org/', true);

    // Check if upload was successful
    preg_match_all('#\[IMG\]([^\[]+)\[\/IMG\]#si', $page, $matches);

    foreach ($matches[1] as $match) {
        if (strpos($match, '?di=') !== false) {
            return $match; // Return the first direct link without '?di='
        }
    }
    throw new Exception("Error uploading to AnonPic.org" . $debug ? "\n" . htmlspecialchars($page) : "");
}


// Index #24
function upload_to_picser_pages_dev($curlfile)
{
    global $debug;

    // PicSer.Pages.dev upload logic
    $upload_url = 'https://picser.pages.dev/api/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to PicSer.Pages.dev" . $debug ? "\n" . htmlspecialchars($page) : "");
    }
}









// Index 100+ are all chevereto hosts
function upload_to_chevereto($curlfile, $file_host, $mime_type)
{
    global $debug, $chevereto_hosts;

    // Chevereto-based hosts 
    // (ImgBB, FreeImage.host, HostImage.org, PasteImg, Imgbb.ws, img.in.th,
    // Inspirats, FxPics.ru, Poop.pictures, Site.pictures, SnappyPic, Eikona.info)

    $url = "";
    $name = "";
    // Select the appropriate host based on index
    foreach ($chevereto_hosts as $host) {
        if ($host['index'] == $file_host) {
            $url = $host['url'];
            $name = $host['name'];
            break;
        }
    }
    if (empty($url)) {
        throw new Exception("Invalid Chevereto host selected.");
    }

    // Prepare upload URL
    $upload_url = $url . "json";

    // Chevereto upload logic
    $page = mimic_browser($url, false, $url, true);

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

    $page = mimic_browser($upload_url, $data, $url, true);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['status_code'] == 200) {
        $hotlink = $response['image']['url'];
        return $hotlink;
    } else
        throw new Exception("Error uploading to {$name}." . $debug ? "\n" . htmlspecialchars($page) : "");
}
