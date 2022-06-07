<div class="comment-form">
	<h2>Leave a comment</h2>

	<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

	<form method="post" action="single.php?post_id=<?php echo $post_id; ?>">
		<textarea name="body"></textarea>
		
		
		<input type="submit" value="Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</div>