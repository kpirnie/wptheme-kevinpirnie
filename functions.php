<?php

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

// setup our path
defined('KPT_PATH') || define('KPT_PATH', dirname(__FILE__) . '/');

// behind the proxy nginx hands PHP a server name of "_" and an internal port, which loops Yoast's URL cleanup redirect
if ('_' === ($_SERVER['SERVER_NAME'] ?? '')) {
    $_SERVER['SERVER_NAME'] = parse_url(home_url(), PHP_URL_HOST);
    $_SERVER['SERVER_PORT'] = is_ssl() ? '443' : '80';
}

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

// Wipe every cookie but the consent choice on each request once cookies have been declined
add_action('init', function () {

    // leave the admin and login alone, and only act on a decline
    if (is_admin() || 'wp-login.php' === ($GLOBALS['pagenow'] ?? '') || 'declined' !== ($_COOKIE['kp_cookie_consent'] ?? '')) {
        return;
    }

    // right before the headers go out
    header_register_callback(function () {

        // drop anything set during this request
        header_remove('Set-Cookie');

        // pull the raw names so array-style cookie names stay intact
        $names = array();
        foreach (explode(';', $_SERVER['HTTP_COOKIE'] ?? '') as $pair) {
            $name = trim(strstr($pair, '=', true) ?: $pair);
            if ('' !== $name && 'kp_cookie_consent' !== $name) {
                $names[] = $name;
            }
        }

        // nothing to wipe
        if (empty($names)) {
            return;
        }

        // every path and domain they could live on
        $parts = explode('.', (string) parse_url(home_url(), PHP_URL_HOST));
        $paths = array_unique(array('/', COOKIEPATH, SITECOOKIEPATH));
        $domains = array('', (string) COOKIE_DOMAIN);
        for ($i = 0; $i < count($parts) - 1; $i++) {
            $domains[] = implode('.', array_slice($parts, $i));
        }
        $domains = array_unique($domains);

        // expire them all
        foreach (array_unique($names) as $name) {
            foreach ($paths as $path) {
                foreach ($domains as $domain) {
                    setcookie($name, '', array('expires' => 1, 'path' => $path, 'domain' => $domain, 'secure' => is_ssl(), 'samesite' => 'Lax'));
                }
            }
        }

        // the auth cookies live on the admin and plugin paths, so let core clear those
        if (preg_grep('/^' . preg_quote(LOGGED_IN_COOKIE, '/') . '$/', $names)) {
            wp_clear_auth_cookie();
        }
    });
}, 0);

// Google Consent Mode defaults, output ahead of any analytics tag so it holds no matter which plugin loads it
add_action('wp_head', function () {
?>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        (function() {
            var state = /(?:^|;\s*)kp_cookie_consent=accepted(?:;|$)/.test(document.cookie) ? 'granted' : 'denied';
            gtag('consent', 'default', {
                ad_storage: state,
                ad_user_data: state,
                ad_personalization: state,
                analytics_storage: state
            });
            if (state !== 'granted') {
                window.a2a_config = window.a2a_config || {};
                window.a2a_config.no_3p = 1;
            }
        })();
    </script>
<?php
}, 0);

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
