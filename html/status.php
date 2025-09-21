<?php

require_once 'inc/functions.php';

$output = [];
$output['status'] = false; // Default status
$output['message'] = '';

try {
    $url = $_REQUEST['url'];
    if (!$url)
        throw new Exception("No URL");
    $url_decoded = base64_decode($url);
    if (!filter_var($url_decoded, FILTER_VALIDATE_URL))
        throw new Exception("Invalid URL");

    $headers = basic_curl_call($url_decoded, false, false, false, 'curl/8.5.0', 0, true, true);
    if (empty($headers))
        throw new Exception("No response from server");

    // Parse headers into an associative array
    $header_lines = explode("\r\n", $headers);
    $data = [];
    foreach ($header_lines as $line) {
        if (strpos($line, ':') !== false) {
            list($key, $value) = explode(': ', $line, 2);
            $key = strtolower($key); // Normalize header keys to lowercase
            $data[$key] = $value;
        }
    }

    if ($data['content-type']) {
        if (stripos($data['content-type'], 'image/') === 0) {
            $output['message'] = "Image found [{$data['content-type']}]";
            $output['status'] = true;
        } else {
            $output['message'] = "Not an image [{$data['content-type']}]: {$url_decoded}";
        }
    } else {
        $output['message'] = "No content-type found: {$url_decoded}";
    }
} catch (Exception $e) {
    $output['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($output);
exit;
