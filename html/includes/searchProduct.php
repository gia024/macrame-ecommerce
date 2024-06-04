<?php
// Start the session at the very beginning
session_start();

// Include database connection and any other necessary files
require('../includes/dbcon.php');

// Check if the user key is set in the session
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    // Handle the case where the user is not logged in
    // Redirect or display an error message
    exit("User not logged in");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/searchproduct.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Document</title>
    <style>
/* General Reset */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Navigation Bar */
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 8%;
    background-color: #fff; /* White background for the navbar */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for better visibility */
}

header .logo {
    font-size: 32px;
    font-weight: 500;
    cursor: pointer;
    color: black; /* Logo color */
}

header ul {
    display: flex;
    align-items: center;
}

header ul li {
    list-style: none;
    display: inline-block;
}

header ul li a {
    display: block;
    margin: 0 10px;
    color: black; /* Link color */
    font-weight: 500;
    text-decoration: none;
    font-size: 17px;
    position: relative;
    padding: 5px 0; /* Padding for better clickability */
}

header ul li a::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    background-color: black; /* Underline color */
    width: 0;
    height: 2.5px;
    transition: all 0.3s ease;
}

header ul li a:hover::before {
    width: 100%;
}

header .search {
    display: flex;
    align-items: center;
}

header .search #searchIcon {
    color: black;
    font-size: 20px;
    cursor: pointer;
}

header .search #searchInput {
    display: none;
    padding: 5px;
    border: 1px solid black;
    border-radius: 4px;
    outline: none;
}

header .header-icons {
    position: relative;
    display: flex;
    align-items: center;
}

header .header-icons i {
    color: black; /* Icon color */
    font-size: 20px;
    margin: 0 10px;
    cursor: pointer;
}

header .header-icons:hover .dropdown-content {
    display: block;
}

header .dropdown-content {
    display: none;
    position: absolute;
    top: 30px;
    right: 0;
    background: white;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
    z-index: 10;
}

header .dropdown-content a {
    display: block;
    padding: 10px 15px;
    color: black;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
}

header .dropdown-content a:hover {
    background-color: #f0f0f0; /* Hover background color */
    color: var(--main-color); /* Main theme color */
}


    </style>
    
</head>
<body>
    <!-- Header section -->
    <header>
        <!-- Logo (with black color) -->
        <a href="../../user_index.php" class="logo" style="color: black;">CRAFTIFY</a>

        <!-- Navigation Links -->
        <ul class="navlist">
            <li><a href="../../user_index.php" style="color: black;">Home</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#featured" style="color: black;">Featured</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#new" style="color: black;">New</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#contact" style="color: black;">Contact</a></li>
        </ul>

       <!-- Search Bar -->
    <div class="search">
        <i class='bx bx-search' id="searchIcon" style="color:green; font-size: 20px;"></i>
        <form id="searchForm" action="html/includes/searchProduct.php" method="GET">
            <input type="text" id="searchInput" name="search" placeholder="Search a product" style="display: none;" />
        </form>
    </div>

     <!-- Wishlist Sidebar -->
<div id="wishlistSidebar" class="sidebar">
    <button onclick="closeWishlistSidebar()" class="close-button">Close</button>
    <h3>My Wishlist</h3>
    <ul id="wishlistItems">
    </ul>
</div>

<!-- Wishlist Icon -->
<div class="header-icons">
    <a href="#" onclick="openWishlistSidebar()">
        <i id="wishlistIcon" class='bx bx-heart' style='color:black;' data-count="0"></i>
    </a>
</div>
    <!-- Cart Icon -->
    <div class="header-icons">
        <a href="html/users/dashboard.php"><i class='bx bx-shopping-bag' style='color:black;'></i></a>
    </div>
        <!-- User icons and dropdown menu -->
        <div class="header-icons">
            <?php if(isset($user['username'])): ?>
                <a class="navbar-action-btnn"><b><?php echo $user['username'] ?></b></a>
                <div class="dropdown-content">
                    <a href="html/users/dashboard.php" class="navbar-action-btn">My Account</a>
                    <a href="html/includes/logout.php" class="navbar-action-btn">Logout</a>
                </div>
            <?php else: ?>
                <a href="html/forms/login.php" class="navbar-action-btn">Log In</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Search Results Section -->
    <section>
        <div class="container">
            <h1>Search Results</h1>
            <div class="product-grid">
                <?php
                // Check if the search query is set
                if(isset($_GET['search'])) {
                    // Sanitize the search query to prevent SQL injection
                    $search = mysqli_real_escape_string($con, $_GET['search']);

                    // Fetch products from the database where the name matches the search query
                    $query = "SELECT * FROM product WHERE name LIKE '%$search%'";
                    $result = mysqli_query($con, $query);

                    // Check if any products were found
                    if(mysqli_num_rows($result) > 0) {
                        // Display search results
                        while($row = mysqli_fetch_assoc($result)) {
                            // Display product details
                            echo "<div class='product'>";
                            echo "<img src='../../images/product/" . $row['avatar'] . "' alt='" . $row['name'] . "'>";
                            echo "<h2>" . $row['name'] . "</h2>";
                            echo "<p>" . $row['description'] . "</p>";
                            echo "<p>Price: Nrs. " . $row['price'] . "</p>";
                            echo "<form action='dashboard.php' method='POST'>";
                            echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                            echo "<input type='hidden' name='user_id' value='" . $user['id'] . "'>";
                            echo "<input type='hidden' name='amount' value='" . $row['price'] . "'>";
                            echo "<input type='hidden' name='quantity' value='1'>";
                            echo "<div class='btn-box'>";
                            echo "<button type='submit' class='cart-btn' style='background-color:black'>Add to Cart</button>";
                            echo "<button type='submit' class='buy-btn' style='background-color:black'>Buy Now</button>";
                            echo "</div>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        // No matching products found
                        echo "<p>No products found matching your search.</p>";
                    }
                } else {
                    // Handle the case where the search query is not provided
                    // Display an error message or redirect
                    exit("<p>Search query not provided.</p>");
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact section -->
    <section class="contact" id="contact">
        <!-- Contact content here -->
        <div class="main-contact">
            <h3>Craftify</h3>
            <h5>Let's Connect</h5>
            <div class="icons">
                <a href="" target="_blank"><i class='bx bxl-instagram-alt'></i></a>
            </div>
        </div>
        <div class="main-contact">
            <h3>Explore</h3>
            <li><a href="#home">Home</a></li>
            <li><a href="#featured">Featured</a></li>
            <li><a href="#new">New</a></li>
            <li><a href="#contact">Contact</a></li>
        </div>
        <div class="main-contact">
            <h3>Legal</h3>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
        </div>
    </section>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 Craftify. All rights reserved.</p>
    </footer>

    <!-- JavaScript for sidebar functionality -->
    <script>
        // Function to open the wishlist sidebar
        function openWishlistSidebar() {
            document.getElementById("wishlistSidebar").classList.add("open");
        }

        // Function to close the wishlist sidebar
        function closeWishlistSidebar() {
            document.getElementById("wishlistSidebar").classList.remove("open");
        }
    </script>
</body>
</html>
