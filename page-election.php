<?php
/**
 * Template Name: Election Page
 *
 * Note: The early voting modal must render BEFORE <body> per original HTML.
 * We hook it into wp_body_open to fire immediately after <body> opens.
 * If the active theme/WP version does not fire wp_body_open, the modal
 * is output at the top of the page content as the closest equivalent.
 */

// Collect all ACF fields up front
$page_title         = get_field( 'election_page_title' ) ?: 'Election';
$modal_image        = get_field( 'election_modal_image' );
$modal_img_url      = $modal_image ? esc_url( $modal_image['url'] ) : esc_url( get_template_directory_uri() . '/images/early-voting-locations.png' );
$modal_img_alt      = $modal_image ? esc_attr( $modal_image['alt'] ) : 'Early Voting Locations';

$eday_heading       = get_field( 'election_day_heading' ) ?: 'Election Day - August 6!';
$eday_subtext       = get_field( 'election_day_subtext' ) ?: 'Today is a great day to make a plan to vote! This means deciding if you are going to vote early, absentee, or on election day.';

$abs_heading        = get_field( 'absentee_heading' ) ?: 'Absentee Vote';
$abs_may_label      = get_field( 'absentee_may_label' ) ?: 'May 5 Election';
$abs_may_dates      = get_field( 'absentee_may_dates' ) ?: 'February 4 - April 25, 2026';
$abs_aug_label      = get_field( 'absentee_aug_label' ) ?: 'August 6 Election';
$abs_aug_dates      = get_field( 'absentee_aug_dates' ) ?: 'April 6 - July 27, 2026';
$abs_requirements   = get_field( 'absentee_requirements' ) ?: 'Your absentee ballot <span class="bold">must</span> be returned by mail or to the Washington County Election Commission office. It <span class="bold">cannot</span> be dropped off at the election commission, an early voting location, or your polling location.';
$abs_btn_text       = get_field( 'absentee_btn_text' ) ?: 'Request Absentee Ballot';
$abs_btn_url        = get_field( 'absentee_btn_url' ) ?: 'https://www.wcecoffice.com/absentee-info/';

$early_heading      = get_field( 'early_vote_heading' ) ?: 'Early Vote';
$early_may_label    = get_field( 'early_may_label' ) ?: 'May 5 Election';
$early_may_dates    = get_field( 'early_may_dates' ) ?: 'April 15 - April 30, 2026';
$early_may_hours    = get_field( 'early_may_hours' ) ?: "Monday - Friday 9 AM - 5 PM\nSaturdays 9 AM - 12 Noon";
$early_aug_label    = get_field( 'early_aug_label' ) ?: 'August 6 Election';
$early_aug_dates    = get_field( 'early_aug_dates' ) ?: 'July 17 - August 1, 2026';
$early_aug_hours    = get_field( 'early_aug_hours' ) ?: "Monday - Friday 9 AM - 5 PM\nSaturdays 9 AM - 12 Noon";
$early_btn_text     = get_field( 'early_btn_text' ) ?: 'Early Voting Locations';

$eday_box_heading   = get_field( 'eday_heading' ) ?: 'On Election Day';
$eday_may_label     = get_field( 'eday_may_label' ) ?: 'May 5 Election';
$eday_may_hours     = get_field( 'eday_may_hours' ) ?: 'Polls open 8 AM - 8 PM';
$eday_aug_label     = get_field( 'eday_aug_label' ) ?: 'August 6 Election';
$eday_aug_hours     = get_field( 'eday_aug_hours' ) ?: 'Polls open 8 AM - 8 PM';
$polling_heading    = get_field( 'polling_location_heading' ) ?: 'District 3 Polling Location';
$polling_name       = get_field( 'polling_location_name' ) ?: 'Old Jonesborough Middle School';
$polling_addr1      = get_field( 'polling_address_1' ) ?: '308 Forest Dr';
$polling_city       = get_field( 'polling_city_state' ) ?: 'Jonesborough, TN 37659';
$all_polling_text   = get_field( 'all_polling_btn_text' ) ?: 'All Polling Locations';
$all_polling_url    = get_field( 'all_polling_btn_url' ) ?: 'https://tnmap.tn.gov/voterlookup/';

$voter_reg_heading  = get_field( 'voter_reg_heading' ) ?: 'Are You Registered to Vote?';
$voter_reg_subtext  = get_field( 'voter_reg_subtext' ) ?: "Don't get an Election Day surprise. Make sure you're registered to vote!";
$check_reg_heading  = get_field( 'check_reg_heading' ) ?: 'Check your Registration';
$check_reg_sub      = get_field( 'check_reg_subheading' ) ?: 'Will you be able to vote?';
$check_reg_text     = get_field( 'check_reg_text' ) ?: "If you haven't voted in a while, are a newly registered voter, or want to ensure your voter registration hasn't been purged, take a minute to confirm your voter status before showing up on Election Day.";
$check_btn_text     = get_field( 'check_reg_btn_text' ) ?: 'Check Your Status';
$check_btn_url      = get_field( 'check_reg_btn_url' ) ?: 'https://tnmap.tn.gov/voterlookup/';
$deadline_heading   = get_field( 'reg_deadline_heading' ) ?: 'Voter Registration Deadlines';
$deadline_may_label = get_field( 'reg_deadline_may_label' ) ?: 'May 5 Election';
$deadline_may_date  = get_field( 'reg_deadline_may_date' ) ?: 'April 6, 2026';
$deadline_aug_label = get_field( 'reg_deadline_aug_label' ) ?: 'August 6 Election';
$deadline_aug_date  = get_field( 'reg_deadline_aug_date' ) ?: 'July 7, 2026';
$register_btn_text  = get_field( 'register_btn_text' ) ?: 'Register to Vote';
$register_btn_url   = get_field( 'register_btn_url' ) ?: 'https://tnmap.tn.gov/voterlookup/';

$rights_heading     = get_field( 'voting_rights_heading' ) ?: 'Know Your Voting Rights';
$rights_subtext     = get_field( 'voting_rights_subtext' ) ?: "When you go to vote, it's important you know your rights.";
$rights_list        = get_field( 'voting_rights_list' );

// Default voting rights if ACF not populated
if ( ! $rights_list ) {
    $rights_list = array(
        array( 'right_text' => 'If you are in line to vote before 8 PM, you have the right to vote.' ),
        array( 'right_text' => 'If someone tells you that you are ineligible to vote, ask for a provisional ballot.' ),
        array( 'right_text' => 'If you need assistance, you have the right to request this from a poll worker. They can read you the ballot or assist you in understanding how to use the machine.' ),
        array( 'right_text' => 'No one can have or wear any candidate material within 100 feet of a polling location.' ),
        array( 'right_text' => 'Poll workers are not allowed to talk to voters about who to vote for, political parties, etc.' ),
        array( 'right_text' => 'Voters with disabilities or an inability to stand for a prolonged duration are allowed to bypass the voting line.' ),
    );
}

// Split rights into two halves for desktop grid
$rights_half = (int) ceil( count( $rights_list ) / 2 );
$rights_col1 = array_slice( $rights_list, 0, $rights_half );
$rights_col2 = array_slice( $rights_list, $rights_half );

// Register the modal to fire immediately after <body> opens (wp_body_open)
add_action( 'wp_body_open', function() use ( $modal_img_url, $modal_img_alt ) {
    ?>
    <div class="modal-overlay" id="earlyVotingModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <img src="<?php echo $modal_img_url; ?>" alt="<?php echo $modal_img_alt; ?>" />
        </div>
    </div>
    <?php
} );

get_header();
?>

    <section class="about-header">
        <h1>Election <span class="election-header-mobile">Information</span></h1>
    </section>

</section><!-- /.background-image.nav-header -->

<!-- Election Section -->
<section class="election-ashley">
    <div class="container">

        <!-- How to Vote -->
        <div class="election-day">
            <h2><?php echo esc_html( $eday_heading ); ?></h2>
            <h3><?php echo wp_kses_post( $eday_subtext ); ?></h3>

            <div class="how-to-vote-grid">

                <!-- Absentee Vote -->
                <div class="how-to-vote-grid-item">
                    <h3><?php echo esc_html( $abs_heading ); ?></h3>
                    <div class="voting-info-text">
                        <h4 class="mt-1"><?php echo esc_html( $abs_may_label ); ?></h4>
                        <p><?php echo esc_html( $abs_may_dates ); ?></p>
                        <h4 class="mt-1"><?php echo esc_html( $abs_aug_label ); ?></h4>
                        <p><?php echo esc_html( $abs_aug_dates ); ?></p>
                        <div class="absentee-ballot-requirements">
                            <p><?php echo wp_kses_post( $abs_requirements ); ?></p>
                        </div>
                    </div>
                    <a href="<?php echo esc_url( $abs_btn_url ); ?>" target="_blank" rel="noopener noreferrer" class="how-to-vote-grid-item-absentee-btn"><?php echo esc_html( $abs_btn_text ); ?></a>
                </div>

                <!-- Early Vote -->
                <div class="how-to-vote-grid-item how-to-vote-grid-item-early">
                    <h3><?php echo esc_html( $early_heading ); ?></h3>
                    <div class="voting-info-text">
                        <h4 class="mt-1"><?php echo esc_html( $early_may_label ); ?></h4>
                        <p><?php echo esc_html( $early_may_dates ); ?></p>
                        <?php foreach ( explode( "\n", $early_may_hours ) as $line ) : ?>
                            <p><?php echo esc_html( trim( $line ) ); ?></p>
                        <?php endforeach; ?>
                        <h4 class="mt-1"><?php echo esc_html( $early_aug_label ); ?></h4>
                        <p><?php echo esc_html( $early_aug_dates ); ?></p>
                        <?php foreach ( explode( "\n", $early_aug_hours ) as $line ) : ?>
                            <p><?php echo esc_html( trim( $line ) ); ?></p>
                        <?php endforeach; ?>
                    </div>
                    <a href="" target="_blank" class="how-to-vote-grid-item-early-btn" id="earlyVotingBtn"><?php echo esc_html( $early_btn_text ); ?></a>
                </div>

                <!-- On Election Day -->
                <div class="how-to-vote-grid-item how-to-vote-grid-item-election">
                    <h3><?php echo esc_html( $eday_box_heading ); ?></h3>
                    <div class="voting-info-text">
                        <h4 class="mt-1"><?php echo esc_html( $eday_may_label ); ?></h4>
                        <p><?php echo esc_html( $eday_may_hours ); ?></p>
                        <h4 class="mt-1"><?php echo esc_html( $eday_aug_label ); ?></h4>
                        <p><?php echo esc_html( $eday_aug_hours ); ?></p>
                        <div class="polling-location">
                            <h4 class="mt-2"><?php echo esc_html( $polling_heading ); ?></h4>
                            <p><?php echo esc_html( $polling_name ); ?></p>
                            <p><?php echo esc_html( $polling_addr1 ); ?></p>
                            <p><?php echo esc_html( $polling_city ); ?></p>
                        </div>
                    </div>
                    <a href="<?php echo esc_url( $all_polling_url ); ?>" target="_blank" rel="noopener noreferrer" class="how-to-vote-grid-item-early-btn"><?php echo esc_html( $all_polling_text ); ?></a>
                </div>

            </div>
        </div>

        <!-- Voter Registration -->
        <div class="polling-location">
            <div class="voter-registration-text">
                <h2><?php echo esc_html( $voter_reg_heading ); ?></h2>
                <h4><?php echo esc_html( $voter_reg_subtext ); ?></h4>
                <div class="registered-to-vote-grid">
                    <div class="registered-to-vote-grid-item">
                        <h3><?php echo esc_html( $check_reg_heading ); ?></h3>
                        <div class="voter-registration-status">
                            <div class="voter-registration-box-text">
                                <h4><?php echo esc_html( $check_reg_sub ); ?></h4>
                                <p><?php echo wp_kses_post( $check_reg_text ); ?></p>
                            </div>
                        </div>
                        <a href="<?php echo esc_url( $check_btn_url ); ?>" target="_blank" rel="noopener noreferrer" class="voter-registration-check-btn"><?php echo esc_html( $check_btn_text ); ?></a>
                    </div>
                    <div class="registered-to-vote-grid-item">
                        <h3><?php echo esc_html( $deadline_heading ); ?></h3>
                        <div class="voter-registration-status">
                            <div class="voter-registration-box-text">
                                <h4 class="mt-1"><?php echo esc_html( $deadline_may_label ); ?></h4>
                                <p><?php echo esc_html( $deadline_may_date ); ?></p>
                                <h4 class="mt-1"><?php echo esc_html( $deadline_aug_label ); ?></h4>
                                <p><?php echo esc_html( $deadline_aug_date ); ?></p>
                            </div>
                        </div>
                        <a href="<?php echo esc_url( $register_btn_url ); ?>" target="_blank" rel="noopener noreferrer" class="voter-registration-check-btn"><?php echo esc_html( $register_btn_text ); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Know Your Voting Rights -->
        <div class="know-your-voting-rights">
            <div class="know-your-voting-rights-text-box">
                <h2><?php echo esc_html( $rights_heading ); ?></h2>
                <h4><?php echo esc_html( $rights_subtext ); ?></h4>
                <div class="know-your-voting-rights-list">

                    <!-- Desktop: 2-column grid -->
                    <div class="know-your-voting-rights-list-grid">
                        <div class="know-your-voting-rights-list-grid-item">
                            <ul>
                                <?php foreach ( $rights_col1 as $right ) : ?>
                                    <li><?php echo wp_kses_post( $right['right_text'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="know-your-voting-rights-list-grid-item">
                            <ul>
                                <?php foreach ( $rights_col2 as $right ) : ?>
                                    <li><?php echo wp_kses_post( $right['right_text'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Mobile: single list -->
                    <div class="know-your-voting-rights-mobile">
                        <ul>
                            <?php foreach ( $rights_list as $right ) : ?>
                                <li><?php echo wp_kses_post( $right['right_text'] ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>
