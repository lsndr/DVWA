<?php

// Define an allowlist of approved URLs for redirection
$allowed_urls = [
    'https://trustedsite.com',
    'https://anothertrustedsite.com'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    $redirect_url = $_GET['redirect'];
    
    // Parse the URL to ensure it is valid and extract the host
    $parsed_url = parse_url($redirect_url);
    if ($parsed_url !== false && isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
        $redirect_host = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        
        // Validate the host against the allowlist
        if (in_array($redirect_host, $allowed_urls)) {
            header("location: " . $redirect_url);
            exit;
        }
    }
    
    // If the URL is not in the allowlist, do not redirect
    http_response_code(400);
    echo "Invalid redirect target.";
    exit;
}

http_response_code(500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>