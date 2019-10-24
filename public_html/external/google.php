<?php

require ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

function getAttendance($FullName) {
    $client = new Google_Client();
    $client->setApplicationName('HuskyTech');
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Script::SCRIPT_PROJECTS]);
    $client->setAccessType('offline');
    $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'] . '/services/credentials.json');
    $spreadsheets = new Google_Service_Sheets($client);
    $call_pick = '1voKorilqdFJV3ZmoLH6oxQVsoGYyQoQ5S_AZ71FSmak';

    $names = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!A2:A")->getValues(),0);
    $callouts = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!C2:C")->getValues(),0);
    $pickups = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!D2:D")->getValues(),0);
    $attendance = ['callOuts' => 0, 'pickUps' => 0];

    $index = array_search($FullName, $names);
    $attendance['callOuts'] = $callouts[$index];
    $attendance['pickUps'] = $pickups[$index];

    return $attendance;
}

function getAllAttendance(){
    $client = new Google_Client();
    $client->setApplicationName('HuskyTech');
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Script::SCRIPT_PROJECTS]);
    $client->setAccessType('offline');
    $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'] . '/services/credentials.json');
    $spreadsheets = new Google_Service_Sheets($client);
    $call_pick = '1voKorilqdFJV3ZmoLH6oxQVsoGYyQoQ5S_AZ71FSmak';

    $names = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!A2:A")->getValues(),0);
    $callouts = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!C2:C")->getValues(),0);
    $pickups = array_column($spreadsheets->spreadsheets_values->get($call_pick, "Attendance Tracker!D2:D")->getValues(),0);
    $attendance = ['callOuts' => 0, 'pickUps' => 0];
    $HC = [];

    foreach($names as $name){
        $index = array_search($name, $names);

        $attendance['callOuts'] = $callouts[$index];
        $attendance['pickUps'] = $pickups[$index];

        $HC[$name] = $attendance;
    }

    ksort($HC);

    return $HC;
}