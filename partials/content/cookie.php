<?php
/** 
 * partials/content/cookie.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<!-- Cookie Notice Overlay -->
<div id="kp-cookie-overlay" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50"></div>

<!-- Cookie Notice -->
<div id="kp-cookie-notice" class="hidden fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-6 shadow-lg z-50 border-t-4 border-[#599bb8]">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col gap-4">
            <div>
                <h3 class="text-2xl font-bold mb-3">Cookie Consent</h3>
                <p class="text-base text-gray-300 mb-4">
                    This website uses cookies to enhance your browsing experience, analyze site traffic, and personalize content. 
                    Cookies are small text files stored on your device that help us remember your preferences and understand how you interact with our site.
                </p>
                <p class="text-base text-gray-300 mb-4">
                    By clicking "Accept", you consent to our use of cookies as described in our Cookie Policy. 
                    If you click "Decline", we will not use cookies for tracking purposes, but some features of the site may not function optimally.
                </p>
                <p class="text-sm text-gray-400">
                    <a href="#" id="kp-cookie-learn-more" class="text-[#599bb8] hover:text-[#43819c] underline">Learn more about our Cookie Policy</a>
                </p>
            </div>
            <div class="flex gap-3 justify-end">
                <button id="kp-cookie-decline" class="px-8 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors font-semibold">
                    Decline
                </button>
                <button id="kp-cookie-accept" class="px-8 py-3 bg-gradient-to-r from-[#599bb8] to-[#2d7696] hover:from-[#43819c] hover:to-[#2d7696] rounded-lg transition-colors font-semibold">
                    Accept
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Policy Modal -->
<div id="kp-cookie-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div id="kp-modal-overlay" class="absolute inset-0 bg-black bg-opacity-75"></div>
    <div class="relative bg-gray-800 rounded-lg max-w-4xl w-full max-h-[85vh] overflow-hidden flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <h2 class="text-2xl font-bold">Cookie Policy</h2>
            <button id="kp-modal-close" class="text-gray-400 hover:text-white text-3xl leading-none">
                &times;
            </button>
        </div>
        <div id="kp-modal-content" class="flex-1 overflow-y-auto p-6 text-gray-300">
            <div class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-[#599bb8]"></div>
            </div>
        </div>
    </div>
</div>
