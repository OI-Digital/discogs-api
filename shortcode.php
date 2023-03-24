<?php
/*
    Replace YOUR_DISCOGS_API_TOKEN with your own Discogs API (personal) token.

    Save the functions.php file.

    To use the shortcode, simply add the [discogs release_id="123456"] shortcode to any post or page, 
    replacing 123456 with the release ID of the release you want to retrieve the tracklist for.

    The shortcode will retrieve the tracklist from Discogs using the provided release ID and 
    display it as an unordered list. You can modify the HTML output in the discogs_shortcode() function 
    to suit your needs.
*/


// Add Discogs shortcode
function discogs_shortcode($atts) {
    // Get the release ID from the shortcode attributes
    $release_id = $atts['release_id'];

    // Set your Discogs API key and secret
    $discogs_api_token = 'YOUR_DISCOGS_API_TOKEN';

    // Set the Discogs API endpoint URL
    $discogs_url = "https://api.discogs.com/releases/$release_id";

    // Create a new cURL resource
    $curl = curl_init();

    // Set the cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $discogs_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'User-Agent: OPsGPTTestApp/1.0',
            'Authorization: Discogs token=' . $discogs_api_token,
        ),
    ));

    // Execute the cURL request and get the response
    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        echo 'Error: ' . curl_error($curl);
    }

    // Close the cURL resource
    curl_close($curl);

    // Decode the JSON response into an associative array
    $release = json_decode($response, true);

    // Get the tracklist array from the release data
    $tracklist = $release['tracklist'];

    // Loop through the tracklist and output the track titles
    $output = '<ul>';
    foreach ($tracklist as $track) {
        $output .= '<li>' . $track['title'] . '</li>';
    }
    $output .= '</ul>';

    // Return the output
    return $output;
}
add_shortcode('discogs', 'discogs_shortcode');
