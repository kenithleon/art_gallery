<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if artist is logged in
if (strlen($_SESSION['artist_id'] == 0)) {
    header('location:artlogin.php');
} else {
    if (isset($_POST['submit'])) {
        $artistid = $_SESSION['artist_id'];
        $aname = $_POST['artistname'];
        $mobno = $_POST['contactnumber'];
        $education = $_POST['education'];
        $award = $_POST['award'];

        // Update artist profile information in the database
        $query = mysqli_query($con, "UPDATE tblartist SET Name ='$aname', MobileNumber='$mobno', Education='$education', Award='$award' WHERE ID='$artistid'");
        if ($query) {
            echo "<script>alert('Artist profile has been updated.');</script>";
            echo "<script>window.location.href='artist-profile.php'</script>";
        } else {
            echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Artist Profile | Art Gallery Management System</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- external css -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body>
    <!-- container section start -->
    <section id="container" class="">
        <!--header start-->
        <?php include_once('includes/header.php'); ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once('includes/sidebar.php'); ?>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-user-md"></i> Artist Profile</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_documents_alt"></i>Pages</li>
                            <li><i class="fa fa-user-md"></i>Profile</li>
                        </ol>
                    </div>
                </div>

                <!-- profile form -->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-info">
                                <ul class="nav nav-tabs">
                                    <li class="">
                                        <a data-toggle="tab" href="#edit-profile">
                                            <i class="icon-envelope"></i>
                                            Edit Profile
                                        </a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div>
                                    <div id="edit-profile" class="tab-pane">
                                        <section class="panel">
                                            <div class="panel-body bio-graph-info">
                                                <h1>Profile Info</h1>
                                                <form class="form-horizontal" role="form" method="post" action="">
                                                    <?php
                                                    $artistid = $_SESSION['artist_id'];
                                                    $ret = mysqli_query($con, "SELECT * FROM tblartist WHERE ID='$artistid'");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Artist Name</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="artistname" name="artistname" type="text" value="<?php echo $row['Name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Username</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="username" name="username" type="text" value="<?php echo $row['Email']; ?>" readonly="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Contact Number</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="contactnumber" name="contactnumber" type="text" value="<?php echo $row['MobileNumber']; ?>" required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Email</label>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" id="email" name="email" type="email" value="<?php echo $row['Email']; ?>" readonly="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Education</label>
                                                        <div class="col-lg-6">
                                                            <textarea class="form-control" id="education" name="education"><?php echo $row['Education']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Awards</label>
                                                        <div class="col-lg-6">
                                                            <textarea class="form-control" id="award" name="award"><?php echo $row['Award']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <?php include_once('includes/footer.php'); ?>
    </section>
    <!-- container section end -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/scripts.js"></script>

    <script>
        $(".knob").knob();
    </script>
</body>

</html>
<?php } ?>
