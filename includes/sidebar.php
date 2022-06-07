<aside class="sidebar">

	<?php 
	$result = $DB->prepare('SELECT profile_pic, username 
		FROM users
		ORDER BY join_date DESC
		LIMIT 5');
	$result->execute();
	if( $result->rowCount() ){ ?>
		<section class="users">
			<h2>Newest Users</h2>
			<ul>
				<?php while($row = $result->fetch()){ 
					extract( $row ); ?>
					<li class="user">
						<img src="<?php echo $profile_pic ?>" alt="<?php echo $username ?>" width="50" height="50">
					</li>
				<?php } //end while ?>
			</ul>
		</section>
	<?php } //end if users ?>


	<?php 
	$result = $DB->prepare('SELECT categories.*, COUNT(*) AS total
							FROM posts, categories
							WHERE posts.category_id = categories.category_id
							GROUP BY posts.category_id
							ORDER BY RAND()');
	$result->execute();
	if( $result->rowCount() ){ ?>
		<section class="categories">
			<h2>Categories</h2>
			<ul>
				<?php 
				while( $row = $result->fetch() ){
					extract($row);
					echo "<li>$name ($total)</li>";
				 } 
				?>
			</ul>
		</section>
	<?php } ?>

		<?php 
	$result = $DB->prepare('SELECT * 
							FROM tags
							ORDER BY RAND()
							LIMIT 20');
	$result->execute();
	if( $result->rowCount() ){ ?>
		<section class="tags">
			<h2>Tags</h2>
			<ul>
				<?php 
				while( $row = $result->fetch() ){
					extract($row);
					echo "<li>$name</li>";
				 } 
				?>
			</ul>
	
		</section>
	<?php } ?>	

</aside>