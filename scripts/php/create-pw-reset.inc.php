<?php

// Check if button has been submitted
if (isset($_POST["reset_password_submit"])) {

  $selector = $_POST["selector"];
  $validator = $_POST["validator"];
  $password = $_POST["pwd"];
  $passwordRepeat = $_POST["pwd-repeat"];
    // Password field is filled and matched
    if(empty($password) || empty($passwordRepeat)) {
      header("Location: ../../create-pw-reset.php?newpwd=empty");
      exit();
    } elseif ($password != $passwordRepeat) {
      header("Location: ../../create-pw-reset.php?newpwd=pwdnotsame");
      exit();
    }
    // Date in seconds since 1970 to check if token has been expired or not.
    $currentDate = date("U");
    // Connect DB.
    require 'db-connect.php';
    // Query to selecting specific token from DB.
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "There was an error!";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
      mysqli_stmt_execute($stmt);
      // Grab result
      $result = mysqli_stmt_get_result($stmt);
      if (!$row = mysqli_fetch_assoc($result)) {
        echo '<script type="text/javascript">';
        echo 'alert("You need to re-submit your reset request.");';
        echo 'window.location.href = "../../request-pw-reset.php";';
        echo '</script>';
        exit();
      } else {
        // Match token inside DB with token sent from the form.
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

        if ($tokenCheck === false) {
          echo '<script type="text/javascript">';
          echo 'alert("You need to re-submit your reset request.");';
          echo 'window.location.href = "../../request-pw-reset.php";';
          echo '</script>';
          exit();
        } elseif ($tokenCheck === true) {
          // Pinpoint the user for password update
          $tokenEmail = $row['pwdResetEmail'];
          $sql = "SELECT * FROM accounts WHERE email=?;";
          $stmt = mysqli_stmt_init($con);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error.";
            exit();
          } else {
            // Update user information inside account table
            $sql = "UPDATE accounts SET password=? WHERE email=?";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error!";
              exit();
          } else {
            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
            mysqli_stmt_execute($stmt);
            // Delete pwdResetEmail which is currently placeholder
            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error!";
              exit();
            } else {
              mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
              mysqli_stmt_execute($stmt);
              echo '<script type="text/javascript">';
              echo 'alert("Password Updated!");';
              echo 'window.location.href = "../../login.html";';
              echo '</script>';
              }
            }
          }
        }
      }
    }
  }
} else {
  header("Location: ../../login.html");
}
