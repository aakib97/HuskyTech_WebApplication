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

    if (!$user) {
        header('location: nonEmployee.php');
    }
} else {
    header('location: index.php');
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

    <title>Profile</title>

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

    <link rel="import" href="pageUp.html">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#3263a8">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-config" content="browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <script>
        $(document).ready(function () {
            let role = "<?php echo $user->Role; ?>";
            $("#role").val(role);
        });
    </script>

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
                <li class="breadcrumb-item" style="color: #006DF0;">Profile</li>
            </ol>

            <form action="updateInformation.php" method="post" id="profileForm" name="profileForm">
                <input type="hidden" name="form" value="profile"/>
                <div class="card py-lg-2 p-3">
                    <div class="form-group">
                        <h3 class="pb-2 border-bottom m-0 text-center">User Profile
                            <i class="fas fa-user-cog" style="color: black; float:right;"></i>
                        </h3>

                        <br>

                        <label for="profilePic">Profile Picture</label>
                        <input type="file" class="form-control-file" name="profilePic" id="profilePic">

                        <br>

                        <label for="first">First Name</label>
                        <input type="text" class="form-control" name="first" id="first" value="<?php global $user; echo $user->First?>">

                        <br>

                        <label for="last">Last Name</label>
                        <input type="text" class="form-control" name="last" id="last" value="<?php global $user; echo $user->Last?>">

                        <br>

                        <label for="full">Full Name</label>
                        <input type="text" class="form-control" name="full" id="full" value="<?php global $user; echo $user->Full?>" readonly>

                        <br>

                        <label for="netid">NetID</label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php global $user; echo $user->NetID?>" readonly>

                        <br>

                        <label for="role">Rank</label>
                        <select class="form-control" name="rank" id="role" disabled>
                            <option content="center">Call Center Lead</option>
                            <option content="center">Shop Lead</option>
                            <option content="center">AIT Lead</option>
                            <option content="center">Call Center Advanced</option>
                            <option content="center">Shop Advanced</option>
                            <option content="center">AIT Advanced</option>
                            <option content="center">Call Center Specialist</option>
                            <option content="center">Shop Specialist</option>
                            <option content="center">AIT Specialist</option>
                            <option content="center" selected>Trainee</option>
                        </select>

                        <br>

                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php global $user; echo $user->Email?>">

                        <br>

                        <label for="StudentEmail">Student Email</label>
                        <input type="text" class="form-control" name="StudentEmail" id="StudentEmail" value="<?php global $user; echo $user->StudentEmail?>" readonly>

                        <br>

                        <label for="Grad">Expected Graduation</label>
                        <input type="text" class="form-control" name="grad" id="Grad" value="<?php global $user; echo $user->Graduation?>">

                        <br>

                        <div class="text-center">
                            <button class="btn btn-primary" title="Submit">Update</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- ./content-wrapper -->

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>
