<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main style="padding: 5rem 2rem; text-align: center; font-family: 'Inter', sans-serif;">
    <h1 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #111;">Bolly Shampoo</h1>
    <p>Please visit the <a href="<?php echo esc_url( home_url( '/bolly' ) ); ?>">Bolly Interactive Landing Page</a>.</p>
</main>

<?php
get_footer();
?>
