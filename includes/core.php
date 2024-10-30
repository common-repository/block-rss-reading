<?php

/**
 * Main functionality
 **/

// simple curl function
function curl_file_get_contents($url){

$userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0';

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
curl_setopt($curl, CURLOPT_FAILONERROR, TRUE); //To fail silently if the HTTP code returned is greater than or equal to 400.
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.	
$contents = curl_exec($curl);
curl_close($curl);

return $contents; // The content of the parsed $url

}

// Get the real ip address
function get_ip_address(){
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip){
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){ return $ip; }
            }
        }
    }
	return false; // There might not be any data
}

// Sanitize and validate
function options_validate( $input ) {global $select_options, $radio_options;
    if ( ! isset( $input['option1'] ) ) $input['option1'] = null;
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
    if ( ! isset( $input['radioinput'] ) ) $input['radioinput'] = null;
    if ( ! array_key_exists( $input['radioinput'], $radio_options ) ) $input['radioinput'] = null;
    $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
    return $input;
}

// Function to display the real feed or the admin defined one based on the client's ip
function custom_rss_feed() {
$options = get_option('block_rss_reading');
$custom_url = $options['custom_rss_url'];
$blocked_ip_list = $options['blocked_ip_list'];
$blocked_ip_list_array = explode("\n", str_replace("\r", "", $blocked_ip_list));

if ( !is_feed() ) return;

elseif ( empty($custom_url) ) return;

elseif ( in_array(get_ip_address(), $blocked_ip_list_array) ) {

    header("Content-Type: application/rss+xml; charset=UTF-8");

	if ( function_exists('curl_init') ){ // If server has cURL enabled read the url via the `curl_file_get_contents` custom curl based function.
	
	echo curl_file_get_contents($custom_url); }
	
	else { // If not, use `file_get_contents`.
	
	echo file_get_contents($custom_url); }
	
    exit();}

} // custom_rss_feed function end

add_action( 'template_redirect', 'custom_rss_feed' );

?>