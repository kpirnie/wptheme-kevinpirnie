<?php
/** 
 * partials/sidebar/search-form.php
 * 
 * Contact form template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-100">Search</h3>
    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="flex gap-2">
            <input type="search" 
                name="s" 
                placeholder="Search..." 
                class="flex-1 px-3 py-2 rounded-lg border border-gray-700 bg-gray-900 text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                value="<?php echo get_search_query(); ?>">
            <button type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white rounded-lg transition-all hover:from-[#43819c] hover:to-[#2d7696]">
                <span class="fa-solid fa-magnifying-glass"></span>
            </button>
        </div>
    </form>
</div>