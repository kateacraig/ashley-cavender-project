<?php
/**
 * index.php — WordPress fallback template.
 *
 * Required by WordPress. Used only if no other template matches.
 * All pages in this theme use explicit page templates, so this
 * file should rarely (if ever) be triggered in production.
 */

get_header();
?>

    <section class="about-header">
        <h1><?php the_title(); ?></h1>
    </section>

</section><!-- /.background-image.nav-header -->

<section style="padding: 100px 0;">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </div>
</section>

<?php get_footer(); ?>
