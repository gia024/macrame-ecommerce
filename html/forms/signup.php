<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
	<link href="../../login.css" rel="stylesheet">
</head>
<body>
	<div class="contact-form">
		<h2>Registration Form</h2>
		<form action="../includes/signup.php" method="post">
			<p>Username</p><input  type="text" name="username">
			<p>Email</p><input  type="email" name="email">
			<p>Contact</p><input  type="number" name="contact">
			<p>Address</p><input  type="text" name="address">
			<p>Password</p><input  type="password" name="password">
			<p>Re-password</p><input  type="password">
            <input type="submit" value="Sign up" name="submit">
			<p>Already have an account? <a href="login.php" style="color:rgb(0, 0, 0)">Login Here</a>.</p>
            <p><a href="../../index.php" style="color:rgb(0, 0, 0)">Go Back</a></p>
             

		</form>
	</div>

	
</body>
</html>


