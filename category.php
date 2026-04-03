<?php
/**
 * Category Archive Template
 *
 * Displays all posts in a category.
 * Matches the News page design: same background, same gray box.
 * Category name replaces the section heading.
 */

get_header();

$news_page = get_page_by_path( 'news' );
$news_url  = $news_page ? get_permalink( $news_page->ID ) : home_url( '/news/' );
$category  = get_queried_object();
?>

<section class="about-header">
    <h1>News</h1>
</section>

</section><!-- /.background-image.nav-header opened in header.php -->

<section class="news-ashley news-ashley-categories-page">
    <div class="container">
        <div class="news-ashley-text">

            <h2><?php echo esc_html( $category->name ); ?></h2>

            <?php if ( have_posts() ) : ?>

                <div class="ac-news-grid">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <div class="ac-news-card">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ac-news-card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium', array( 'class' => 'ac-news-thumbnail' ) ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="ac-news-card-content">
                                <h3 class="ac-news-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="ac-news-card-date"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></p>
                                <p class="ac-news-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="ac-event-btn ac-news-read-more">Read More</a>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>

                <?php
                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
                    <div class="ac-news-pagination">
                        <?php
                        echo paginate_links( array(
                            'total'     => $GLOBALS['wp_query']->max_num_pages,
                            'current'   => $paged,
                            'prev_text' => '&larr; Newer',
                            'next_text' => 'Older &rarr;',
                        ) );
                        ?>
                    </div>
                <?php endif; ?>

            <?php else : ?>

                <p class="ac-news-empty">No posts found in this category.</p>

            <?php endif; ?>

            <div class="ac-single-event-actions" style="margin-top: 2rem;">
                <a href="<?php echo esc_url( $news_url ); ?>" class="ac-event-btn ac-event-btn-back">&larr; All News</a>
            </div>

        </div><!-- /.news-ashley-text -->
    </div><!-- /.container -->
</section>

<?php get_footer(); ?>