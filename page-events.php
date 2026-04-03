<?php
/**
 * Template Name: Events Page
 *
 * Displays campaign events using The Events Calendar plugin (StellarWP).
 * List view only, 10 events per page, past and future events shown.
 * Structure matches original events.html exactly.
 */

get_header();

$page_title     = get_field( 'events_page_title' ) ?: 'Events';
$events_heading = get_field( 'events_heading' ) ?: 'Upcoming Events';
$events_subtext = get_field( 'events_subtext' ) ?: 'Join Ashley at an upcoming event! If you\'d like to volunteer at one, email <a href="mailto:ashleycforcounty@gmail.com">ashleycforcounty@gmail.com</a>.';
?>

<section class="about-header">
    <h1><?php echo esc_html( $page_title ); ?></h1>
</section>

</section><!-- /.background-image.nav-header opened in header.php -->

<section class="events-ashley">
    <div class="container">
        <div class="events-ashley-text">

            <h2><?php echo esc_html( $events_heading ); ?></h2>
            

            <?php if ( class_exists( 'Tribe__Events__Main' ) ) : ?>

                <?php
                $paged        = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $events_query = new WP_Query( array(
                    'post_type'      => 'tribe_events',
                    'posts_per_page' => 10,
                    'paged'          => $paged,
                    'post_status'    => 'publish',
                    'orderby'        => 'meta_value',
                    'meta_key'       => '_EventStartDate',
                    'order'          => 'ASC',
                ) );
                ?>

                <?php if ( $events_query->have_posts() ) : ?>

                    <div class="ac-events-list">

                        <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>

                            <?php
                            $start_date    = tribe_get_start_date( null, false, 'F j, Y' );
                            $start_time    = tribe_get_start_date( null, false, 'g:i A' );
                            $end_date      = tribe_get_end_date( null, false, 'F j, Y' );
                            $end_time      = tribe_get_end_date( null, false, 'g:i A' );
                            $venue_name    = tribe_get_venue();
                            $venue_address = tribe_get_full_address();
                            $event_url     = tribe_get_event_website_url();
                            $same_day      = ( $start_date === $end_date );
                            ?>

                            <div class="ac-event-card">
                                <div class="ac-event-date">
                                    <span class="ac-event-month"><?php echo esc_html( tribe_get_start_date( null, false, 'M' ) ); ?></span>
                                    <span class="ac-event-day"><?php echo esc_html( tribe_get_start_date( null, false, 'j' ) ); ?></span>
                                    <span class="ac-event-year"><?php echo esc_html( tribe_get_start_date( null, false, 'Y' ) ); ?></span>
                                </div>
                                <div class="ac-event-details">
                                    <h3 class="ac-event-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p class="ac-event-time">
                                        <?php if ( $same_day ) : ?>
                                            <?php echo esc_html( $start_date . ' · ' . $start_time . ' – ' . $end_time ); ?>
                                        <?php else : ?>
                                            <?php echo esc_html( $start_date . ' ' . $start_time . ' – ' . $end_date . ' ' . $end_time ); ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php if ( $venue_name ) : ?>
                                        <p class="ac-event-venue">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo esc_html( $venue_name ); ?>
                                            <?php if ( $venue_address ) : ?>
                                                &mdash; <?php echo esc_html( $venue_address ); ?>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ( get_the_excerpt() ) : ?>
                                        <p class="ac-event-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                                    <?php endif; ?>
                                    <div class="ac-event-actions">
                                        <a href="<?php the_permalink(); ?>" class="ac-event-btn">Event Details</a>
                                        <?php if ( $event_url ) : ?>
                                            <a href="<?php echo esc_url( $event_url ); ?>" class="ac-event-btn ac-event-btn-secondary" target="_blank" rel="noopener noreferrer">More Info</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; wp_reset_postdata(); ?>

                    </div>

                    <?php if ( $events_query->max_num_pages > 1 ) : ?>
                        <div class="ac-events-pagination">
                            <?php
                            echo paginate_links( array(
                                'total'     => $events_query->max_num_pages,
                                'current'   => $paged,
                                'prev_text' => '&larr; Newer Events',
                                'next_text' => 'Older Events &rarr;',
                            ) );
                            ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>

                    <p class="ac-events-empty">No events scheduled right now. Check back soon!</p>

                <?php endif; ?>

            <?php else : ?>

                <p class="ac-events-empty">Events coming soon &mdash; check back shortly!</p>

            <?php endif; ?>

        </div><!-- /.events-ashley-text -->
    </div><!-- /.container -->
</section>

<?php get_footer(); ?>