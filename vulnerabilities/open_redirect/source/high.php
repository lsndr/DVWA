<?php

// Define an allowlist of valid redirect targets
$valid_redirects = [
    'info.php'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    // Parse the URL to extract the path
    $url_parts = parse_url($_GET['redirect']);
    $path = isset($url_parts['path']) ? basename($url_parts['path']) : '';

    // Check if the path is in the allowlist
    if (in_array($path, $valid_redirects)) {
        header("location: " . $_GET['redirect']);
        exit;
    } else {
        http_response_code(500);
        ?>
        <p>You can only redirect to the info page.</p>
        <?php
        exit;
    }
}

http_response_code(500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>