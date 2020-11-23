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
    <title>Donate!</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
  </head>
  <body>

<!-- Navbar -->
  <nav>
		<img class="cretn_logo"src="images/cretanq.png" alt="Cretan Logo">

    <div class="links">
     <ul>
       <li><a href="home.php">Home -- Request</a></li>
       <li><a id="donate" href="donate.php">Donate!</a></li>
       <li><a href="contact.php">Contact</a></li>
     </ul>
    </div>
    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
  </nav>

<!-- Donate Info -->
  <div class="container" id="donate_container">
    <h1>Donate to the Project!!</h1>
		<h2>Venmo: <u>@Domenic-Rocca</u></h2>
		<br>
      <ul>
				<li>Scan the QR Code below to Venmo your Donation! Much Appreciated!</li>
        <li>Help recoup server build costs!</li>
        <li>Grow library space -- More HDD = More Content!</li>
      </ul>
			<div class="qr_code">
				<p id="lifetime"><strong>Lifetime Donations:<span id="green">   $0</span></strong></p>
				<img id ="qr_image" src="images/qrcode.png" alt="Cretan Logo" width="200px" height="200px">
			</div>
			<br>
			<p id="disk_space"><strong><u>Current Goal</u>: Server Recoup!</strong></p>
      <progress value="0.00" max="1125"></progress></br>
      <span id="total_donate">Raised: $0 -- Goal: $225</span>
    </div>



<!-- Donate Status Containers -->
<!-- Start Comment Out
    <div class="flex_container">
      <div class="container" id="left_flex">
        <h4> Server Recoup <span id="green">   (CURRENT)</span></h4>
        <span>Funds Raised: $0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $225</span>
        <progress value="0" max="225"><p> 0% </p> </progress>
      </div>
      <div class="container" id="right_flex">
        <h4> HDD #1(8TB) Recoup ~ </h4>
        <span>Funds Raised: $0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</span>
        <progress value="0" max="150"><p> 0% </p> </progress>
      </div>
    </div>

    <div class="flex_container">
      <div class="container" id="left_flex">
        <h4> HDD #2(8TB) ~ </h4>
        <span for="file">Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</span>
        <progress value="0" max="150"><p> 0% </p> </progress>
      </div>
      <div class="container" id="right_flex">
        <h4> HDD #3(8TB) ~ </h4>
        <span>Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</span>
        <progress value="0" max="150"><p> 0% </p> </progress>
      </div>
    </div>


    <div class="flex_container">
      <div class="container" id="left_flex">
        <h4> HDD #4(8TB) ~ </h4>
        <label for="file">Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</label>
        <progress id="file" value="0" max="150"><p> 0% </p> </progress>
      </div>
      <div class="container" id="right_flex">
        <h4> HDD #5(8TB) ~ </h4>
        <label for="file">Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</label>
        <progress id="file" value="0" max="150"><p> 0% </p> </progress>
      </div>
    </div>

    <div class="flex_container">
      <div class="container" id="left_flex">
        <h4> HDD #6(8TB) ~ </h4>
        <label for="file">Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $150</label>
        <progress id="file" value="0" max="150"><p> 0% </p> </progress>
      </div>
      <div class="container" id="right_flex">
        <h4>  Extra Funds! ~</h4>
        <label for="file">Funds Raised: $0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goal: $1,000</label>
        <progress id="file" value="0" max="1000"><p> 0% </p> </progress>
      </div>
    </div>
		End comment out !-->
  </body>
</html>
