<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>


<div class="row">
	<div class="panel panel-defatult  col-md-6 col-md-offset-3">
		<div>
			<a href="login.php" class="pull-left activePage2">Login</a>
			<a href="register.php" class="pull-right activePage">Register</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<?php validate_user_registration(); ?>
		<?php display_message(); ?>
	</div>
</div>

<div class="row">
	<div class="panel panel-defatult col-md-6 col-md-offset-3">
		<div class="regForm">
			<form action="" method="POST" role='form' id="register-form">
				<div class="form-group">
					<input type="text" name="firstname" id="firstname" class="form-control" tabindex="1" placeholder="First name" required="true">
				</div>
				<div class="form-group">
					<input type="text" name="lastname" id="lastname" class="form-control" tabindex="1" placeholder="Last name" required="true">
				</div>
				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control" tabindex="1" placeholder="Username" required="true">
				</div>
				<div class="form-group">
					<input type="text" name="email" id="email" class="form-control" tabindex="1" placeholder="Email Address" required="true">
				</div>
				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control" tabindex="1" placeholder="Password" required="true">
				</div>
				<div class="form-group">
					<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" tabindex="1" placeholder="Confirm Password" required="true">
				</div>
				<div class="form-group">
					<input type="submit" value="Sign Up Now" name="submit" class="btn btn-lg btn-success center">
				</div>
			</form>
		</div>
	</div>
</div>
	
<?php include 'includes/footer.php' ?>