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

    <title>Supplies Request Form</title>

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
    <link href="css/equipmentForm.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Datatable exports -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <!-- Datatable exports -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- Local stylesheet -->
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/card&widget.css">
    <link rel="stylesheet" type="text/css" href="css/nav&sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/equipmentForm.css">

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
            $("#equipmentRank").val(role);
        });

        $(document).ready(function () {
            $('#suppliesTable').DataTable({ "scrollX": true,
                "order": [[ 0, "asc" ]]});
            $('#suppliesTable_length').css('float','left');
            $('#suppliesTable_info').css('float','left');
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
                    <a href="#">Shop Managment</a>
                </li>
                <li class="breadcrumb-item active">Supplies Request Form</li>
            </ol>

            <section>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col mx-auto my-0">
                            <div class="card p-3 roundy shadow text-center mb-0">
                                <div style="height: 70px" class="row">
                                    <div style="text-align: left;"  class="col"><h2>My <b>Requests</b></h2></div>
                                </div>

                                <div class="table">
                                    <table id="suppliesTable" class="table table-fixed table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Rank</th>
                                            <th>Supplies Requested</th>
                                            <th>Comments</th>
                                            <th>Status</th>
                                            <th>Feedback</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php $submissions = $user->equipmentRequest();
                                        foreach($submissions as $row): ?>
                                            <tr>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td><?php echo $row[3]; ?></td>
                                                <td><?php echo $row[4]; ?></td>
                                                <td><?php echo $row[5]; ?></td>
                                                <td><?php echo $row[6]; ?></td>
                                                <td>
                                                    <a href="#editSubModal" onclick="mysupplyModal(this)" class="edit" id="<?php echo $row[0];?>" data-toggle="modal"><i style="color: green;" class="fas fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                                    <a href="#deleteSubModal" onclick="deleteWorker(this)" class="delete" id="<?php echo $row[0];?>" data-toggle="modal"><i style="color: red;" class="fas fa-trash-alt" data-toggle="tooltip" title="Delete"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <br>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form action="updateInformation.php" method="post">
                                <input type="hidden" name="form" value="equipment"/>
                                <div class="card shadow py-lg-2 p-3">
                                    <div class="form-group">
                                        <i class="material-icons" style="float: left; transform: rotate(90deg); color: black;">local_offer</i>
                                        <h3 class="pb-2 border-bottom m-0 text-center">Supplies Form
                                            <i class="material-icons" style="float: right; color: black;">local_offer</i>
                                        </h3>

                                        <br>

                                        <label for="equipmentName">Your Name</label>
                                        <input type="text" name="equipmentName" class="form-control" id="equipmentName"
                                               value="<?php global $user;
                                               echo $user->Full ?>" readonly>
                                        <br>

                                        <label for="equipmentRank">Rank</label>
                                        <select class="form-control" name="equipmentRank" id="equipmentRank" disabled>
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

                                        <input hidden id="equipmentRank" name="equipmentRank" value="<?php echo $user->Role;?>">

                                        <br>

                                        <label for="equipmentSupplies">Supplies Needed</label>
                                        <input type="text" class="form-control" name="equipmentSupplies" id="equipmentSupplies"
                                               placeholder="Pens, Postit Notes, etc." required>

                                        <br>

                                        <label for="equipmentComments">Additional Comments</label>
                                        <textarea class="form-control" name="equipmentComments" id="equipmentComments" rows="3"
                                                  placeholder="Provide feedback regarding the usage and need for the supplies" required></textarea>

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

<!--Edit Employee Modal-->
<div id="editSubModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="pb-2 m-0 text-center"><i class="fas fa-dollar-sign fa-fw" style="color: black;"></i> Request Edit Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="updateInformation.php" method="post" name="equipSub">
                    <input type="hidden" name="form" value="modalSub"/>
                    <div class="form-group">
                        <label for="modalID" hidden>Name</label>
                        <input type="text" name="modalID" class="form-control" id="modalID"
                               value="" hidden>

                        <label for="modalName">Name</label>
                        <input type="text" name="modalName" class="form-control" id="modalName"
                               value="" readonly>
                        <br>

                        <label for="modalRank">Rank</label>
                        <input type="text" name="modalRank" class="form-control" id="modalRank"
                               value="" readonly>
                        <br>

                        <label for="modalSupplies">Supplies Needed</label>
                        <input type="text" class="form-control" name="modalSupplies" id="modalSupplies"
                               value="">

                        <br>

                        <label for="modalComments">Additional Comments</label>
                        <textarea class="form-control" name="modalComments" id="modalComments" rows="3"
                                  value=""></textarea>

                        <label for="modalStatus">Status</label>
                        <select class="form-control" name="modalStatus" id="modalStatus" disabled>
                            <option value="Pending" content="center">Pending</option>
                            <option value="Withdrawn" content="center">Withdrawn</option>
                            <option value="Finished" content="center">Finished</option>
                        </select>

                        <br>

                        <label for="modalFeedback">Feedback</label>
                        <textarea class="form-control" name="modalFeedback" id="modalFeedback" rows="3" disabled></textarea>

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
<div id="deleteSubModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="updateInformation.php" method="post" name="deleteForm">
                <input type="hidden" name="form" value="deleteMySub"/>
                <input type="hidden" name="ID" id="deleteID" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Delete Submission</h4>
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

</body>

</html>