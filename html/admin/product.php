<?php
session_start();
$admin = $_SESSION['admin'];

require('../includes/dbcon.php');

// Process form submission for adding a new product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    
    $filename = $_FILES['product_image']['name'];
    $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);

    $image_name = md5($filename. time()) . '.' .$ext;

    $upload_dir = "../../images/product/$image_name";
    move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir);

    // Add a new product
    $query = "INSERT INTO `product` (`name`, `description`, `price`, `quantity`,`avatar`) 
              VALUES ('$product_name', '$product_description', '$product_price', '$product_quantity','$image_name')";

    $result = mysqli_query($con, $query);

    if ($result == 1) {
        $msg = "Product Added";
        header("Location:dashboard.php");
        exit(); // Important to prevent further execution after redirection
    } else {
        $msg = "Something went wrong.";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin/style.css">
    <link rel="stylesheet" href="../../css/adminaddproduct.css">

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .sidebar .nav-links li a.active{
  background: darkgray;
}
.sidebar .nav-links li a:hover{
  background: darkgray;
}
    </style>
    </head>
<body>
<div class="sidebar">
<div class="logo-container">
    <div class="logo-details">
    <span class="logo_name" style="font-family: 'Arial', sans-serif; font-size: 30px;">CRAFTIFY</span>
    </div>
</div>
    <ul class="nav-links">
        <li>
            <a href="dashboard.php">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="product.php" class="active">
                <i class='bx bx-box'></i>
                <span class="links_name">Product</span>
            </a>
        </li>
        <li>
            <a href="orderlist.php">
                <i class='bx bx-list-ul'></i>
                <span class="links_name">Order list</span>
            </a>
        </li>
        <li>
            <a href="stock.php">
                <i class='bx bx-coin-stack'></i>
                <span class="links_name">Stock</span>
            </a>
        </li>
        <li class="log_out">
            <?php
            if (isset($admin)) {
                ?>
                <a href="../includes/logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
                <?php
            }
            ?>
        </li>
    </ul>
</div>
<section class="home-section">
    <nav>
        <div class="profile-details">
            <span class="admin_name">Admin</span>
            <i class='bx bxs-user-circle'></i>
        </div>
    </nav>
    <div class="home-content">
        <div class="container">
            <div class="admin-product-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Add new product</h3>
                    <input type="text" placeholder="enter product name" name="product_name" class="box">
                    <input type="text" placeholder="enter product description" name="product_description" class="box">
                    <input type="number" placeholder="enter product price" name="product_price" class="box">
                    <input type="number" placeholder="enter product quantity" name="product_quantity" class="box">
                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                    <input type="submit" class="btn" name="add_product" value="Add Product">
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>
