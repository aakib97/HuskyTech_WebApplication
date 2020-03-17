<?php
/* phpCAS CONFIGURATION */
session_start();

//Import the phpCAS Library
include_once('./CAS/CAS.php');
require('./classes/Employee.class.php');

// Initialize phpCAS
phpCAS::client(SAML_VERSION_1_1, "uconn cas login", 'port number', "type of login");
phpCAS::setNoCasServerValidation();

// check CAS authentication
$auth = phpCAS::checkAuthentication();

if (!$auth) {
    phpCAS::forceAuthentication();
} else {
    $netid = phpCAS::getUser();

    $user = findEmployee($netid);

    if ($user) {
        header('location: dashboard.php');
    } else {
        header('location: nonEmployee.php');
    }
}
