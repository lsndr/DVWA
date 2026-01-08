<?php

// Define an allowlist of valid redirect targets
$valid_redirects = [
    'info.php'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    // Parse the URL to extract the host and path
    $url_parts = parse_url($_GET['redirect']);
    $host = isset($url_parts['host']) ? $url_parts['host'] : '';
    $path = isset($url_parts['path']) ? basename($url_parts['path']) : '';

    // Ensure the host is empty (relative URL) and the path is in the allowlist
    if ($host === '' && in_array($path, $valid_redirects)) {
        header("location: " . $_GET['redirect']);
        exit;
    } else {
        http_response_code(400);
        ?>
        <p>Invalid redirect target.</p>
        <?php
        exit;
    }
}

http_response_code(400);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>