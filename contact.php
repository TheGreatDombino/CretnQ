<?php
// Always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
  </head>
  <body>

<!-- NavBar -->
    <nav>
			<img class="cretn_logo"src="images/cretanq.png" alt="Cretan Logo">

      <div class="links">
        <ul>
          <li><a href="home.php">Home -- Request</a></li>
          <li><a href="donate.php">Donate!</a></li>
          <li><a id="contact" href="contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="logout">
        <a href="logout.php">Logout</a>
      </div>
    </nav>

<!-- Contact Us Container -->
    <div class="container" id="contact_container">
      <form action="scripts/php/contact.inc.php">

        <label for="subject"><b>Subject</b></label>
        <input type="text" name="subject" placeholder="Subject Line..">

        <label for="summary"><b>Summary</b></label>
        <textarea name="summary" placeholder="Write something.." style="height:200px"></textarea>

        <button type="submit" value="submit">Submit!</button>

      </form>
    </div>
  </body>
</html>
