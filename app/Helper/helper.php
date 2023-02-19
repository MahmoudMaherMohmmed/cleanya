<?php

function create_avater($string)
{
    return 'https://ui-avatars.com/api/?name=' . $string;
}

function get_full_address($lat, $lng)
{
    $language = app()->getLocale();
    $lat = trim($lat);
    $lng = trim($lng);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=&callback=initMap&v=weekly&channel=2&language=$language";
    $json = @file_get_contents($url);
    $data = json_decode($json);

    return $data->results[0]->formatted_address;
}

function get_city($lat, $lng, $language)
{
    $city = '---';
    $lat = trim($lat);
    $lng = trim($lng);

    $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=&callback=initMap&v=weekly&channel=2&language=$language");

    $json_decode = json_decode($geocode);

    if (isset($json_decode->results[0])) {
        foreach ($json_decode->results[0]->address_components as $addressComponet) {
            if ($addressComponet->types[0] == 'administrative_area_level_2') {
                $city = $addressComponet->long_name;
            }
        }
    }

    return $city;
}

function get_neighborhood_name_multi_language($lat, $lng)
{
    $languages = ['en', 'ar'];
    $name = ["en" => "", "ar" => ""];
    $lat = trim($lat);
    $lng = trim($lng);

    foreach ($languages as $language) {
        $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=&callback=initMap&v=weekly&channel=2&language=$language");

        $json_decode = json_decode($geocode);

        if (isset($json_decode->results[0])) {
            //dd($json_decode->results[0]->address_components);
            foreach ($json_decode->results[0]->address_components as $addressComponet) {
                if (isset($addressComponet->types[2]) && $addressComponet->types[2] == 'sublocality_level_1') {
                    //append city name to array
                    $name[$language] = $addressComponet->long_name;
                }
            }
        }
    }

    return $name;
}

function get_neighborhood_name_multi_language_check_api($lat, $lng)
{
    $languages = ['en', 'ar'];
    $name = ["en" => "", "ar" => ""];
    $lat = trim($lat);
    $lng = trim($lng);

    foreach ($languages as $language) {
        $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=&callback=initMap&v=weekly&channel=2&language=$language");

        $json_decode = json_decode($geocode);

        if (isset($json_decode->results[0])) {
            //dd($json_decode->results[0]->address_components);
            foreach ($json_decode->results[0]->address_components as $addressComponet) {
                if (isset($addressComponet->types[2]) && $addressComponet->types[2] == 'sublocality_level_1') {
                    //append city name to array
                    $name[$language] = $addressComponet->long_name;
                } elseif (isset($addressComponet->types[0]) && $addressComponet->types[0] == 'locality') {
                    //append city name to array
                    $name[$language] = $addressComponet->long_name;
                } elseif (isset($addressComponet->types[0]) && $addressComponet->types[0] == 'administrative_area_level_2') {
                    //append city name to array
                    $name[$language] = $addressComponet->long_name;
                }
            }
        }
    }

    return $name;
}

/**
 * Write code on Method
 *
 * @return response()
 */
function send_notification($device_token, $message)
{
    $SERVER_API_KEY = '';

    // payload data, it will vary according to requirement
    $data = [
        "to" => $device_token,
        // for single device id
        "notification" => $message
    ];
    $dataString = json_encode($data);

    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_exec($ch);
    curl_close($ch);

    return true;
}

function generate_activation_code_message($activation_code)
{
    return $activation_code . ' : ' . 'كود التفعيل';
}

function sendSms($numbers, $message)
{
    $fields = [
        "userName" => "",
        "userSender" => "",
        "apiKey" => "",
        "numbers" => $numbers,
        "msg" => $message,
        "msgEncoding" => "UTF8",
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
