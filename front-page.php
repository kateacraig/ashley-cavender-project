<?php
/**
 * Template Name: Home Page
 * Front page template for Ashley Cavender campaign website.
 */

get_header();
?>

    <section class="hero">
        <div class="container">
            <div class="hero-grid">

                <!-- Desktop Countdown -->
                <div class="hero-countdown-clock">
                    <div class="countdown-container">
                        <h2 class="text-left"><?php echo esc_html( get_field( 'countdown_label' ) ?: 'Days till Election Day' ); ?></h2>
                        <div class="countdown-wrapper mt-4">
                            <div class="countdown-grid">
                                <div class="countdown-box">
                                    <span class="countdown-number" id="days">00</span>
                                    <span class="countdown-label">Days</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="hours">00</span>
                                    <span class="countdown-label">Hours</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="minutes">00</span>
                                    <span class="countdown-label">Minutes</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="seconds">00</span>
                                    <span class="countdown-label">Seconds</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Name -->
                <div class="hero-name">
                    <?php
                    $first_name = get_field( 'hero_first_name' ) ?: 'Ashley';
                    $last_name  = get_field( 'hero_last_name' ) ?: 'Cavender';
                    $position   = get_field( 'hero_position' ) ?: 'Washington County Commission District 3';
                    $oak_leaf   = get_field( 'hero_oak_leaf' );
                    $oak_url    = $oak_leaf ? esc_url( $oak_leaf['url'] ) : esc_url( get_template_directory_uri() . '/images/oak-leaf.png' );
                    $oak_alt    = $oak_leaf ? esc_attr( $oak_leaf['alt'] ) : 'Oak Leaf graphic';
                    ?>
                    <h1>
                        <div><?php echo esc_html( $first_name ); ?></div>
                        <div class="hero-last-name"><?php echo esc_html( $last_name ); ?></div>
                    </h1>
                    <h2>
                        <span>Washington County Commission
                            <span><img src="<?php echo $oak_url; ?>" alt="<?php echo $oak_alt; ?>" class="hero-oak-leaf" /></span>
                            District 3
                        </span>
                    </h2>
                </div>

                <!-- Mobile Countdown -->
                <div class="hero-countdown-clock-mobile">
                    <div class="countdown-container">
                        <h2 class="text-left"><?php echo esc_html( get_field( 'countdown_label' ) ?: 'Days till Election Day' ); ?></h2>
                        <div class="countdown-wrapper mt-4">
                            <div class="countdown-grid">
                                <div class="countdown-box">
                                    <span class="countdown-number" id="days-mobile">00</span>
                                    <span class="countdown-label">Days</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="hours-mobile">00</span>
                                    <span class="countdown-label">Hours</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="minutes-mobile">00</span>
                                    <span class="countdown-label">Minutes</span>
                                </div>
                                <div class="countdown-box">
                                    <span class="countdown-number" id="seconds-mobile">00</span>
                                    <span class="countdown-label">Seconds</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</section><!-- /.background-image.nav-header (opened in header.php) -->

<!-- Slogan Section -->
<?php
$slogan_bg      = get_field( 'slogan_bg_image' );
$slogan_bg_url  = $slogan_bg ? esc_url( $slogan_bg['url'] ) : esc_url( get_template_directory_uri() . '/images/downtown-jonesborough.jpg' );
$headshot       = get_field( 'slogan_headshot' );
$headshot_url   = $headshot ? esc_url( $headshot['url'] ) : esc_url( get_template_directory_uri() . '/images/ashley-banjo-headshot.jpg' );
$headshot_alt   = $headshot ? esc_attr( $headshot['alt'] ) : 'Ashley Cavender headshot';
$quote          = get_field( 'slogan_quote' ) ?: '"We deserve someone who will protect our land and put the citizens first. I\'ve been showing up for Jonesborough through my work and service.<br /><br />Now I\'m asking for your vote on August 6 to continue serving our community as District 3\'s representative on the Washington County Commission."';
$attribution    = get_field( 'slogan_attribution' ) ?: '-Ashley Cavender';
$tagline        = get_field( 'slogan_tagline' ) ?: 'Rooted here. Protecting our land. Serving our community, always.';
$vol_label      = get_field( 'slogan_volunteer_label' ) ?: 'Sign up to volunteer';
$vol_btn_text   = get_field( 'slogan_volunteer_btn_text' ) ?: 'Volunteer';
$vol_btn_url    = get_field( 'slogan_volunteer_btn_url' ) ?: 'https://forms.gle/DQeMieEwQsRafqx2A';
$don_label      = get_field( 'slogan_donate_label' ) ?: 'Donate to the campaign';
$don_btn_text   = get_field( 'slogan_donate_btn_text' ) ?: 'Donate';
$don_btn_url    = get_field( 'slogan_donate_btn_url' ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
?>

<section class="slogan-section" style="background-image: linear-gradient(rgba(255,255,255,0.3), rgba(0,0,0,0.7)), url('<?php echo $slogan_bg_url; ?>'); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="slogan-ashley-grid">
            <div class="slogan-ashley-grid-item">
                <img src="<?php echo $headshot_url; ?>" alt="<?php echo $headshot_alt; ?>" />
            </div>
            <div class="slogan-ashley-grid-item slogan-ashley-grid-item-text">
                <div class="ashley-quote">
                    <h3><?php echo wp_kses_post( $quote ); ?></h3>
                    <h4><?php echo esc_html( $attribution ); ?></h4>
                    <div class="slogan">
                        <h2><?php echo esc_html( $tagline ); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="slogan-grid">
            <div class="slogan-grid-item">
                <h3 class="text-center slogan-grid-item-yellow"><?php echo esc_html( $vol_label ); ?></h3>
                <a href="<?php echo esc_url( $vol_btn_url ); ?>" class="btn-volunteer-slogan" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $vol_btn_text ); ?></a>
            </div>
            <div class="slogan-grid-item">
                <h3 class="text-center slogan-grid-item-purple"><?php echo esc_html( $don_label ); ?></h3>
                <a href="<?php echo esc_url( $don_btn_url ); ?>" class="btn-donate-slogan" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $don_btn_text ); ?></a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
