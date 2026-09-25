<?php

/** 
 * navigation/breadcrumbs.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 */

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

$cache_key = 'kpt_breadcrumbs_' . get_the_ID();
$cached = get_transient($cache_key);

if (false !== $cached && !is_user_logged_in()) {
    echo $cached;
    return;
}

ob_start();
?>
<nav class="mb-6 text-right">
    <?php 
	if(function_exists('yoast_breadcrumb')) {
		yoast_breadcrumb(); 
	}
    ?>
</nav>

<?php
$output = ob_get_clean();
set_transient($cache_key, $output, DAY_IN_SECONDS);
echo $output;
