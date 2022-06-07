<section class="comment-form">
	<h2>Leave a Comment</h2>

	<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

	<form action="single.php?<?php echo $_SERVER['QUERY_STRING'] ?>" method="post">
		<label>Your Comment</label>
		<textarea name="body"></textarea>

		<input type="submit" value="Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</section>