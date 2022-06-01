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
    $result = $DB->prepare( 'SELECT *
                              FROM categories
                              LIMIT 10' );
    $result->execute();
    // check if any rows were found
    if( $result->rowCount() >= 1 ){
      // loop it
      echo "<h2 class='categories'>Categories</h2>";
      while( $row = $result->fetch() ){
        // make variables from the array keys
        extract($row);
    ?>

    <section class="categories">
      <ul>
        <li><?php echo $name; ?></li>
      </ul>
    </section>

    <?php
      } // end while
    }else{
      // no rows found from our query
      echo 'No categories found';
    } ?>

    <?php // get up to 10 tags
    $result = $DB->prepare( 'SELECT *
                              FROM tags
                              LIMIT 10' );
    $result->execute();
    // check if any rows were found
    if( $result->rowCount() >= 1 ){
      // loop it
      echo "<h2 class='tags'>Tags</h2>";
      while( $row = $result->fetch() ){
        // make variables from the array keys
        extract($row);
    ?>

    <section class="tags">
      <ul>
        <li><?php echo $name; ?></li>
      </ul>
    </section>

    <?php
      } // end while
    }else{
      // no rows found from our query
      echo 'No tags found';
    } ?>

  </aside>