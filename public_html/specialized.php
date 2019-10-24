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

if ($auth) {
    $netid = phpCAS::getUser();
    $user = findEmployee($netid);

    if (!$user) {
        header('location: nonEmployee.php');
    } elseif ($user->Role == 'Trainee' || strpos($user->Role, 'Specialists') !== false) {
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

    <title>Specialized Training</title>

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
    <link rel="stylesheet" type="text/css" href="css/grading.css">

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

<body id="page-top" class="sidebar-toggled">

<nav id="navbar"></nav>

<div id="wrapper">
    <!-- Sidebar -->
    <ul id='sidebar' class="sidebar navbar-nav sidebar-shadow toggled"></ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!--- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Training Progress</li>
                <li class="breadcrumb-item active">Specialized Training</li>
            </ol>

            <section>
                <div class="container-fluid">

                    <!-- Needs Grading Header -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col mx-auto my-0">
                                <div class="card shadow p-3 roundy text-center mb-0">
                                    <h1>Needs Grading</h1>
                                </div>

                                <br>

                                <div class="row">
                                    <?php $allTests = $user->getTests()['Specialist'];
                                    foreach ($allTests as $dept => $tests):?>
                                        <div class="col">
                                            <div class="card shadow p-2 roundy text-center mb-0">
                                                <h1><?php echo $dept;?></h1>
                                            </div>

                                            <br>

                                            <?php foreach ($tests as $test):
                                                if ($test->needsGrading):?>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="card shadow p-3">
                                                                <h3 class="text-center border-bottom pb-2">
                                                                    <?php echo $test->name; ?>
                                                                    <i class="fas fa-tasks" style="color:orange; float:right;"></i>
                                                                </h3>

                                                                <?php $HC_workers = $user->getStudents();
                                                                foreach ($test->needsGrading as $quiz):
                                                                    if ($quiz):
                                                                        foreach ($HC_workers as $worker):
                                                                            if ($worker->blackboardID == $quiz->userId):?>
                                                                                <a style="margin-top: 10px" class="btn btn-outline-primary btn-block" target="_blank" href="https://lmsdev.uconn.edu/webapps/assessment/do/viewAttempt?outcome_definition_id=<?php echo $test->ID; ?>&course_id=<?php echo $worker->courseID; ?>">
                                                                                    <?php echo $worker->Full; ?>
                                                                                </a>
                                                                            <?php endif;?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif;?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <br>
                                                <?php endif;?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <section>
                            <div class="container-fluid mt-3">
                                <div class="row">
                                    <div class="col mx-auto my-0">
                                        <div class="card p-3 roundy shadow text-center mb-0">
                                            <label for="students"><h1>Students</h1></label>
                                            <div class="container">
                                                <div class="d-flex">
                                                    <div class="form-group" style="width: 100%">
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="selectStudents" id="selectStudents">
                                                            <select form="selectStudents" name="student" class="form-control" id="students"
                                                                    style="text-align: center; text-align-last: center;">
                                                                <option value="" selected disabled hidden>Select Employee</option>
                                                                <?php global $user; $HC_workers = $user->getSpecialists();
                                                                if ($HC_workers):
                                                                    foreach($HC_workers as $worker):?>
                                                                        <option content="center" value="<?php echo $worker->NetID;?>"><?php echo $worker->Full;?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>

                                                            <br>

                                                            <input id="load" type="submit" class="btn btn-primary" value="Load Information"/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") :
                $student = $HC_workers[htmlspecialchars($_REQUEST['student'])]; ?>
                <br>

                <div class="container-fluid">
                    <div class="card p-3 roundy shadow text-center mb-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <img alt="Profile Picture" class="img-responsive img-thumbnail mx-auto d-block" src="Assets/turtle2.jpg">
                                <div style="background: none;" class="jumbotron">
                                    <h2 id='full' class="widget-title"><?php echo $student->Full;?></h2>
                                    <h3 id='netid' class="widget-info"><?php echo $student->NetID;?></h3>
                                    <h3 id='studentEmail' class="widget-info"><?php echo $student->StudentEmail;?></h3>
                                    <h3 id='rank' class="widget-info"><?php echo $student->Role;?></h3>
                                    <h3 id='grad' class="widget-info"><?php echo $student->Graduation;?></h3>
                                </div>
                            </div>
                            <!-- Training Info -->
                            <div class="col">
                                <div class="profile-content">

                                    <?php if ($student->Role == 'Call Center Specialist'){
                                        $allTests = $allTests['Call Center'];
                                    } elseif ($student->Role == 'Shop Specialist'){
                                        $allTests = $allTests['Shop'];
                                    } elseif ($student->Role == 'AIT Specialist') {
                                        $allTests = $allTests['Academic IT'];
                                    } $graded = $student->getGraded($allTests);
                                    $total = $allTests['totalPts']; $score = $graded['totalScore'];?>

                                    <!-- Progress Bar -->
                                    <section>
                                        <div class="card shadow my-3">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">SPECIALIZED TRAINING</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <span class="text-gray">Progress</span>
                                                </div>
                                                <div>
                                                    <div class="progress">
                                                        <div aria-valuemax="100"
                                                             aria-valuemin="0" aria-valuenow="75"
                                                             class="progress-bar progress-bar-striped progress-bar-animated"
                                                             role="progressbar"
                                                             style="width: <?php echo $student->getProgress(); ?>%; background-color: #623dca !important;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Needs Grading -->
                                    <section>
                                        <div class="card shadow p-3">
                                            <h3 class="text-center border-bottom pb-2 mb-0">
                                                Needs Grading
                                            </h3>

                                            <?php $grades = $student->getNeedsGrades($allTests);
                                            foreach ($grades as $grade):?>
                                                <a style="margin-top: 10px" class="btn btn-outline-primary btn-block" target="_blank" href="https://lmsdev.uconn.edu/webapps/assessment/do/viewAttempt?outcome_definition_id=<?php echo $grade->testID; ?>&course_id=<?php echo $student->courseID; ?>">
                                                    <?php echo $grade->testName; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </section>

                                    <!-- Completed Assignments -->
                                    <section>
                                        <div class="card shadow my-3 p-3">
                                            <div class="border-bottom">
                                                <h3 class="text-center">All Assignments</h3>
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="my-2">
                                                        <h2 class="m-0" style="font-size: 1.8rem;" id="total"><?php echo $score .'/'.$total; ?></h2>
                                                        <span class="text-muted small"
                                                              style="font-family: 'Poppins', sans-serif;">Total Score</span>
                                                    </div>
                                                    <div class="my-2">
                                                        <h2 class="m-0" style="font-size: 1.8rem;"><?php echo (count($graded)-1) .'/' .(count($allTests)-1); ?></h2>
                                                        <span class="text-muted small"
                                                              style="font-family: 'Poppins', sans-serif;">Assignments Completed</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <?php foreach ($allTests as $id => $test):
                                                        if ($id !== 'totalPts') :?>
                                                            <a style="margin-top: 10px" class="btn btn-outline-primary btn-block" target="_blank" href="https://lmsdev.uconn.edu/webapps/assessment/do/viewAttempt?outcome_definition_id=<?php echo $test->ID; ?>&course_id=<?php echo $student->courseID; ?>">
                                                                <?php echo $test->name; ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(function () {
                        $( "#students").val("<?php echo $student->NetID; ?>");
                    });
                </script>

                <br>

            <?php endif; ?>
        </div>
    </div>
    <!-- ./content-wrapper -->
</div>
<!-- #wrapper -->

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>