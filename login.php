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
		<?php display_message(); ?>
		<?php validate_user_login(); ?>
	</div>
</div>

<div class="row">
	<div class="panel panel-defatult col-md-6 col-md-offset-3">
		<div class="logForm">
			<form action="" method="POST" role='form' id="register-form">
				<div class="form-group">
					<input type="text" name="email" id="email" class="form-control" tabindex="1" placeholder="Email Address" required="true">
				</div>
				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control" tabindex="1" placeholder="Password" required="true">
				</div>
				<div class="checkbox">
				         <label>
				         	<input type="checkbox" name="remember" id="remember-me" value="remember-me"> Remember me
				         </label>
				</div>
				<div class="form-group">
					<input type="submit" value="Log In" name="login" class="btn btn-lg btn-primary center">
				</div>
				<a href="recover.php">Forgot password?</a>
			</form>
		</div>
	</div>
</div>
	
<?php include 'includes/footer.php' ?>