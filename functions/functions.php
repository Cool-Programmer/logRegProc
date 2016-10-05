<?php 
// error_reporting(0);
	// ****************************HELPERS***************************************//
	function clean($string){
		return htmlentities($string);
	}

	function redirect($location){
		return header('Location: {$location}');
	}

	function set_message($message){
		if (!empty($message)) {
			$_SESSION['message'] = $message;
		}else {
			$message='';
		}
	}

	function display_message(){
		if (isset($_SESSION['message'])) {
			echo $_SESSION['message'];
			unset ($_SESSION['message']);
		}
	}

	function display_validation_errors($error_message){
		$error_message= <<<DELIMITER
			<div class="alert alert-danger alert-dismissible" role="alert"> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				$error_message
			</div>	
DELIMITER;
		return  $error_message;
	}

	function email_exists($email){
		$sql = "SELECT `id` FROM `users` WHERE `email` = '$email' ";
		$result = query($sql);
		if(row_count($result)==1){
			return true;
		}else {
			return false;
		}
	}

	function username_exists($username){
		$sql = "SELECT `id` FROM `users` WHERE `username` = '$username' ";
		$result = query($sql);
		if (row_count($result)==1) {
			return true;
		}else {
			return false;
		}
	}

	function token_gnenerator(){
		$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
		return $token;
	}

	function send_email($email, $subject, $msg, $headers){
		return mail($email, $subject, $msg, $headers);			
	}

	// ****************************HELPERS***************************************//

	function validate_user_registration(){
		$min = 3;
		$max = 20;
		$errors = [];
		if ($_SERVER["REQUEST_METHOD"]=="POST") {
			$firstname = clean($_POST['firstname']);
			$lastname = clean($_POST['lastname']);
			$username = clean($_POST['username']);
			$email = clean($_POST['email']);
			$password = clean($_POST['password']);
			$confirmPassword = clean($_POST['confirmPassword']);

			if (strlen($firstname)<$min) {
				$errors[] = "Your firstname cannot be less than {$min} characters. <br>";
			}

			if (strlen($lastname)<$min) {
				$errors[] = "Your lastname cannot be less than {$min} characters. <br> ";
			}

			if (strlen($username)<$min) {
				$errors[] = "Your username cannot be less than {$min} characters. <br>";
			}

			if (strlen($firstname)>$max) {
				$errors[] = "Your firstname cannot be more than {$max} characters. <br>";
			}

			if (strlen($lastname)>$max) {
				$errors[] = "Your lastname cannot be more than {$max} characters. <br>";
			}

			if (strlen($username)>$max) {
				$errors[] = "Your firstname cannot be more than {$max} characters. <br>";
			}

			if (strlen($email)>50) {
				$errors[] = "Your email cannot be more than 50 characters. <br>";
			}

			if ($password !== $confirmPassword) {
				$errors[] = "Passwords do not match. <br>";
			}

			if (email_exists($email)) {
				$errors[] = "The email you entered is already registered in our database. <br>";
			}

			if (username_exists($username)) {
				$errors[] = "The username you entered is already taken. <br>";
			}


			if (!empty($errors)) {
				foreach ($errors as $error) {
				 	echo display_validation_errors($error);
				}
			}else {
				if (register_user($firstname, $lastname, $username, $email, $password)) {
					set_message("<div class='alert alert-success text-center'> Please check your email inbox or spam folders for activation link.</div>");
					header('location: index.php');
				}else {
					set_message("<div class='alert alert-danger text-center'>Registration failed. Please try again later. Our professionals currently working on that issue.<div>");
					header('location: index.php');
				}
			}
		}
	}

	function register_user($firstname, $lastname, $username, $email, $password){
		$firstname = escape($firstname);
		$lastname = escape($lastname);
		$username = escape($username);
		$email = escape($email);
		$password = escape($password);

		if(username_exists($username)){
			return false;
		}elseif (email_exists($email)) {
			return false;
		}else {
			$password = md5($password);
			$validation_code = md5($username . microtime());
			$sql = "INSERT INTO users (firstname, lastname, username, email, password, validation_code, active) VALUES ('$firstname', '$lastname', '$username', '$email', '$password', '$validation_code', 0) ";
			$result = query($sql);
			confirm($result);

			$subject = "Activate account";
			$msg = "Please click the link below to activate your account.
				http://localhost/login_advanced/activate.php?email=$email&code=$validation_code
			";
			$headers = "From: noreply@somewebsite.kkk";
			send_email($email, $subject, $msg, $headers);
			return true;
		}
	}


	function activate_user(){
		if ($_SERVER['REQUEST_METHOD']=='GET') {
			if (isset($_GET['email'])) {
				echo $email = clean($_GET['email']);
				echo $validation_code = clean($_GET['code']);
				$sql = "SELECT `id` FROM `users` WHERE `email` = '".escape($_GET['email'])."' AND `validation_code` = '". escape($_GET['code'])."' ";
				$result = query($sql);
				confirm($result);
				if (row_count($result)==1) {
					$sql2= "UPDATE `users` SET `active` = 1, `validation_code` = 0 WHERE `email` = '".escape($email)."' AND `validation_code` = '".escape($validation_code)."' ";
					$result2 = query($sql2);
					confirm($result2);
					set_message("<div class='alert alert-success text-center'>Your account has been activated. Please log in.<div>");
					header ('Location: login.php');
				}else{
					set_message("<div class='alert alert-danger text-center'>Something went wrong and your account could not activated.<div>");
				}
				
			}
		}
	}

	function validate_user_login(){
		$min = 3;
		$max = 20;
		$errors = [];
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			$email = clean($_POST['email']);
			$password = clean($_POST['password']);
			$remember = isset ($_POST['remember']);

			if (empty($email)) {
				$errors[]='Email field cannot be empty. <br>';
			}

			if (empty($password)) {
				$errors[]='password field cannot be empty. <br>';
			}

			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo display_validation_errors($error);
				}
			}else {
				if (login_user($email, $password, $remember)) {
					header('Location: admin.php');
				}else {
					echo display_validation_errors("Your credentials are not correct.");
				}
			}


		}
	}	

	function login_user($email, $password, $remember){
		$sql = "SELECT `password`, `id` FROM `users` WHERE `email` = '".escape($email)."' AND `active` = 1";
		$result = query($sql);
		if (row_count($result)==1) {

			$row = fetch_array($result);
			$password_db = $row['password'];

			if (md5($password) === $password_db) {
				if ($remember=='on') {
					setcookie('email', $email, time()+86400);
				}
				$_SESSION['email'] = $email;
				return true;
			}else {
				return false;
			}
			return true;
		}else {
			return false;
		}
	}

	function logged_in(){
		if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
			return true;
		}else {
			return false;
		}
	}

	function password_recover(){
		if ($_SERVER["REQUEST_METHOD"]=="POST") {
			if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
				$email = clean($_POST['email']);
				if (email_exists($email)) {
					$validation_code = md5($email + microtime());
					setcookie('temporary_access_code', $validation_code, time()+(60*60));
					$sql = "UPDATE `users` SET `validation_code` = '".escape($validation_code)."' WHERE `email` = '".$email."' ";
					$result = query($sql);
					confirm($result);
					$subject = "Password reset";
					$msg = "Please use this code to reset your password {$validation_code}.
					Click here to reset it: http://localhost/login_advanced/code.php?email=$email&code=$validation_code
					";
					$headers = "FROM: noreply@somewebsite.kkk";
					if (!send_email($email, $subject, $msg, $headers)) {
						echo display_validation_errors('An error occured in our side and email is not sent. Sorry.');
					}

						set_message("<div class = 'alert alert-success'>Please check your inbox or spam folder for the activation code.</div>");
						header('Location: index.php');
				}else {
					echo display_validation_errors('The email you entered does not exists.');
				}
			}else {
				header('Location: login.php');
			}
		}
	}

	function validate_code(){
		if (isset($_COOKIE['temporary_access_code'])) {
			if (!isset($_GET['code']) && !isset($_GET['email'])) {
				header('location: index.php');
			}else if(empty($_GET['code']) && empty($_GET['email'])){
				header('location: index.php');
			}else{
				if (isset($_POST['code'])) {
					$email = clean($_GET['email']);
					$validation_code = clean($_POST['code']);
					$sql = "SELECT `id` FROM `users` WHERE `validation_code` = '".escape($validation_code)."' AND `email` = '".escape($email)."' ";
					$result = query($sql);
					confirm($result);

					if (row_count($result)==1) {
						setcookie('temporary_access_code', $validation_code, time()+(60*60));
						header('location: reset.php?email='.$email.'&code='.$validation_code.' ');
					}else {
						echo display_validation_errors('Sorry, wrong validation code.');
					}
				}
			}
		}else {
			set_message("<div class = 'alert alert-danger'>Sorry, your validation code has expired. Please try again.</div>");
			header("Location: recover.php");
		}
	}

	function password_reset(){
		if (isset($_COOKIE['temporary_access_code'])) {
			if (isset($_GET['email']) && isset($_GET['code'])) {
				if (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {

					if ($_POST['password'] === $_POST['confirm_password']) {
						$updated_password = md5($_POST['password']);
						$sql = "UPDATE `users` SET `password` = '".escape($updated_password)."', `validation_code` = 0 WHERE `email` = '".escape($_GET['email'])."' ";
						$result = query($sql);
						set_message("<div class = 'alert alert-success'>Your password has been updated. Please log in.</div>");
						header('location: login.php');
					}else {
						echo display_validation_errors("Passwords do not match.");
					}
				}
			}
		}else {
			set_message("<div class = 'alert alert-danger'>Sorry, your validation code has expired. Please try again.</div>");
			header("Location: recover.php");
		}
	}
?>	