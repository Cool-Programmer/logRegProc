<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1><?php if (logged_in()) {
        		echo "You are logged in, congrats!";
        }else {
        	header('location: index.php');
        } ?>
        	
        </h1>
      </div>

      
<?php include 'includes/footer.php'; ?>