<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');

//Which post are we trying to view?
//url will be like single.php?post_id=X
if( isset($_GET['post_id']) ){
	$post_id = filter_var( $_GET['post_id'], FILTER_SANITIZE_NUMBER_INT );
	//make sure it isn't blank
	if( '' == $post_id  ){
		$post_id = 0;
	}
}else{
	$post_id = 0;
}

require('includes/comment-parse.php');
?>
	<main class="content">
		<?php 
		//1. Write it. get all published posts, newest first
		$result = $DB->prepare('SELECT posts.post_id, posts.image, posts.title, posts.body, posts.date, users.username, users.profile_pic, categories.name
								FROM posts, users, categories
								WHERE posts.is_published = 1
								AND users.user_id = posts.user_id
								AND categories.category_id = posts.category_id
								AND posts.post_id = ?
								ORDER BY posts.date DESC
								LIMIT 1'); 
		//2. run it
		$result->execute( array( $post_id ) );
		//3. check it - did we find any posts?	
		if( $result->rowCount() >= 1 ){			
			//4. loop it - once per row
			while( $row = $result->fetch() ){
		?>
		<div class="one-post">
			<img src="<?php echo $row['image']; ?>">

			<span class="author">
				<?php show_profile_pic( $row['profile_pic'] ); ?>
				<?php echo $row['username']; ?>
			</span>

			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>

			<span class="category"><?php echo $row['name']; ?></span>

			<span class="date"><?php echo time_ago( $row['date'] ); ?></span>

			<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
		</div>	

		<?php require('includes/comments.php'); ?>
		<?php require('includes/comment-form.php'); ?>

		<?php 
			} //end post while loop
		}else{ ?>
		
		<div class="feedback">
			<h2>Sorry</h2>
			<p>No posts found. Try a search instead.</p>
		</div>

		<?php }//end if posts found ?>

	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	