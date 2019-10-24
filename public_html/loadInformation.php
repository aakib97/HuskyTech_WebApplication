<?php
//Import the phpCAS Library
include_once('./CAS/CAS.php');
require('./classes/Employee.class.php');

// Initialize phpCAS
phpCAS::client(SAML_VERSION_1_1, "uconn cas login", 'port number', "type of login");
phpCAS::setNoCasServerValidation();

$requested_page = $_POST['argument'];
$form = $_POST['form'];

// check CAS authentication
$auth = phpCAS::checkAuthentication();

$netid = phpCAS::getUser();
$user = findEmployee($netid);

if ($form == 'modalStudent'){
    $HC_workers = $user->getEmployees();

    $worker = $HC_workers[$requested_page];

    $output = ['first' => $worker->First, 'last' => $worker->Last, 'netid' => $worker->NetID,
        'full' => $worker->Full, 'rank' => $worker->Role, 'ID' => $worker->blackboardID, 'team' => $worker->Team, 'email' => $worker->Email, 'StudentEmail' => $worker->StudentEmail,
        'grad' => $worker->Graduation, 'acd' => $worker->ACD, 'notes' => $worker->Notes];
    echo json_encode($output);
}

if ($form == 'modalSupply'){
    $submissions = $user->equipmentSubmissions();

    foreach ($submissions as $submission){
        if ($requested_page == $submission[0]){
            $sub = $submission;
            break;
        }
    }

    $output = ['ID' => $sub[0],'name' => $sub[1], 'rank' => $sub[2], 'supplies' => $sub[3],
        'comments' => $sub[4], 'status' => $sub[5], 'feedback' => $sub[6]];

    echo json_encode($output);
}

if ($form == 'mymodalSupply'){
    $submissions = $user->equipmentRequest();

    foreach ($submissions as $submission){
        if ($requested_page == $submission[0]){
            $sub = $submission;
            break;
        }
    }

    $output = ['ID' => $sub[0],'name' => $sub[1], 'rank' => $sub[2], 'supplies' => $sub[3],
        'comments' => $sub[4], 'status' => $sub[5], 'feedback' => $sub[6]];

    echo json_encode($output);
}

if ($form == 'feedSub'){
    $submissions = $user->allFeedbacks();

    foreach ($submissions as $submission){
        if ($requested_page == $submission[0]){
            $sub = $submission;
            break;
        }
    }

    $output = ['ID' => $sub[0],'name' => $sub[1], 'rank' => $sub[2], 'tech' => $sub[3],
        'type' => $sub[4], 'comments' => $sub[5]];

    echo json_encode($output);
}

if ($form == 'sync'){
    $HC_workers = $user->getEmployees();
    $output = [];

    foreach($HC_workers as $worker){
        $worker->setBlackboardID();
        $output[$worker->NetID] = $worker->blackboardID;
    }

    echo $output;
}