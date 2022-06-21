<?php
/*
Add or remove a 'follow' from the DB when a viewer clicks the follow button on a user profile
*/
require('../config.php');
require_once('../includes/functions.php');
$logged_in_user = check_login();

//clean all data
$is_followed_id = clean_int( $_REQUEST['to'] );
$follower_id = $logged_in_user['user_id'];

if(! $is_followed_id ){
  //TODO - test this; it should prevent a $is_followed_id of 0
  exit( 'error' );
}

//check to see if this follow already exists
$result = $DB->prepare( 'SELECT * FROM follows
                          WHERE follower_id = :to
                          AND is_followed_id = :from
                          LIMIT 1' );
$result->execute( array(
                        'to' => $follower_id,
                        'from' => $is_followed_id
                      ) );
if( $result->rowCount() ){
  //it already exists; remove it.
  $query = 'DELETE FROM follows
            WHERE follower_id = :to
            AND is_followed_id = :from
            LIMIT 1';
}else{
  //add the follow
  $query = 'INSERT INTO follows
            ( follower_id, is_followed_id, date )
            VALUES
            ( :to, :from, now() )';
}
                    
//run the resulting query
$result = $DB->prepare( $query );
$result->execute( array(
                        'to' => $follower_id,
                        'from' => $is_followed_id
                      ) );
//update the interface
follows_interface( $is_followed_id );