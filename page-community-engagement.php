<?php
/**
 * Template Name: Community Engagement Page
 */

get_header();

$page_title = get_field( 'issues_page_title' ) ?: 'Issues';
$heading    = get_field( 'issue_heading' ) ?: '5. Community Engagement & Service Beyond the Commission';
$quote      = get_field( 'issue_quote' ) ?: '"You shouldn\'t have to know the right person to serve — your community should make room for you." - Ashley Cavender';
$p1         = get_field( 'issue_paragraph_1' ) ?: 'Representation doesn\'t stop at the commission table — it grows when more people have a seat at the table.';
$p2         = get_field( 'issue_paragraph_2' ) ?: 'We can all benefit from increasing and varying the voices around the table. A good idea becomes a great idea when we collaborate together. So many in our community have experience and expertise that can enable the Washington County Commission to make better, community-focused decisions.';
$p3         = get_field( 'issue_paragraph_3' ) ?: 'Our community is strongest when decision-making bodies reflect the people they impact.';
$if_elected = get_field( 'issue_if_elected' ) ?: 'If elected, I promise to help Washington County residents access opportunities to serve on local boards and committees, share information about openings, and lower barriers to participation. I pledge to use my role to open doors, amplify voices, and make civic service accessible to everyone.';
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
