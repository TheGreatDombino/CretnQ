<?php
// Check if button has been submitted
if (isset($_POST["reset_request_submit"])) {
  // Create tokens -- authenticate user and look inside DB to prevent timing attacks.
  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);
  // Link to be sent to user by email
  $url = "cretnq.com/create-pw-reset.php?selector=" . $selector . "&validator=" . bin2hex($token);
  // Want our token to expire after 30 minutes. Seconds since 1970.
  $expires = date("U") + 1800;
  // Connect to DB
  require 'db-connect.php';
  // Create variable for email
  $userEmail = $_POST["email"];
  // Delete any existing tokens from same user in DB
  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
  $stmt = mysqli_stmt_init($con);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }
  // Insert token inside of DB
  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($con);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }

  mysqli_stmt_close($stmt);
  // Confirmation Alert
  echo '<script type="text/javascript">';
  echo 'alert("Password reset email sent!");';
  echo 'window.location.href = "../../login.html";';
  echo '</script>';

} else {
  header("Location: ../../login.html");
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

$mail->addAddress($_POST['email']);
$mail->addBCC('email@gmail.com');
$mail->isHTML(true);
$mail->AddEmbeddedImage('../../images/cretanq.png', 'logo_cretn');

$mail->Subject = "CretnQ -- Reset Password -- Instructions!";
$mail->Body =
"<div style=\"margin-left: 7.5%; border: solid 6px black; padding: 3% 5% 3% 5%; font-family: Courier New; font-size: 1.1em; font-weight: bold; width: 550px; background-color: white; color: black\">
  <div style=\"padding-left: 60%\">
    <img src='cid:logo_cretn' width=180px height=75px>
  </div>
  <h2><u>Please click the link below to reset password!</u></h2>
  <br>
  <a href = $url> $url </a>
  <br>
</div>";

$mail->send();
$con->close();
