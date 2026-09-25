<?php
/** 
 * footer.php
 * 
 * This is the footer template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// check if we actually have ANY widgets for the footer
$have_widgets = in_array( true, array( is_active_sidebar('footer-1'), is_active_sidebar('footer-2'), is_active_sidebar('footer-3') ) );

?>
            </div>
        </main>

        <!-- Scroll to Top Button -->
        <button id="scroll-to-top" class="fixed bottom-8 right-8 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:from-[#43819c] hover:to-[#2d7696] z-40" aria-label="Scroll to top">
            <span class="fa-solid fa-arrow-up-from-bracket inline-block w-6 h-6"></span>
        </button>

        <footer class="bg-gray-800 border-t border-gray-700 mt-8">

            <?php 
            // we only need to show this is the widgets actually have anything in them
            if ($have_widgets): ?>
                <div class="w-full px-4 sm:px-8 md:px-16 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="footer-column">
                            <?php if (is_active_sidebar('footer-1')): ?>
                                <?php dynamic_sidebar('footer-1'); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="footer-column">
                            <?php if (is_active_sidebar('footer-2')): ?>
                                <?php dynamic_sidebar('footer-2'); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="footer-column">
                            <?php if (is_active_sidebar('footer-3')): ?>
                                <?php dynamic_sidebar('footer-3'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-gray-900 border-t border-gray-700">
                <div class="w-full px-4 sm:px-8 md:px-16 py-4">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                        <div class="mb-2 md:mb-0 w-1/2">
                            <p>Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                        </div>
                        <?php get_template_part( 'partials/navigation/footer' ); ?>
                    </div>
                </div>
            </div>

        </footer>

        <?php get_template_part( 'partials/content/cookie' ); ?>
        
        <?php wp_footer( ); ?>
    </body>
</html>