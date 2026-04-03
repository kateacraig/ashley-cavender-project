<?php
/**
 * Template Name: Smarter Space Planning Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '2. Smarter Open Space Planning with Community & Environmental Input';
$quote      = get_field( 'issue_quote' ) ?: '"Good planning today saves taxpayers money tomorrow — and protects what makes our community home." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'Growth should strengthen our community, not overwhelm it.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'I support thoughtful open space planning that includes public input, protects natural resources, and respects the character of our rural and residential areas. Decisions about development should consider long-term impacts on water quality, flooding, infrastructure, and quality of life.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'Washington County is special and as stewards of this land, we should do all we can to protect it for us and future generations.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I promise to be a good steward of our land and to ensure the needs of industries vying to open in Washington County don\'t outweigh the health of Washington County residents or the protection of the land we have been entrusted. I promise to uplift our farmers and protect the land they work.';
?>

    <section class="about-header">
        <h1><?php echo esc_html( $page_title ); ?></h1>
    </section>

</section><!-- /.background-image.nav-header -->

<section class="issues-ashley">
    <div class="container">
        <div class="issues-ashley-text-box">
            <div class="issues-header-grid">

                <!-- Desktop Sidebar -->
                <div class="issues-header-grid-item issues-header-grid-item-links" id="my-priorities">
                    <?php ac_render_sidebar_links(); ?>
                </div>

                <!-- Main Content -->
                <div class="issues-header-grid-item">
                    <h2><?php echo esc_html( $heading ); ?></h2>
                    <div class="issues-quote">
                        <p><?php echo wp_kses_post( $quote ); ?></p>
                    </div>
                    <p><?php echo wp_kses_post( $p1 ); ?></p>
                    <p><?php echo wp_kses_post( $p2 ); ?></p>
                    <p><?php echo wp_kses_post( $p3 ); ?></p>
                    <div class="if-elected">
                        <p><?php echo wp_kses_post( $if_elected ); ?></p>
                    </div>
                </div>

                <!-- Mobile Sidebar -->
                <div class="issues-header-grid-item issues-header-grid-item-links issues-header-grid-item-mobile">
                    <?php ac_render_sidebar_links(); ?>
                </div>

            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
