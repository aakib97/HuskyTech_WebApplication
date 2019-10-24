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

<body class="sidebar-toggled">

<ul class="sidebar navbar-nav toggled">

    <div class="mx-auto pt-3" id="sidebar-block">
        <i style="color: #004b98;" class="fa fa-paw"></i>myHT
    </div>

    <!-- Dashboard Link -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php if ($user) { echo 'dashboard.php'; } else { echo 'nonEmployee.php'; } ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span class="pl">Dashboard</span>
        </a>
    </li>

    <?php if ($user) : ?>
        <?php if ($user->Role != 'FTE' && strpos($user->Role, 'Lead') != true) :?>
            <?php if (date('Y-m-d', strtotime('today')) <= date('Y-m-d', strtotime('2019-09-13'))):?>
                <li class="nav-item active">
                    <a class="nav-link" href="teamSelection.php">
                        <i class="fas fa-user-friends"></i>
                        <span class="pl">Team Selection</span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <?php global $user; if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false) : ?>
            <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                   id="trainingDropdown" role="button">
                    <i class="fas fa-user-friends"></i>
                    <span class="pl ">Team <br> Selections</span>
                </a>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Pages</h6>
                    <?php if (date('Y-m-d', strtotime('today')) <= date('Y-m-d', strtotime('2019-09-13'))):?>
                        <a class="dropdown-item" href="teamSelection.php">Team Selection</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="teamSubmissions.php">Team Selection Review</a>
                </div>
            </li>
        <?php endif; ?>

        <?php if ($user->Role != 'Trainee' && strpos($user->Role, 'Specialist') != true) :?>
            <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                   id="trainingDropdown" role="button">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="pl">Training <br> Progress</span>
                </a>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Training</h6>
                    <a class="dropdown-item" href="basicTraining.php">Basic Training</a>
                    <a class="dropdown-item" href="specialized.php">Specialized Training</a>
                </div>
            </li>
        <?php endif; ?>

        <?php if ($user->Role == 'Trainee' || strpos($user->Role, 'Specialist') != false) : ?>
        <li id="trainingDropdown" class="nav-item dropdown">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                <i class="fas fa-chalkboard-teacher"></i>
                <span class="pl ">Training</span>
            </a>
            <?php if ($user->Role == 'Trainee') :?>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Departments</h6>
                    <a class="dropdown-item" href="callCenter.php">Call Center</a>
                    <a class="dropdown-item" href="shop.php">Shop</a>
                    <a class="dropdown-item" href="ait.php">Academic IT</a>
<!--                    <a class="dropdown-item" href="userServices.php">User Services</a>-->
                </div>
            <?php elseif (strpos($user->Role, 'Specialist') != false) :?>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Department</h6>
                    <?php if ($user->Role == 'Call Center Specialist'):?>
                        <a class="dropdown-item" href="callCenter.php">Call Center</a>
                    <?php elseif ($user->Role == 'Shop Specialist'):?>
                        <a class="dropdown-item" href="shop.php">Shop</a>
                    <?php elseif ($user->Role == 'AIT Specialist'):?>
                        <a class="dropdown-item" href="ait.php">Academic IT</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </li>
        <?php endif; ?>

        <li class="nav-item dropdown">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
               id="trainingDropdown" role="button">
                <i class="fas fa-box-open"></i>
                <span class="pl">Help Center <br> Inventory </span>
            </a>
            <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                <h6 class="dropdown-header">Forms</h6>
                <a class="dropdown-item" href="equipmentForm.php">Supplies Request <br> Form</a>
                <a class="dropdown-item" href="USBInventoryform.php">USB Inventory</a>

                <?php if ($user->Role == 'FTE'  || strpos($user->Role, 'Lead') != false):?>
                    <h6 class="dropdown-header">Inventory Review</h6>
                    <a class="dropdown-item" href="equipmentSubmissions.php">Supplies Requests</a>
                    <a class="dropdown-item" href="USBSubmissions.php">Shop Inventory <br> Submissions</a>
                <?php endif; ?>
            </div>
        </li>

        <?php if ($user->Role == 'Trainee' || strpos($user->Role, 'Specialist') == true) : ?>
            <li id='feedback' class="nav-item">
                <a class="nav-link" href="feedbackForm.php">
                    <i class="fas fa-comment-alt"></i>
                    <span class="pl ">Student Feedback</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($user->Role != 'Trainee' && strpos($user->Role, 'Specialist') != true) : ?>
            <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                   id="trainingDropdown" role="button">
                    <i class="fas fa-edit"></i>
                    <span class="pl ">Demonstration <br> Signoff</span>
                </a>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Modules</h6>
                    <a class="dropdown-item" href="phoneCheckoff.php">Phone Check-off</a>
                    <a class="dropdown-item" href="shopChecklist.php">Shop Checklist </a>
                </div>
            </li>
        <?php endif; ?>

        <?php if (strpos($user->Role, 'Advanced') != false) : ?>
            <li id='feedback' class="nav-item">
                <a class="nav-link" href="feedbackForm.php">
                    <i class="fas fa-comment-alt"></i>
                    <span class="pl ">Student Feedback</span>
                </a>
            </li>
        <?php endif; ?>

        <?php global $user; if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false) : ?>
            <li class="nav-item dropdown">
                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                   id="trainingDropdown" role="button">
                    <i class="fas fa-comment-alt"></i>
                    <span class="pl ">Student <br> Feedback</span>
                </a>
                <div aria-labelledby="pagesDropdown" class="dropdown-menu animate slideIn">
                    <h6 class="dropdown-header">Pages</h6>
                    <a class="dropdown-item" href="feedbackForm.php">Student Feedback</a>
                    <a class="dropdown-item" href="feedbackSubmission.php">Feedback Review</a>
                </div>
            </li>
        <?php endif; ?>

        <li class="nav-item dropdown">
            <a class="nav-link" href="manageStudents.php">
                <i class="fas fa-users"></i>
                <span class="pl ">Student <br> Management</span></a>
        </li>

        <!-- Updates Link -->
        <li id='updates' class="nav-item">
            <a class="nav-link" href="updates.php">
                <i class="fas fa-exclamation"></i>
                <span class="pl ">Updates</span></a>
        </li>
    <?php endif; ?>
</ul>

</body>
</html>