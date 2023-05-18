<?php
require_once('UserDAO.php');
require_once('User.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from login form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Create a new UserDAO and get the user by email
    $dao = new UserDAO();
    $user = $dao->getUserByEmail($email);
    
    // Check if user was found
    if ($user != null) {
        //Check password
        $pass = password_hash($password, PASSWORD_DEFAULT);
        if (password_verify($password, $user->getPassword())) {
            // Save user data to session
            $_SESSION["user"] = $user;
            if($user->getUserType() == "user"){
                echo"logged in as user";
                header("Location: dashboard.php");
            }else{
                echo"logged in as admin";
                header("Location: adminDashboard.php");
            }
            exit();
        } else {
            // Display error message
            $error = "Invalid email or password";
        } 
    } else {
        // Display error message
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style>
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		h1 {
			text-align: center;
			margin-top: 50px;
		}
		form {
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			margin: 50px auto;
			max-width: 400px;
			padding: 20px;
		}
		label {
			display: block;
			font-weight: bold;
			margin-bottom: 10px;
		}
        input[type="email"],
		input[type="text"],
		input[type="password"] {
			border: 1px solid #ccc;
			border-radius: 3px;
			font-size: 16px;
			padding: 10px;
			width: 94%;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			border: none;
			border-radius: 3px;
			color: #fff;
			cursor: pointer;
			font-size: 16px;
			margin-top: 20px;
			padding: 10px;
			width: 100%;
		}
		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
        .error-container {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border: 1px solid #f5c6cb;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .error-message {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }
	</style>
</head>
<body>
	<h1>Login</h1>
	<form method="post" action="login.php">
		<label for="username">Email:</label>
		<input type="email" id="email" name="email" required>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>
		<input type="submit" value="Login">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
	</form>
    <?php if (isset($error)) { ?>
        <div class = "error-container">
            <p class="error-message"><?php echo $error; ?></p>
        </div>
      
    <?php } ?>
</body>
</html>
