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

    <title>Student Feedback Submissions</title>

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
    <link rel="stylesheet" type="text/css" href="css/teamSubmissions.css">

    <!-- Datatable exports -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <!-- Datatable exports -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <link rel="import" href="pageUp.html">

    <script type="text/javascript">
        $(document).ready(function(){
            $('#teamsTable').DataTable({ "scrollX": true, "columnDefs": [{ "orderable": false, "targets": 0 }],
                "order": [[ 0, "asc" ]]});
            $('#teamsTable_length').css('float','left');
            $('#teamsTable_info').css('float','left');
        });
    </script>


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
                <li class="breadcrumb-item">Student Feedback</li>
                <li class="breadcrumb-item active">Feedback Review</li>
            </ol>

            <section>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col mx-auto my-0">
                            <div class="card p-3 roundy shadow text-center mb-0">
                                <div style="height: 70px" class="row">
                                    <div style="text-align: left;"  class="col"><h2>All <b>Requests</b></h2></div>
                                    <div style="text-align: right;" class="col">
                                        <div class="input-group">
                                            <input id="searchBar" class="form-control" onkeyup="searchTeams()" type="text" placeholder="Search" aria-label="Search" style="padding-left: 20px; border-radius: 40px;" id="mysearch">
                                            <div class="input-group-addon" style="margin-left: -35px; z-index: 3; border-radius: 40px; background-color: transparent; border:none;">
                                                <button class="btn btn-primary btn-sm" type="submit" style="border-radius: 20px; margin-top: .2em"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table id="teamsTable" class="table table-fixed table-striped table-hover">
                                            <thead id="dtBasicExample" class="table">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Rank</th>
                                                    <th>Team Selection</th>
                                                    <th>Meeting Time</th>
                                                    <th>Comments</th>
                                                </tr>
                                                </thead>
                                            <tbody>
                                            <?php $submissions = $user->allTeams();
                                            foreach($submissions as $row): ?>
                                                <tr>
                                                    <td class="name-cell"><?php echo $row[0]; ?></td>
                                                    <td><div<?php if ($row[1] == 'Shop Lead'):?> class="shoplead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Call Center Lead'):?> class="calllead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'AIT Lead'):?> class="aitlead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Call Center Advanced'):?> class="calladvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Shop Advanced'):?> class="shopadvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'AIT Advanced'):?> class="aitadvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Call Center Specialist'):?> class="callspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Shop Specialist'):?> class="shopspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'AIT Specialist'):?> class="aitspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[1] == 'Trainee'):?> class="trainee-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"<?php endif; ?>>
                                                            <?php echo $row[1]?></div></td>
                                                    <td><div<?php if ($row[2] == 'Improvements Team'):?> class="improvements-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[2] == 'Training Committee'):?> class="training-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[2] == 'Events Coordination'):?> class="events-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($row[2] == 'Knowledge Base'):?> class="kb-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"<?php endif; ?>>
                                                            <?php echo $row[2]?></div></td>
                                                    <td><?php echo $row[3]; ?></td>
                                                    <td><?php echo $row[4]; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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