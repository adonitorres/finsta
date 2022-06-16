<?php
/**
* Handler file for the like/unlike JS interaction
* This file never leaves the server! It updates the DB and sends back an updated UI for the heart and count
*/
//dependencies
require('../config.php');
require_once('../includes/functions.php');
//get all the data from the JS event (REQUEST works with POST or GET)
$post_id = clean_int( $_REQUEST[ 'postId' ] );
$user_id = clean_int( $_REQUEST[ 'userId' ] );

//does this user already like this post?
$result = $DB->prepare( 'SELECT * FROM likes
                          WHERE user_id = ?
                          AND post_id = ?' );
$result->execute( array( $user_id, $post_id ) );
if( $result->rowCount() ){
  //The user previously liked this post, DELETE the row
  $query = 'DELETE FROM likes
            WHERE user_id = :user_id
            AND post_id = :post_id';
}else{
  //INSERT the row
  $query = 'INSERT INTO likes
            ( user_id, post_id, date )
            VALUES
            ( :user_id, :post_id, now() )';
}
//run the resulting query
$result = $DB->prepare( $query );
$result->execute( array(
                  'post_id' => $post_id,
                  'user_id' => $user_id
                ) );
if( $result->rowCount() ){
  //it worked! update the like interface
  like_interface( $post_id, $user_id );
}