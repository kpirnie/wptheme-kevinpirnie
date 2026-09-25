<?php

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

// setup our path
defined('KPT_PATH') || define('KPT_PATH', dirname(__FILE__) . '/');

// At our earliest point, fire this up
add_action('after_setup_theme', function () {

    // include our autoloader
    include_once KPT_PATH . '/vendor/autoload.php';

    // we can fire up the rest of the theme's functionality now
    $_kpt = new KPT();

    // initialize the theme
    $_kpt->init();

    // clean up
    unset($_kpt);
}, 999);

// Clear fragment caches when content is updated
add_action('save_post', function ($post_id) {
    delete_transient('kpt_portfolio_' . md5(serialize([])));
    delete_transient('kpt_heroes_' . $post_id);
    delete_transient('kpt_breadcrumbs_' . $post_id);
}, 10, 1);

function is_parent_page($page_id = null)
{
    if ((is_page('about-kevin-pirnie/privacy-policy') || is_page('about-kevin-pirnie/cookie-policy') || is_page('about-kevin-pirnie/lets-talk')) || is_front_page()) {
        return true;
    }
    $page_id = $page_id ?: get_the_ID();
    $children = get_pages(array('child_of' => $page_id));
    $is_child = (get_post()->post_parent > 0);
    $is_parent = (! empty($children) && count($children) > 0);
    return $is_parent && ! $is_child;
}
