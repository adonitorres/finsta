<?php
require('config.php');
require_once('includes/functions.php');
require('includes/header.php');
?>

    <main class="content">
      <?php // get up to 20 published posts, newest first
      $result = $DB->prepare( 'SELECT *
                                FROM posts
                                WHERE is_published = 1
                                ORDER BY date DESC
                                LIMIT 20' );
      $result->execute();
      // check if any rows were found
      if( $result->rowCount() >= 1 ){
        // loop it
        while( $row = $result->fetch() ){
          // make variables from the array keys
          extract($row);
      ?>

      <div class="post">
        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
        <h2><?php echo $title; ?></h2>
        <p><?php echo $body; ?></p>
        <span class="date"><?php echo time_ago( $date ); ?></span>
      </div>

      <?php
        } // end while
      }else{
        // no rows found from our query
        echo 'No posts found';
      } ?>

    </main>

<?php 
require('includes/sidebar.php');
require('includes/footer.php');
?>
