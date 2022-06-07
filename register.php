<?php 
require('config.php'); 
require_once('includes/functions.php');

//doctype and visible header
require('includes/header.php');
?>
<main class="container">
	<h1>Create an Account</h1>

	<form method="post" action="register.php">
		<label>Username:</label>
		<input type="text" name="username">

		<label>Email Address:</label>
		<input type="email" name="email">

		<label>Password:</label>
		<input type="password" name="password">

		<label>
			<input type="checkbox" name="policy" value="1">
			I agree to the <a href="#" target="_blank">terms of use and privacy policy</a>
		</label>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="1">
	</form>
</main>

<?php include('includes/footer.php'); ?>