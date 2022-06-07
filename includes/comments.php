<section class="comments">
	<h2>
		<?php 
		$total = count_comments( $post_id );
		echo $total == 1 ? 'One Comment' : "$total Comments" ; ?> 
		on this post
	</h2>

	<?php //if there's comments, go get them 
	if( $total >= 1 ){
		//get all the approved comments on this post, oldest first
		$result = $DB->prepare('SELECT comments.body, comments.date, users.username, 
								users.profile_pic, users.user_id
								FROM comments, users
								WHERE comments.user_id = users.user_id
								AND comments.is_approved = 1
								AND comments.post_id = ?
								LIMIT 50');
		$result->execute( array($post_id) );
		if( $result->rowCount() ){
			while( $row = $result->fetch() ){
				extract($row);
	?>
	<div class="one-comment">
		<div class="user">
			<img src="<?php echo $profile_pic; ?>" alt="<?php echo $username; ?>" width="50" height="50">
			<?php echo $username; ?>
		</div>

		<p><?php echo $body; ?></p>

		<span class="date"><?php echo time_ago($date); ?></span>
	</div><!-- one-comment -->
	<?php 
			} //end while
		} //end if query worked
	} //end if comments ?>

</section>