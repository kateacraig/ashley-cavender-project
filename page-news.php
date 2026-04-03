<?php
/**
 * Template Name: News Page
 *
 * Displays WordPress posts (blog) as a news listing.
 * Categories at top (max 8, 4 per row, max 2 rows).
 * Posts grid: 3 per row, 10 per page, featured image,
 * title, date, 1-sentence excerpt, Read More button.
 * All fonts: body font.
 */
 
get_header();
 
$page_title   = get_field( 'news_page_title' ) ?: 'News';
$news_heading = get_field( 'news_heading' ) ?: 'Campaign News';
?>
 
<section class="about-header">
    <h1><?php echo esc_html( $page_title ); ?></h1>
</section>
 
</section><!-- /.background-image.nav-header opened in header.php -->
 
<section class="news-ashley">
    <div class="container">
        <div class="news-ashley-text">
 
            <h2><?php echo esc_html( $news_heading ); ?></h2>
 
            <h3>Categories</h3>
            <?php
            // Categories — max 8, 4 per row, max 2 rows
            $categories = get_categories( array(
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => true,
                'number'     => 8,
            ) );
 
            if ( ! empty( $categories ) ) : ?>
                <div class="ac-news-categories">
                    <?php foreach ( $categories as $category ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="ac-news-category-link">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
 
            <?php
            $paged      = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
            $news_query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => 10,
                'paged'          => $paged,
                'post_status'    => 'publish',
            ) );
            ?>
 
            <h3 class="news-ashley-text-posts">Posts</h3>
            <?php if ( $news_query->have_posts() ) : ?>
 
                <div class="ac-news-grid">
                    <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
 
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
 
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
 
                <?php if ( $news_query->max_num_pages > 1 ) : ?>
                    <div class="ac-news-pagination">
                        <?php
                        echo paginate_links( array(
                            'total'     => $news_query->max_num_pages,
                            'current'   => $paged,
                            'prev_text' => '&larr; Newer',
                            'next_text' => 'Older &rarr;',
                        ) );
                        ?>
                    </div>
                <?php endif; ?>
 
            <?php else : ?>
 
                <p class="ac-news-empty">No posts yet. Check back soon!</p>
 
            <?php endif; ?>
 
        </div><!-- /.news-ashley-text -->
    </div><!-- /.container -->
</section>
 
<?php get_footer(); ?>