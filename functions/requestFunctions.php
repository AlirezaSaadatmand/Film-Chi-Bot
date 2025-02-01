<?php

function chatBot($data)
{

    $gpt3 = 'https://api.one-api.ir/chatbot/v1/gpt3.5-turbo/';
    $gpt4 = 'https://api.one-api.ir/chatbot/v1/gpt4o/';

    $url = $gpt3;

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
    return json_decode($response, true);
}

function makeChat($chatId, $userFile, $questionFile)
{

    if (!file_exists($userFile)) {
        return "USERFILE NOT FOUND";
    }

    if (!file_exists($questionFile)) {
        return "DATAFILE NOT FOUND";
    }
    $text = "یک فرد به تعدادی سوال پاسخ داده است.  
    براساس این پاسخ‌ها، 4 فیلم یا سریال پیشنهاد بده.  
    🔹 برای هر مورد، اطلاعات زیر را ارائه کن:
    - عنوان فیلم
    - توضیح کوتاه در مورد فیلم
    - لینک IMDb  
    📌 **فقط همین اطلاعات را برگردان و چیز دیگری اضافه نکن.**  
    فرمت پاسخ باید دقیقاً به این شکل باشد و بدون توضیحات اضافه:  
    
    ---
    Title: [نام فیلم یا سریال]  
    Description: [توضیح کوتاه]  
    IMDb: [لینک IMDb]  
    --- ";

    $userJsonData = file_get_contents($userFile);
    $userData = json_decode($userJsonData, true);

    $text .= "\n\n📌 **سوالات و پاسخ‌های کاربر:**\n";

    foreach ($userData['users'] as $user) {
        if ($user['chatid'] === $chatId) {
            foreach ($user['answers'] as $questionNumber => $answer) {
                $q = getQuestion($questionNumber, $questionFile);

                $text .= "❓ سوال: {$q}\n";
                $text .= "✅ جواب: {$answer}\n";
            }
            break;
        }
    }

    addRequestCount($chatId, $userFile);
    return chatBot($text);
}

