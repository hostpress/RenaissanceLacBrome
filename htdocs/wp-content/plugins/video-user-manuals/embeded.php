<html>
    <head>
        <title>Video Player</title>
    </head>
    <body style="padding:0;margin:0;">
        <div style="padding:25px">
   <?php

// Load WP
require('../../../wp-config.php');

if(!isset($_GET['wpmvid'])) { die; }

$x = $_GET['wpmvid'];

echo stripcslashes( get_option('wpm_o_localvideos_'.$x.'_5') );

?>
        </div>
        </body>
</html>