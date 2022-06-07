<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');

//page configuration
$per_page = 4;

//sanitize the search phrase
if( isset( $_GET['phrase'] ) ){
	$phrase = clean_string( $_GET['phrase'] );
}else{
	$phrase = '';
}
require('includes/header.php');
?>
<main class="content">
	<?php //get all the published posts that match the phrase
	if( $phrase != '' ){
		$query = 'SELECT title, post_id, image, date
				FROM posts
				WHERE 
				(title LIKE :phrase OR body LIKE :phrase)
				AND is_published = 1 
				ORDER BY date DESC';
		$result = $DB->prepare( $query );
		$result->execute(array( 'phrase' => "%$phrase%" ));
	 	
	 	//total number of matching posts
	 	$total = $result->rowCount();

	 	//how many pages? ceil means always round up to a full page
	 	$max_pages = ceil( $total / $per_page );

	 	//what page are we on? URL will be search.php?phrase=cat&page=2
		$current_page = 1;
	 	if(isset( $_GET['page'] )){
	 		$current_page = filter_var( $_GET['page'], FILTER_SANITIZE_NUMBER_INT );
	 	}
	 	//validate the current page (must be between 1 and the max page)
	 	if( $current_page < 1 OR $current_page > $max_pages ){
	 		$current_page = 1;
	 	}

	 	//figure out the offset for the LIMIT
	 	$offset = ( $current_page - 1 ) * $per_page;

	 	//run the query again, applying the new limit
	 	$query .= ' LIMIT :offset, :per_page';
	 	$result = $DB->prepare( $query );
	 	//bind parameters because LIMIT requires integers
	 	$wildcard_phrase = "%$phrase%";
	 	$result->bindParam( 'phrase', 	$wildcard_phrase, 	PDO::PARAM_STR );
	 	$result->bindParam( 'offset', 	$offset, 			PDO::PARAM_INT );
	 	$result->bindParam( 'per_page', $per_page, 			PDO::PARAM_INT );
	 	//run it
	 	$result->execute();
	 	//debug_statement($result);
	?>
	<section class="title">
		<h2>Search Results for <?php echo $phrase; ?></h2>
		<h3><?php echo $total; ?> posts found. 
			Showing page <?php echo $current_page; ?> of <?php echo $max_pages; ?>.</h3>
	</section>

	<?php if( $total >= 1 ){ ?>
	<section class="grid">
		<?php 
		while( $row = $result->fetch() ){
			extract($row);
		?>
		<div class="item">
			<a href="single.php?post_id=<?php echo $post_id; ?>">
				<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" width="200" height="200">
				<h3><?php echo $title; ?></h3>
				<span class="date"><?php echo convert_date( $date ); ?></span>
			</a>
		</div>
		<?php }//end while ?>
	</section><!-- .grid -->

	<section class="pagination">
		<?php 
		$prev = $current_page - 1;
		$next = $current_page + 1;
		 ?>
		
		<?php if( $current_page > 1 ){ ?>
		<a class="button" href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>">
			&larr; Previous</a>
		<?php } ?>

		<?php 
		for( $i = 1; $i <= $max_pages; $i++ ){ 
			if( $i == $current_page ){
				$class = 'button-current';
			}else{
				$class= 'button-outline';
			}
			?>
			<a class="button <?php echo $class; ?>" href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>">
				<?php echo $i; ?>
			</a>
		<?php } ?>

		<?php if( $current_page < $max_pages ){ ?>
		<a class="button" href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">
			Next &rarr;</a>
		<?php } ?>

	</section><!-- .pagination -->
	<?php }//end if posts found ?>

	<?php 
	}else{
		$message = 'Search is Blank';
		$class = 'error';
		show_feedback($message, $class);
	} //end search validation
	?>
</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php'); 	