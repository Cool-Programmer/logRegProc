<?php include 'includes/header.php'; ?>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<?php password_reset(); ?>
		<?php display_message(); ?>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-defatult col-md-6 col-md-offset-3">
			<div class="recForm">
			<h2 class="page-header text-center">Reset Password</h2>
				<form action="" method="POST" role='form' id="register-form">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control" tabindex="1" placeholder="New Password" required="true">
					</div>
					<div class="form-group">
						<input type="password" name="confirm_password" id="confirm_password" class="form-control" tabindex="1" placeholder="Confirm Password" required="true">
					</div>
					<div class="form-group">
						<input type="submit" value="Reset password" name="reset" class="btn btn-success">
					</div>
					<input type="hidden" class="hide" name="token" id="token" value="<?php echo token_gnenerator(); ?>">
				</form>
			</div>
		</div>
	</div>
<?php include 'includes/footer.php' ?>