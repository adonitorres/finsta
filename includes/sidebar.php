  <aside class="sidebar">
  <?php // get up to 5 user profile pics, newest first
    $result = $DB->prepare( 'SELECT profile_pic, username
                              FROM users
                              ORDER BY join_date DESC
                              LIMIT 5' );
    $result->execute();
    // check if any rows were found
    if( $result->rowCount() >= 1 ){ ?>
    <section class="users">
      <h2 class="users">Newest Users</h2>
      <ul>
        <?php
        while( $row = $result->fetch() ){
          extract($row); ?>
          <li class="user">
            <img src="<?php echo $profile_pic; ?>" alt="<?php echo $username; ?>">
          </li>
        <?php } // end while
    } ?>
      </ul>
    </section>
    
    <?php // get up to 10 categories
    $result = $DB->prepare( 'SELECT categories.*, COUNT(*) AS total
                              FROM posts, categories
                              WHERE posts.category_id = categories.category_id
                              GROUP BY posts.category_id
                              ORDER BY RAND()' );
    $result->execute();
    // check if any rows were found
    if( $result->rowCount() >= 1 ){ ?>
    <section class="categories">
      <h2 class="categories">Categories</h2>
      <ul>
        <?php
        while( $row = $result->fetch() ){
          extract($row);
          echo "<li>$name ($total)</li>";
        } // end while
    } ?>
      </ul>
    </section>
    
    <?php // get up to 20 tags
    $result = $DB->prepare( 'SELECT *
                              FROM tags
                              LIMIT 20' );
    $result->execute();
    // check if any rows were found
    if( $result->rowCount() >= 1 ){ ?>
    <section class="tags">
      <h2 class="tags">Tags</h2>
      <ul>
        <?php
        while( $row = $result->fetch() ){
          extract($row); ?>
          <li><?php echo $name; ?></li>
        <?php } // end while
    } ?>
      </ul>
    </section>

  </aside>