<?php
/**
 * Plugin Name: Bolly 3D Product Showcase
 * Plugin URI: https://github.com/bolly/shampoo
 * Description: Renders an interactive 3D shampoo bottle for the Bolly landing page using Three.js.
 * Version: 1.0.0
 * Author: DeepMind Antigravity
 * Author URI: https://deepmind.google/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register and enqueue plugin assets.
 */
function bolly_3d_enqueue_assets() {
    // 1. Enqueue Three.js from cdnjs
    wp_enqueue_script( 'three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), 'r128', true );

    // 2. Enqueue custom 3D bottle script with cache-busting timestamp
    wp_enqueue_script( 
        'bolly-3d-script', 
        plugins_url( 'assets/js/bolly-3d-v2.js', __FILE__ ), 
        array( 'three-js' ), 
        time(), 
        true 
    );

    // 3. Enqueue custom styling for the 3D canvas
    wp_enqueue_style( 
        'bolly-3d-style', 
        plugins_url( 'assets/css/bolly-3d.css', __FILE__ ), 
        array(), 
        '1.0.0' 
    );
}
add_action( 'wp_enqueue_scripts', 'bolly_3d_enqueue_assets' );

/**
 * Shortcode to render the 3D product showcase.
 * Usage: [bolly_3d_product]
 */
function bolly_3d_product_shortcode() {
    ob_start();
    ?>
    <div class="bolly-3d-container" id="bolly-3d-bottle-viewer">
        <div class="bolly-3d-loader">
            <div class="spinner"></div>
            <p>Loading 3D Experience...</p>
        </div>
        <div class="bolly-3d-drag-hint">
            <span class="icon">↔</span> Drag to rotate
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'bolly_3d_product', 'bolly_3d_product_shortcode' );
