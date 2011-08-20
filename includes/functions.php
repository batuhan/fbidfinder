<?php

function curl_get_contents($url) {
    
        // this function was found on http://fusionswift.com/blog/2010/02/curl-vs-file_get_contents/
        
	// Initiate the curl session
	$ch = curl_init();
	// Set the URL
	curl_setopt($ch, CURLOPT_URL, $url);
	// Removes the headers from the output
	curl_setopt($ch, CURLOPT_HEADER, 0);
	// Return the output instead of displaying it directly
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// Execute the curl session
	$output = curl_exec($ch);
	// Close the curl session
	curl_close($ch);
	// Return the output as a variable
	return $output;
}


function get_fb_info($username){
    
    // should I check somethings here?
    
    $data = curl_get_contents('http://graph.facebook.com/'.$username);    
    $data = json_decode($data, TRUE);
    
    if( ! isset($data['error']) )
        return $data;
    else
        return FALSE;
    
}