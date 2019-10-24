<?php
//Import the phpCAS Library
include_once('./CAS/CAS.php');
require('./classes/Employee.class.php');

// Initialize phpCAS
phpCAS::client(SAML_VERSION_1_1, "uconn cas login", 'port number', "type of login");
phpCAS::setNoCasServerValidation();

// check CAS authentication
$auth = phpCAS::checkAuthentication();

if ($auth) {
    $netid = phpCAS::getUser();
    $user = findEmployee($netid);

    if ($user) {
        header('location: dashboard.php');
    }
} else {
    header('location: welcome.php');
}

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Non Employee</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

    <!-- Font Awesome Icon Library -->
    <script src="https://kit.fontawesome.com/23698344ca.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins|Source+Sans+Pro:600,700|Roboto+Condensed:700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <script src="js/functions.js"></script>

    <!-- Local stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/nav&sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/nonEmployee.css">
    <link rel="stylesheet" type="text/css" href="css/card&widget.css">
    <link rel="stylesheet" type="text/css" href="css/buttons.css">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#3263a8">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-config" content="browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

</head>

<body id="page-top" class="sidebar-toggled">

<nav id="navbar"></nav>

<div id="wrapper">
    <!-- Sidebar -->
    <ul id='sidebar' class="sidebar navbar-nav sidebar-shadow toggled"></ul>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item" style="color: #006DF0;">myHuskyTech</li>
            </ol>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-11 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                            <div class="card mb-3" style="box-shadow: -webkit-box-shadow: 0px 0px 40px -34px rgba(0,0,0,0.75);
              -moz-box-shadow: 0px 0px 40px -34px rgba(0,0,0,0.75);
              box-shadow: 0px 0px 40px -34px rgba(0,0,0,0.75);">
                                <div class="card-header">
                                    <h5 class="card-title">Thank you for showing your interest!</h5>
                                </div>
                                <div style="text-align:center" class="card-body">
                                    <p>If you are looking to work in ITS,</p>
                                    <p>please click "Jobx" below to direct yourself to the portal and look for our
                                        current
                                        postings.</p>
                                    <p>We look forward to reviewing your application if the position is available!</p>
                                    <p>If you require IT assistance please click "Contact Us" to create a ticket for
                                        your
                                        issue.</p>
                                    <p>If you prefer chat please click "Chat". You may also call us at (860)
                                        486-4357</p>
                                    <p>Be sure to look through Confluence for articles to assist with your issue as
                                        well.</p>

                                    <a class="btn btn-outline-orange m-3" href="mailto: help@uconn.edu"
                                       role="button"
                                       target="_blank">Contact Us</a>
                                    <a class="btn btn-outline-primary m-3" href="https://confluence.uconn.edu"
                                       role="button"
                                       target="_blank">Confluence</a>
                                    <a class="btn btn-outline-green m-3" href="https://helpcenter.uconn.edu"
                                       role="button" target="_blank">Chat</a>
                                    <a class="btn btn-outline-navy m-3"
                                       href="https://uconn.studentemployment.ngwebsolutions.com/" role="button"
                                       target="_blank">Jobx</a>
                                    <a class="btn btn-outline-dark-blue m-3" href="https://netid.uconn.edu"
                                       role="button"
                                       target="_blank">General NetID</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
        <a id="scrollUp"></a>

</body>

</html>
