<?php
// Include the database connection file
require('html/includes/dbcon.php');

// Start a new or resume an existing session
session_start();

// Retrieve user information from the session
$user = $_SESSION['user'];

// SQL query to select all rows from the 'product' table
$query = "SELECT * FROM product";

// Execute the query and store the result
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags and title for the HTML document -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Craftify</title>
    
    <!-- Linking CSS stylesheets and external libraries -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/userindex.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    /* Wishlist Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    right: -250px;
    height: 100%;
    width: 250px;
    background-color: #f4f4f4;
    z-index: 999;
    transition: 0.3s;
    padding-top: 60px;
}

.sidebar.open {
    right: 0;
}

.sidebar h3 {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.sidebar li:last-child {
    border-bottom: none;
}

/* Wishlist Table */
#wishlistTable {
    width: 100%;
}

#wishlistTable th,
#wishlistTable td {
    padding: 10px;
    text-align: left;
}

#wishlistTable th {
    background-color: #f4f4f4;
    font-weight: bold;
}

#wishlistTable td img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 5px;
}

#wishlistTable td button {
    background-color: black;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

#wishlistTable td button:hover {
    background-color: #333;
}

      /* Wishlist Table */
#wishlistTable {
    width: 100%;
    border-collapse: collapse;
}

#wishlistTable th,
#wishlistTable td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd; /* Add border between rows */
}

#wishlistTable th {
    background-color: green;
}

#wishlistTable td img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 5px;
}

#wishlistTable td button {
    background-color: black;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
#wishlistTable td button:hover {
    background-color: #555;
}

/* Alternate row color */
#wishlistTable tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

        
        th, td {
            padding: 15px;
            text-align: left;
        }
        .close-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .close-button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
        .image-box img {
    width: 100%;
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Ensure the image covers the area while maintaining its aspect ratio */
    transition: transform 0.3s;
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
            <li><a href="#home" style="color: black;">Home</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#featured" style="color: black;">Featured</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#new" style="color: black;">New</a></li>
            <li><span class="nav-bar">|</span></li>
            <li><a href="#contact" style="color: black;">Contact</a></li>
        </ul>
        
        <!-- Search Bar -->
        <div class="search">
            <!-- Search Icon (with adjusted style) -->
            <i class='bx bx-search' id="searchIcon" style="color: black; font-size: 20px;"></i>
            <!-- Search Input (Initially Hidden) -->
            <form id="searchForm" action="html/includes/searchProduct.php" method="GET">
                <input type="text" id="searchInput" name="search" placeholder="Search a product" style="display: none;" />
            </form>
        </div>

        <!-- Wishlist Sidebar -->
        <div id="wishlistSidebar" class="sidebar">
            <button onclick="closeWishlistSidebar()" class="close-button" style="
                background-color: black;
                color: white;
                border: none;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 14px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: background-color 0.3s ease, transform 0.3s ease;"
                onmouseover="this.style.backgroundColor='black'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor='black'; this.style.transform='scale(1)';">
                Close
            </button>
            <!-- Wishlist content goes here -->
            <h3>My Wishlist</h3>
            <table id="wishlistItems" class="wishlist-table">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Wishlist items will be populated here by JavaScript -->
                </tbody>
            </table>
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
                <a class=""><b>Hi!<?php echo $user['username'] ?></b></a>
                
                <div class="dropdown-content">
                    <a href="html/users/dashboard.php" class="navbar-action-btn">My Account</a>
                    <a href="html/includes/logout.php" class="navbar-action-btn">Logout</a>
                </div>
            <?php else: ?>
                <a href="html/forms/login.php" class="navbar-action-btn">Log In</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Home section -->
    
    <section class="home" style=" color:white; height: 70vh;
 background-image: url('images/macramehome.jpeg');">
    <div class="home-text">
        <br><br><br><br><h2><i style=" color:white;">CRAFTIFY!</i></h2>
        <p style="color:black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"><b>"Your one-stop destination for all things crafty."</b></p>
        
        <a href="html/forms/login.php" class="btn">Shop Now</a>
    </div>
</section>

    <!-- Section for Gift Ideas -->
   <!-- Section for Gift Ideas -->
<section class="idea" style="background-image: url('images/sale.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container ">
        <div class="text22" style=" color:black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
            <h2 class="gift">Gift Ideas That Last Longer</h2>
            <p class="lead">Sale Up to 10%</p>
            <a href="#" class="btn1">Let's Go</a>
        </div>
    </div>
</section>

    <section class="featured" id="featured">
        <div class="center-text">
            <h2>Featured Categories</h2>
        </div>

 <div class="featured-content">
    <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="image-box">
        <img src="images/product/<?php echo $row['avatar'] ?>" alt="<?php echo $row['name'] ?>">
        <div class="product-info">
            <h3><?php echo $row['name'] ?></h3>
            <p><?php echo $row['description'] ?></p>
            <h4>Nrs. <?php echo $row['price'] ?></h4>
            <a href="html/users/product_detail.php?id=<?php echo $row['id'] ?>"><button class="buy1">Buy Now</button></a>
            <div class="wishlist-icon">
                <a href="#" onclick="addToWishlist(event)">
                    <i class='bx bx-heart'></i>
                </a>
            </div>
        </div>
    </div>
    <?php
            }
        }
    ?>
</div>


    </section>

    <section class="new" id="new">
        <div class="center-text">
            <h2>New Featured Products</h2>
            <p>Here you can check out new featured products</p>
        </div>

        <div class="new-content">
            <div class="box">
                <img src="images/pp4.jpg">
                <h5>Angel wallhanging</h5>
                <h6>Nrs.2000</h6>
            </div>

            <div class="box">
                <img src="images/p3.jpg">
                <h5>Coasters</h5>
                <h6>Nrs.500</h6>
            </div>

            <div class="box">
                <img src="images/p6.jpg">
                <h5>Moon shaped dream catcher</h5>
                <h6>Nrs.1500</h6>
            </div>

            <div class="box">
                <img src="images/p7.jpg">
                <h5>Macrame Bottle Holder</h5>
                <h6>Nrs.1600</h6>
            </div>
        </div>
    </section>

    <!-- Contact section -->
    <section class="contact" id="contact">
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
            <h3>Our Services</h3>
            <li><a href="#">Pricing</a></li>
        </div>
        <div class="main-contact">
            <h3>Shopping</h3>
            <li><a href="#">Handicraft</a></li>
        </div>
        <!-- Feedback form-->
        <div class="contact-form" style="text-align: center; margin-left: 300px; max-width: 400px;">
            <h2 style="color: aliceblue;"><u>Send us your feedback</u></h2>
            <p><a href="mailto:craftify@example.com" style="color:aliceblue"><i class="fa-solid fa-envelopes-bulk"></i>click here </a></p>
        </div>
    </section>

    <!-- Footer section -->
    <div class="last-text">
        <p>&copy; <?php echo date("Y"); ?> Craftify. All Rights Reserved.</p>
    </div>

    <!-- Scroll to top button -->
    <a href="#" class="top"><i class='bx bx-up-arrow-alt'></i></a>

    <!-- ScrollReveal library -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- Custom JavaScript file -->
    <script src="js/script.js"></script>
    <script>
    // JavaScript to toggle search input visibility when search icon is clicked
    document.getElementById("searchIcon").addEventListener("click", function() {
        var searchInput = document.getElementById("searchInput");
        if (searchInput.style.display === "none") {
            searchInput.style.display = "inline-block";
        } else {
            searchInput.style.display = "none";
        }
    });

    // JavaScript for opening and closing the wishlist sidebar
    function openWishlistSidebar() {
        document.getElementById("wishlistSidebar").classList.add("open");
    }

    function closeWishlistSidebar() {
        document.getElementById("wishlistSidebar").classList.remove("open");
    }

    // Function to load wishlist items from local storage and populate the wishlist sidebar
    function loadWishlistItems() {
        const wishlistItems = localStorage.getItem('wishlistItems');
        if (wishlistItems) {
            const parsedItems = JSON.parse(wishlistItems);
            const wishlistElement = document.getElementById('wishlistItems').getElementsByTagName('tbody')[0];
            wishlistElement.innerHTML = ''; // Clear any existing items
            parsedItems.forEach(item => {
                // Create table row
                const tableRow = document.createElement('tr');

                // Create table cell for product image
                const imageCell = document.createElement('td');
                const imageElement = document.createElement('img');
                imageElement.src = item.productImage;
                imageElement.width = 50; // Set the width of the image
                imageElement.height = 50; // Set the height of the image
                imageCell.appendChild(imageElement);
                tableRow.appendChild(imageCell);

                // Create table cell for product name
                const nameCell = document.createElement('td');
                nameCell.textContent = item.productName;
                tableRow.appendChild(nameCell);

                // Create table cell for product price
                const priceCell = document.createElement('td');
                priceCell.textContent = item.productPrice;
                tableRow.appendChild(priceCell);

                // Create table cell for actions
                const actionCell = document.createElement('td');

                // Add "Add to Cart" button
                const addToCartButton = document.createElement('button');
                addToCartButton.textContent = 'Add to Cart';
                addToCartButton.style.cssText = 'background-color: black; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease;';
                addToCartButton.addEventListener('click', function() {
                    console.log(`Adding ${item.productName} to cart`);
                });
                actionCell.appendChild(addToCartButton);

                // Add delete button
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.style.cssText = 'background-color: black; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease;';
                deleteButton.addEventListener('click', function() {
                    const itemIndex = parsedItems.findIndex(wishlistItem => wishlistItem.productName === item.productName && wishlistItem.productPrice === item.productPrice);
                    if (itemIndex !== -1) {
                        parsedItems.splice(itemIndex, 1);
                        localStorage.setItem('wishlistItems', JSON.stringify(parsedItems));
                        tableRow.remove();
                    }
                });
                actionCell.appendChild(deleteButton);

                tableRow.appendChild(actionCell);
                wishlistElement.appendChild(tableRow);
            });
        }
    }

    // Call loadWishlistItems if defined to load wishlist items when the page loads
    if (typeof loadWishlistItems === 'function') {
        loadWishlistItems();
    }

    function addToWishlist(event) {
        event.preventDefault();
        const itemElement = event.target.closest('.image-box');
        const productImage = itemElement.querySelector('img').src;
        const productName = itemElement.querySelector('h3').textContent;
        const productPrice = itemElement.querySelector('h4:last-of-type').textContent;

        const wishlistItem = {
            productImage,
            productName,
            productPrice
        };

        let wishlistItems = localStorage.getItem('wishlistItems');
        if (wishlistItems) {
            wishlistItems = JSON.parse(wishlistItems);
        } else {
            wishlistItems = [];
        }

        wishlistItems.push(wishlistItem);
        localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));

        loadWishlistItems();
    }
</script>

</body>
</html>
