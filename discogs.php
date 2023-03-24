<?php

// Used ChatGPT to generate this script using the prompt "write a PHP script that will pull the tracklist from a release on discogs via their API"

// Discogs API endpoint
$discogs_url = 'https://api.discogs.com/releases/{RELEASE_ID}';

// Set your Discogs API key and secret
$discogs_api_token = 'YOUR_SECRET_TOKEN_HERE';

// Set the release ID of the release you want to retrieve
$release_id = 2655031;

// Build the URL with the release ID and Discogs API key
$url = str_replace('{RELEASE_ID}', $release_id, $discogs_url);
$url .= '?token=' . $discogs_api_token;

// Initialize cURL
$curl = curl_init();

// Set the cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'User-Agent: OPsTestApp/1.0',
        'Content-Type: application/json'
    ),
));

// Execute the cURL request and get the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
}

// Close the cURL session
curl_close($curl);

// Decode the JSON response into an associative array
$release = json_decode($response, true);

// Get the tracklist array from the release data
$tracklist = $release['tracklist'];

// Loop through the tracklist and output the track titles
foreach ($tracklist as $track) {
    echo $track['title'] . "\n";
}
?>
