<?php
/**
 * Template Name: Site Settings
 *
 * Admin-only page. Stores all site-wide ACF fields:
 * header/nav settings, issues sidebar links, and footer content.
 *
 * This page should be:
 *   - Created in the WordPress admin as a Page titled "Site Settings"
 *   - Slug set to: site-settings
 *   - Template set to: Site Settings
 *   - NOT added to any navigation menu
 *   - Visibility set to Private (visible to admins only)
 *
 * No frontend output — this template exists solely to hold ACF field groups.
 */

// Block any frontend access — redirect to home if not logged in as admin.
if ( ! current_user_can( 'manage_options' ) ) {
    wp_redirect( home_url( '/' ) );
    exit;
}

get_header();
?>

    <section class="about-header">
        <h1>Site Settings</h1>
    </section>

</section><!-- /.background-image.nav-header -->

<section style="padding: 80px 0;">
    <div class="container">
        <p style="font-family: var(--font-body); font-size: 1.2rem; text-align: center;">
            This page stores site-wide settings managed through ACF fields below.<br />
            It has no public frontend — edit fields in the panel below and save.
        </p>
    </div>
</section>

<?php get_footer(); ?>
