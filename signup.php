<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}
		h1 {
			text-align: center;
		}
		form {
			background-color: #ffffff;
			border: 1px solid #cccccc;
			border-radius: 5px;
			margin: 0 auto;
			padding: 20px;
			width: 400px;
		}
		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
		}
		input[type="text"], input[type="email"], input[type="password"] {
			display: block;
			margin-bottom: 20px;
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #cccccc;
			box-sizing: border-box;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
			margin-bottom: 10px;
		}
		input[type="submit"]:hover {
			background-color: #45a049;
		}
		.error {
			color: red;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<h1>Sign Up</h1>
	<form method="post">
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" required>
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" required>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required>
		<input type="submit" name="submit" value="Sign Up">
        <p>Already have an account? <a href="login.php">login here</a></p>
	</form>

	<?php
    require_once('UserDAO.php');
    require_once('User.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
        $dao = new UserDAO();
		if($dao->createUser($name, $email, $password, "user")){
            echo '<div class="success">Sign up successful!</div>';
        }else{
            echo '<div class="success">Sign up failed!</div>';
        }
	}
	?>
</body>
</html>
