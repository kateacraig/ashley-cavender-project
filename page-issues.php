<?php
/**
 * Template Name: Issues Page
 */

get_header();

$page_title   = get_field( 'issues_page_title' ) ?: 'Issues';
$main_heading = get_field( 'issues_main_heading' ) ?: 'A Practical, Non-Partisan Voice for Our Community.';
$p1           = get_field( 'issues_intro_p1' );
$p2           = get_field( 'issues_intro_p2' );
$p3           = get_field( 'issues_intro_p3' );
$p4           = get_field( 'issues_intro_p4' );
$boxes        = get_field( 'issues_boxes' );

if ( ! $boxes ) {
    $boxes = array(
        array( 'box_number' => '1', 'box_heading' => 'Diversifying County Revenue',                                         'box_url' => home_url( '/diversify-county-revenue/#my-priorities' ),  'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '2', 'box_heading' => 'Smarter Open Space Planning with Community & Environmental Input',    'box_url' => home_url( '/smarter-space-planning/#my-priorities' ),     'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '3', 'box_heading' => 'Stronger Collaboration Between the School Board & County Commission', 'box_url' => home_url( '/stronger-collaboration/#my-priorities' ),    'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '4', 'box_heading' => 'Non-Partisan, Community-Centered Leadership',                        'box_url' => home_url( '/bipartisan-leadership/#my-priorities' ),     'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '5', 'box_heading' => 'Community Engagement & Service Beyond the Commission',                'box_url' => home_url( '/community-engagement/#my-priorities' ),      'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '6', 'box_heading' => 'Transparency in Budgeting & Long-Term Forecasting',                  'box_url' => home_url( '/transparency-in-budget/#my-priorities' ),   'box_btn_text' => 'Learn More' ),
        array( 'box_number' => '7', 'box_heading' => 'Investing in Community Health & Wellbeing Through Grants',            'box_url' => home_url( '/investing-in-community/#my-priorities' ),   'box_btn_text' => 'Learn More' ),
    );
}
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
                    <h2><?php echo esc_html( $main_heading ); ?></h2>
                    <?php if ( $p1 ) : ?><p><?php echo wp_kses_post( $p1 ); ?></p><?php endif; ?>
                    <?php if ( $p2 ) : ?><p><?php echo wp_kses_post( $p2 ); ?></p><?php endif; ?>
                    <?php if ( $p3 ) : ?><p><?php echo wp_kses_post( $p3 ); ?></p><?php endif; ?>
                    <?php if ( $p4 ) : ?><p><?php echo wp_kses_post( $p4 ); ?></p><?php endif; ?>

                    <div class="issues-boxes">
                        <div class="issues-boxes-grid">
                            <?php foreach ( $boxes as $box ) : ?>
                            <div class="issue-box-grid-item">
                                <h4><?php echo esc_html( $box['box_number'] ); ?></h4>
                                <div class="issue-text">
                                    <h3><?php echo esc_html( $box['box_heading'] ); ?></h3>
                                </div>
                                <a href="<?php echo esc_url( $box['box_url'] ); ?>"><?php echo esc_html( $box['box_btn_text'] ?: 'Learn More' ); ?></a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
