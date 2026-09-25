<?php
/** 
 * partials/forms/contact.php
 * 
 * Contact form template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Get reCAPTCHA site key
$recaptcha_site_key = KPT_Utilities::get_option( 'kpt_recaptcha_site_key' );

// Check if form was successfully submitted
$success = isset( $_GET['contact_success'] ) && $_GET['contact_success'] == '1';
?>

<div class="kpt-contact-form-wrapper w-full mx-auto">
    
    <?php if ( $success ) : ?>
        <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">Thank You!</h3>
            <p class="text-green-700 dark:text-green-300">Your message has been received. We'll get back to you soon.</p>
        </div>
    <?php endif; ?>

    <form method="post" action="" class="space-y-6" id="kpt-contact-form">
        
        <?php wp_nonce_field( 'kpt_contact_form', 'kpt_contact_nonce' ); ?>
        
        <!-- Honeypot fields (hidden from users) -->
        <div style="position: absolute; left: -9999px;" aria-hidden="true">
            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            <input type="text" name="company_name" tabindex="-1" autocomplete="off">
        </div>
        <!-- Time-based honeypot -->
        <input type="hidden" name="form_token" value="<?php echo esc_attr( base64_encode( time() ) ); ?>">

        <p class="text-sm text-gray-500 dark:text-gray-400 text-right">
            <span class="text-red-500">*</span> Required fields
        </p>

        <!-- Name Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    First Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="first_name" 
                    name="first_name" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                >
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Last Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="last_name" 
                    name="last_name" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                >
            </div>
        </div>

        <!-- Email and Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                >
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Phone Number
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                >
            </div>
        </div>

        <!-- URL -->
        <div>
            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Website URL
            </label>
            <input 
                type="url" 
                id="url" 
                name="url"
                placeholder="https://"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
            >
        </div>

        <!-- Message -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Message <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="message" 
                name="message" 
                rows="6" 
                required
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
            ></textarea>
        </div>

        <!-- Privacy Consent -->
        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <label class="flex items-start cursor-pointer">
                <input 
                    type="checkbox" 
                    name="privacy_consent" 
                    id="privacy_consent" 
                    required
                    class="mt-1 mr-3 h-4 w-4 text-[#599bb8] border-gray-300 rounded focus:ring-[#599bb8]"
                >
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    <span class="text-red-500">*</span> I agree to the <a href="/about-kevin-pirnie/privacy-policy/" target="_blank" class="text-[#599bb8] hover:text-[#43819c] underline">Privacy Policy</a>. 
                    By submitting this form, you consent to Kevin Pirnie collecting and using your contact information to respond to your inquiry and for related business purposes. Your information will be stored securely, shared only with necessary service providers, and retained as outlined in our Privacy Policy.
                </span>
            </label>
        </div>

        <!-- reCAPTCHA -->
        <?php if ( $recaptcha_site_key ) : ?>
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
        <?php endif; ?>

        <p>
            This site is protected by reCAPTCHA and the Google
            <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and
            <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
        </p>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                name="kpt_contact_submit"
                class="w-full btn-primary text-lg py-3"
            >
                Send Message
            </button>
        </div>

    </form>

    <!-- Loading Overlay -->
    <div id="contact-form-loading" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-[#599bb8] mb-4"></div>
            <p class="text-white text-lg font-medium">Sending your message...</p>
        </div>
    </div>

</div>
<?php if ( $recaptcha_site_key ) : ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr( $recaptcha_site_key ); ?>"></script>
<script>
grecaptcha.ready(function() {
    // Get token on page load and refresh it every 90 seconds
    function getToken() {
        grecaptcha.execute('<?php echo esc_js( $recaptcha_site_key ); ?>', {action: 'contact_form'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    }
    
    getToken();
    setInterval(getToken, 90000);
});

// Just show overlay on submit, don't interfere
document.getElementById('kpt-contact-form').addEventListener('submit', function() {
    document.getElementById('contact-form-loading').classList.remove('hidden');
});
</script>
<?php else : ?>
<script>
document.getElementById('kpt-contact-form').addEventListener('submit', function() {
    document.getElementById('contact-form-loading').classList.remove('hidden');
});
</script>
<?php endif; ?>
