<?php
/**
 * Template Name: Diversify County Revenue Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '1. Diversifying County Revenue';
$quote      = get_field( 'issue_quote' ) ?: '"We need to bring more money into Washington County — not take more out of our neighbors\' pockets." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'We can\'t keep balancing the budget on the backs of working families.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'Washington County relies too heavily on taxing residents to fund essential services. I will advocate for diversifying county revenue by pursuing grants, partnerships, and smart economic development that brings in outside dollars. This approach reduces pressure on community members while still investing in our schools, infrastructure, and public services.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'We deserve the opportunity to thrive. And rising costs make it hard for Washington County Residents to get ahead or even afford basic necessities.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I promise to put Washington County residents first, making sure their ability to afford basic necessities is at the forefront of all decisions I make. And I pledge to pursue alternative revenue sources to lift the financial burden from the shoulders of Washington County residents.';
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
