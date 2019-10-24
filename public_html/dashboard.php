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

    <title>Dashboard</title>

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
    <link rel="stylesheet" href="css/nav&sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">

    <link rel="import" href="pageUp.html">

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

<div id="navbar"></div>

<div id="wrapper">
    <!-- Sidebar -->
    <ul id='sidebar' class="sidebar navbar-nav sidebar-shadow toggled"></ul>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a style="color: #004b98;">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Overview</li>
            </ol>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="row justify-content-center">
                                    <a class="btn btn-outline-primary m-3" id="links-btn" data-toggle="collapse" href="#"
                                       data-target="#links" role="button" aria-expanded="false" aria-controls="links">
                                        Tech Support Center Tools
                                    </a>

                                    <?php if ($user->Role != 'Trainee' && (strpos($user->Role, 'Specialist') == false)): ?>
                                        <a class="btn btn-outline-sea-green m-3" id="advanced-btn" data-toggle="collapse" href="#"
                                           data-target="#adv" role="button" aria-expanded="false" aria-controls="links">
                                            Advanced Tools
                                        </a>
                                    <?php endif; ?>

                                    <a class="btn btn-outline-navy m-3" id="refs-btn"  data-toggle="collapse" href="#"
                                       data-target="#refs" role="button" aria-expanded="false" aria-controls="refs">
                                        Departments supported by ITS
                                    </a>
                                    <a class="btn btn-outline-green m-3" id="boot-btn" data-toggle="collapse" href="#"
                                       data-target="#boot" role="button" aria-expanded="false" aria-controls="refs">
                                        Common Boot Keys
                                    </a>
                                </div>
                            </div>

                            <div class="collapse" id="links">
                                <br>

                                <div class="card card-body shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Help Center Tools</span>
                                        </h5>
                                    </div>

                                    <div style="text-align:center;" class="card-body">
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-primary m-3"
                                           href="https://confluence.uconn.edu" role="button">
                                            <i class="fab fa-confluence blue-icon"></i> Confluence</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-orange m-3"
                                           href="https://serviceit.uconn.edu" role="button">
                                            <i class="fas fa-ticket-alt orange-icon"></i> ServiceIT</a>
                                        <a style="display: inline-grid; pointer-events: none;" target="_blank" class="btn btn-outline-black m-3"
                                           href="#"
                                           role="button"><i class="fab fa-atlassian black-icon"></i> Jira</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-primary m-3"
                                           href="https://login.microsoftonline.com" role="button">
                                            <img src="Assets/outlook-logo1.png" class="outlook-icon">Outlook</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-dark-blue m-3"
                                           href="https://netid.uconn.edu" role="button">
                                            <i class="fas fa-id-badge dark-blue-icon"></i> General NetID</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-navy m-3" href="https://teams.microsoft.com/l/team/19%3a7d2514197f284ca0a895aa16dadbe58c%40thread.skype/
                                                                                    conversations?groupId=0b92e5c9-20b9-480f-954f-8df3245d94b3&tenantId=17f1a87e-2a25-4eaa-b9df-9d439034b080"
                                           role="button"><img src="Assets/teams.png" class="teams-icon">Microsofts Team</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-red-orange m-3"
                                           href="https://netidadmin-private.uconn.edu" role="button">
                                            <i class="fas fa-fingerprint red-orange-icon"></i> NetID Private Login</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-sea-green m-3"
                                           href="https://netidadmin-private.uconn.edu/id/search.php" role="button">
                                            <i class="fas fa-fingerprint sea-green-icon"></i> NetID Private Search</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-green m-3" href="https://tawk.to"
                                           role="button">
                                            <i class="fas fa-comments green-icon"></i> Chat</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-purple m-3" href="https://helpcentertoolkit.uconn.edu"
                                           role="button">
                                            <i class="fas fa-toolbox purple-icon"></i> HuskyCT Toolkit</a>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="adv">
                                <br>

                                <div class="card card-body shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Advanced Tools</span>
                                        </h5>
                                    </div>

                                    <div style="text-align:center;" class="card-body">
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-primary m-3"
                                           href="https://horizon.uconn.edu/admin/" role="button">
                                            <i class="fas fa-server blue-icon"></i> AnyWare Admin</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-orange m-3"
                                           href="http://mbam-2-primary.grove.ad.uconn.edu/Helpdesk" role="button">
                                            <i class="far fa-window-close orange-icon"></i></i> Bitlocker</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-red-orange m-3"
                                           href="https://sccm-mbam4.grove.ad.uconn.edu/KeyRecoveryPage/aspx" role="button">
                                            <i class="far fa-window-close red-orange-icon"></i></i> Bitlocker (Older Machines)</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-sea-green m-3"
                                           href="https://pername.uconn.edu" role="button">
                                            <i class="far fa-envelope sea-green-icon"></i> Pername</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-dark-blue m-3"
                                           href="https://admin.google.com" role="button">
                                            <i class="fab fa-google dark-blue-icon"></i> Google Admin</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-navy m-3"
                                           href="https://infoblox.uits.uconn.edu" role="button">
                                            <i class="fas fa-network-wired navy-icon"></i> Infoblox</a>
                                        <a style="display: inline-grid" target="_blank" class="btn btn-outline-sea-green m-3"
                                           href="https://admin.duosecurity.com/login?next=%2F" role="button">
                                            <i class="fas fa-fingerprint sea-green-icon"></i> Duo Security</a>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="refs">
                                <br>

                                <div class="card card-body shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Departments supported by ITS</span>
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">Academic Achievement Center</li>
                                                <li class="list-group-item">Admissions</li>
                                                <li class="list-group-item">African American Cultural Center</li>
                                                <li class="list-group-item">Air Force ROTC</li>
                                                <li class="list-group-item">Alumni</li>
                                                <li class="list-group-item">AP (Accounts Payable)</li>
                                                <li class="list-group-item">Asian American Cultural Center</li>
                                                <li class="list-group-item">Athletics</li>
                                                <li class="list-group-item">Audit Compliance & Ethics</li>
                                                <li class="list-group-item">Avery Point</li>
                                                <li class="list-group-item">Bursar</li>
                                                <li class="list-group-item">Career Services</li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">College of Agriculture and Natural Resources
                                                    (CANR)
                                                </li>
                                                <li class="list-group-item">Communications</li>
                                                <li class="list-group-item">Early College Experience</li>
                                                <li class="list-group-item">Economic Development</li>
                                                <li class="list-group-item">Facilities</li>
                                                <li class="list-group-item">Financial Aid</li>
                                                <li class="list-group-item">First Year Programs</li>
                                                <li class="list-group-item">Global Affairs</li>
                                                <li class="list-group-item">Graduate School</li>
                                                <li class="list-group-item">Government Relations</li>
                                                <li class="list-group-item">Facilities</li>
                                                <li class="list-group-item">Human Resources</li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">Humanities Institute</li>
                                                <li class="list-group-item">Information Technology Services (ITS)</li>
                                                <li class="list-group-item">Institute of Materials Science (IMS)</li>
                                                <li class="list-group-item">Institute Research</li>
                                                <li class="list-group-item">Institutional Equity</li>
                                                <li class="list-group-item">International Services</li>
                                                <li class="list-group-item">Lodewick Visitors Center</li>
                                                <li class="list-group-item">Mail Services/Purchasing</li>
                                                <li class="list-group-item">Marine Sciences</li>
                                                <li class="list-group-item">Museum of Natural History</li>
                                                <li class="list-group-item">Office of the Controller</li>
                                                <li class="list-group-item">Office of the General Counsel</li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">Office of the President</li>
                                                <li class="list-group-item">Orientation Services</li>
                                                <li class="list-group-item">Payroll</li>
                                                <li class="list-group-item">Provost Office</li>
                                                <li class="list-group-item">Public Policy</li>
                                                <li class="list-group-item">Puerto Rican/Latin American Cultural Center
                                                    (PRLACC)
                                                </li>
                                                <li class="list-group-item">Q Center</li>
                                                <li class="list-group-item">Rainbow Center</li>
                                                <li class="list-group-item">Registrar</li>
                                                <li class="list-group-item">Rowe Center for Undergraduate Education</li>
                                                <li class="list-group-item">School of Fine Arts</li>
                                                <li class="list-group-item">School of Nursing</li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">School of Pharmacy</li>
                                                <li class="list-group-item">Seagrant</li>
                                                <li class="list-group-item">Summer Programs</li>
                                                <li class="list-group-item">Technology Incubation</li>
                                                <li class="list-group-item">Treasury Services</li>
                                                <li class="list-group-item">UEI</li>
                                                <li class="list-group-item">UNESCO</li>
                                                <li class="list-group-item">Univ Events & Conf Services</li>
                                                <li class="list-group-item">Veteran Services</li>
                                                <li class="list-group-item">VP of Enrollment Mgmt</li>
                                                <li class="list-group-item">Women’s Center</li>
                                                <li class="list-group-item">Writing Center</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="boot">
                                <br>

                                <div class="card card-body shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Common Boot Menu Keys</span>
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Acer</li>
                                                <li class="list-group-item">Apple</li>
                                                <li class="list-group-item">Asus</li>
                                                <li class="list-group-item">Dell</li>
                                                <li class="list-group-item">HP</li>
                                                <li class="list-group-item">Lenovo</li>
                                                <li class="list-group-item">Old Microsoft Surface</li>
                                                <li class="list-group-item">New Microsoft Surface</li>
                                                <li class="list-group-item">MSI</li>
                                                <li class="list-group-item">Razer</li>
                                                <li class="list-group-item">Samsung</li>
                                                <li class="list-group-item">Sony VAIO</li>
                                                <li class="list-group-item">Toshiba</li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul style="text-align: center;" class="list-group list-group-flush">
                                                <li class="list-group-item">F2 | F2 | DELETE</li>
                                                <li class="list-group-item">Option</li>
                                                <li class="list-group-item">ESC | F2 | F10 | DELETE | INSERT</li>
                                                <li class="list-group-item">F1 | F2 | F3 | F12 | DELETE </li>
                                                <li class="list-group-item">F1 | F2 | F6 | F10 | F11 | F12 | ESC</li>
                                                <li class="list-group-item">F1 | F2 | F12 | CLRT+ALT+F3</li>
                                                <li class="list-group-item">VOLUME DOWN</li>
                                                <li class="list-group-item">VOLUME UP</li>
                                                <li class="list-group-item">F2 | DELETE</li>
                                                <li class="list-group-item">F12</li>
                                                <li class="list-group-item">F2 | F10</li>
                                                <li class="list-group-item">F1 | F3 | F3 | ASSIST</li>
                                                <li class="list-group-item">F1 | F2 | F12 | ESC</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php if ($user->Role != 'FTE') : ?>
                <br>

                <section>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-11 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title" style="color: rgb(0, 109, 240);"><span class="card-title">My Schedule
                                        </h5>
                                    </div>
                                    <div style="text-align:center" class="card-body">
                                        <iframe width="100%" height="650px" src="https://account.subitup.com/"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($user):?>
                <br>

                <section>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-11 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title" style="color: rgb(0, 109, 240);"><span class="card-title">Tech Support Center Schedule
                                        </h5>
                                    </div>
                                    <div style="text-align:center" class="card-body">
                                        <iframe width="100%" height="650px" src="https://account.subitup.com/public/?MMvjpw5WAyY%3d#byTimeDay"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            
            <section>
                <?php if ($user->Role =='Trainee'): ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">SPECIALIST TRAINING</span></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <span class="text-gray">Progress</span>
                                        </div>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                     aria-valuemax="100"
                                                     style="width: <?php echo $user->getProgress(); ?>%; background-color: #51b848 !important;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Incomplete Work</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <span class="text-gray">Quizzes</span>
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-primary btn-block" type="button">
                                                Level 2 Quiz A
                                            </button>
                                            <button class="btn btn-outline-primary btn-block" type="button">
                                                Level 2 Quiz B
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (strpos($user->Role, 'Specialist') != false) : ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">ADVANCED TRAINING</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <span class="text-gray">Progress</span>
                                        </div>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                     aria-valuemax="100"
                                                     style="width: <?php echo $user->getProgress(); ?>%; background-color: #623dca !important;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4 mb-lg-0 pl-lg-0 mx-auto">
                                <div class="card mb-3 shadow">
                                    <div class="card-header">
                                        <h5 class="card-title"><span class="card-title">Incomplete Work</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-title">
                                            <span class="text-gray">Quizzes</span>
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-primary btn-block" type="button">
                                                Level 2 Quiz A
                                            </button>
                                            <button class="btn btn-outline-primary btn-block" type="button">
                                                Level 2 Quiz B
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <!-- ./content-wrapper -->
    </div>
</div>
<!-- #wrapper -->

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>