<?php
/**
 * Template Name: Investing in Community Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '7. Investing in Community Health & Wellbeing Through Grants';
$quote      = get_field( 'issue_quote' ) ?: '"Grants help us invest in people without raising taxes." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'A healthy community is a strong community.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'Strategic grant funding allows us to expand services without increasing the tax burden on residents. Services funded by the Washington County government ensure our infrastructure is maintained, our farmlands are protected, and our industry is supported.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'Grants are a viable means to fund and expand services offered by Washington County\'s government without increasing taxes.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I will focus on securing grants and outside funding to support public health, recreation, environmental health, and community wellbeing initiatives.';
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
