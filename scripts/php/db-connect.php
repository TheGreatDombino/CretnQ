<?php
session_start();
// Connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'cretnq64_rocca';
$DATABASE_PASS = 'Pasco987!';
$DATABASE_NAME = 'cretnq64_cretanqlogin';
// Connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
