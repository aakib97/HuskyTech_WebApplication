<?php
//Import the phpCAS Library
include_once('./CAS/CAS.php');
require('./classes/Employee.class.php');

// Initialize phpCAS
phpCAS::client(SAML_VERSION_1_1, "uconn cas login", 'port number', "type of login");
phpCAS::setNoCasServerValidation();

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
    session_destroy();
}

// check CAS authentication
$auth = phpCAS::checkAuthentication();

if ($auth){
    $netid = phpCAS::getUser();
    $user = findEmployee($netid);

    if (!$user) {
        header('location: nonEmployee.php');
    } elseif ($user->Role != 'Trainee' && $user->Role != 'Call Center Specialist'){
        header('location: dashboard.php');
    }
} else {
    phpCAS::forceAuthentication();
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

    <title>AcademicIT Training</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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

    <!-- Local stylesheet -->
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/card&widget.css">
    <link rel="stylesheet" type="text/css" href="css/nav&sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/training.css">

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

</head>

<body id="page-top">

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

<body id="page-top" class="sidebar-toggled">

<nav id="navbar"></nav>

<div id="wrapper">
    <!-- Sidebar -->
    <ul id='sidebar' class="sidebar navbar-nav sidebar-shadow toggled"></ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Training</li>
                <li class="breadcrumb-item active">AcademicIT</li>
            </ol>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title"><span class="card-title">ACADEMIC IT <?php echo ($user->Role == 'Trainee' ? 'BASIC ' : 'SPECIALIZED '); ?>TRAINING</h5>
                                </div>
                                <div class="card-body">
                                    <div class="card-title">
                                        <span class="text-gray">Progress</span>
                                    </div>
                                    <div>
                                        <div class="progress">
                                            <div id="progBar"
                                                 class="progress-bar progress-bar-striped progress-bar-animated"
                                                 role="progressbar"
                                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: <?php echo $user->getProgress(); ?>%; background-color:
                                                 <?php if ($user->Role == 'Trainee'): ?> #51b848 <?php else: ?> #623dca <?php endif; ?>
                                                         !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <?php if ($user->Role == 'Trainee'): $allMaterials= $user->getBasicModules('AcademicIT');
                        foreach ($allMaterials->modules as $module):?>
                            <div class="row">
                                <div class="col">
                                    <div class="card p-3">
                                        <h3 class="pb-2 border-bottom m-0 text-center">Training Module <?php echo $module->title;?>
                                            <i class="fas fa-tasks" style="color:orange; float:right;"></i>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6 text-center pt-2">
                                                <p class="my-2">Reference Materials</p>
                                                <?php $materials = $allMaterials->materials[$module->title];
                                                foreach ($materials as $material):?>
                                                    <a target=_blank class="btn btn-outline-warning btn-block"
                                                       href="https://lmsdev.uconn.edu/webapps/blackboard/execute/content/file?cmd=view&mode=designer&content_id=<?php echo $material->id; ?>&course_id=<?php echo $user->courseID; ?>"
                                                       role="button"><?php echo $material->title; ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-6 text-center pt-2">
                                                <p class="my-2">Assignments</p>
                                                <?php $quizzes = $allMaterials->quizzes[$module->title] ;
                                                foreach ($quizzes as $quiz):?>
                                                    <a target=_blank
                                                       class="align-middle btn btn-outline-purple btn-block"
                                                       href="https://lmsdev.uconn.edu/webapps/assessment/take/launchAssessment.jsp?course_id=<?php echo $user->courseID; ?>&content_id=<?php echo $quiz->id; ?>&mode=reset"
                                                       role="button"><?php echo $quiz->title; ?>
                                                        <i id="Q1Ico" class="far fa-check-square"
                                                           style="color: red; float: right; font-size: 24px;"></i>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($user->Role == 'Specialized'): $allMaterials= $user->getSpecializedModules('AcademicIT');
                        foreach ($allMaterials->modules as $module):?>
                            <div class="row">
                                <div class="col">
                                    <div class="card p-3">
                                        <h3 class="pb-2 border-bottom m-0 text-center">Training Module <?php echo $module->title;?>
                                            <i class="fas fa-tasks" style="color:orange; float:right;"></i>
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-6 text-center pt-2">
                                                <p class="my-2">Reference Materials</p>
                                                <?php $materials = $allMaterials->materials[$module->title];
                                                foreach ($materials as $material):?>
                                                    <a target=_blank class="btn btn-outline-warning btn-block"
                                                       href="https://lmsdev.uconn.edu/webapps/blackboard/execute/content/file?cmd=view&mode=designer&content_id=<?php echo $material->id; ?>&course_id=<?php echo $user->courseID; ?>"
                                                       role="button"><?php echo $material->title; ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-6 text-center pt-2">
                                                <p class="my-2">Assignments</p>
                                                <?php $quizzes = $allMaterials->quizzes[$module->title] ;
                                                foreach ($quizzes as $quiz):?>
                                                    <a target=_blank
                                                       class="align-middle btn btn-outline-purple btn-block"
                                                       href="https://lmsdev.uconn.edu/webapps/assessment/take/launchAssessment.jsp?course_id=<?php echo $user->courseID; ?>&content_id=<?php echo $quiz->id; ?>&mode=reset"
                                                       role="button"><?php echo $quiz->title; ?>
                                                        <i id="Q1Ico" class="far fa-check-square"
                                                           style="color: red; float: right; font-size: 24px;"></i>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </section>
        </div>

    </div>
    <!-- ./content-wrapper -->
</div>

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>