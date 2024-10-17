<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
<title>Art Gallery Management System | Product Page</title>

<script>
addEventListener("load", function () {
   setTimeout(hideURLbar, 0);
}, false);

function hideURLbar() {
   window.scrollTo(0, 1);
}
</script>
<!-- Meta Tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
<!-- Font Awesome Icons -->
<link href="css/fontawesome-all.min.css" rel="stylesheet" type="text/css" media="all">
<!-- Shopping Cart CSS -->
<link rel="stylesheet" href="css/shop.css" type="text/css" />
<!-- Price Range CSS -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui1.css">
<!-- Custom Stylesheet -->
<link href="css/style.css" rel='stylesheet' type='text/css' media="all">
<link href="//fonts.googleapis.com/css?family=Sunflower:500,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
</head>
<body>
<!-- Header -->
<?php include_once('includes/header.php'); ?>

<!-- Banner -->
<div class="inner_page-banner one-img"></div>

<!-- Breadcrumb -->
<div class="using-border py-3">
<div class="inner_breadcrumb ml-4">
<ul class="short_ls">
<li><a href="index.php">Home</a><span>/ </span></li>
<li>Products</li>
</ul>
</div>
</div>

<!-- Product Display -->
<section class="contact py-lg-4">
<div class="container-fluid py-lg-5">
<h3 class="title text-center mb-lg-5">
<h2 class="head" align="center"><?php echo htmlspecialchars($_GET['artname']); ?></h2>
<hr />
</h3>
<div class="row">
<!-- Sidebar -->
<div class="side-bar col-lg-3">
<div class="search-hotel">
<h3 class="agileits-sear-head">Search Here..</h3>
<form action="search.php" method="post">
<input type="search" placeholder="Art name..." name="search" required="">
<input type="submit" name="submit">
</form>
</div>

<!-- Art Type Preference -->
<div class="left-side">
<h3 class="agileits-sear-head">Art Type</h3>
<ul>
<li>
<?php
$artTypesQuery = mysqli_query($con, "SELECT * FROM tblarttype");
while ($row = mysqli_fetch_array($artTypesQuery)) {
   echo '<a class="nav-link" href="product.php?cid=' . $row['ID'] . '&&artname=' . urlencode($row['ArtType']) . '">
                                        <span class="span">' . htmlspecialchars($row['ArtType']) . '</span></a>';
}
?>
</li>
</ul>
</div>
</div>

<!-- Products -->
<div class="left-ads-display col-lg-9">
<div class="row">
<?php
$cid = $_GET['cid'];
$productsQuery = mysqli_query($con, "SELECT tblarttype.ID AS atid, tblarttype.ArtType AS typename, tblartproduct.ID AS apid, tblartproduct.Title, tblartproduct.Image FROM tblartproduct JOIN tblarttype ON tblarttype.ID=tblartproduct.ArtType WHERE tblartproduct.ArtType='$cid'");
$count = mysqli_num_rows($productsQuery);

if ($count > 0) {
   while ($row = mysqli_fetch_array($productsQuery)) {
      ?>
      <div class="col-lg-4 col-md-6 col-sm-6 product-men women_two">
      <div class="product-toys-info">
      <div class="men-pro-item">
      <div class="men-thumb-item">
      <img src="../images/<?php echo $row['Image']; ?>" data-imagezoom="true" class="img-fluid" alt=" ">
      
      <div class="men-cart-pro">
      <div class="inner-men-cart-pro">
      <a href="single-product.php?pid=<?php echo $row['apid']; ?>" class="link-product-add-cart">View Details</a>
      </div>
      </div>
      <span class="product-new-top">New</span>
      </div>
      <div class="item-info-product">
      <div class="info-product-price">
      <div class="grid_meta">
      <div class="product_price">
      <h4>
      <a href="single-product.php?pid=<?php echo $row['apid']; ?>" style="color:#000"><?php echo htmlspecialchars($row['Title']); ?></a>
      </h4>
      <div class="product_price">
      <?php if (isset($_SESSION['user_id'])) { ?>
         <!-- Buy Now button -->
         <form method="post" action="checkout.php" style="display:inline;">
         <input type="hidden" name="product_id" value="<?php echo $row['apid']; ?>">
         <button type="submit" class="btn btn-primary">Buy Now</button>
         </form>
         
         <!-- Add to Cart button -->
         <form method="post" action="add_to_cart.php" style="display:inline;">
         <input type="hidden" name="product_id" value="<?php echo $row['apid']; ?>">
         <button type="submit" class="btn btn-secondary">Add to Cart</button>
         </form>
         <?php } else { ?>
            <!-- Login prompt for non-logged users -->
            <p>Please <a href="login.php">log in</a> to purchase or add to cart.</p>
            <?php } ?>
            </div>
            </div>
            </div>
            </div>
            <div class="clearfix"></div>
            </div>
            </div>
            </div>
            </div>
            <?php
         }
      } else {
         echo '<h3 align="center" style="color:red;">No Record Found</h3>';
      }
      ?>
      </div>
      </div>
      </div>
      </div>
      </section>
      
      <!-- Footer -->
      <?php include_once('includes/footer.php'); ?>
      
      <!-- JavaScript -->
      <script src='js/jquery-2.2.3.min.js'></script>
      <script src="js/minicart.js"></script>
      <script src="js/bootstrap.min.js"></script>
      </body>
      </html>
      