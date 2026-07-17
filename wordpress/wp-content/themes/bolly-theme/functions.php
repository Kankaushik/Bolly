<?php
/**
 * Bolly Theme functions and definitions
 */

if ( ! function_exists( 'bolly_theme_setup' ) ) {
    function bolly_theme_setup() {
        // Add support for custom logo
        add_theme_support( 'custom-logo' );
        // Add support for document title tag
        add_theme_support( 'title-tag' );
        // Enable support for Post Thumbnails on posts and pages
        add_theme_support( 'post-thumbnails' );
    }
}
add_action( 'after_setup_theme', 'bolly_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function bolly_theme_scripts() {
    // Load Inter and Outfit fonts from Google Fonts
    wp_enqueue_style( 'bolly-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@1,400;1,600&display=swap', array(), null );
    
    // Load main theme stylesheet
    wp_enqueue_style( 'bolly-theme-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'bolly_theme_scripts' );

/**
 * Disable WordPress Admin Bar on the front end for an immersive landing page.
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Custom Login Page Branding
 */
function bolly_login_logo() {
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('/wp-content/plugins/bolly-3d-product/assets/images/bolly-shampoo-render.png');
            height: 140px;
            width: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 10px;
        }
        body.login {
            background-color: #f2f0f7 !important;
        }
        body.login #loginform {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(18, 19, 28, 0.05);
            border: 1px solid rgba(18, 19, 28, 0.06);
        }
        body.login .button-primary {
            background: #8c88f9 !important;
            border-color: #8c88f9 !important;
            text-shadow: none !important;
            box-shadow: none !important;
            font-weight: 700 !important;
        }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'bolly_login_logo' );

function bolly_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'bolly_login_logo_url' );

function bolly_login_logo_url_title() {
    return 'bolly - Premium Haircare';
}
add_filter( 'login_headertext', 'bolly_login_logo_url_title' );
