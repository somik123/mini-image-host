<?php

if ($_REQUEST['short_code']) {
    // Initialize output array
    $output = ['status' => false, 'message' => 'Unknown error'];

    try {
        // Include necessary files
        require_once 'inc/functions.php';
        require_once("inc/ext_hosts.php");

        // Get the short code from the request
        $short_code = $_REQUEST['short_code'];
        if (!$short_code)
            throw new Exception("No short code provided");

        // Read filehosts file for external file host functions
        $ext_link = get_ext_link($short_code, false);
        if (!$ext_link)
            throw new Exception("Short code not found in database");

        // Validate the URL format
        if (!filter_var($ext_link, FILTER_VALIDATE_URL))
            throw new Exception("Invalid URL format: {$ext_link}");

        // Make a HEAD request to the URL to check if it's an image
        $headers = basic_curl_call($ext_link, false, false, false, 'curl/8.5.0', 0, true, true);
        if (empty($headers))
            throw new Exception("No response from server for URL: {$ext_link}");

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

        // Check the Content-Type header
        if ($data['content-type']) {
            if (stripos($data['content-type'], 'image/') === 0) {
                $output['message'] = "Image found [{$data['content-type']}]";
                $output['status'] = true;
            } else {
                $output['message'] = "Not an image [{$data['content-type']}]: {$ext_link}";
            }
        } else {
            $output['message'] = "No content-type found: {$ext_link}";
        }
    } catch (Exception $e) { // Catch any exceptions and set the error message
        $output['message'] = $e->getMessage();
    }

    // Return the output as JSON
    header('Content-Type: application/json');
    echo json_encode($output);
    exit;
}
