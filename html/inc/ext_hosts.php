<?php


$external_hosts = array();
$chevereto_hosts = array();
$ext_links_db = '../db/ext_links.db';


init_external_hosts();
initialize_ext_links_db();


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
    );

    $external_hosts[] = array(
        'name' => 'CatBox',
        'function' => 'upload_to_catbox',
        'url' => 'https://catbox.moe/',
    );

    $external_hosts[] = array(
        'name' => 'Pomf2.Lain.la',
        'function' => 'upload_to_pomf2_lain_la',
        'url' => 'https://pomf2.lain.la/',
    );

    $external_hosts[] = array(
        'name' => '0x0.st',
        'function' => 'upload_to_0x0_st',
        'url' => 'https://0x0.st/',
    );

    $external_hosts[] = array(
        'name' => 'UploadImgur',
        'function' => 'upload_to_imgur',
        'url' => 'https://uploadimgur.com/',
    );

    $external_hosts[] = array(
        'name' => 'MyImgs.org',
        'function' => 'upload_to_myimgs',
        'url' => 'https://myimgs.org/',
    );

    $external_hosts[] = array(
        'name' => 'ImgHost.cc',
        'function' => 'upload_to_imghost',
        'url' => 'https://imghost.cc/',
    );

    $external_hosts[] = array(
        'name' => 'UpImg',
        'function' => 'upload_to_upimg',
        'url' => 'https://upimg.com/',
    );

    $external_hosts[] = array(
        'name' => 'ImgBox',
        'function' => 'upload_to_imgbox',
        'url' => 'https://imgbox.com/',
    );

    $external_hosts[] = array(
        'name' => 'ImgBB (API)',
        'function' => 'upload_to_imgbb',
        'url' => 'https://imgbb.com/',
    );

    $external_hosts[] = array(
        'name' => 'ImgPaste',
        'function' => 'upload_to_imgpaste',
        'url' => 'https://imgpaste.net/',
    );

    $external_hosts[] = array(
        'name' => 'PngUp',
        'function' => 'upload_to_pngup',
        'url' => 'https://pngup.org/',
    );

    $external_hosts[] = array(
        'name' => 'SnipShot.io',
        'function' => 'upload_to_snipshot',
        'url' => 'https://snipshot.io/',
    );

    $external_hosts[] = array(
        'name' => 'ImgIU',
        'function' => 'upload_to_imgiu',
        'url' => 'https://imgiu.com/',
    );

    $external_hosts[] = array(
        'name' => 'FileShare.ing',
        'function' => 'upload_to_fileshare_ing',
        'url' => 'https://fileshare.ing/',
    );

    $external_hosts[] = array(
        'name' => 'Xilt.net',
        'function' => 'upload_to_xilt_net',
        'url' => 'https://xilt.net/',
    );

    $external_hosts[] = array(
        'name' => 'WindyPix',
        'function' => 'upload_to_windypix',
        'url' => 'https://windypix.com/',
    );

    $external_hosts[] = array(
        'name' => 'ImgLink.io',
        'function' => 'upload_to_imglink_io',
        'url' => 'https://imglink.io/',
    );

    $external_hosts[] = array(
        'name' => 'BigByte.no',
        'function' => 'upload_to_bigbyte_no',
        'url' => 'http://img.bigbyte.no/',
    );

    $external_hosts[] = array(
        'name' => 'Image2url',
        'function' => 'upload_to_image2url',
        'url' => 'https://image2url.com/',
    );

    $external_hosts[] = array(
        'name' => 'DragNdropZ',
        'function' => 'upload_to_dragndropz',
        'url' => 'https://dragndropz.com/',
    );

    $external_hosts[] = array(
        'name' => 'AnonPic.org',
        'function' => 'upload_to_anonpic_org',
        'url' => 'https://anonpic.org/',
    );

    $external_hosts[] = array(
        'name' => 'PicSer.Pages.dev',
        'function' => 'upload_to_picser_pages_dev',
        'url' => 'https://picser.pages.dev/',
    );

    $external_hosts[] = array(
        'name' => 'ImgPx',
        'function' => 'upload_to_imgpx',
        'url' => 'https://imgpx.com/',
    );

    $external_hosts[] = array(
        'name' => 'ImgLink.app',
        'function' => 'upload_to_imglink_app',
        'url' => 'https://imglink.app/',
    );

    $external_hosts[] = array(
        'name' => 'HostPic.org',
        'function' => 'upload_to_hostpic_org',
        'url' => 'https://hostpic.org/',
    );









    // Define Chevereto-based hosts
    $chevereto_hosts[] = array(
        'name' => 'ImgBB',
        'function' => 'upload_to_imgbb',
        'function_alt' => 'upload_to_chevereto',
        'url' => 'https://imgbb.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'FreeImage.host',
        'function' => 'upload_to_chevereto',
        'url' => 'https://freeimage.host/',
    );

    $chevereto_hosts[] = array(
        'name' => 'HostImage.org',
        'function' => 'upload_to_chevereto',
        'url' => 'https://hostimage.org/',
    );

    $chevereto_hosts[] = array(
        'name' => 'PasteImg',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pasteimg.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgBB.ws',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgbb.ws/',
    );

    $chevereto_hosts[] = array(
        'name' => 'Img.in.th',
        'function' => 'upload_to_chevereto',
        'url' => 'https://www.img.in.th/',
    );

    $chevereto_hosts[] = array(
        'name' => 'Inspirats',
        'function' => 'upload_to_chevereto',
        'url' => 'https://inspirats.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'FxPics.ru',
        'function' => 'upload_to_chevereto',
        'url' => 'https://fxpics.ru/',
    );

    $chevereto_hosts[] = array(
        'name' => 'Poop.pictures',
        'function' => 'upload_to_chevereto',
        'url' => 'https://poop.pictures/',
    );

    $chevereto_hosts[] = array(
        'name' => 'Site.pictures',
        'function' => 'upload_to_chevereto',
        'url' => 'https://site.pictures/',
    );

    $chevereto_hosts[] = array(
        'name' => 'SnappyPic',
        'function' => 'upload_to_chevereto',
        'url' => 'https://snappypic.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'Eikona.info',
        'function' => 'upload_to_chevereto',
        'url' => 'https://eikona.info/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgCDN.dev',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgcdn.dev/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgUh',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imguh.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgShare.pl',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgshare.pl/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgKub',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgkub.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgHive',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imghive.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'JpgJet',
        'function' => 'upload_to_chevereto',
        'url' => 'https://jpgjet.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'PostImage.me',
        'function' => 'upload_to_chevereto',
        'url' => 'https://postimage.me/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgTap',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imgtap.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ZippyImage',
        'function' => 'upload_to_chevereto',
        'url' => 'https://zippyimage.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'PixShare.de',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pixshare.de/',
    );

    $chevereto_hosts[] = array(
        'name' => 'PixelStash.co',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pixelstash.co/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImageCC.net',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imagecc.net/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImgHit',
        'function' => 'upload_to_chevereto',
        'url' => 'https://www.imghit.com/',
    );

    $chevereto_hosts[] = array(
        'name' => 'ImageHost.me',
        'function' => 'upload_to_chevereto',
        'url' => 'https://imagehost.me/',
    );

    $chevereto_hosts[] = array(
        'name' => 'PicHost.net',
        'function' => 'upload_to_chevereto',
        'url' => 'https://pichost.net/',
    );



    // Sort hosts alphabetically by name and add index
    usort($external_hosts, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    foreach ($external_hosts as $index => &$host) {
        $host['index'] = $index + 1; // Start external hosts index from 1
    }

    usort($chevereto_hosts, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    foreach ($chevereto_hosts as $index => &$host) {
        $host['index'] = $index + 101; // Start Chevereto hosts index from 101
    }
}



function upload_to_postimages($curlfile)
{
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
        throw new Exception("Error uploading to PostImages" . add_full_error_info($page));
    }
}


function upload_to_catbox($curlfile)
{
    // CatBox upload logic
    $upload_url = 'https://catbox.moe/user/api.php';
    $data = array('reqtype' => 'fileupload', 'fileToUpload' => $curlfile);
    $page = mimic_browser($upload_url, $data);

    // Check if upload was successful
    if (strpos($page, 'files.catbox.moe') !== false) {
        return trim($page);
    } else {
        throw new Exception("Error uploading to CatBox" . add_full_error_info($page));
    }
}


function upload_to_pomf2_lain_la($curlfile)
{
    // pomf2.lain.la upload logic
    $upload_url = 'https://pomf2.lain.la/upload.php';
    $data = array('files[]' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success'] == "true") {
        return $response['files'][0]['url'];
    } else {
        throw new Exception("Error uploading to pomf2.lain.la" . add_full_error_info($page));
    }
}


function upload_to_0x0_st($curlfile)
{
    // 0x0.st upload logic
    $upload_url = 'https://0x0.st';
    $data = array('file' => $curlfile);

    // Using basic curl to handle 0x0.st specific requirements
    $page = basic_curl_call($upload_url, "post", $data, [], 'curl/8.5.0');

    // Check if upload was successful
    if (strpos($page, '0x0.st') !== false) {
        return trim($page);
    } else {
        throw new Exception("Error uploading to 0x0.st" . add_full_error_info($page));
    }
}


function upload_to_imgur($curlfile)
{
    // UploadImgur upload logic
    $upload_url = "https://uploadimgur.com/api/upload";
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['link']) {
        return $response['link'];
    } else {
        throw new Exception("Error uploading to UploadImgur" . add_full_error_info($page));
    }
}


function upload_to_myimgs($curlfile)
{
    // myimgs.org upload logic
    $url = "http://myimgs.org/";
    $upload_url = "https://myimgs.org/";
    $page = mimic_browser($url, false, $url, true);
    preg_match('#name="_token" value="([^"]+)"#si', $page, $matches);

    // Check if token was found
    $token = $matches[1];
    if (empty($token)) {
        throw new Exception("Error retrieving token from myimgs.org." . add_full_error_info($page));
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
        throw new Exception("Error uploading to myimgs.org" . add_full_error_info($page));
    }
}



function upload_to_imghost($curlfile)
{
    // imghost.cc upload logic
    $upload_url = "https://imghost.cc/upload";
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);

    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['filename']) {
        return "https://i.imghost.cc/" . $response['filename'];
    } else {
        throw new Exception("Error uploading to imghost.cc" . add_full_error_info($page));
    }
}



function upload_to_upimg($curlfile)
{
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
        throw new Exception("Error uploading to upimg.com" . add_full_error_info($page));
    }
}



function upload_to_imgbox($curlfile)
{
    global $cookie_file;

    // ImgBox upload logic
    $url = "https://imgbox.com/";
    $session_url = $url . "/ajax/token/generate";
    $upload_url = $url . "/upload/process";

    // Get X-CSRF-Token
    $page = mimic_browser($url, false, '', true);

    preg_match('#<input name="authenticity_token" type="hidden" value="([^"]+)"#si', $page, $matches);
    $csrf_token = $matches[1];
    if (empty($csrf_token)) {
        throw new Exception("Error retrieving CSRF token from ImgBox." . add_full_error_info($page));
    }

    // Set required headers for ImgBox
    $headers = ['X-CSRF-Token: ' . $csrf_token];
    // Get session token
    $page = basic_curl_call($session_url, "post", "", $headers, "", $cookie_file);

    if (stristr($page, "token_secret") === FALSE) {
        throw new Exception("Error retrieving session token from ImgBox." . add_full_error_info($page));
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
        throw new Exception("Error uploading to ImgBox." . add_full_error_info($page));
    }
    $response = json_decode($page, true);
    return $response['files'][0]['original_url'];
}



function upload_to_imgbb($curlfile)
{
    global $imgbb_api_key;

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
        throw new Exception("Error uploading to Imgbb via API" . add_full_error_info($page));
    }
}



function upload_to_imgpaste($curlfile)
{
    // ImgPaste upload logic
    $upload_url = 'https://api.imgpaste.net/upload';
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['url']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to ImgPaste" . add_full_error_info($page));
    }
}



function upload_to_pngup($curlfile)
{
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
        throw new Exception("Error uploading to PngUp" . add_full_error_info($page));
    }
}



function upload_to_snipshot($curlfile)
{
    // Snipshot upload logic
    $upload_url = 'https://snipshot.io/upload';
    $data = array('image' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['status'] == 'success') {
        return $response['image_path'];
    } else {
        throw new Exception("Error uploading to Snipshot" . add_full_error_info($page));
    }
}



function upload_to_imgiu($curlfile)
{
    // ImgiU upload logic
    $upload_url = 'https://imgiu.com/upload.php';
    $data = array('file[0]' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['success']) {
        return $response['files'][0]['url'];
    } else {
        throw new Exception("Error uploading to ImgiU" . add_full_error_info($page));
    }
}



function upload_to_fileshare_ing($curlfile)
{
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
        throw new Exception("Error uploading to fileshare.ing" . add_full_error_info($page));
    }
}


function upload_to_xilt_net($curlfile)
{
    // Xilt.net upload logic
    $upload_url = 'https://xilt.net/inc/upload.php';
    $data = array('file[]' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response[0]) {
        return $response[0];
    } else {
        throw new Exception("Error uploading to Xilt.net" . add_full_error_info($page));
    }
}



function upload_to_windypix($curlfile)
{
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
    throw new Exception("Error uploading to AnonPic.org" . add_full_error_info($page));
}


function upload_to_imglink_io($curlfile)
{
    // Imglink.io upload logic
    $upload_url = 'https://imglink.io/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);
    // Check if upload was successful
    if ($response['success']) {
        return $response['images'][0]['direct_link'];
    } else {
        throw new Exception("Error uploading to Imglink.io" . add_full_error_info($page));
    }
}


function upload_to_bigbyte_no($curlfile)
{
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
    throw new Exception("Error uploading to AnonPic.org" . add_full_error_info($page));
}



function upload_to_image2url($curlfile)
{
    // Image2url upload logic
    $upload_url = 'https://www.image2url.com/api/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to Image2url" . add_full_error_info($page));
    }
}



function upload_to_dragndropz($curlfile)
{
    // DragNdropZ upload logic
    $upload_url = 'https://serv1.dragndropz.com/image_uploader.php';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['image_path']) {
        return $response['image_path'];
    } else {
        throw new Exception("Error uploading to DragNdropZ" . add_full_error_info($page));
    }
}



function upload_to_anonpic_org($curlfile)
{
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
    throw new Exception("Error uploading to AnonPic.org" . add_full_error_info($page));
}



function upload_to_picser_pages_dev($curlfile)
{
    // PicSer.Pages.dev upload logic
    $upload_url = 'https://picser.pages.dev/api/upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['url'];
    } else {
        throw new Exception("Error uploading to PicSer.Pages.dev" . add_full_error_info($page));
    }
}


function upload_to_imgpx($curlfile)
{
    // ImgPx upload logic
    $url = "https://imgpx.com/";
    $upload_url = "https://imgpx.com/uploads";

    $page = mimic_browser($url, false, $url, true);
    preg_match('#name="upload_token" value="([^"]+)"#si', $page, $matches);
    if (empty($matches[1])) {
        throw new Exception("Error retrieving token from ImgPx." . add_full_error_info($page));
    }
    $upload_token = $matches[1];
    $data = array(
        "upload_token" => $upload_token,
        "fileToUpload[]" => $curlfile,
        "photoSize" => "original"
    );
    $page = mimic_browser($upload_url, $data, $url, true);

    // Check if upload was successful
    preg_match_all('#\[IMG\]([^\[]+)\[\/IMG\]#si', $page, $matches);

    foreach ($matches[1] as $match) {
        if (strpos($match, '/thumbnail/') === false) {
            return $match; // Return the first direct link without '/thumbnail/'
        }
    }
}



function upload_to_imglink_app($curlfile)
{
    // Imglink.app upload logic
    $upload_url = 'https://imglink.app/api/blob-upload';
    $data = array('file' => $curlfile);
    $page = mimic_browser($upload_url, $data);
    $response = json_decode($page, true);

    // Check if upload was successful
    if ($response['success']) {
        return $response['links']['direct'];
    } else {
        throw new Exception("Error uploading to Imglink.app" . add_full_error_info($page));
    }
}



function upload_to_hostpic_org($curlfile)
{
    // HostPic.org upload logic
    $upload_url = 'https://www.hostpic.org/inc/uploader.php';
    $data = array('thefile0' => $curlfile);
    $page = basic_curl_call($upload_url, "post", $data, [], 'curl/8.5.0', 0, true);

    $parts = explode("','|", $page);

    // Check if upload was successful
    if ($parts[4]) {
        return trim($parts[4]);
    } else {
        throw new Exception("Error uploading to HostPic.org" . add_full_error_info($page));
    }
}








// Index 100+ are all chevereto hosts
function upload_to_chevereto($curlfile, $file_host, $mime_type)
{
    global $chevereto_hosts;

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
        throw new Exception("Error retrieving token from {$name}." . add_full_error_info($page));

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
        throw new Exception("Error uploading to {$name}." . add_full_error_info($page));
}


// Initialize sqlite database for external links if not exists
function initialize_ext_links_db()
{
    global $ext_links_db;

    if (!file_exists($ext_links_db)) {
        $db = new SQLite3($ext_links_db);
        $db->exec("CREATE TABLE IF NOT EXISTS links (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            ext_link TEXT NOT NULL,
            short_code TEXT NOT NULL UNIQUE,
            file_ext TEXT NOT NULL,
            delete_code TEXT NOT NULL UNIQUE,
            created DATETIME DEFAULT CURRENT_TIMESTAMP,
            creator_ip TEXT NOT NULL,
            hits INTEGER DEFAULT 0,
            last_accessed DATETIME,
            enabled INTEGER DEFAULT 1
        )");
        $db->close();
    }
}


// Add new external link to the database
function add_ext_link($ext_link, $short_code = "", $file_ext = "")
{
    global $ext_links_db;

    $db = new SQLite3($ext_links_db, SQLITE3_OPEN_READWRITE);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    // Generate a random delete code (not used for now)
    $delete_code = rand_str(15);

    // If no file extension provided, default to jpg
    if (empty($file_ext))
        $file_ext = "jpg";

    // If no short_code provided, generate a unique one
    if (empty($short_code)) {
        // Generate unique short_code and delete_code
        do {
            $short_code = rand_str(10);
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM links WHERE short_code = :short_code");
            $stmt->bindValue(':short_code', $short_code, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);
        } while ($row['count'] > 0);
    }

    $created = date('Y-m-d H:i:s');
    $creator_ip = get_client_ip();

    $stmt = $db->prepare("INSERT INTO links (ext_link, short_code, file_ext, delete_code, created, creator_ip) 
                          VALUES (:ext_link, :short_code, :file_ext, :delete_code, :created, :creator_ip)");
    $stmt->bindValue(':file_ext', $file_ext, SQLITE3_TEXT);
    $stmt->bindValue(':ext_link', $ext_link, SQLITE3_TEXT);
    $stmt->bindValue(':short_code', $short_code, SQLITE3_TEXT);
    $stmt->bindValue(':delete_code', $delete_code, SQLITE3_TEXT);
    $stmt->bindValue(':created', $created, SQLITE3_TEXT);
    $stmt->bindValue(':creator_ip', $creator_ip, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();
    return array('short_code' => $short_code, 'delete_code' => $delete_code);
}


// Retrieve external link details by short code
function get_ext_link($short_code)
{
    global $ext_links_db;

    $db = new SQLite3($ext_links_db, SQLITE3_OPEN_READWRITE);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $stmt = $db->prepare("SELECT * FROM links WHERE short_code = :short_code AND enabled = 1");
    $stmt->bindValue(':short_code', $short_code, SQLITE3_TEXT);
    $result = $stmt->execute();
    $link = $result->fetchArray(SQLITE3_ASSOC);

    if ($link) {
        // Update hit count and last accessed time
        $stmt = $db->prepare("UPDATE links SET hits = hits + 1, last_accessed = :last_accessed WHERE id = :id");
        $stmt->bindValue(':last_accessed', date('Y-m-d H:i:s'), SQLITE3_TEXT);
        $stmt->bindValue(':id', $link['id'], SQLITE3_INTEGER);
        $stmt->execute();
    }
    $db->close();

    return $link ? $link['ext_link'] : null;
}


// Delete external link by short code as Admin
function delete_ext_link($short_code)
{
    global $ext_links_db;

    $db = new SQLite3($ext_links_db, SQLITE3_OPEN_READWRITE);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $stmt = $db->prepare("DELETE FROM links WHERE short_code = :short_code");
    $stmt->bindValue(':short_code', $short_code, SQLITE3_TEXT);
    $result = $stmt->execute();
    $changes = $db->changes();
    $db->close();
    return $changes > 0;
}



// Show all external links
function list_ext_links()
{
    global $ext_links_db;

    $db = new SQLite3($ext_links_db, SQLITE3_OPEN_READONLY);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $results = $db->query("SELECT * FROM links ORDER BY created DESC");
    $links = [];
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $links[] = $row;
    }
    $db->close();
    return $links;
}



// Get client IP address
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function add_full_error_info($page)
{
    global $debug;

    if ($debug) {
        return "\n\nDebug info: \n" . htmlspecialchars($page);
    } else {
        return "";
    }
}
