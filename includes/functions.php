<?php 
/**
 * Get a human-friendly version of a datestamp
 * @param  string $date any date string
 * @return string       nice-looking date
 */
function convert_date( $date = 'today' ){
	$output = new DateTime( $date );
	return $output->format( 'F jS' );
}

/**
 * convert a date into the "time ago"
 * @param  string  $datetime 
 * @param  boolean $full     whether to break down the hours, minutes, seconds
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
 * @param  int $id any post id
 * @return int     number of comments
 */
function count_comments( $id ){
    //use the existing DB connection
    global $DB;
    $result = $DB->prepare('SELECT COUNT(*) AS total
                    FROM comments
                    WHERE post_id = ?
                    AND is_approved = 1');
    //run it and bind the data to the placeholders
    $result->execute(array($id));
    //check it
    if($result->rowCount()){
        //loop it
        while( $row = $result->fetch() ){
            return $row['total'];
        }
    }
}

/**
 * Display the feedback after a typical form submission
 * @param string $message The feedback message for the user
 * @param string $class The CSS class for the feedback div - use 'error' or 'success'
 * @param array $list   The list of error issues
 * @return mixed HTML output
 */
function show_feedback( &$message, &$class = 'error', $list = array() ){
    if( isset( $message ) ){ ?>
        <div class="feedback <?php echo $class; ?>">
            <h4><?php echo $message; ?></h4>
            <?php 
            if( ! empty($list) ){ 
                echo '<ul>';
                foreach ( $list AS $item ) {
                    echo "<li>$item</li>";
                }
                echo '</ul>';
            }
            ?>
        </div>
    <?php }
}

/**
 * sanitize a string input by removing all tags and trimming leftover white space
 * @param  string $dirty the untrusted data
 * @return string        the sanitized string
 */
function clean_string( $dirty ){
    return trim( strip_tags( $dirty ) );
}

/**
* displays sql query information including the computed parameters.
* Silent unless DEBUG MODE is set to 1 in config.php
* @param [statement handler] $sth -  any PDO statement handler that needs troubleshooting
*/
function debug_statement($sth){
    if( DEBUG_MODE ){
        echo '<pre>';
        $info = debug_backtrace();
        echo '<b>Debugger ran from ' . $info[0]['file'] . ' on line ' . $info[0]['line'] . '</b><br><br>';
        $sth->debugDumpParams();
        echo '</pre>';
    }
}
