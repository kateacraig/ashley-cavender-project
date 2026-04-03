<?php
/**
 * Template Name: Contact Page
 */

get_header();

$page_title       = get_field( 'contact_page_title' ) ?: 'Contact Ashley';
$contact_heading  = get_field( 'contact_heading' ) ?: 'I want to hear from you!';
$q1               = get_field( 'contact_question_1' ) ?: 'What issues keep you up at night?';
$q2               = get_field( 'contact_question_2' ) ?: "What's a project you'd like for the Washington County Commission to tackle?";
$q3               = get_field( 'contact_question_3' ) ?: "What has the Washington County Commission done that you wish they hadn't?";
$q4               = get_field( 'contact_question_4' ) ?: 'What are you looking for from your Washington County Commissioner?';
$subheading       = get_field( 'contact_subheading' ) ?: 'Let me know!';
$form_heading     = get_field( 'contact_form_heading' ) ?: 'Contact Ashley';
$cf7_shortcode    = get_field( 'contact_cf7_shortcode' ) ?: '[contact-form-7 id="7dde1f2" title="Contact Page Form"]';

$vol_heading      = get_field( 'volunteer_section_heading' ) ?: '3 ways you can help me flip this seat';
$vote_heading     = get_field( 'vote_box_heading' ) ?: 'Vote!';
$vote_content     = get_field( 'vote_box_content' ) ?: 'Make a plan to vote for me on <span class="bold green">August 6</span>, during early voting between <span class="bold green">July 17 - August 1</span>, or absentee between <span class="bold green">April 6 - July 27</span>.';
$donate_heading   = get_field( 'donate_box_heading' ) ?: 'Donate!';
$donate_content   = get_field( 'donate_box_content' ) ?: 'Every dollar you donate helps me talk to more voters in the district.';
$donate_btn_text  = get_field( 'donate_btn_text' ) ?: 'Donate';
$donate_btn_url   = get_field( 'donate_btn_url' ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
$vol_heading_box  = get_field( 'volunteer_box_heading' ) ?: 'Volunteer!';
$vol_content      = get_field( 'volunteer_box_content' ) ?: 'Help me talk to voters and flip this seat on election day!';
$vol_btn_text     = get_field( 'volunteer_btn_text' ) ?: 'Volunteer';
$vol_btn_url      = get_field( 'volunteer_btn_url' ) ?: 'https://forms.gle/DQeMieEwQsRafqx2A';
?>

    <section class="about-header">
        <h1><?php echo esc_html( $page_title ); ?></h1>
    </section>

</section><!-- /.background-image.nav-header -->

<!-- Contact Section -->
<section class="ashley-contact">
    <div class="container">
        <div class="ashley-contact-header">
            <div class="ashley-contact-grid">
                <div class="ashley-contact-grid-item">
                    <div class="ashley-contact-grid-item-text">
                        <h2><?php echo esc_html( $contact_heading ); ?></h2>
                        <ul>
                            <li><?php echo esc_html( $q1 ); ?></li>
                            <li><?php echo esc_html( $q2 ); ?></li>
                            <li><?php echo esc_html( $q3 ); ?></li>
                            <li><?php echo esc_html( $q4 ); ?></li>
                        </ul>
                        <h3><?php echo esc_html( $subheading ); ?></h3>
                    </div>
                </div>
                <div class="ashley-contact-grid-item ashley-contact-grid-item-form">
                    <div class="contact-form">
                        <h2><?php echo esc_html( $form_heading ); ?></h2>
                        <?php echo do_shortcode( $cf7_shortcode ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Volunteer Section -->
<section class="volunteer-for-ashley">
    <div class="container">
        <h2><?php echo esc_html( $vol_heading ); ?></h2>
        <div class="volunteer-grid">
            <div class="volunteer-grid-item volunteer-grid-item-green">
                <h2><?php echo esc_html( $vote_heading ); ?></h2>
                <h3><?php echo wp_kses_post( $vote_content ); ?></h3>
            </div>
            <div class="volunteer-grid-item volunteer-grid-item-purple">
                <h2><?php echo esc_html( $donate_heading ); ?></h2>
                <h3><?php echo wp_kses_post( $donate_content ); ?></h3>
                <a href="<?php echo esc_url( $donate_btn_url ); ?>" class="btn-donate-contact" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $donate_btn_text ); ?></a>
            </div>
            <div class="volunteer-grid-item volunteer-grid-item-yellow">
                <h2><?php echo esc_html( $vol_heading_box ); ?></h2>
                <h3><?php echo wp_kses_post( $vol_content ); ?></h3>
                <a href="<?php echo esc_url( $vol_btn_url ); ?>" class="btn-volunteer-contact" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $vol_btn_text ); ?></a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
