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
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Students</title>

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
    <link rel="stylesheet" type="text/css" href="css/manageStudents.css">

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

    <!-- Datatable exports -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

    <!-- Datatable exports -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <script src="js/functions.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');

            checkbox.click(function(){
                if(!this.checked){
                    $("#selectAll").prop("checked", false);
                }
            });

            $(document).ready(function () {
                let role = "<?php echo $user->Role; ?>";
                $("#role").val(role);
                $('#workerTable').DataTable({ "scrollX": true, "columnDefs": [{ "orderable": false, "targets": 0 }],
                                            "order": [[ 1, "asc" ]], 'stateSave': true, dom: 'lBfrtip',  buttons: [{
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            download: 'open',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            }
                        }
                    ]});
                $('#workerTable_length').css('float','left');
                $('#workerTable_length').css('margin-right','15px');
                $('#workerTable_info').css('float','left');
                $('.buttons-pdf').addClass('btn');
                $('.buttons-pdf').addClass('btn-outline-primary');
                $('.buttons-pdf').removeClass('dt-button');
                $('.buttons-pdf').removeClass('button-html5');
                $('.buttons-pdf').removeClass('buttons-pdf');
            });
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
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Student Management</li>
                <li class="breadcrumb-item active">Update Student Information</li>
            </ol>


            <?php
            if (isset($_REQUEST['mesg'])):
                if ($_REQUEST['mesg'] == 'updated'):?>
                    <div class="alert alert-info text-center" role="alert">
                        Employee is added successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                elseif ($_REQUEST['mesg'] == 'deleted'):?>
                    <div class="alert alert-danger text-center" role="alert">
                        Employee is deleted successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                elseif ($_REQUEST['mesg'] == 'added'):?>
                    <div class="alert alert-success text-center" role="alert">
                        Employee Information updated successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <section>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col mx-auto my-0">
                            <div class="card p-3 roundy shadow text-center mb-0">
                                <div style="height: 70px" class="row">
                                    <div style="text-align: left;"  class="col"><h2>Manage <b>Employees</b></h2></div>
                                    <div style="text-align: right;" class="col">
                                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="fas fa-minus-circle"></i> <span>Delete</span></a>
                                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="fas fa-plus-circle"></i> <span>Add New Employee</span></a>
                                        <?php if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false):?>
                                            <a onclick="syncUsers()" class="btn btn-info" data-toggle="modal" style="color: white"><i class="fas fa-sync-alt"></i> <span>Sync All Employees</span></a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div style="margin-top: 15px;" class="row">
                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="calllead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Call Center Lead
                                        </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Percent</th>
                                                </tr>
                                            </thead>
                                            <tbody class="number-table">
                                                <tr>
                                                    <td><?php echo $user->rankNumbers('Call Center Lead')['Number'];?></td>
                                                    <td><?php echo round($user->rankNumbers('Call Center Lead')['Percent']*100) . '%';?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="shoplead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Shop Lead
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Shop Lead')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Shop Lead')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="aitlead-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            AIT Lead
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr class="text-align-center">
                                                <td><?php echo $user->rankNumbers('AIT Lead')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('AIT Lead')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="calladvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Call Center Advanced
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Call Center Advanced')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Call Center Advanced')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="shopadvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Shop Advanced
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Shop Advanced')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Shop Advanced')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="aitadvanced-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            AIT Advanced
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('AIT Advanced')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('AIT Advanced')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="callspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Call Center Specialist
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Call Center Specialist')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Call Center Specialist')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="shopspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Shop Specialist
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Shop Specialist')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Shop Specialist')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="aitspecialist-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            AIT Specialist
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('AIT Specialist')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('AIT Specialist')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="trainee-badge rank-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Trainee
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->rankNumbers('Trainee')['Number'];?></td>
                                                <td><?php echo round($user->rankNumbers('Trainee')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div style="margin-top: 15px;" class="row">
                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="improvements-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Improvements Team
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->teamNumbers('Improvements Team')['Number'];?></td>
                                                <td><?php echo round($user->teamNumbers('Improvements Team')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="kb-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Knowledge Base
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->teamNumbers('Knowledge Base')['Number'];?></td>
                                                <td><?php echo round($user->teamNumbers('Knowledge Base')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="training-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Training Committee
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->teamNumbers('Training Committee')['Number'];?></td>
                                                <td><?php echo round($user->teamNumbers('Training Committee')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div style="margin-bottom: .5em;" class="events-badge team-cell center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center">
                                            Events Coordination
                                        </div>
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Percent</th>
                                            </tr>
                                            </thead>
                                            <tbody class="number-table">
                                            <tr>
                                                <td><?php echo $user->teamNumbers('Events Coordination')['Number'];?></td>
                                                <td><?php echo round($user->teamNumbers('Events Coordination')['Percent']*100) . '%';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="table">
                                    <table id="workerTable" class="table table-fixed table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th class="checkbox-cell">
                                                <span class="custom-checkbox">
                                                    <input onclick="selectAll(this)" type="checkbox" id="selectAll">
                                                    <label for="selectAll"></label>
                                                </span>
                                            </th>

                                            <th class="full-cell">Full Name</th>
                                            <th class="netid-cell">NetID</th>
                                            <th class="ID-cell">BlackboardID</th>
                                            <th class="rank-cell">Rank</th>
                                            <th class="team-cell">Team Selection</th>
                                            <th class="email-cell">Email</th>
                                            <th class="stuEmail-cell">Student Email</th>
                                            <th class="grad-cell">Graduation</th>
                                            <th class="acd-cell">ACD</th>
                                            <?php if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false):?>
                                                <th class="notes-cell">Notes</th>
                                                <th class="actions-cell">Actions</th>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php global $user; $HC_workers = $user->getEmployees();
                                        if ($HC_workers):
                                            foreach($HC_workers as $worker): ?>
                                                <tr>
                                                    <td class="checkbox-cell">
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" class="checkbox" onclick="workerCheck()" id="<?php echo $worker->NetID;?>" name="options[]" value="1">
                                                            <label for="<?php echo $worker->NetID;?>"></label>
                                                        </span>
                                                    </td>

                                                    <td class="full-cell"><?php echo $worker->Full;?></td>
                                                    <td class="netid-cell"><?php echo $worker->NetID;?></td>
                                                    <td id="<?php echo $worker->NetID . " ID"; ?>" class="ID-cell"><?php echo $worker->blackboardID;?></td>
                                                    <td class="rank-cell"><div<?php if ($worker->Role == 'FTE'):?>  class="fte-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Shop Lead'):?>  class="shoplead-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Call Center Lead'):?> class="calllead-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'AIT Lead'):?> class="aitlead-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Call Center Advanced'):?> class="calladvanced-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Shop Advanced'):?> class="shopadvanced-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'AIT Advanced'):?> class="aitadvanced-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Call Center Specialist'):?> class="callspecialist-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Shop Specialist'):?> class="shopspecialist-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'AIT Specialist'):?> class="aitspecialist-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Role == 'Trainee'):?> class="trainee-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"<?php endif; ?>>
                                                            <?php echo $worker->Role;?></div></td>
                                                    <td class="team-cell"><div<?php if ($worker->Team == 'Improvements Team'):?> class="improvements-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Team == 'Training Committee'):?> class="training-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Team == 'Events Coordination'):?> class="events-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"
                                                        <?php elseif ($worker->Team == 'Knowledge Base'):?> class="kb-badge center-block badge shadow badge-pill d-inline-flex align-items-center justify-content-center"<?php endif; ?>>
                                                            <?php echo $worker->Team;?></div></td>
                                                    <td class="email-cell"><?php echo $worker->Email;?></td>
                                                    <td class="stuEmail-cell"><?php echo $worker->StudentEmail;?></td>
                                                    <td class="grad-cell"><?php echo $worker->Graduation;?></td>
                                                    <td class="acd-cell"><?php echo $worker->ACD;?></td>
                                                    <?php if ($user->Role == 'FTE' || strpos($user->Role, 'Lead') != false):?>
                                                        <td class="notes-cell"><?php echo $worker->Notes;?></td>
                                                        <td class="actions-cell">
                                                            <a href="#editEmployeeModal" onclick="infoModal(this)" class="edit" id="<?php echo $worker->NetID;?>" data-toggle="modal"><i style="color: green;" class="fas fa-user-edit" data-toggle="tooltip" title="Edit"></i></a>
                                                            <a href="#deleteEmployeeModal" onclick="deleteWorker(this)" class="delete" id="<?php echo $worker->NetID;?>" data-toggle="modal"><i style="color: red;" class="fas fa-trash-alt" data-toggle="tooltip" title="Delete"></i></a>
                                                            <a href="infoPage.php?NetID=<?php echo $worker->NetID; ?>" class="info"><i style="color: orange;" class="fas fa-external-link-alt" data-toggle="tooltip" title="Info Page"></i></a>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
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

<!--Add Employee Modal-->
<div id="addEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="pb-2 m-0 text-center"><i class="fas fa-user-plus fa-fw" style="color: black;"></i> Student Add Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="updateInformation.php" method="post" name="studentForm">
                    <input type="hidden" name="form" value="addStudent"/>
                    <div class="form-group">
                        <label for="first">Students First Name</label>
                        <input type="text" class="form-control" name="first" id="fname" onkeyup="autoGenerate()" placeholder="Jonathan" required>

                        <br>

                        <label for="last">Students Last Name</label>
                        <input type="text" class="form-control" name="last" id="lname" onkeyup="autoGenerate()" placeholder="Husky" required>

                        <br>

                        <label for="full">Students Full Name</label>
                        <input type="text" class="form-control" name="full" id="fullname" placeholder="Jonathan Husky" readonly>

                        <br>

                        <label for="netid">Students NetID</label>
                        <input type="text" class="form-control" name="netid" placeholder="joh12345" required>

                        <br>

                        <label for="rank">Students Rank</label>
                        <select class="form-control" name="rank" id="stuRole" onchange="autoGenerate()" required>
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

                        <br>

                        <label for="teamSelection">Team Selection</label>
                        <select class="form-control" name="team" id="teamSelection">
                            <option value="" selected disabled hidden>Select One</option>
                            <option value="Knowledge Base" content="center">Knowledge Base</option>
                            <option value="Improvements Team" content="center">Improvements Team</option>
                            <option value="Events Coordination" content="center">Events Coordination</option>
                            <option value="Training Committee" content="center">Training Committee</option>
                        </select>

                        <br>

                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="EMail" placeholder="jonathan.husky@uconn.edu">

                        <br>

                        <label for="StudentEmail">Student Email</label>
                        <input type="text" class="form-control" name="StudentEmail" id="stuEmail" placeholder="joh12345work@uconn.edu">

                        <br>

                        <label for="grad">Expected Graduation</label>
                        <input type="text" class="form-control" name="grad" id="graduation" placeholder="Spring 2022">

                        <br>

                        <label for="ACD">ACD Level (Accounts/Help Center)</label>
                        <input type="text" class="form-control" name="acd" id='acd' value="9/9">

                        <br>

                        <label for="notes">Notes</label>
                        <textarea class="form-control" placeholder="Any Additional Notes" name="notes" rows="3"></textarea>

                        <br>

                        <div class="text-center">
                            <button class="btn btn-primary" title="Submit">Add Student</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Edit Employee Modal-->
<div id="editEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="pb-2 m-0 text-center"><i class="fas fa-user-plus fa-fw" style="color: black;"></i> Student Add Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="updateInformation.php" method="post" name="studentForm">
                    <input type="hidden" name="form" value="student"/>
                    <div class="form-group">
                        <img class="img-responsive img-thumbnail mx-auto d-block" src="Assets/turtle2.jpg" style="width: 300px; height: auto;">

                        <br>

                        <label for="first">First Name</label>
                        <input type="text" class="form-control"  name="first" id="first">

                        <br>

                        <label for="last">Last Name</label>
                        <input type="text" class="form-control" name="last" id="last">

                        <br>

                        <label for="full">Full Name</label>
                        <input type="text" class="form-control" name="full" id="full" readonly>

                        <br>

                        <label for="NetID">NetID</label>
                        <input type="text" class="form-control" name="netid" id="NetID" readonly>

                        <br>

                        <label for="blackboardID">BlackboardID</label>
                        <input type="text" class="form-control" name="blackboardID" id="blackboardID">

                        <br>

                        <label for="rank">Rank</label>
                        <select class="form-control" name="rank" id="role">
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

                        <br>

                        <label for="team">Team Selection</label>
                        <select class="form-control" name="team" id="team">
                            <option value="Knowledge Base" content="center">Knowledge Base</option>
                            <option value="Improvements Team" content="center">Improvements Team</option>
                            <option value="Events Coordination" content="center">Events Coordination</option>
                            <option value="Training Committee" content="center" selected>Training Committee</option>
                        </select>

                        <br>

                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email">

                        <br>

                        <label for="StudentEmail">Student Worker Email</label>
                        <input type="text" class="form-control" name="StudentEmail" value="" id="StudentEmail">

                        <br>

                        <label for="Grad">Expected Graduation</label>
                        <input type="text" class="form-control" name="grad" id="Grad">

                        <br>

                        <label for="ACD">ACD Level (Accounts/Help Center)</label>
                        <input type="text" class="form-control" name="acd" id="ACD">

                        <br>

                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>

                        <br>

                        <div class="text-center">
                            <button class="btn btn-primary" title="Submit">Update</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!--Delete Employee Modal-->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="updateInformation.php" method="post" name="deleteForm">
                <input type="hidden" name="form" value="deleteStudent"/>
                <input type="hidden" name="netid" id="deleteID" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div style="text-align: center;" class="modal-body">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="syncEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="pb-2 m-0 text-center"><i class="fas fa-sync-alt fa-fw" style="color: black;"></i> Please Wait</h3>
                <hr>
                <h5 class="pb-2 m-0 border-bottom text-center">Syncing all Employees to Blackboard. This may take several minutes...</h5>
            </div>

            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                         aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>



