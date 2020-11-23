<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
  </head>
  <body>

<!-- NavBar -->
    <nav>
      <img class="cretn_logo"src="images/cretanq.png" alt="Cretan Logo">

    </nav>

<!-- Enter new password Form -->
    <div class="container" id="login_container">
      <h1>Create New Password</h1>
      <ul>
        <li>Enter your new password below.</li>
      </ul>

      <?php
        // Check if Tokens are in URL
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];
        // Check if tokens exist; Have valid types
        if(empty($selector) || empty($validator)) {
          echo "Could not validate your request!";
        } else {
          if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
        ?>

        <form action="scripts/php/create-pw-reset.inc.php" method="post">
          <!-- Inputs are hidden and filled with value from URL !-->
          <input type="hidden" name="selector" value="<?php echo $selector ?>">
          <input type="hidden" name="validator" value="<?php echo $validator ?>">
          <input type="password" name="pwd" placeholder="Enter a new password...">
          <input type="password" name="pwd-repeat" placeholder="Repeat new password...">
          <button type="submit" name="reset_password_submit" value="submit">Reset!</button>
        </form>

        <?php
            }
          }
        ?>
    </div>
  </body>
</html>
