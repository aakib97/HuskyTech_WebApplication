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
    phpCAS::forceAuthentication();
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

    <title>Feedback Form</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins|Source+Sans+Pro:600,700|Roboto+Condensed:700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

    <!-- Font Awesome Icon Library -->
    <script src="https://kit.fontawesome.com/23698344ca.js"></script>

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

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Local stylesheet -->
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/card&widget.css">
    <link rel="stylesheet" type="text/css" href="css/nav&sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">

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
            $("#feedbackRank").val(role);
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
            <!--- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Feedback Form</a>
                </li>
            </ol>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form action="updateInformation.php" method="post">
                                <input type="hidden" name="form" value="feedback"/>
                                <div class="card shadow py-lg-2 p-3">
                                    <div class="form-group">
                                        <h3 class="pb-2 border-bottom m-0 text-center">
                                            <i class="fas fa-comment-alt" style="color:black; float:left;"></i>
                                            Student Feedback Form
                                            <i class="fas fa-comment-alt" style="color:black; float:right;"></i>
                                        </h3>

                                        <br>

                                        <label for="feedbackName">Your Name</label>
                                        <input type="text" name="feedbackName" class="form-control" id="feedbackName"
                                               value="<?php echo $user->Full;?>" required readonly>
                                        <br>

                                        <label for="feedbackRank">Rank</label>
                                        <select class="form-control" name="feedbackRank" id="feedbackRank" disabled>
                                            <option content="center">FTE</option>
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
                                        <input hidden id="feedbackRank" name="feedbackRank" value="<?php echo $user->Role;?>">

                                        <br>

                                        <label for="techName">Tech Name</label>
                                        <input type="text" name="techName" class="form-control" id="techName"
                                               placeholder="Jonathan Husky" required>

                                        <br>

                                        <label for="feedbackType">Feeback Type</label>
                                        <select class="form-control" name="feedbackType" id="feedbackType" required>
                                            <option value="" selected disabled hidden>Select One</option>
                                            <option>Positive</option>
                                            <option>Negative</option>
                                            <option>N/A</option>
                                        </select>

                                        <br>

                                        <label for="feedbackComments">Comments</label>
                                        <textarea class="form-control" name="feedbackComments" id="feedbackComments" rows="3"
                                                  placeholder="Provide feedback regarding the tech's work performance" required></textarea>

                                        <br>

                                        <div class="text-center">
                                            <button class="btn btn-primary" title="Submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- ./content-wrapper -->
</div>

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>