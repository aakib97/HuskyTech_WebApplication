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

    <script type="text/javascript">
        $(document).ready(function(){
            $(document).ready(function () {
                $('#feedbackTable').DataTable({ "scrollX": true,
                    "order": [[ 0, "asc" ]]});
                $('#feedbackTable_length').css('float','left');
                $('#feedbackTable_info').css('float','left');
            });
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
                                            <input id="searchBar" class="form-control" onkeyup="searchFeedbacks()" type="text" placeholder="Search" aria-label="Search" style="padding-left: 20px; border-radius: 40px;" id="mysearch">
                                            <div class="input-group-addon" style="margin-left: -35px; z-index: 3; border-radius: 40px; background-color: transparent; border:none;">
                                                <button class="btn btn-primary btn-sm" type="submit" style="border-radius: 20px; margin-top: .2em"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table id="feedbackTable" class="table table-fixed table-striped table-hover">
                                            <thead id="dtBasicExample" class="table">
                                            <tr>
                                                <th>Name</th>
                                                <th>Rank</th>
                                                <th>Tech Name</th>
                                                <th>Feedback Type</th>
                                                <th>Comments</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $submissions = $user->allFeedbacks();
                                            foreach($submissions as $row): ?>
                                                <tr>
                                                    <td><?php echo $row[1]; ?></td>
                                                    <td><?php echo $row[2]; ?></td>
                                                    <td><?php echo $row[3]; ?></td>
                                                    <td><?php echo $row[4]; ?></td>
                                                    <td><?php echo $row[5]; ?></td>
                                                    <td>
                                                        <a href="#editSubModal" onclick="feedbackModal(this)" class="edit" id="<?php echo $row[0];?>" data-toggle="modal"><i style="color: green;" class="fas fa-edit" data-toggle="tooltip" title="Edit"></i></a>
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
                <h3 class="pb-2 m-0 text-center"><i class="fas fa-dollar-sign fa-fw" style="color: black;"></i>Student Feeback Edit Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="updateInformation.php" method="post" name="feedSub">
                    <input type="hidden" name="form" value="FeedSub"/>
                    <div class="form-group">
                        <label for="feedSubID" hidden>ID</label>
                        <input type="text" name="feedSubID" class="form-control" id="feedSubID"
                               value="" hidden>

                        <label for="feedSubName">Name</label>
                        <input type="text" name="feedSubName" class="form-control" id="feedSubName"
                               value="" readonly>
                        <br>

                        <label for="feedSubRank">Rank</label>
                        <input type="text" name="feedSubRank" class="form-control" id="feedSubRank"
                               value="" readonly>
                        <br>

                        <label for="feedSubTech">Tech Name</label>
                        <input type="text" class="form-control" name="feedSubTech" id="feedSubTech"
                               value="">

                        <br>

                        <label for="feedSubType">Rank</label>
                        <select class="form-control" name="feedSubType" id="feedSubType">
                            <option content="center">Positive</option>
                            <option content="center">Negative</option>
                            <option content="center" selected>N/A</option>
                        </select>

                        <br>

                        <label for="feedSubComments">Comments</label>
                        <textarea class="form-control" name="feedSubComments" id="feedSubComments" rows="3"></textarea>

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
                <input type="hidden" name="form" value="deleteFeed"/>
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