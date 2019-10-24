<?php
//Import the phpCAS Library
include_once('./CAS/CAS.php');
require('./classes/Employee.class.php');

include('./Persistence.php');

$comment_post_ID = 1;
$db = new Persistence();
$comments = $db->get_comments($comment_post_ID);
$has_comments = (count($comments) > 0);

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
    header('location: index.php');
}

if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
    session_destroy();
}

//var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Updates</title>

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
    <link rel="stylesheet" type="text/css" href="css/updates.css">

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
                <li class="breadcrumb-item" style="color: #006DF0;">Updates</li>
                <!--                <li class="breadcrumb-item active">Call Center</li>-->
            </ol>

            <section id="comments" class="body">

                <!-- <header>
                     <h3>Updates</h3>
                 </header> -->


                <ol id="posts-list" class="hfeed<?php echo($has_comments?' has-comments': ''); ?>">
                    <li class="no-comments">Nothing here...</li>
                    <?php
                    foreach ($comments as $comment) {
                        ?>
                        <li><article id="comment_<?php echo($comment['id']); ?>" class="hentry">
                                <footer class="post-info">
                                    <abbr class="published" title="<?php echo($comment['date']); ?>">
                                        <?php echo( date('d F Y', strtotime($comment['date']) ) ); ?>
                                    </abbr>

                                    <address class="vcard author">
                                        By <a class="url fn" href="#"><?php echo($comment['comment_author']); ?></a>
                                    </address>
                                </footer>

                                <div class="entry-content">
                                    <p><?php echo($comment['comment']); ?></p>
                                </div>
                            </article></li>
                        <?php
                    }
                    ?>
                </ol>
            </section>

            <div id="respond">

                <h4>Leave a Comment</h4>

                <form action="./post_comment.php" method="post" id="commentform">

                    <label for="comment_author" class="required">Your name</label>
                    <input type="text" name="comment_author" id="comment_author" value="<?php global $user;
                    echo $user->Full; ?>" tabindex="1"
                           required="required">

                    <label for="email" class="required">Your email</label>
                    <input type="email" name="email" id="email" value="<?php global $user;
                    echo $user->Email; ?>" tabindex="2" required="required">

                    <label for="comment" class="required">Your message</label>
                    <textarea name="comment" id="comment" rows="10" tabindex="4" required="required"></textarea>

<!--                    comment_post_ID value hard-coded as 1-->
                    <input type="hidden" name="comment_post_ID" value="<?php echo($comment_post_ID); ?>" id="comment_post_ID"/>
                    <input name="submit" type="submit" value="Submit comment"/>

                </form>

            </div>
        </div>
    </div>
    <!-- ./content-wrapper -->

</div>
<!-- #wrapper -->

<!-- Scroll to Top Button-->
<a id="scrollUp"></a>

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
<script src="js/app.js"></script>

</body>

</html>