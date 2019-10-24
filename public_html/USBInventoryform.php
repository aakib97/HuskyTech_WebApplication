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

    <title>USB Inventory</title>

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
    <link rel="stylesheet" type="text/css" href="css/USBInventoryform.css">

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
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item" style="color: #006DF0;">Shop Management</li>
                <li class="breadcrumb-item active">USB Inventory Tracker</li>
            </ol>

            <div class="card shadow py-lg-2 p-3">
                <h3 class="pb-2 border-bottom m-0 text-center">
                    <i class="material-icons" style="color:black; font-size: 45px; float:left;">
                        usb
                    </i>
                    USB Inventory Tracker
                    <i class="material-icons" style="color:black; font-size: 45px; float:right;">
                        usb
                    </i>
                </h3>

                <?php $USBs = $user->allUSBs();?>

                <form action="updateInformation.php" method="post" name="windowsInventory">
                    <div class="form-group">
                        <label for="netid" hidden></label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php echo $user->NetID ?>" hidden>
                        <input type="text" class="form-control" name="form" id="form" value="windowsUSB" hidden>

                        <br>

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-windows"></i> Windows USB
                        </h5>

                        <?php $windows = $USBs['Windows']; $i = 0;
                        foreach ($windows as $win):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $win[0]; ?>_ava').val("<?php echo $win[2]; ?>");
                                        $('#<?php echo $win[0]; ?>_work').val("<?php echo $win[3]; ?>");

                                        if ($('#<?php echo $win[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $win[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $win[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $win[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $win[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $win[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $win[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $win[0]; ?>_ava" name="<?php echo $win[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $win[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $win[0]; ?>_work" name="<?php echo $win[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php $i++; else:?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $win[0]; ?>_ava').val("<?php echo $win[2]; ?>");
                                            $('#<?php echo $win[0]; ?>_work').val("<?php echo $win[3]; ?>");

                                            if ($('#<?php echo $win[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $win[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $win[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $win[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $win[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $win[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $win[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $win[0]; ?>_ava" name="<?php echo $win[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $win[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $win[0]; ?>_work" name="<?php echo $win[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; endif;
                            if ($i == count($windows) && count($windows) % 2 != 0):?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="row">
                            <div style="text-align: center; text-align-last: center;" class="col">
                                <button class="btn btn-primary" title="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <form action="updateInformation.php" method="post" name="macInventory">
                    <div class="form-group">
                        <label for="netid" hidden></label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php echo $user->NetID ?>" hidden>
                        <input type="text" class="form-control" name="form" id="form" value="macUSB" hidden>

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-apple"></i> macOS USB
                        </h5>

                        <hr class="subHR">

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-apple"></i> Mojave
                        </h5>

                        <?php $mojave = $USBs['Mojave']; $i = 0;
                        foreach ($mojave as $moj):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $moj[0]; ?>_ava').val("<?php echo $moj[2]; ?>");
                                        $('#<?php echo $moj[0]; ?>_work').val("<?php echo $moj[3]; ?>");

                                        if ($('#<?php echo $moj[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $moj[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $moj[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $moj[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $moj[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $moj[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $moj[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $moj[0]; ?>_ava" name="<?php echo $moj[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $moj[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $moj[0]; ?>_work" name="<?php echo $moj[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else: ?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $moj[0]; ?>_ava').val("<?php echo $moj[2]; ?>");
                                            $('#<?php echo $moj[0]; ?>_work').val("<?php echo $moj[3]; ?>");

                                            if ($('#<?php echo $moj[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $moj[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $moj[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $moj[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $moj[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $moj[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $moj[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $moj[0]; ?>_ava" name="<?php echo $moj[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $moj[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $moj[0]; ?>_work" name="<?php echo $moj[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($mojave) && count($mojave) % 2 != 0):?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>

                        <hr class="subHR">

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-apple"></i> High Sierra
                        </h5>

                        <?php $highsierra = $USBs['High Sierra']; $i = 0;
                        foreach ($highsierra as $hs):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $hs[0]; ?>_ava').val("<?php echo $hs[2]; ?>");
                                        $('#<?php echo $hs[0]; ?>_work').val("<?php echo $hs[3]; ?>");

                                        if ($('#<?php echo $hs[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $hs[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $hs[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $hs[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $hs[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $hs[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $hs[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $hs[0]; ?>_ava" name="<?php echo $hs[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $hs[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $hs[0]; ?>_work" name="<?php echo $hs[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else: ?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $hs[0]; ?>_ava').val("<?php echo $hs[2]; ?>");
                                            $('#<?php echo $hs[0]; ?>_work').val("<?php echo $hs[3]; ?>");

                                            if ($('#<?php echo $hs[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $hs[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $hs[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $hs[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $hs[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $hs[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $hs[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $hs[0]; ?>_ava" name="<?php echo $hs[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $hs[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $hs[0]; ?>_work" name="<?php echo $hs[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($highsierra) && count($highsierra) % 2 != 0):?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                        <hr class="subHR">


                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-apple"></i> Sierra
                        </h5>

                        <?php $sierra = $USBs['Sierra']; $i = 0;
                        foreach ($sierra as $sie):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $sie[0]; ?>_ava').val("<?php echo $sie[2]; ?>");
                                        $('#<?php echo $sie[0]; ?>_work').val("<?php echo $sie[3]; ?>");

                                        if ($('#<?php echo $sie[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $sie[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $sie[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $sie[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $sie[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $sie[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $sie[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $sie[0]; ?>_ava" name="<?php echo $sie[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $sie[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $sie[0]; ?>_work" name="<?php echo $sie[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else: ?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $sie[0]; ?>_ava').val("<?php echo $sie[2]; ?>");
                                            $('#<?php echo $sie[0]; ?>_work').val("<?php echo $sie[3]; ?>");

                                            if ($('#<?php echo $sie[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $sie[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $sie[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $sie[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $sie[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $sie[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $sie[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $sie[0]; ?>_ava" name="<?php echo $sie[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $sie[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $sie[0]; ?>_work" name="<?php echo $sie[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($sierra) && count($sierra) % 2 != 0):?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="row">
                            <div style="text-align: center; text-align-last: center;" class="col">
                                <button class="btn btn-primary" title="Submit">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>

                <hr>

                <form action="updateInformation.php" method="post" name="linuxInventory">
                    <div class="form-group">
                        <label for="netid" hidden></label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php echo $user->NetID ?>" hidden>
                        <input type="text" class="form-control" name="form" id="form" value="linuxUSB" hidden>


                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fab fa-linux"></i> Linux USB
                        </h5>

                        <?php $linux = $USBs['Linux']; $i = 0;
                        foreach ($linux as $lin):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $lin[0]; ?>_ava').val("<?php echo $lin[2]; ?>");
                                        $('#<?php echo $lin[0]; ?>_work').val("<?php echo $lin[3]; ?>");

                                        if ($('#<?php echo $lin[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $lin[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $lin[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $lin[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $lin[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $lin[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $lin[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $lin[0]; ?>_ava" name="<?php echo $lin[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $lin[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $lin[0]; ?>_work" name="<?php echo $lin[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else:?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $lin[0]; ?>_ava').val("<?php echo $lin[2]; ?>");
                                            $('#<?php echo $lin[0]; ?>_work').val("<?php echo $lin[3]; ?>");

                                            if ($('#<?php echo $lin[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $lin[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $lin[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $lin[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $lin[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $lin[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $lin[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $lin[0]; ?>_ava" name="<?php echo $lin[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $lin[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $lin[0]; ?>_work" name="<?php echo $lin[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($linux ) && count($linux) % 2 != 0):?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="row">
                            <div style="text-align: center; text-align-last: center;" class="col">
                                <button class="btn btn-primary" title="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <form action="updateInformation.php" method="post" name="fileInventory">
                    <div class="form-group">
                        <label for="netid" hidden></label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php echo $user->NetID ?>" hidden>
                        <input type="text" class="form-control" name="form" id="form" value="fileUSB" hidden>

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="fas fa-file-download"></i> Fileserver USB
                        </h5>

                        <?php $fileserver = $USBs['Fileserver']; $i = 0;
                        foreach ($fileserver as $fs):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $fs[0]; ?>_ava').val("<?php echo $fs[2]; ?>");
                                        $('#<?php echo $fs[0]; ?>_work').val("<?php echo $fs[3]; ?>");

                                        if ($('#<?php echo $fs[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $fs[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $fs[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $fs[0]; ?>_work').css('color','red');
                                        }

                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $fs[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $fs[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $fs[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $fs[0]; ?>_ava" name="<?php echo $fs[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $fs[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $fs[0]; ?>_work" name="<?php echo $fs[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else:?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $fs[0]; ?>_ava').val("<?php echo $fs[2]; ?>");
                                            $('#<?php echo $fs[0]; ?>_work').val("<?php echo $fs[3]; ?>");

                                            if ($('#<?php echo $fs[0]; ?>_ava').val() === 'Missing'){
                                                $('#<?php echo $fs[0]; ?>_ava').css('color','red');
                                            }

                                            if ($('#<?php echo $fs[0]; ?>_work').val() === 'Broken'){
                                                $('#<?php echo $fs[0]; ?>_work').css('color','red');
                                            }
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $fs[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $fs[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $fs[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $fs[0]; ?>_ava" name="<?php echo $fs[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $fs[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $fs[0]; ?>_work" name="<?php echo $fs[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($fileserver) && count($fileserver) % 2 != 0):?>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="row">
                            <div style="text-align: center; text-align-last: center;" class="col">
                                <button class="btn btn-primary" title="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <form action="updateInformation.php" method="post" name="bootcampInventory">
                    <div class="form-group">
                        <label for="netid" hidden></label>
                        <input type="text" class="form-control" name="netid" id="netid" value="<?php echo $user->NetID ?>" hidden>
                        <input type="text" class="form-control" name="form" id="form" value="bootUSB" hidden>

                        <h5 style="text-align: center; display: grid;">
                            <i style="color: black;" class="far fa-window-restore"></i> Bootcamp USB
                        </h5>

                        <?php $Bootcamp = $USBs['Bootcamp']; $i = 0;
                        foreach ($Bootcamp as $bc):
                            if (($i % 2) == 0):?>
                                <script>
                                    $(function () {
                                        $('#<?php echo $bc[0]; ?>_ava').val("<?php echo $bc[2]; ?>");
                                        $('#<?php echo $bc[0]; ?>_work').val("<?php echo $bc[3]; ?>");

                                        if ($('#<?php echo $bc[0]; ?>_ava').val() === 'Missing'){
                                            $('#<?php echo $bc[0]; ?>_ava').css('color','red');
                                        }

                                        if ($('#<?php echo $bc[0]; ?>_work').val() === 'Broken'){
                                            $('#<?php echo $bc[0]; ?>_work').css('color','red');
                                        }
                                    })
                                </script>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $bc[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $bc[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $bc[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $bc[0]; ?>_ava" name="<?php echo $bc[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $bc[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $bc[0]; ?>_work" name="<?php echo $bc[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; else:?>
                                    <script>
                                        $(function () {
                                            $('#<?php echo $bc[0]; ?>_ava').val("<?php echo $bc[2]; ?>");
                                            $('#<?php echo $bc[0]; ?>_work').val("<?php echo $bc[3]; ?>");
                                        })
                                    </script>
                                    <div class="col">
                                        <div class="mb-4 mb-xl-0">
                                            <div class="bg-white shadow roundy px-2 py-2 h-100 d-flex align-items-center justify-content-between">
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <div class="text">
                                                        <h6 class="widget-title"><?php echo $bc[1]; ?></h6>
                                                        <h2 class="widget-info">ID:<?php echo $bc[0]; ?></h2>
                                                    </div>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $bc[0]; ?>_ava">Inventory Status</label>
                                                    <select style="text-align: center; text-align-last: center;"
                                                            id="<?php echo $bc[0]; ?>_ava" name="<?php echo $bc[0]; ?>_ava">
                                                        <option value="Available">Available</option>
                                                        <option value="Missing">Missing</option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-fill bd-highlight align-items-center">
                                                    <label style="display: block;" for="<?php echo $bc[0]; ?>_work">Working Status</label>
                                                    <select id="<?php echo $bc[0]; ?>_work" name="<?php echo $bc[0]; ?>_work">
                                                        <option value="Working">Working</option>
                                                        <option value="Broken">Broken</option>
                                                    </select>
                                                </div>
                                                <div style="text-align: right;" class="col">
                                                    <i style="color:#006DF0;" class="fab fa-usb fa-3x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endif;
                                if ($i == count($Bootcamp) && count($Bootcamp) % 2 != 0):?>
                                    </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <div class="row">
                            <div style="text-align: center; text-align-last: center;" class="col">
                                <button class="btn btn-primary" title="Submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./content-wrapper -->

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

</body>

</html>
