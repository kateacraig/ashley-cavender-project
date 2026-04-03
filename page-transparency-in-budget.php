<?php
/**
 * Template Name: Transparency in Budget Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '6. Transparency in Budgeting & Long-Term Forecasting';
$quote      = get_field( 'issue_quote' ) ?: '"If we can\'t explain the budget, we haven\'t done our job." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'Taxpayers deserve clear, honest explanations.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'Any Washington County resident should be able to read and understand Washington County\'s budget. This includes having plain language explanations and clear forecasting.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'Residents should understand not only what we\'re funding, but why — and what it means for the future.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I pledge to ensure that Washington County\'s budget includes plain language regarding how tax dollars are spent and clear forecasting to understand the county\'s financial health.';
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
