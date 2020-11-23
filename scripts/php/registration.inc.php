<?php
session_start();
// Connect
require 'db-connect.php';

if (isset($_POST["register_submit"])) {

	$password = $_POST["pwd"];
	$passwordRepeat = $_POST["pwd-repeat"];
	// Check if email is valid
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo '<script type="text/javascript">';
		echo 'alert("Email is not Valid! Redirecting to login.");';
		echo 'window.location.href = "../../login.html";';
		echo '</script>';
		exit();
	}
	// Check username is made with valid characters
	if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
		echo '<script type="text/javascript">';
		echo 'alert("Username is not Valid! Redirecting to login.");';
		echo 'window.location.href = "../../login.html";';
		echo '</script>';
		exit();
	}
	// Check length of password within threshold
	if (strlen($_POST['pwd']) > 20 || strlen($_POST['pwd']) < 5) {
		echo '<script type="text/javascript">';
		echo 'alert("Password Must be between 5 and 20 Characters Long!\n\nRedirecting to login.");';
		echo 'window.location.href = "../../login.html";';
		echo '</script>';
		exit();
	}
	// Check to see if passwords match
	if(empty($password) || empty($passwordRepeat)) {
		echo '<script type="text/javascript">';
		echo 'alert("Password Field Empty. Redirecting to login.");';
		echo 'window.location.href = "../../login.html";';
		echo '</script>';
		exit();
	} elseif ($password != $passwordRepeat) {
		echo '<script type="text/javascript">';
		echo 'alert("Passwords do not match. Redirecting to login.");';
		echo 'window.location.href = "../../login.html";';
		echo '</script>';
		exit();
	}

	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the account exists in the database.
		if ($stmt->num_rows > 0) {
			// Username already exists
			echo '<script type="text/javascript">';
			echo 'alert("Username Exists, Please Choose Another!\n\nRedirecting to login.");';
			echo 'window.location.href = "../../login.html";';
			echo '</script>';
		} else {
			// Username doesn't exist, insert new account
			if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
				// Hash the password and use password_verify when a user logs in.
				$passwordHash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
				$stmt->bind_param('sss', $_POST['username'], $passwordHash, $_POST['email']);
				$stmt->execute();
				// alert box after new account is inserted.
				echo '<script type="text/javascript">';
				echo 'alert("\\t\\t\\t\\tCONGRATULATIONS!!!\\n\\n  \\u2022  You have Successfully Registered to CretanQ.\\n  \\u2022  An email has been sent with additional registration info. \\n\\n\\t\\t\\t\\t...Redirecting to login.");';
				echo 'window.location.href = "../../login.html";';
				echo '</script>';
			} else {
				// Something is wrong with the sql statement
				echo 'Could not prepare statement!';
			}
		}
		$stmt->close();
	} else {
		// Something is wrong with the sql statement
		echo 'Could not prepare statement!';
	}
}

// Automated Email Response
$name = $_POST['username'];
$first = $_POST['first'];
$last = $_POST['last'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../../vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->SMTPDebug = 3;
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username='email@gmail.com';
$mail->Password='password!';
$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->From = "email@gmail.com";
$mail->FromName = "Cretn Admin";

$mail->addAddress($_POST['email']);
$mail->addBCC('email@gmail.com');

$mail->isHTML(true);
$mail->AddEmbeddedImage('../../images/cretanq.png', 'logo_cretn');

$mail->Subject = "$name's Registration to CretnQ has been Confirmed!";
$mail->Body =
"<div style=\"margin-left: 7.5%; border: solid 6px black; padding: 3% 5% 3% 5%; font-family: Courier New; font-size: 1.1em; font-weight: bold; width: 550px; background-color: white; color: black\">

	<div style=\"padding-left: 60%\">
		<img src='cid:logo_cretn' width=180px height=75px>
	</div>

	<h2><u>$first $last! Welcome to the CretnQ Community!</u></h2>

	<ul>
		<li>CretnQ is a website meant for users of CretnVision to queue requests for Movies or TV be uploaded to CretnVision(Plex).</li>
		<br>
		<li>An invitation to the CretnVision server, via the Plex platform, will be sent to this email pending a successful review. </li>
		<br>
		<li>Don't forget to check out our <u>Donate!</u> page to contribute to the expansion of CretnVision!</li>
		<br>
		<li>Below is a direct link to the login page.</li>
	</ul>
	<br>
	<span>Take me to CretnQ! -></span>
	<a href=\"cretnq.com\">www.cretnq.com!</a>
</div>";

$mail->send();
$con->close();
