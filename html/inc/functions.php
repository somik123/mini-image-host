<?php
// Prevent direct access to this file
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Direct access not allowed.');
}


// Conver byte size to human redable size
function human_readable_size($raw_size, $return_array = true)
{
    $size_arr = array("B", "KB", "MB", "GB", "TB", "PB");
    $max = count($size_arr) - 1;

    // Loop to find the most suitable size
    for ($i = $max; $i >= 0; $i--) {
        $value = pow(1024, $i);

        if ($raw_size > $value) {
            $size_hr = round(($raw_size / $value), 2);

            return $return_array ? array($size_hr, $size_arr[$i]) : "{$size_hr} {$size_arr[$i]}";
        }
    }
}



// Function used to generate a random string for filename
function rand_str($length = 10)
{
    $char_set = '23456789abcdefghjkmnpqrtuvwxyzABCDEFGHJKLMNPQRTUVWXYZ';
    $repeat_count = ceil($length / strlen($char_set));
    $long_string = str_repeat($char_set, $repeat_count);
    $shuffled = str_shuffle($long_string);
    return substr($shuffled, 0, $length);
}



// Function to perform HTTP requests using cURL and return the response
// This mimics a browser request as much as possible
function mimic_browser($upload_url, $data = false, $reffer = false, $cookie = false, $head = false)
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


// Basic cURL function to handle requests with more options
// This is used for 0x0.st, UpImg and ImgBox, and mimics curl or ajax requests
function basic_curl_call(
    $url,
    $request_type = "post",
    $data = "",
    $headers = [],
    $user_agent = "",
    $cookie_file = "",
    $ignore_ssl = false,
    $headonly = false
) {
    // Using basic curl to handle 0x0.st specific requirements
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set user agent if provided
    if ($user_agent)
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

    // Set request type
    if ($request_type == "post")
        curl_setopt($ch, CURLOPT_POST, true);
    else
        curl_setopt($ch, CURLOPT_HTTPGET, true);

    // Set data if provided
    if ($data)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Set headers if provided
    if ($headers)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Set cookie file if provided
    if ($cookie_file) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    }

    // Ignore SSL verification if specified
    if ($ignore_ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }

    // If headonly is true, set to fetch headers only
    if ($headonly) {
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
    }


    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $page = curl_exec($ch);

    // Check for curl errors
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);

    return $page;
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



// Generate an image from text using Imagick
function text2image($text)
{
    // Settings
    $font_size = 24;
    $font_file = __DIR__ . "/calibri-regular.ttf"; // Ensure this font exists
    $max_width = 800;
    $line_height = 30;
    $background_color = "#303030";
    $text_color = "#FFFFFF";
    $padding_top = 30;
    $padding_left = 20;

    // Prepare ImagickDraw for metrics and drawing
    $draw = new ImagickDraw();
    $draw->setFont($font_file);
    $draw->setFontSize($font_size);
    $draw->setTextAntialias(true); // Enable anti-aliasing for text

    // Word wrap the text
    $wrapped_lines = [];
    foreach (explode("\n", $text) as $line) {
        $words = explode(' ', $line);
        $current_line = '';
        foreach ($words as $word) {
            $test_line = $current_line === '' ? $word : $current_line . ' ' . $word;
            $metrics = (new Imagick())->queryFontMetrics($draw, $test_line);
            if ($metrics['textWidth'] > $max_width - 2 * $padding_left) {
                if ($current_line !== '') {
                    $wrapped_lines[] = $current_line;
                }
                $current_line = $word;
            } else {
                $current_line = $test_line;
            }
        }
        if ($current_line !== '') {
            $wrapped_lines[] = $current_line;
        }
    }

    $height = max(100, count($wrapped_lines) * $line_height + $padding_top + 10);

    // Create image
    $image = new Imagick();
    $image->newImage($max_width, $height, new ImagickPixel($background_color));
    $image->setImageFormat('png');

    // Prepare for drawing text
    $draw->setFillColor(new ImagickPixel($text_color));
    $draw->setTextAlignment(Imagick::ALIGN_LEFT);

    // Draw each line
    $y = $padding_top;
    foreach ($wrapped_lines as $line) {
        $image->annotateImage($draw, $padding_left, $y, 0, $line);
        $y += $line_height;
    }

    // Output the image
    header("Content-Type: image/png");
    echo $image;
    $image->destroy();
    exit;
}



// Clean up temporary files and exit
function cleanup()
{
    global $cookie_file, $file;
    if ($cookie_file)
        @unlink($cookie_file);
    if ($file && isset($file['tmp_name']) && file_exists($file['tmp_name']))
        @unlink($file['tmp_name']);
}


// HTML Footer
function html_footer($contact)
{
    global $enable_short_links_for_external_hosts, $enable_external_hosts;
?>
    <!-- Footer Start -->
    <div class="footer text-center small mt-4 footer-div">
        <a href="./">Home</a>
        <?php if ($enable_short_links_for_external_hosts && $enable_external_hosts): ?>
            | <a href="?links">Ext Links</a>
        <?php endif; ?>
        | <a href="?gallery">Gallery</a>
        <?php if ($contact && $contact != "#"): ?>
            | <a href="<?= $contact ?>" target="_blank">Reach out</a>
        <?php endif; ?>
        <br />

        Copyright &copy; <?= date("Y") ?> <a href="https://somik.org/" target="_blank">Somik.org</a>
    </div>
    <!-- Footer End -->
<?php
}
