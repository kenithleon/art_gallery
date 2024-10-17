<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
   $userid = $_SESSION['user_id'];
   $username = $_SESSION['user_name'];

   // Optionally, fetch user data from the database to ensure data consistency
   /*
   $query = mysqli_query($con, "SELECT user_name FROM tbuser WHERE user_id='$userid'");
   $result = mysqli_fetch_array($query);
   $username = $result['user_name'];
   */
}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
   <title>Art Gallery Management System | Home Page</title>
   
   <script>
      addEventListener("load", function () {
         setTimeout(hideURLbar, 0);

         // Greet the user with their name when they log in
         <?php if(isset($username)) { ?>
            alert("Welcome, <?php echo $username; ?>!");
         <?php } ?>
      }, false);
      
      function hideURLbar() {
         window.scrollTo(0, 1);
      }
   </script>
   <!--//meta tags ends here-->
   <!--bootstrap-->
   <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
   <!--//bootstrap end-->
   <!-- font-awesome icons -->
   <link href="css/fontawesome-all.min.css" rel="stylesheet" type="text/css" media="all">
   <!-- //font-awesome icons -->
   <!-- For Clients slider -->
   <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all" />
   <!--flexs slider-->
   <link href="css/JiSlider.css" rel="stylesheet">
   <!--Shopping cart-->
   <link rel="stylesheet" href="css/shop.css" type="text/css" />
   <!--//Shopping cart-->
   <!--stylesheets-->
   <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
   <!--//stylesheets-->
   <link href="//fonts.googleapis.com/css?family=Sunflower:500,700" rel="stylesheet">
   <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
</head>
<body>
   <?php include_once('includes/header.php'); ?>
   <div class="slider text-center">
      <div class="callbacks_container">
         <ul class="rslides" id="slider4">
            <li>
               <div class="slider-img one-img">
                  <div class="container">
                     <div class="slider-info">
                        <h5>Pick The Best Art For <br>Your Choice</h5>
                        <div class="bottom-info">
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                        <!-- <div class="outs_more-buttn">
                           <a href="about.php">Read More</a>
                        </div> -->
                     </div>
                  </div>
               </div>
            </li>
            <li>
               <div class="slider-img two-img">
                  <div class="container">
                     <div class="slider-info">
                        <h5>Sort Art And Painting<br>For Your Choice</h5>
                        <div class="bottom-info">
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                        <!-- <div class="outs_more-buttn">
                           <a href="about.php">Read More</a>
                        </div> -->
                     </div>
                  </div>
               </div>
            </li>
            <li>
               <div class="slider-img three-img">
                  <div class="container">
                     <div class="slider-info">
                        <h5>Best Art And Painting<br> For Your Choice</h5>
                        <div class="bottom-info">
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                        </div>
                        <!-- <div class="outs_more-buttn">
                           <a href="about.php">Read More</a>
                        </div> -->
                     </div>
                  </div>
               </div>
            </li>
         </ul>
      </div>
      <div class="clearfix"></div>
   </div>
   <!-- about -->
   <!-- <section class="about py-lg-4 py-md-3 py-sm-3 py-3" id="about">
      <div class="container py-lg-5 py-md-5 py-sm-4 py-4">
         <h3 class="title text-center mb-lg-5 mb-md-4  mb-sm-4 mb-3">Best Products</h3>
         <div class="row banner-below-w3l">
            <!- Product Categories -->
            <!-- <div class="col-lg-4 col-md-6 col-sm-6 text-center banner-agile-flowers">
               <img src="images/a1.jpg" width="200" height="200" class="img-thumbnail" alt="">
               <div class="banner-right-icon">
                  <h4 class="pt-3">Sculptures</h4>
               </div>
            </div> -->
            <!-- Repeat similar blocks for other product categories -->
            <!-- ... -->
            <!-- <div class="toys-grids-upper">
               <div class="about-toys-off">
                  <h2>Get Up to <span>70% Off </span>On Selected Art</h2>
               </div>
            </div>
         </div>
      </div>
   </section> --> 
   <!-- //about -->
   <!-- New Arrivals -->
   <!-- <section class="blog py-lg-4 py-md-3 py-sm-3 py-3">
      <div class="container py-lg-5 py-md-4 py-sm-4 py-3">
         <h3 class="title clr text-center mb-lg-5 mb-md-4 mb-sm-4 mb-3">New Arrivals</h3>
         <div class="slid-img">
            <ul id="flexiselDemo1">
                <?php
               $ret = mysqli_query($con, "SELECT tblarttype.ID as atid, tblarttype.ArtType as typename, tblartproduct.ID as apid, tblartproduct.Title, tblartproduct.Image, tblartproduct.ArtType FROM tblartproduct JOIN tblarttype ON tblarttype.ID=tblartproduct.ArtType");
               while ($row = mysqli_fetch_array($ret)) {
               ?> 
               <li>
                  <div class="agileinfo_port_grid">
                     <img src="admin/images/<?php echo $row['Image']; ?>" width="300" height="300" alt=" " class="img-fluid" />
                     <div class="banner-right-icon">
                        <h4 class="pt-3"><?php echo $row['typename']; ?></h4>
                     </div>
                     <div class="outs_more-buttn">
                        <a href="art-enquiry.php?eid=<?php echo $row['apid']; ?>">Enquiry</a>
                     </div>
                  </div>
               </li>
               <?php } ?>
            </ul>
         </div>
      </div>
   </section> -->
   <!--//New Arrivals -->
   <!-- Product About -->
   <!-- <section class="about py-lg-4 py-md-3 py-sm-3 py-3">
      <div class="container py-lg-5 py-md-5 py-sm-4 py-3">
         <?php
         $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='aboutus'");
         while ($row = mysqli_fetch_array($ret)) {
         ?>
         <h3 class="title text-center mb-lg-5 mb-md-4 mb-sm-4 mb-3"><?php echo $row['PageTitle']; ?></h3>
         <div class="about-products-w3layouts">
            <p><?php echo $row['PageDescription']; ?></p>
         </div>
         <?php } ?>
      </div>
   </section> -->
   <!--//Product About -->
   <!-- Footer -->
   <?php include_once('includes/footer.php'); ?>
   <!-- //Footer -->
   <!-- JS Scripts -->
   <script src='js/jquery-2.2.3.min.js'></script>
   <!-- Cart JS -->
   <script src="js/minicart.js"></script>
   <script>
      toys.render();
      
      toys.cart.on('toys_checkout', function (evt) {
         var items, len, i;
         if (this.subtotal() > 0) {
            items = this.items();
            for (i = 0, len = items.length; i < len; i++) {}
         }
      });
   </script>
   <!-- //Cart JS -->
   <!-- Responsive Slides -->
   <script src="js/responsiveslides.min.js"></script>
   <script>
      $(function () {
         $("#slider4").responsiveSlides({
            auto: true,
            pager: false,
            nav: true,
            speed: 900,
            namespace: "callbacks",
            before: function () {
               $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
               $('.events').append("<li>after event fired.</li>");
            }
         });
      });
   </script>
   <!-- //Responsive Slides -->
   <script src="js/bootstrap.min.js"></script>
   <script src="js/JiSlider.js"></script>
   <script>
      $(function () {
         $('# JiSlider').JiSlider();
      });
   </script>
   <!-- FlexSlider -->
   <script src="js/jquery.flexisel.js"></script>
   <script>
      $(document).ready(function () {
         $("#flexiselDemo1").flexisel({
            visibleItems: 3,
            animationSpeed: 1000,
            autoPlay: true,
            autoPlaySpeed: 3000,
            pauseOnHover: true,
            enableResponsiveBreakpoints: true,
            responsiveBreakpoints: {
               portrait: {
                  changePoint:480,
                  visibleItems: 1
               },
               landscape: {
                  changePoint:640,
                  visibleItems: 2
               },
               tablet: {
                  changePoint:768,
                  visibleItems: 3
               }
            }
         });
      });
   </script>
   <!-- //FlexSlider -->
</body>
</html>
