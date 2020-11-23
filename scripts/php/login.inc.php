<?php
session_start();
// Connect
include 'db-connect.php';

if (isset($_POST["login_submit"])) {
	// Check if the data from the login form was submitted
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
	}
	// Prepare the SQL statement to prevent SQL injection.
	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
		// Bind parameters, in our case the username is a string so we use "s"
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database
		$stmt->store_result();

  	if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password);
			$stmt->fetch();
			// Account exists, now we verify the password.
			if (password_verify($_POST['password'], $password)) {
				// Verification success! User has loggedin!
				// Create sessions so we know the user is logged in, act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				header('Location: ../../home.php');
			} else {
				// Incorrect password
				echo '<script type="text/javascript">';
				echo 'alert("Incorrect Password. Please Re-Enter Credentials.");';
				echo 'window.location.href = "../../login.html";';
				echo '</script>';
			}
		} else {
			// Incorrect username
			echo '<script type="text/javascript">';
			echo 'alert("Incorrect Username. Please Re-Enter Credentials.");';
			echo 'window.location.href = "../../login.html";';
			echo '</script>';
		}
		$stmt->close();
	}
}
