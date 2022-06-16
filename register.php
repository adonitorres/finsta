<?php 
require('config.php'); 
require_once('includes/functions.php');
require('includes/parse-register.php');
//doctype and visible header
require('includes/header.php');
?>
<main class="container">
	<h1>Create an Account</h1>

	<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

	<form method="post" action="register.php">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $username ?>" class="<?php field_error( 'username', $errors ); ?>">

		<label>Email Address:</label>
		<input type="email" name="email" value="<?php echo $email ?>" class="<?php field_error( 'email', $errors ); ?>">

		<label>Password:</label>
		<input type="password" name="password" value="<?php echo $password ?>" class="<?php field_error( 'password', $errors ); ?>">

		<label class="<?php field_error( 'policy', $errors ); ?>">
			<input type="checkbox" name="policy" value="1" <?php checked( $policy, 1 ); ?>>
			I agree to the <a href="#" target="_blank">terms of use and privacy policy</a>
		</label>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="1">
	</form>
</main>

<?php include('includes/footer.php'); ?>