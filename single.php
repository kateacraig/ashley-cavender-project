<?php
/**
 * Single Post Template
 *
 * Matches the Events/News page design: same background,
 * same gray box. Post title replaces section heading,
 * full content inside the gray box.
 */

get_header();

$news_page  = get_page_by_path( 'news' );
$news_url   = $news_page ? get_permalink( $news_page->ID ) : home_url( '/news/' );
?>

<section class="about-header">
    <h1>News</h1>
</section>

</section><!-- /.background-image.nav-header opened in header.php -->

<section class="news-ashley">
    <div class="container">
        <div class="news-ashley-text">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <h2><?php the_title(); ?></h2>

                <div class="ac-single-post">

                    <p class="ac-news-card-date"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></p>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="ac-single-post-image">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'ac-single-post-thumbnail' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="ac-single-post-content">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    // Display tags if any
                    $tags = get_the_tags();
                    if ( $tags ) : ?>
                        <div class="ac-single-post-tags">
                            <span class="ac-tags-label">Tags:</span>
                            <?php foreach ( $tags as $tag ) : ?>
                                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="ac-tag-link">
                                    <?php echo esc_html( $tag->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="ac-single-event-actions">
                        <a href="<?php echo esc_url( $news_url ); ?>" class="ac-event-btn ac-event-btn-back">&larr; All News</a>
                    </div>

                </div>

            <?php endwhile; endif; ?>

        </div><!-- /.news-ashley-text -->
    </div><!-- /.container -->
</section>

<?php get_footer(); ?>