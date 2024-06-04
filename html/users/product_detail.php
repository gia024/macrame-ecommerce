<?php
    require('../includes/dbcon.php');

    session_start();
    $user = $_SESSION['user'];

    $id = $_GET['id'];

    $query = "select * from product where id = $id";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details Page</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/user/product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

		.header-icons{
			position: relative;
            color: black;
		}
		.header-icons:hover .dropdown-content{
			display: block;
		}
		.dropdown-content{
			padding: 5px 0;
			position: absolute;
			display: none;
			text-align: left;
			background: white ;
			width: 100%;
		}
		.dropdown-content > a{
			color: black;
			font-weight: 500;
			padding: 10px;
			display: block;
		}	
		.dropdown-content > a:hover{
			color: var(--main-color);
		}
        .big-img {
    width: 400px; /* Adjust width as needed */
    height: 400px; /* Adjust height as needed */
    border-radius: 10px; /* Adjust border radius as needed */
    overflow: hidden; /* Ensure image does not overflow */
}

.big-img img {
    width: 100%; /* Ensure image fills the container */
    height: 100%; /* Ensure image fills the container */
    object-fit: cover; /* Cover the container with the image */
}
.cart-btn,
.buy-btn {
    background-color: black;
    color: white; /* Set text color to contrast with the black background */
    border: none; /* Remove border */
    padding: 10px 20px; /* Adjust padding as needed */
    border-radius: 5px; /* Add border radius for rounded corners */
    cursor: pointer;
}

.cart-btn:hover,
.buy-btn:hover {
    /* Optional: Hover effect */
    background-color: darkgray; /* Change the background color on hover */
}


		
	</style>
</head>
<body>
    <!----header--->
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

    <!-- Cart Icon -->
    <div class="header-icons">
        <a href="dashboard.php"><i class='bx bx-shopping-bag' style='color:black;'></i></a>
    </div>

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


    <div class="flex-box">
        <div class="left">
            <div class="big-img">
                <img src="../../images/product/<?php echo $row['avatar'] ?>">
            </div>
        </div>
        <form action="../includes/addtocart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $_GET['id']?>">
            <input type="hidden" name="user_id" value="<?= $user['id']?>">
            <input type="hidden" name="amount" value="<?= $row['price']?>">
            <div class="right">
                <div class="pname"><?php echo $row['name'] ?></div>
                <div class="description"><?php echo $row['description'] ?></div>
                
                <div class="price">Nrs. <span id="price"><?php echo $row['price'] ?></span></div>
                
                <div class="quantity">
                    <p>Quantity :</p>
                    <input type="number" name="quantity" min="1" max="5" value="1" onchange="priceUpdate(this)">
                </div>
                <div class="btn-box">
                    <button class="cart-btn">Add to Cart</button>
                    <button class="buy-btn">Buy Now</button>
                </div>
            </div>
        </form>
    </div>


    <script>
        let bigImg = document.querySelector('.big-img img');
        function showImg(pic){
            bigImg.src = pic;
        }
        function priceUpdate(elem){
            let price = <?php echo $row['price'] ?>;
            console.log(elem.value);
            console.log(price);
            amount = price * elem.value;
            document.querySelector("#price").textContent = amount; 
            document.querySelector("input[name=amount]").value = amount; 
        }
    </script>
</body>
</html>