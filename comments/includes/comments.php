	<?php //get all the approved comments about this post, oldest first 
		$result = $DB->prepare('SELECT comments.body, comments.date, users.username, users.profile_pic
								FROM comments, users
								WHERE users.user_id = comments.user_id
								AND comments.is_approved = 1
								AND comments.post_id = ?
								ORDER BY comments.date ASC
								LIMIT 50');
		$result->execute( array( $post_id ) );
		$total = $result->rowCount();
		if( $total >= 1 ){
		?>
		<div class="comments">
			<h2><?php echo $total == 1 ? 'One Comment' : "$total Comments"; ?></h2>

			<?php while( $row = $result->fetch() ){ ?>
			<div class="one-comment">
				<div class="user">
					<?php show_profile_pic( $row['profile_pic'] ) ?>
					<?php echo $row['username']; ?>
				</div>

				<p><?php echo $row['body']; ?></p>
				<span class="date"><?php echo time_ago( $row['date'] ); ?></span>
			</div>
			<?php } //end while comments ?>
		</div>
		<?php } //end if comments found ?>	