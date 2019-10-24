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

$netid = phpCAS::getUser();
$user = findEmployee($netid);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-blue static-top px-4">
    <button class="btn btn-link btn-sm order-0" href="#" id="sidebarToggle">
        <i class="fas fa-bars fa-2x"></i>
    </button>

    <!-- Center logo -->
    <a class="navbar-brand mx-auto" href="<?php global $user; if ($user) { echo 'dashboard.php'; } else { echo 'nonEmployee.php'; } ?>">
        <i class="fas huskyLogo fa-3x"></i>
    </a>

    <!-- Navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item dropdown no-arrow justify-content-end">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown"
               href="#"
               id="alertsDropdown" role="button">
                <i class="fas fa-bell fa-fw fa-3x"></i>
            </a>
            <div aria-labelledby="alertsDropdown" class="dropdown-menu dropdown-menu-right animate slideIn">
                <a class="dropdown-item" href="#">Recent Updates</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Alerts</a>
            </div>
        </li>

        <li class="nav-item dropdown no-arrow justify-content-end">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown"
               href="#" id="userDropdown" role="button">
                <!--<i class="fas fa-user-circle fa-fw fa-2x"></i>-->
                <i class="fas huskyPWR fa-fw fa-3x"></i>
            </a>

            <div aria-labelledby="userDropdown" class="dropdown-menu dropdown-menu-right animate slideIn" style="width: 420px !important;">
                <h3 class="text-center"> User Profile </h3>

                <hr>

                <div class="container text-center">
                    <img class="img-thumbnail mx-auto d-block"
                         src="Assets/turtle2.jpg"
                         alt="Profile Picture" style="width:200px;height:auto;">
                </div>

                <hr>

                <div class="flex-grow-1 ">
                    <div class="text-center">
                        <?php if ($user) :?>
                            <?php if ($user->Role != 'FTE'):?>
                                <h4 class="widget-title"><?php global $user; echo $user->Full; ?></h4>
                                <h5 class="widget-info"><?php global $user; echo $user->NetID; ?></h5>
                                <h5 class="widget-info"><?php global $user; echo $user->Email; ?></h5>
                                <h5 class="widget-info"><?php global $user; echo $user->StudentEmail; ?></h5>
                                <h5 class="widget-info"><?php global $user; echo $user->Role; ?></h5>
                                <h5 class="widget-info"><?php global $user; echo $user->Graduation; ?></h5>
                            <?php else: ?>
                                <h4 class="widget-title"><?php global $user; echo $user->Full; ?></h4>
                                <h5 class="widget-info"><?php global $user; echo $user->Role; ?></h5>
                                <h5 class="widget-info"><?php global $user; echo $user->Email; ?></h5>
                            <?php endif; ?>
                        <?php else :?>
                            <h4 id='full' class="widget-title">Jonathan Husky</h4>
                            <h5 id='netid' class="widget-info">joh12345</h5>
                            <h5 id='studentEmail' class="widget-info">joh12345work@uconn.edu</h5>
                            <h5 id='rank' class="widget-info">Guest</h5>
                            <h5 id='grad' class="widget-info"></h5>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="container">
                    <div class="row">
                        <div class="mx-auto">
                            <div class="col">
                                <a class="<?php global $user; if ($user) { echo "dropdown-item"; } else{ echo "dropdown-item disabled"; }?>"
                                   href="profile.php">
                                    <h5>Profile</h5>
                                </a>
                            </div>
                        </div>

                        <div class="mx-auto">
                            <div class="col">
                                <a class="dropdown-item" data-target="#logoutModal" data-toggle="modal" href="#" style="width: auto">
                                    <h5>Logout</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="?logout">Logout</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>


