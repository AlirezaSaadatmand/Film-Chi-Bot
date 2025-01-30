<?php

function chatBot($data) {
    
    $url  = 'CHAT BOT URL';
    
    $data = [["role" => "user", "content" => $data]];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json'], ["one-api-token:" . APIKEY]),
    ]);


    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $response = 'Error: ' . curl_error($curl);
    }

    curl_close($curl);
    return json_decode($response , true)["result"];
}