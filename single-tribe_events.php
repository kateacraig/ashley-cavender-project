<?php
/**
 * Template for single The Events Calendar event pages.
 * Matches the Events page design: same background, same gray box,
 * event title replaces "Upcoming Events", details inside the gray box.
 */

get_header();

// Gather event data
$start_date    = tribe_get_start_date( null, false, 'F j, Y' );
$start_time    = tribe_get_start_date( null, false, 'g:i A' );
$end_date      = tribe_get_end_date( null, false, 'F j, Y' );
$end_time      = tribe_get_end_date( null, false, 'g:i A' );
$venue_name    = tribe_get_venue();
$venue_address = tribe_get_full_address();
$description   = get_the_content();
$event_url     = tribe_get_event_website_url();
$same_day      = ( $start_date === $end_date );
$events_page   = get_page_by_path( 'events' );
$events_url    = $events_page ? get_permalink( $events_page->ID ) : home_url( '/events/' );
?>

<section class="about-header">
    <h1>Events</h1>
</section>

</section><!-- /.background-image.nav-header opened in header.php -->

<section class="events-ashley">
    <div class="container">
        <div class="events-ashley-text">

            <h2><?php the_title(); ?></h2>

            <div class="ac-single-event">

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

                <?php if ( $description ) : ?>
                    <div class="ac-single-event-description">
                        <?php echo wp_kses_post( apply_filters( 'the_content', $description ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="ac-single-event-actions">
                    <?php if ( $event_url ) : ?>
                        <a href="<?php echo esc_url( $event_url ); ?>" class="ac-event-btn" target="_blank" rel="noopener noreferrer">More Info</a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $events_url ); ?>" class="ac-event-btn ac-event-btn-back">&larr; All Events</a>
                </div>

            </div>

        </div><!-- /.events-ashley-text -->
    </div><!-- /.container -->
</section>

<?php get_footer(); ?>