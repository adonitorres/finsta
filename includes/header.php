<?php
//check login keys
$logged_in_user = check_login(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finsta - Image Sharing</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="css/style.css">	
</head>
<body>
	<div class="site">
		<header class="header">
			<h1><a href="index.php">Finsta</a></h1>

			<nav class="main-navigation">
				<form class="searchform" method="get" action="search.php">
					<label class="screen-reader-text">Search</label>
					<input type="search" name="phrase">
					<input type="submit" value="Search">
				</form>

				<ul class="menu">
					<?php if($logged_in_user){
					?>
					<li class="user">
						<a href="profile.php">
							<?php show_profile_pic( $logged_in_user['profile_pic'], $logged_in_user['username'], 30 ); ?>
							<?php echo $logged_in_user['username']; ?>
						</a>
					</li>
					<li><a href="">New Post</a></li>
					<li><a href="login.php?action=logout">Log Out</a></li>

					<?php }else{ ?>

					<li><a href="register.php">Sign Up</a></li>
					<li><a href="login.php">Login In</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>	