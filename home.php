<?php
// Always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlexQ</title>
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  </head>
  <body>

<!-- NavBar -->
<div id = "nav_length">
    <nav>
			<img class="cretn_logo"src="images/cretanq.png" alt="Cretan Logo">
      <div class="links">
        <ul>
          <li><a id="home" href="home.php">Home -- Request</a></li>
          <li><a href="donate.php">Donate!</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="logout">
        <a href="logout.php">Logout</a>
      </div>
    </nav>
	</div>

<!-- Announcement Section -->
    <div class="container">
      <h1><?=$_SESSION['name']?> -- Welcome to CretnQ!</h1>
      <ul>
        <li>New users - Remember to never give out your credentials to CretnVision!</li>
        <li>Request Movies and TV Shows Below!</li>
        <li>Remember to visit our Donatations page!</li>
				<li>Start viewing media! Launch -->  <a href="https://www.plex.tv" target ="_blank">Plex Media Server!</a></li>
      </ul>
      <label id="disk_space"><b>Disk Space:</b></label></br>
      <progress value="1077.89" max="7028"></progress></br>
      <span id="total_memory">1.08 TB (15.3%) Used / 7.02 TB Total</span>
    </div>

<!-- Flex Box Request -->
    <div class="flex_container">

   <!-- Movie Form -->
      <div class="container" id="movie_flex">
        <h2 id="heading">Movies - Request</h2>
        <form action="scripts/php/movie-request.inc.php" method="post">

          <label for="title"><b>Title</b></label>
          <input type="text" name="title" placeholder="Type title here..">

          <label for="imdb"><b>IMDB Link</b></label>
          <input type="text" name="imdb" placeholder="Paste imdb link here..">

          <label for="summary"><b>Comments</b></label>
          <textarea name="summary" placeholder="If Applicable..." style="height:100px"></textarea>

          <button type="submit">Request!</button>
        </form>
      </div>

    <!-- TV Form -->
      <div class="container" id="tv_flex">
        <h2 id="heading">TV Shows - Request</h2>
        <form action="scripts/php/tv-request.inc.php" method="post">

          <label for="title"><b>Title</b></label>
          <input type="text" id="title" name="title" placeholder="Type title here..">

          <label for="imdb"><b>IMDB Link</b></label>
          <input type="text" id="imdb" name="imdb" placeholder="Paste imdb link here..">


          <label for="summary"><b>Comments</b></label>
          <textarea id="summary" name="summary" placeholder="If Applicable.." style="height:100px"></textarea>

          <button type="submit">Request!</button>
        </form>
      </div>
    </div>
  </body>
</html>
