<?php

$delibera=json_decode(file_get_contents("php://input"),true);
$jsonData =json_encode($delibera);
file_put_contents("delibera.json",$jsonData );

$url = 'http://localhost:8000/nuovaDelibera';

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url); // URL to request
curl_setopt($ch, CURLOPT_PORT, 8000); // Replace PORT with the port number
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify SSL certificate
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);   // Verify host name
curl_setopt($ch, CURLOPT_POST, true);         // Specify POST request
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Attach JSON data

// Set HTTP headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',  // JSON payload
]);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    // Decode JSON response
    //$decodedResponse = json_decode($response, true);
    echo "Response: ".$response;
    //print_r($decodedResponse);
}

// Close cURL session
curl_close($ch);
?>