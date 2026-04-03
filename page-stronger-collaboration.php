<?php
/**
 * Template Name: Stronger Collaboration Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '3. Stronger Collaboration Between the School Board & County Commission';
$quote      = get_field( 'issue_quote' ) ?: '"When the County Commission and School Board pull in the same direction, our schools are stronger." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'Our kids benefit when local leaders work together.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'Our students, educators, and community deserve well-funded schools and the support they need to be successful. This means increasing communication between the Washington County Commission and the Washington County School Board.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'Increased coordination leads to clearer budgeting, stronger long-term planning, and better outcomes for students, educators, and families.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I promise to improve communication and collaboration between the County Commission and the Washington County School Board. Better coordination leads to clearer budgeting, stronger long-term planning, and better outcomes for students, educators, and families.';
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
