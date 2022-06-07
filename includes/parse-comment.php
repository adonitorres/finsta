<?php 
//pre-define vars
$errors = array();
$body = '';

//Process the comment form if it was submitted
if( isset( $_POST['did_comment'] ) ){
	//sanitize everything
	$body = strip_tags($_POST['body'], ['b', 'i', 'strong', 'em']);
	//@TODO: replace this with the real logged in user
	$logged_in_user_id = 1;

	//validate - body cannot be blank
	$valid = true;
	if( $body == '' ){
		$valid = false;
		$errors['body'] = 'Comment body is required.';
	}
	//if valid, add the comment to the database
	if( $valid ){
		$result = $DB->prepare('INSERT INTO comments
								( user_id, body, post_id, date, is_approved )
								VALUES
								( :user_id, :body, :post_id, NOW(), 1 )');
		$result->execute(array(
							'user_id' 	=> $logged_in_user_id,
							'body'		=> $body,
							'post_id' 	=> $post_id,
						));
		//if it worked, show success message
		if( $result->rowCount() ){
			$feedback = 'Thank you for your comment!';
			$feedback_class = 'success';
		}else{
			$feedback = 'Your comment could not be added';
			$feedback_class = 'error';
		}
	}else{
		//not valid
		$feedback = 'Please fix the following:';
		$feedback_class = 'error';
	}
	
}