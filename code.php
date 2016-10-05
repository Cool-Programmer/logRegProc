<?php include 'includes/header.php'; ?>

<section class="recover">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
		<?php validate_code(); ?>
		<?php display_message(); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well bordered">
				<h3 class="text-center bold">Enter Code</h3>
				<form action="" method="POST">
					<div class="form-group">
						<input type="text" placeholder="#########" name="code" class="form-control">
					</div>
					<div class="row">
					<div class="col-lg-3 col-lg-offset-3">
						<input type="submit" value="Cancel" name="cancel" class="btn btn-danger danger">
					</div>
					<div class="col-lg-3 col-lg-offset-3">
						<input type="submit" value="Continue" name="continue" class="btn btn-success pull-left">
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php include 'includes/footer.php' ?>