<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
   $userid = $_SESSION['user_id'];
   $username = $_SESSION['user_name'];
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

   <!-- Meta tags, CSS, and Fonts -->
   <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
   <link href="css/fontawesome-all.min.css" rel="stylesheet" type="text/css" media="all">
   <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all" />
   <link href="css/JiSlider.css" rel="stylesheet">
   <link rel="stylesheet" href="css/shop.css" type="text/css" />
   <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
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
                           <p>Empowering Creativity, Curating Excellence: Manage, Showcase, and Inspire Art with Ease.</p>
                        </div>
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
                           <p>Empowering Creativity, Curating Excellence: Manage, Showcase, and Inspire Art with Ease.</p>
                        </div>
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
                           <p>Empowering Creativity, Curating Excellence: Manage, Showcase, and Inspire Art with Ease.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </li>
         </ul>
      </div>
      <div class="clearfix"></div>
   </div>
   
   <?php include_once('includes/footer.php'); ?>

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

   <script src="js/bootstrap.min.js"></script>
   <script src="js/JiSlider.js"></script>
   <script>
      $(function () {
         $('#JiSlider').JiSlider();
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
                  changePoint: 480,
                  visibleItems: 1
               },
               landscape: {
                  changePoint: 640,
                  visibleItems: 2
               },
               tablet: {
                  changePoint: 768,
                  visibleItems: 3
               }
            }
         });
      });
   </script>
</body>
</html>
