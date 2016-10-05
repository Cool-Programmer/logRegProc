<?php 
	session_start();
	session_destroy();

	if (isset($_COOKIE['email'])) {
		unset($_COOKIE['email']);
		setcookie('email', $email, time()-86400);
	}
	header('location:login.php');
?>