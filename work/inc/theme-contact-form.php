<?php
/** 
 * Contact Form Handler
 * 
 * Handles contact form submissions, storage, and email notifications
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if ( ! class_exists( 'KPT_Contact_Form' ) ) {

    class KPT_Contact_Form {

        public function init() : void {
            add_action( 'init', array( $this, 'register_cpt' ) );
            add_action( 'template_redirect', array( $this, 'process_submission' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_columns' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'admin_action_kpt_toggle_spam', array( $this, 'handle_spam_toggle' ) );
        }

        public function register_cpt() : void {
            register_post_type( 'kpt_contact', array(
                'labels' => array(
                    'name'               => 'Contact Submissions',
                    'singular_name'      => 'Contact Submission',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New Submission',
                    'edit_item'          => 'View Submission',
                    'new_item'           => 'New Submission',
                    'all_items'          => 'All Submissions',
                    'view_item'          => 'View Submission',
                    'search_items'       => 'Search Submissions',
                    'not_found'          => 'No submissions found',
                    'not_found_in_trash' => 'No submissions found in trash',
                    'menu_name'          => 'Contact Form'
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-email',
                'capability_type'     => 'post',
                'capabilities'        => array(
                    'create_posts' => 'do_not_allow',
                ),
                'map_meta_cap'        => true,
                'supports'            => array( 'title' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => false,
            ) );

            // Register custom post status for spam
            register_post_status( 'spam', array(
                'label'                     => _x( 'Spam', 'post status', 'kpt' ),
                'public'                    => false,
                'exclude_from_search'       => true,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Spam <span class="count">(%s)</span>', 'Spam <span class="count">(%s)</span>', 'kpt' ),
            ) );

        }

        public function add_admin_columns() : void {
            add_filter( 'manage_kpt_contact_posts_columns', function( $columns ) {
                $new = array();
                $new['cb'] = $columns['cb'];
                $new['title'] = 'Name';
                $new['email'] = 'Email';
                $new['phone'] = 'Phone';
                $new['date'] = $columns['date'];
                $new['spam_status'] = 'Status';
                $new['date'] = $columns['date'];
                return $new;
            } );

            add_action( 'manage_kpt_contact_posts_custom_column', function( $column, $post_id ) {
                switch ( $column ) {
                    case 'email':
                        echo esc_html( get_post_meta( $post_id, '_contact_email', true ) );
                        break;
                    case 'phone':
                        echo esc_html( get_post_meta( $post_id, '_contact_phone', true ) );
                        break;
                }
            }, 10, 2 );

            add_action( 'manage_kpt_contact_posts_custom_column', function( $column, $post_id ) {
                if ( $column === 'spam_status' ) {
                    $status = get_post_status( $post_id );
                    if ( $status === 'spam' ) {
                        echo '<span style="color: #dc3232; font-weight: bold;">⚠ Spam</span>';
                    } else {
                        echo '<span style="color: #46b450;">✓ Clean</span>';
                    }
                }
            }, 10, 2 );

            // Add row actions for spam toggle
            add_filter( 'post_row_actions', function( $actions, $post ) {
                if ( $post->post_type !== 'kpt_contact' ) {
                    return $actions;
                }
                
                $nonce = wp_create_nonce( 'kpt_spam_toggle_' . $post->ID );
                
                if ( get_post_status( $post->ID ) === 'spam' ) {
                    $actions['not_spam'] = sprintf(
                        '<a href="%s" style="color: #46b450;">Not Spam</a>',
                        admin_url( 'admin.php?action=kpt_toggle_spam&post_id=' . $post->ID . '&mark=clean&_wpnonce=' . $nonce )
                    );
                } else {
                    $actions['mark_spam'] = sprintf(
                        '<a href="%s" style="color: #dc3232;">Mark as Spam</a>',
                        admin_url( 'admin.php?action=kpt_toggle_spam&post_id=' . $post->ID . '&mark=spam&_wpnonce=' . $nonce )
                    );
                }
                
                return $actions;
            }, 10, 2 );

            // Add spam filter dropdown
            add_action( 'restrict_manage_posts', function() {
                global $typenow;
                if ( $typenow !== 'kpt_contact' ) return;
                
                $current = isset( $_GET['post_status'] ) ? $_GET['post_status'] : '';
                ?>
                <select name="post_status">
                    <option value="">All Statuses</option>
                    <option value="publish" <?php selected( $current, 'publish' ); ?>>Clean</option>
                    <option value="spam" <?php selected( $current, 'spam' ); ?>>Spam</option>
                </select>
                <?php
            } );

        }

        public function add_meta_boxes() : void {
            add_meta_box(
                'contact_details',
                'Submission Details',
                array( $this, 'render_meta_box' ),
                'kpt_contact',
                'normal',
                'high'
            );
        }

        public function render_meta_box( $post ) : void {
            $first_name = get_post_meta( $post->ID, '_contact_first_name', true );
            $last_name = get_post_meta( $post->ID, '_contact_last_name', true );
            $email = get_post_meta( $post->ID, '_contact_email', true );
            $phone = get_post_meta( $post->ID, '_contact_phone', true );
            $url = get_post_meta( $post->ID, '_contact_url', true );
            $message = get_post_meta( $post->ID, '_contact_message', true );
            $ip = get_post_meta( $post->ID, '_contact_ip', true );
            $user_agent = get_post_meta( $post->ID, '_contact_user_agent', true );
            
            ?>
            <div style="padding: 10px;">
                <p><strong>First Name:</strong> <?php echo esc_html( $first_name ); ?></p>
                <p><strong>Last Name:</strong> <?php echo esc_html( $last_name ); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                <p><strong>Phone:</strong> <?php echo esc_html( $phone ); ?></p>
                <?php if ( $url ) : ?>
                    <p><strong>Website:</strong> <a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php echo esc_html( $url ); ?></a></p>
                <?php endif; ?>
                <p><strong>Message:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 4px;">
                    <?php echo nl2br( esc_html( $message ) ); ?>
                </div>
                <hr style="margin: 20px 0;">
                <p style="font-size: 12px; color: #666;">
                    <strong>IP Address:</strong> <?php echo esc_html( $ip ); ?><br>
                    <strong>User Agent:</strong> <?php echo esc_html( $user_agent ); ?>
                </p>
            </div>
            <?php
        }

        public function handle_spam_toggle() : void {
            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_die( 'Unauthorized' );
            }
            
            $post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : 0;
            $mark = isset( $_GET['mark'] ) ? sanitize_text_field( $_GET['mark'] ) : '';
            
            if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'kpt_spam_toggle_' . $post_id ) ) {
                wp_die( 'Security check failed' );
            }
            
            if ( $post_id && get_post_type( $post_id ) === 'kpt_contact' ) {
                $new_status = ( $mark === 'spam' ) ? 'spam' : 'publish';
                wp_update_post( array(
                    'ID' => $post_id,
                    'post_status' => $new_status,
                ) );
            }
            
            wp_redirect( admin_url( 'edit.php?post_type=kpt_contact' ) );
            exit;
        }

        public function process_submission() : void {

            if ( ! isset( $_POST['kpt_contact_submit'] ) || ! isset( $_POST['kpt_contact_nonce'] ) ) {
                return;
            }

            if ( ! wp_verify_nonce( $_POST['kpt_contact_nonce'], 'kpt_contact_form' ) ) {
                wp_die( 'Security check failed' );
            }

            // Rate limiting by IP
            $ip = $_SERVER['REMOTE_ADDR'];
            $rate_limit_key = 'kpt_contact_limit_' . md5( $ip );
            $submissions = get_transient( $rate_limit_key );

            if ( $submissions !== false && $submissions >= 3 ) {
                wp_die( 'Too many submissions. Please try again later.' );
            }

            set_transient( $rate_limit_key, ( $submissions ? $submissions + 1 : 1 ), HOUR_IN_SECONDS );

            // Honeypot checks
            if ( ! empty( $_POST['website_url'] ) || ! empty( $_POST['company_name'] ) ) {
                wp_redirect( home_url() );
                exit;
            }

            // Time-based check (form submitted too fast = bot)
            if ( isset( $_POST['form_token'] ) ) {
                $form_time = (int) base64_decode( $_POST['form_token'] );
                $elapsed = time() - $form_time;
                // Less than 3 seconds = likely bot
                if ( $elapsed < 3 ) {
                    wp_redirect( home_url() );
                    exit;
                }
            }

            // Spam content patterns check
            $spam_patterns = array(
                '/\[url=/i',
                '/\[link=/i',
                '/<a\s+href/i',
                '/https?:\/\/[^\s]+\s+https?:\/\//i', // Multiple URLs
                '/viagra|cialis|casino|lottery|cryptocurrency|bitcoin|crypto wallet/i',
                '/click here.*https?:\/\//i',
                '/dear\s+(sir|madam|friend)/i',
                '/\b(SEO|backlink|rank|traffic)\b.*\b(service|offer|guarantee)/i',
            );

            $check_fields = array(
                sanitize_text_field( $_POST['first_name'] ?? '' ),
                sanitize_text_field( $_POST['last_name'] ?? '' ),
                sanitize_textarea_field( $_POST['message'] ?? '' ),
            );

            $combined_content = implode( ' ', $check_fields );

            foreach ( $spam_patterns as $pattern ) {
                if ( preg_match( $pattern, $combined_content ) ) {
                    // Silently reject
                    wp_redirect( add_query_arg( 'contact_success', '1', wp_get_referer() ) );
                    exit;
                }
            }

            // Check for excessive URLs in message
            $url_count = preg_match_all( '/https?:\/\//i', $_POST['message'] ?? '' );
            if ( $url_count > 2 ) {
                wp_redirect( add_query_arg( 'contact_success', '1', wp_get_referer() ) );
                exit;
            }

            // Check for Cyrillic/non-Latin characters (common in spam)
            if ( preg_match( '/[\x{0400}-\x{04FF}]/u', $combined_content ) ) {
                wp_redirect( add_query_arg( 'contact_success', '1', wp_get_referer() ) );
                exit;
            }

            // reCAPTCHA v3 verification
            $recaptcha_secret = KPT_Utilities::get_option( 'kpt_recaptcha_secret_key' );
            if ( $recaptcha_secret && isset( $_POST['g-recaptcha-response'] ) ) {
                $recaptcha_response = sanitize_text_field( $_POST['g-recaptcha-response'] );
                $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
                
                $response = wp_remote_post( $verify_url, array(
                    'body' => array(
                        'secret' => $recaptcha_secret,
                        'response' => $recaptcha_response,
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    )
                ) );

                if ( ! is_wp_error( $response ) ) {
                    $response_body = json_decode( wp_remote_retrieve_body( $response ) );
                    if ( ! $response_body->success || $response_body->score < 0.7 ) {
                        wp_die( 'reCAPTCHA verification failed' );
                    }
                }
            }

            // Sanitize inputs
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
            $email = sanitize_email( $_POST['email'] );
            $phone = sanitize_text_field( $_POST['phone'] );
            $url = esc_url_raw( $_POST['url'] );
            $message = sanitize_textarea_field( $_POST['message'] );
            $privacy_consent = isset( $_POST['privacy_consent'] ) ? 1 : 0;

            // Validate required fields
            if ( empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $message ) || ! $privacy_consent ) {
                wp_die( 'Please fill in all required fields and accept the privacy policy' );
            }

            if ( ! is_email( $email ) ) {
                wp_die( 'Please provide a valid email address' );
            }

            // Create submission post
            $post_id = wp_insert_post( array(
                'post_type' => 'kpt_contact',
                'post_title' => $first_name . ' ' . $last_name,
                'post_status' => 'publish',
            ) );

            if ( $post_id ) {
                // Save meta data
                update_post_meta( $post_id, '_contact_first_name', $first_name );
                update_post_meta( $post_id, '_contact_last_name', $last_name );
                update_post_meta( $post_id, '_contact_email', $email );
                update_post_meta( $post_id, '_contact_phone', $phone );
                update_post_meta( $post_id, '_contact_url', $url );
                update_post_meta( $post_id, '_contact_message', $message );
                update_post_meta( $post_id, '_contact_ip', $_SERVER['REMOTE_ADDR'] );
                update_post_meta( $post_id, '_contact_user_agent', $_SERVER['HTTP_USER_AGENT'] );

                // Send email notification
                $to = get_option( 'admin_email' );
                $subject = 'New Contact Form Submission from ' . $first_name . ' ' . $last_name;
                $body = "New contact form submission:\n\n";
                $body .= "Name: {$first_name} {$last_name}\n";
                $body .= "Email: {$email}\n";
                $body .= "Phone: {$phone}\n";
                if ( $url ) {
                    $body .= "Website: {$url}\n";
                }
                $body .= "\nMessage:\n{$message}\n\n";
                $body .= "---\n";
                $body .= "View submission: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

                $headers = array(
                    'Content-Type: text/plain; charset=UTF-8',
                    'Reply-To: ' . $email
                );

                wp_mail( $to, $subject, $body, $headers );

                // Redirect with success message
                wp_redirect( add_query_arg( 'contact_success', '1', wp_get_referer() ) );
                exit;
            }

            wp_die( 'There was an error processing your submission. Please try again.' );
        }
    }
}
