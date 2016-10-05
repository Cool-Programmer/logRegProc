<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<?php password_recover(); ?>
		<?php display_message(); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="panel panel-defatult col-md-6 col-md-offset-3">
			<div class="recForm">
			<h2 class="page-header text-center">Recover Password</h2>
				<form action="" method="POST" role='form' id="register-form">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" id="email" class="form-control" tabindex="1" placeholder="Email Address" required="true">
					</div>
					<div class="form-group">
						<a name="cancel" class="btn btn-default" href="login.php">Cancel</a>
						<input type="submit" value="Send password reset link" name="recover" class="btn btn-success pull-right">
					</div>
						<input type="hidden" class="hide" name="token" id="token" value="<?php echo token_gnenerator(); ?>">
				</form>
			</div>
		</div>
	</div>
<?php include 'includes/footer.php' ?>