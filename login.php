<?php 
require('config.php'); 
require_once('includes/functions.php');

$logged_in_user = check_login();

require('includes/parse-logout.php');
require('includes/parse-login.php');
//doctype 
require('includes/header-no-nav.php'); 
?>
	<div class="container important-form">
		<h1>Log In</h1>

    <?php show_feedback( $feedback, $feedback_class, $errors); ?>

		<form method="post" action="login.php">
			<label>Username</label>
			<input type="text" name="username">

			<label>Password</label>
			<input type="password" name="password">

			<input type="submit" value="Log In" >

			<input type="hidden" name="did_login" value="true">
		</form>
	</div>
<?php include('includes/footer.php'); ?>