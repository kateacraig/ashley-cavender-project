<?php
/**
 * Template Name: Bipartisan Leadership Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '4. Non-Partisan, Community-Centered Leadership';
$quote      = get_field( 'issue_quote' ) ?: '"Good ideas don\'t belong to one party — they belong to our community." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'County government shouldn\'t be about party politics — it should be about people.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'I\'m non-partisan by nature and committed to working with anyone who wants to move Washington County forward. I believe in listening to different perspectives, finding common ground, and focusing on practical solutions instead of political labels.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'We are all Washington County and deserve leadership who don\'t see us as party identifiers but instead as community members.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I promise to put the people I serve in Washington County ahead of partisan politics. I pledge to listen, coordinate, and collaborate with anyone willing to come to the table and share ideas. I pledge to serve every Washington County resident.';
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
