<?php
session_start();
// Connect
include 'db-connect.php';

// Alert Box Confirmation
echo '<script type="text/javascript">';
echo 'alert("Thank you for your Submission!.\\n\\n  \\u2022  E-mail confirmation has been sent.\\n\\n  \\u2022  Please allow up to 24 hours for queue.");';
echo 'window.location.href = "../../home.php";';
echo '</script>';

// Automated Email Response
$name = $_SESSION['name'];
$title = $_POST['title'];
$imdb = $_POST['imdb'];
$summary = $_POST['summary'];
// SQL Query to pull email and set as variable
$sqli= "SELECT email FROM accounts WHERE username = '".$_SESSION[name]."'";
if ($result = $con->query($sqli)) {
  while ($row = $result->fetch_object()) {
    $email = $row->email;
  }
  $result->close();
}

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

$mail->addAddress($email);
$mail->addBCC('email@gmail.com');

$mail->isHTML(true);
$mail->AddEmbeddedImage('../../images/cretanq.png', 'logo_cretn');

$mail->Subject = "$name, Your TV Request for $title has been Queued!";
$mail->Body =
"<div style=\"margin-left: 7.5%; border: solid 6px black; padding: 3% 5% 3% 5%; font-family: Courier New; font-size: 1.1em; font-weight: bold; width: 550px; background-color: white; color: black\">

  <div style=\"padding-left: 60%\">
		<img src='cid:logo_cretn' width=180px height=75px>
	</div>

	<h2><u>Thank You for your TV Submission!</u></h2>
	<ul>
	 <li><u>Title</u>: $title</li>
   <li><u>IMDB Link</u>: $imdb</li>
   <li><u>Comments</u>: $summary</li>
  </ul>
  <br>
	<span>Please allow up to 24 hours for upload. </span>
	<br><br>
	<span>If you do not see your submission uploaded. Please Contact Us! </span>
	<br><br>
	<span>Don't forget to check out our <u>Donate!</u> page to contribute to the expansion of CretnVision!</span>
  <br>
</div>";

$mail->send();
$con->close();
