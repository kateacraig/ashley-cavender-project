<?php
/**
 * Template Name: About Page
 */

get_header();

$page_title     = get_field( 'about_page_title' ) ?: 'About Ashley';
$main_image     = get_field( 'about_main_image' );
$main_img_url   = $main_image ? esc_url( $main_image['url'] ) : esc_url( get_template_directory_uri() . '/images/about-images/ashley-and-banjo.jpg' );
$main_img_alt   = $main_image ? esc_attr( $main_image['alt'] ) : 'Ashley Cavender and her dog Banjo';
$greeting       = get_field( 'about_greeting' ) ?: "It's nice to meet you!";
$p1             = get_field( 'about_paragraph_1' ) ?: 'I was born and raised in East Tennessee and chose to build my life in Jonesborough after graduating from East Tennessee State University in 2015. I began my career with Jonesborough Locally Grown at Boone Street Market, and it\'s here in Washington County that my values feel most alive. This isn\'t just where I live — it\'s where I\'ve invested my time, energy, and heart.';
$p2             = get_field( 'about_paragraph_2' ) ?: 'I serve as Director of Equitable Nutrition & Food Access with the Appalachian Resource Conservation & Development Council, supporting conservation, local agriculture, and community-based initiatives. I currently chair Keep Jonesborough Beautiful and am active with Slow Food Tri-Cities. I\'ve also contributed to long-range planning through Johnson City Horizon 2045 and supported affordable housing efforts with Unity Housing.';
$p3             = get_field( 'about_paragraph_3' ) ?: 'My time with One Acre Cafe deepened my commitment to food access with dignity. I\'ve volunteered with community events like Meet the Mountains and Blue Plum Festival, celebrating our region\'s culture and local businesses.';
$p4             = get_field( 'about_paragraph_4' ) ?: 'Outside of work, you\'ll find me gardening, hiking Northeast Tennessee trails, or near the water with my Jack Russell, Banjo. I care deeply about smart land use, healthy waterways, local food, and civic engagement — and I believe County Commission decisions should protect the land, water, and quality of life we pass on to the next generation.';
$carousel_heading = get_field( 'about_carousel_heading' ) ?: 'I love our Jonesborough community!';
$carousel_bg    = get_field( 'about_carousel_bg' );
$carousel_bg_url = $carousel_bg ? esc_url( $carousel_bg['url'] ) : esc_url( get_template_directory_uri() . '/images/carousel-background-jonesborough.jpeg' );
$slides         = get_field( 'about_carousel_slides' );
?>

    <section class="about-header">
        <h1><?php echo esc_html( $page_title ); ?></h1>
    </section>

</section><!-- /.background-image.nav-header -->

<!-- About Body -->
<section class="about-ashley">
    <div class="container">
        <div class="about-ashley-grid">
            <div class="about-ashley-grid-item about-photos">
                <div class="about-ashley-photos">
                    <img src="<?php echo $main_img_url; ?>" alt="<?php echo $main_img_alt; ?>" />
                </div>
            </div>
            <div class="about-ashley-grid-item">
                <h3><?php echo esc_html( $greeting ); ?></h3>
                <?php if ( $p1 ) : ?><p><?php echo wp_kses_post( $p1 ); ?></p><?php endif; ?>
                <?php if ( $p2 ) : ?><p><?php echo wp_kses_post( $p2 ); ?></p><?php endif; ?>
                <?php if ( $p3 ) : ?><p><?php echo wp_kses_post( $p3 ); ?></p><?php endif; ?>
                <?php if ( $p4 ) : ?><p><?php echo wp_kses_post( $p4 ); ?></p><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Carousel Section -->
<section class="candidate-slider" style="background-image: linear-gradient(rgba(194,191,191,0.6), rgba(26,26,47,0.4), rgba(8,8,45,0.4), rgba(1,1,22,0.4)), url('<?php echo $carousel_bg_url; ?>'); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="candidate-header">
            <h2 class="text-center"><?php echo esc_html( $carousel_heading ); ?></h2>
        </div>
        <div class="carousel-background">
            <div class="carousel candidate-carousel">
                <div class="carousel-slides" id="candidateCarouselSlides">
                    <?php if ( $slides ) : ?>
                        <?php foreach ( $slides as $slide ) :
                            $img     = $slide['slide_image'];
                            $img_url = $img ? esc_url( $img['url'] ) : '';
                            $img_alt = $slide['slide_alt'] ? esc_attr( $slide['slide_alt'] ) : ( $img ? esc_attr( $img['alt'] ) : '' );
                            if ( ! $img_url ) continue;
                        ?>
                        <div class="carousel-slide carousel-candidate-slide">
                            <div class="carousel-placeholder">
                                <div class="carousel-placeholder-icon">
                                    <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <!-- Fallback: default slides -->
                        <?php
                        $default_slides = array(
                            array( 'img' => 'ashley-jonesborough-beautiful.jpg', 'alt' => 'Ashley Cavender volunteering to keep Jonesborough beautiful.' ),
                            array( 'img' => 'ashley-small-business.jpg', 'alt' => 'Ashley Cavender with an award supporting small businesses.' ),
                            array( 'img' => 'ashley-farm-table.jpg', 'alt' => 'Ashley Cavender volunteering at the Farm to Table dinner.' ),
                            array( 'img' => 'ashley-river.jpeg', 'alt' => 'Ashley Cavender standing in front of a river.' ),
                            array( 'img' => 'ashley-play.jpg', 'alt' => 'Ashley Cavender in a play surrounded by other actors.' ),
                            array( 'img' => 'ashley-green.jpg', 'alt' => "Ashley Cavender wearing green for a St. Patrick's Day event." ),
                            array( 'img' => 'ashley-farmers-market.jpg', 'alt' => "Ashley Cavender holding Banjo at the Jonesborough Farmer's Market." ),
                            array( 'img' => 'ashley-working-farmers-market.jpeg', 'alt' => "Ashley Cavender working at the Jonesborough Farmer's Market." ),
                            array( 'img' => 'ashley-schools.jpeg', 'alt' => 'Ashley Cavender working a pop-up market at Washington County Schools.' ),
                            array( 'img' => 'ashley-solo.jpg', 'alt' => 'Ashley Cavender in a Jonesborough Community Play.' ),
                        );
                        foreach ( $default_slides as $ds ) : ?>
                        <div class="carousel-slide carousel-candidate-slide">
                            <div class="carousel-placeholder">
                                <div class="carousel-placeholder-icon">
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/about-images/' . $ds['img'] ); ?>" alt="<?php echo esc_attr( $ds['alt'] ); ?>" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
