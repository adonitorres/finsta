<?php

/**
 * Get a human-friendly version of a datestamp
 * @param string $date = any date string
 * @return string = nice-looking date
 */
function convert_date( $date = 'today' ){
  $output = new DateTime( $date );
  return $output->format( 'F j, Y' );
}

/**
 * Convert a date into the "time ago"
 * @param string $datetime
 * @param boolean $full = whether to break down the hours, minutes, seconds
 * @link https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
 */
function time_ago($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
  );
  foreach ($string as $k => &$v) {
      if ($diff->$k) {
          $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
          unset($string[$k]);
      }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Count approved comments on any post
 * @param int $id = any post id
 * @return int = number of comments
 */
function count_comments( $id ){
  // use the existing database connection
  global $DB;
  $result = $DB->prepare( 'SELECT COUNT(*) AS total
                FROM comments
                WHERE post_id = ?
                AND is_approved = 1' );
  // run it and bind the data to the placeholder
  $result->execute( array( $id ) );
  // check it
  if( $result->rowCount() ){
    // loop it
    while( $row = $result->fetch() ){
      return $row['total'];
    }
  }
}