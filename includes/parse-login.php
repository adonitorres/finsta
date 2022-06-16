<?php
//pre-define vars
$username = '';
$password = '';
$errors   = array();
//process the login if submitted
if( isset( $_POST['did_login'] ) ){
  //sanitize everything
  $username = clean_string( $_POST['username'] );
  $password = clean_string( $_POST['password'] );
  //validate
  $valid = true;
  //username wrong length
  if ( strlen($username) < USERNAME_MIN OR strlen($username) > USERNAME_MAX ){
    $valid = false;
    //only show detailed error in debug mode for security
    if( DEBUG_MODE ): //<-------------------------------------alternate way to do if statement; works with if, if/else, while, etc...
      $errors['username'] = 'username wrong length';
    endif;
  }
  //password too short
  if( strlen($password) < PASSWORD_MIN ){
    $valid = false;
    //only show detailed error in debug mode for security
    if( DEBUG_MODE ):
      $errors['password'] = 'password too short';
    endif;
  }
  //if valid, look up the username
  if( $valid ):
    $result = $DB->prepare('SELECT user_id, password
                            FROM users
                            WHERE username = ?
                            LIMIT 1');
    $result->execute( array($username) );
    //if one row found, check password
    if( $result->rowCount() ):
      while( $row = $result->fetch() ):
        //if password matches, log them in for 2 weeks and redirect to home page
        if( password_verify( $password, $row['password'] ) ):
          $feedback = 'Successful Login';
          $feedback_class = 'success';

          //generate 60-char random string ( bin2hex() changes it to hexidecimal characters )
          $access_token = bin2hex( random_bytes(30) );
          //store it in the DB for this user only
          $result = $DB->prepare('UPDATE users
                            SET access_token = :token
                            WHERE user_id = :id
                            LIMIT 1');
        $result->execute( array(
          'token' => $access_token,
          'id' => $row['user_id']
        ) );
        //if the update worked, store the cooking and session
        if( $result->rowCount() ):
          $expire = time() + 60 * 60 * 24 * 14;
          setcookie( 'access_token', $access_token, $expire );
          $_SESSION['access_token'] = $access_token;

          $hashed_id = password_hash( $row['user_id'], PASSWORD_DEFAULT );
          setcookie( 'user_id', $hashed_id, $expire );
          $_SESSION['user_id'] = $hashed_id;

          //redirect
          header('Location:index.php');
        endif;
        else:
          $feedback = 'Incorrect Login';
          $feedback_class = 'error';
        endif;
      endwhile;
    endif;
  else:
    //invalid
    $feedback = 'Incorrect Login';
    $feedback_class = 'error';
  endif;
}//end form parser