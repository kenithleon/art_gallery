<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the session variable 'ID' exists
if (isset($_SESSION['ID'])) {
    $artistId = $_SESSION['ID'];  // Use the correct session key
} else {
    die('Artist ID not set in session.');
}



// Fetch artist's name from the database
$query = "SELECT Name FROM tblartist WHERE ID = '$artistId'";
$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error); // Debugging line to show the error
}

$artist = $result->fetch_assoc();
$name = $artist['Name']; // Get the artist's name

// Fetch notifications
$ret1 = $con->query("SELECT * FROM tblenquiry WHERE (Status='' OR Status IS NULL) AND ArtistID='$artistId'");
$num1 = $ret1 ? mysqli_num_rows($ret1) : 0;
?>

<header class="header dark-bg">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
    </div>

    <a href="artist_dashboard.php" class="logo"><span class="lite"><strong> ART GALLERY | ARTIST</strong></span></a>

    <div class="top-nav notification-row">
        <ul class="nav pull-right top-menu">

            <li id="alert_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-bell" style="color:#fff;"></i>
                    <span class="badge bg-important"><?php echo $num1; ?></span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <div class="notify-arrow notify-arrow-blue"></div>
                    <li>
                        <p class="blue">You have <?php echo $num1; ?> new notifications</p>
                    </li>

                    <?php
                    if ($num1 > 0) {
                        while ($row1 = mysqli_fetch_array($ret1)) { ?>
                            <li>
                                <a href="view-enquiry-detail.php?viewid=<?php echo $row1['ID']; ?>">
                                    <span class="label label-primary"><i class="icon_profile"></i></span>
                                    New Enquiry: <?php echo $row1['FullName']; ?>
                                </a>
                            </li>
                        <?php } 
                    } else { ?>
                        <p align="center">No Enquiry found</p>
                    <?php } ?>
                </ul>
            </li>

            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="profile-ava">
                        <img alt="" src="images/artist_avatar.jpg" width="40" height="30">
                    </span>
                    <span class="username"><?php echo $name; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout" style="z-index: 9999;">
                    <div class="log-arrow-up"></div>
                    <li class="eborder-top">
                        <a href="artist-profile.php"><i class="icon_profile"></i> My Profile</a>
                    </li>
                    <li>
                        <a href="artist-change-password.php"><i class="icon_mail_alt"></i> Change Password</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="icon_key_alt"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<?php
// Close the database connection
$conn->close();
?>
