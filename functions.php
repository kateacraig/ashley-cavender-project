<?php
/**
 * Ashley Cavender Campaign Theme Functions
 * Designed & coded by Kate Craig, Kate Craig Consulting
 */

// ==========================================
// Theme Setup
// ==========================================
function ac_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'ashley-cavender' ),
    ) );
}
add_action( 'after_setup_theme', 'ac_theme_setup' );

// ==========================================
// Enqueue Scripts & Styles
// ==========================================
function ac_enqueue_assets() {
    wp_enqueue_style( 'ac-main-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_script( 'ac-main-js', get_template_directory_uri() . '/scripts/main.js', array(), '1.0.0', true );
    wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/c95030a0b6.js', array(), null, false );
    wp_enqueue_style( 'ac-google-fonts', 'https://fonts.googleapis.com/css2?family=Boogaloo&family=Knewave&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Unica+One&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'ac_enqueue_assets' );

// Add crossorigin to Font Awesome script tag
function ac_font_awesome_crossorigin( $tag, $handle, $src ) {
    if ( 'font-awesome' === $handle ) {
        return '<script src="' . esc_url( $src ) . '" crossorigin="anonymous"></script>' . "\n";
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'ac_font_awesome_crossorigin', 10, 3 );

// Add Google Fonts preconnect
function ac_preconnect_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'ac_preconnect_fonts', 1 );

// ==========================================
// Custom Nav Walker
// Moves btn-donate class from <li> to <a>
// Adds target="_blank" for external links
// ==========================================
class AC_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes     = empty( $item->classes ) ? array() : (array) $item->classes;
        $is_donate   = in_array( 'btn-donate', $classes );

        // Remove btn-donate from li classes
        $li_classes  = array_filter( $classes, function( $c ) {
            return $c !== 'btn-donate';
        });
        $li_class_str = ! empty( $li_classes ) ? ' class="' . esc_attr( implode( ' ', array_filter( $li_classes ) ) ) . '"' : '';

        $output .= '<li' . $li_class_str . '>';

        $href   = ! empty( $item->url ) ? esc_url( $item->url ) : '';
        $target = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $rel    = ( ! empty( $item->target ) && $item->target === '_blank' ) ? ' rel="noopener noreferrer"' : '';
        $a_class = $is_donate ? ' class="btn-donate"' : '';
        $title  = apply_filters( 'the_title', $item->title, $item->ID );

        $output .= '<a href="' . $href . '"' . $target . $rel . $a_class . '>' . $title . '</a>';
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

// ==========================================
// Helper: Get Site Settings Page ID
// ==========================================
function ac_get_settings_id() {
    static $settings_id = null;
    if ( $settings_id === null ) {
        $page = get_page_by_path( 'site-settings' );
        $settings_id = $page ? $page->ID : 0;
    }
    return $settings_id;
}

// ==========================================
// Helper: Render Issues Sidebar Links
// Used on the Issues page and all 7 issue sub-pages
// ==========================================
function ac_render_sidebar_links() {
    $settings_id     = ac_get_settings_id();
    $sidebar_heading = get_field( 'issues_sidebar_heading', $settings_id ) ?: 'My Priorities';
    $sidebar_subtext = get_field( 'issues_sidebar_subtext', $settings_id ) ?: 'Select priority to read more';
    $priority_links  = get_field( 'issues_priority_links', $settings_id );

    if ( ! $priority_links ) {
        $priority_links = array(
            array( 'priority_text' => 'Diversifying County Revenue',                                          'priority_url' => home_url( '/diversify-county-revenue/#my-priorities' ) ),
            array( 'priority_text' => 'Smarter Open Space Planning with Community & Environmental Input',     'priority_url' => home_url( '/smarter-space-planning/#my-priorities' ) ),
            array( 'priority_text' => 'Stronger Collaboration Between the School Board & County Commission',  'priority_url' => home_url( '/stronger-collaboration/#my-priorities' ) ),
            array( 'priority_text' => 'Bipartisan, Community-Centered Leadership',                            'priority_url' => home_url( '/bipartisan-leadership/#my-priorities' ) ),
            array( 'priority_text' => 'Community Engagement & Service Beyond the Commission',                 'priority_url' => home_url( '/community-engagement/#my-priorities' ) ),
            array( 'priority_text' => 'Transparency in Budgeting & Long-Term Forecasting',                   'priority_url' => home_url( '/transparency-in-budget/#my-priorities' ) ),
            array( 'priority_text' => 'Investing in Community Health & Wellbeing Through Grants',             'priority_url' => home_url( '/investing-in-community/#my-priorities' ) ),
        );
    }

    echo '<h3>' . esc_html( $sidebar_heading ) . '</h3>';
    echo '<p class="small-text">' . esc_html( $sidebar_subtext ) . '</p>';
    foreach ( $priority_links as $link ) {
        echo '<hr /><br />';
        echo '<a href="' . esc_url( $link['priority_url'] ) . '">' . esc_html( $link['priority_text'] ) . '</a>';
        echo '<br /><br />';
    }
}

// ==========================================
// Force our custom Events page template when
// The Events Calendar tries to load its archive.
// Also forces our single event template for
// individual event pages.
// Fires after WordPress resolves the template,
// giving us the final say.
// ==========================================
add_filter( 'template_include', function( $template ) {

    // Archive override — use our custom Events page
    if ( is_post_type_archive( 'tribe_events' ) || ( function_exists( 'tribe_is_event' ) && tribe_is_month() ) ) {
        $events_page = get_page_by_path( 'events' );
        if ( $events_page ) {
            global $wp_query, $post;
            $post = $events_page;
            $wp_query->queried_object    = $events_page;
            $wp_query->queried_object_id = $events_page->ID;
            $wp_query->is_singular       = true;
            $wp_query->is_archive        = false;
            $wp_query->is_post_type_archive = false;
            $wp_query->is_page           = true;
            setup_postdata( $post );
            $custom = locate_template( 'page-events.php' );
            if ( $custom ) {
                return $custom;
            }
        }
    }

    // Single event override — use our custom single template
    if ( is_singular( 'tribe_events' ) ) {
        $custom = locate_template( 'single-tribe_events.php' );
        if ( $custom ) {
            return $custom;
        }
    }

    return $template;
}, 99 );

// ==========================================
// ACF Local Field Groups
// ==========================================
if ( function_exists( 'acf_add_local_field_group' ) ) :

// ------------------------------------------
// 1. Site Settings — Header & Footer Fields
// ------------------------------------------
acf_add_local_field_group( array(
    'key'    => 'group_ac_site_settings',
    'title'  => 'Site Settings (Header & Footer)',
    'fields' => array(

        // --- Header ---
        array( 'key' => 'field_ac_site_tab_header', 'label' => 'Header Settings', 'name' => '', 'type' => 'tab' ),

        array( 'key' => 'field_ac_site_bg_image', 'label' => 'Header Background Image', 'name' => 'site_background_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Used on all page headers. Default: background-image.png' ),

        array( 'key' => 'field_ac_nav_donate_text', 'label' => 'Donate Button Text', 'name' => 'nav_donate_text',
            'type' => 'text', 'default_value' => 'Donate' ),

        array( 'key' => 'field_ac_nav_donate_url', 'label' => 'Donate Button URL', 'name' => 'nav_donate_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        // --- Issues Sidebar ---
        array( 'key' => 'field_ac_site_tab_issues', 'label' => 'Issues Sidebar Links', 'name' => '', 'type' => 'tab' ),

        array( 'key' => 'field_ac_issues_sidebar_heading', 'label' => 'Sidebar Heading', 'name' => 'issues_sidebar_heading',
            'type' => 'text', 'default_value' => 'My Priorities' ),

        array( 'key' => 'field_ac_issues_sidebar_subtext', 'label' => 'Sidebar Subtext', 'name' => 'issues_sidebar_subtext',
            'type' => 'text', 'default_value' => 'Select priority to read more' ),

        array( 'key' => 'field_ac_issues_priority_links', 'label' => 'Priority Links', 'name' => 'issues_priority_links',
            'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Add Priority Link',
            'sub_fields' => array(
                array( 'key' => 'field_ac_priority_text', 'label' => 'Link Text', 'name' => 'priority_text', 'type' => 'text', 'column_width' => 60 ),
                array( 'key' => 'field_ac_priority_url', 'label' => 'Link URL', 'name' => 'priority_url', 'type' => 'url', 'column_width' => 40 ),
            ),
        ),

        // --- Footer ---
        array( 'key' => 'field_ac_site_tab_footer', 'label' => 'Footer Settings', 'name' => '', 'type' => 'tab' ),

        array( 'key' => 'field_ac_footer_links_heading', 'label' => 'Links Column Heading', 'name' => 'footer_links_heading',
            'type' => 'text', 'default_value' => 'Links' ),

        array( 'key' => 'field_ac_footer_contact_heading', 'label' => 'Contact Heading', 'name' => 'footer_contact_heading',
            'type' => 'text', 'default_value' => 'Contact Ashley' ),

        array( 'key' => 'field_ac_footer_email', 'label' => 'Contact Email', 'name' => 'footer_email',
            'type' => 'email', 'default_value' => 'ashleycforcounty@gmail.com' ),

        array( 'key' => 'field_ac_footer_follow_heading', 'label' => 'Follow Heading', 'name' => 'footer_follow_heading',
            'type' => 'text', 'default_value' => 'Follow Ashley' ),

        array( 'key' => 'field_ac_footer_facebook_url', 'label' => 'Facebook URL', 'name' => 'footer_facebook_url',
            'type' => 'url', 'default_value' => 'https://www.facebook.com/AshleyCforCommission' ),

        array( 'key' => 'field_ac_footer_instagram_url', 'label' => 'Instagram URL', 'name' => 'footer_instagram_url',
            'type' => 'url', 'default_value' => 'https://www.instagram.com/ashleyc_forcounty' ),

        array( 'key' => 'field_ac_footer_donate_heading', 'label' => 'Donate Section Heading', 'name' => 'footer_donate_heading',
            'type' => 'text', 'default_value' => 'Help Ashley Win!' ),

        array( 'key' => 'field_ac_footer_donate_tagline', 'label' => 'Donate Tagline', 'name' => 'footer_donate_tagline',
            'type' => 'text', 'default_value' => 'Donate and help Ashley flip this seat!' ),

        array( 'key' => 'field_ac_footer_donate_10_url', 'label' => 'Donate $10 URL', 'name' => 'footer_donate_10_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_footer_donate_25_url', 'label' => 'Donate $25 URL', 'name' => 'footer_donate_25_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_footer_donate_50_url', 'label' => 'Donate $50 URL', 'name' => 'footer_donate_50_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_footer_donate_100_url', 'label' => 'Donate $100 URL', 'name' => 'footer_donate_100_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_footer_donate_other_url', 'label' => 'Donate Other Amount URL', 'name' => 'footer_donate_other_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_footer_logo', 'label' => 'Footer Logo', 'name' => 'footer_logo',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail',
            'instructions' => 'Default: logo-transparent.png' ),

        array( 'key' => 'field_ac_footer_copyright', 'label' => 'Copyright Text', 'name' => 'footer_copyright',
            'type' => 'textarea', 'default_value' => 'Paid for by the Committee to elect to Ashley Cavender, Treasurer Ashley Cavender.' . "\n\n" . 'This website was coded by Kate Craig | Copyright 2026',
            'new_lines' => 'br' ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-site-settings.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 2. Front Page (Home)
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_front_page',
    'title' => 'Home Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_home_countdown_label', 'label' => 'Countdown Label', 'name' => 'countdown_label',
            'type' => 'text', 'default_value' => 'Days till Election Day' ),

        array( 'key' => 'field_ac_home_first_name', 'label' => 'Candidate First Name', 'name' => 'hero_first_name',
            'type' => 'text', 'default_value' => 'Ashley' ),

        array( 'key' => 'field_ac_home_last_name', 'label' => 'Candidate Last Name', 'name' => 'hero_last_name',
            'type' => 'text', 'default_value' => 'Cavender' ),

        array( 'key' => 'field_ac_home_position', 'label' => 'Position Line', 'name' => 'hero_position',
            'type' => 'text', 'default_value' => 'Washington County Commission District 3' ),

        array( 'key' => 'field_ac_home_oak_leaf', 'label' => 'Oak Leaf Image', 'name' => 'hero_oak_leaf',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail',
            'instructions' => 'Default: oak-leaf.png' ),

        array( 'key' => 'field_ac_home_slogan_bg', 'label' => 'Slogan Section Background Image', 'name' => 'slogan_bg_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: downtown-jonesborough.jpg' ),

        array( 'key' => 'field_ac_home_headshot', 'label' => 'Candidate Headshot', 'name' => 'slogan_headshot',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: headshot.jpg' ),

        array( 'key' => 'field_ac_home_quote', 'label' => 'Quote Text', 'name' => 'slogan_quote',
            'type' => 'textarea', 'new_lines' => 'br',
            'default_value' => '"We deserve someone who will protect our land and put the citizens first. I\'ve been showing up for Jonesborough through my work and service. Now I\'m asking for your vote on August 6 to continue serving our community as District 3\'s representative on the Washington County Commission."' ),

        array( 'key' => 'field_ac_home_attribution', 'label' => 'Quote Attribution', 'name' => 'slogan_attribution',
            'type' => 'text', 'default_value' => '-Ashley Cavender' ),

        array( 'key' => 'field_ac_home_tagline', 'label' => 'Campaign Tagline', 'name' => 'slogan_tagline',
            'type' => 'text', 'default_value' => 'Rooted here. Protecting our land. Serving our community, always.' ),

        array( 'key' => 'field_ac_home_vol_label', 'label' => 'Volunteer Label', 'name' => 'slogan_volunteer_label',
            'type' => 'text', 'default_value' => 'Sign up to volunteer' ),

        array( 'key' => 'field_ac_home_vol_btn_text', 'label' => 'Volunteer Button Text', 'name' => 'slogan_volunteer_btn_text',
            'type' => 'text', 'default_value' => 'Volunteer' ),

        array( 'key' => 'field_ac_home_vol_btn_url', 'label' => 'Volunteer Button URL', 'name' => 'slogan_volunteer_btn_url',
            'type' => 'url', 'default_value' => 'https://forms.gle/DQeMieEwQsRafqx2A' ),

        array( 'key' => 'field_ac_home_don_label', 'label' => 'Donate Label', 'name' => 'slogan_donate_label',
            'type' => 'text', 'default_value' => 'Donate to the campaign' ),

        array( 'key' => 'field_ac_home_don_btn_text', 'label' => 'Donate Button Text', 'name' => 'slogan_donate_btn_text',
            'type' => 'text', 'default_value' => 'Donate' ),

        array( 'key' => 'field_ac_home_don_btn_url', 'label' => 'Donate Button URL', 'name' => 'slogan_donate_btn_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),
    ),
    'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 3. About Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_about',
    'title' => 'About Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_about_title', 'label' => 'Page Title', 'name' => 'about_page_title',
            'type' => 'text', 'default_value' => 'About Ashley' ),

        array( 'key' => 'field_ac_about_main_image', 'label' => 'Main Photo', 'name' => 'about_main_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: about-images/ashley-and-banjo.jpg' ),

        array( 'key' => 'field_ac_about_greeting', 'label' => 'Greeting Heading', 'name' => 'about_greeting',
            'type' => 'text', 'default_value' => "It's nice to meet you!" ),

        array( 'key' => 'field_ac_about_p1', 'label' => 'Paragraph 1', 'name' => 'about_paragraph_1',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'I was born and raised in East Tennessee and chose to build my life in Jonesborough after graduating from East Tennessee State University in 2015. I began my career with Jonesborough Locally Grown at Boone Street Market, and it\'s here in Washington County that my values feel most alive. This isn\'t just where I live — it\'s where I\'ve invested my time, energy, and heart.' ),

        array( 'key' => 'field_ac_about_p2', 'label' => 'Paragraph 2', 'name' => 'about_paragraph_2',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'I serve as Director of Equitable Nutrition & Food Access with the Appalachian Resource Conservation & Development Council, supporting conservation, local agriculture, and community-based initiatives. I currently chair Keep Jonesborough Beautiful and am active with Slow Food Tri-Cities. I\'ve also contributed to long-range planning through Johnson City Horizon 2045 and supported affordable housing efforts with Unity Housing.' ),

        array( 'key' => 'field_ac_about_p3', 'label' => 'Paragraph 3', 'name' => 'about_paragraph_3',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'My time with One Acre Cafe deepened my commitment to food access with dignity. I\'ve volunteered with community events like Meet the Mountains and Blue Plum Festival, celebrating our region\'s culture and local businesses.' ),

        array( 'key' => 'field_ac_about_p4', 'label' => 'Paragraph 4', 'name' => 'about_paragraph_4',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Outside of work, you\'ll find me gardening, hiking Northeast Tennessee trails, or near the water with my Jack Russell, Banjo. I care deeply about smart land use, healthy waterways, local food, and civic engagement — and I believe County Commission decisions should protect the land, water, and quality of life we pass on to the next generation.' ),

        array( 'key' => 'field_ac_about_carousel_heading', 'label' => 'Carousel Section Heading', 'name' => 'about_carousel_heading',
            'type' => 'text', 'default_value' => 'I love our Jonesborough community!' ),

        array( 'key' => 'field_ac_about_carousel_bg', 'label' => 'Carousel Background Image', 'name' => 'about_carousel_bg',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: carousel-background-jonesborough.jpeg' ),

        array( 'key' => 'field_ac_about_carousel_slides', 'label' => 'Carousel Slides', 'name' => 'about_carousel_slides',
            'type' => 'repeater', 'layout' => 'table', 'min' => 1, 'max' => 20, 'button_label' => 'Add Slide',
            'sub_fields' => array(
                array( 'key' => 'field_ac_slide_image', 'label' => 'Slide Image', 'name' => 'slide_image',
                    'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'column_width' => 70 ),
                array( 'key' => 'field_ac_slide_alt', 'label' => 'Alt Text', 'name' => 'slide_alt',
                    'type' => 'text', 'column_width' => 30 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 4. Issues Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_issues',
    'title' => 'Issues Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_issues_title', 'label' => 'Page Title', 'name' => 'issues_page_title',
            'type' => 'text', 'default_value' => 'Issues' ),

        array( 'key' => 'field_ac_issues_main_heading', 'label' => 'Main Heading', 'name' => 'issues_main_heading',
            'type' => 'text', 'default_value' => 'A Practical, Bipartisan Voice for Our Community.' ),

        array( 'key' => 'field_ac_issues_p1', 'label' => 'Paragraph 1', 'name' => 'issues_intro_p1',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => "I'm running for County Commission to put our community first — always. I believe local government works best when it listens to residents, plans thoughtfully, and makes decisions that protect both our quality of life and our natural resources." ),

        array( 'key' => 'field_ac_issues_p2', 'label' => 'Paragraph 2', 'name' => 'issues_intro_p2',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => "As Washington County grows, land use decisions matter more than ever. I will advocate for responsible planning that includes community input and carefully considers environmental impacts like water quality, flooding, infrastructure strain, and long-term costs to taxpayers. Growth should strengthen our neighborhoods, not come at the expense of our land, health, or future." ),

        array( 'key' => 'field_ac_issues_p3', 'label' => 'Paragraph 3', 'name' => 'issues_intro_p3',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => "I'm non-partisan by nature and focused on practical solutions, not politics. By prioritizing transparency, responsible budgeting, and community engagement, I will work to ensure county decisions reflect the values and needs of the people who live here — today and for generations to come." ),

        array( 'key' => 'field_ac_issues_p4', 'label' => 'Paragraph 4', 'name' => 'issues_intro_p4',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => "Washington County deserves leadership that treats land, infrastructure, and community health as deeply connected. I'm running to work alongside District 3 residents—bringing transparent decision-making, practical planning, and responsible land use that protects what we love while preparing for the future." ),

        array( 'key' => 'field_ac_issues_boxes', 'label' => 'Issue Boxes', 'name' => 'issues_boxes',
            'type' => 'repeater', 'layout' => 'table', 'min' => 1, 'max' => 10, 'button_label' => 'Add Issue Box',
            'sub_fields' => array(
                array( 'key' => 'field_ac_box_number', 'label' => 'Number', 'name' => 'box_number', 'type' => 'text', 'column_width' => 10 ),
                array( 'key' => 'field_ac_box_heading', 'label' => 'Heading', 'name' => 'box_heading', 'type' => 'text', 'column_width' => 50 ),
                array( 'key' => 'field_ac_box_url', 'label' => 'URL', 'name' => 'box_url', 'type' => 'url', 'column_width' => 30 ),
                array( 'key' => 'field_ac_box_btn', 'label' => 'Button Text', 'name' => 'box_btn_text', 'type' => 'text', 'default_value' => 'Learn More', 'column_width' => 10 ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-issues.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// Helper: Individual Issues Sub-Page Field Group
// ------------------------------------------
function ac_register_issue_subpage( $group_key, $template_file, $title, $default_heading, $default_quote, $default_paragraphs, $default_if_elected ) {
    $fields = array(
        array( 'key' => 'field_' . $group_key . '_page_title', 'label' => 'Page Title (H1)', 'name' => 'issues_page_title',
            'type' => 'text', 'default_value' => 'Issues' ),
        array( 'key' => 'field_' . $group_key . '_heading', 'label' => 'Issue Heading (H2)', 'name' => 'issue_heading',
            'type' => 'text', 'default_value' => $default_heading ),
        array( 'key' => 'field_' . $group_key . '_quote', 'label' => 'Pull Quote', 'name' => 'issue_quote',
            'type' => 'textarea', 'new_lines' => 'br', 'default_value' => $default_quote ),
    );
    foreach ( $default_paragraphs as $i => $p ) {
        $fields[] = array(
            'key'           => 'field_' . $group_key . '_p' . ( $i + 1 ),
            'label'         => 'Paragraph ' . ( $i + 1 ),
            'name'          => 'issue_paragraph_' . ( $i + 1 ),
            'type'          => 'textarea',
            'new_lines'     => 'wpautop',
            'default_value' => $p,
        );
    }
    $fields[] = array(
        'key'           => 'field_' . $group_key . '_if_elected',
        'label'         => '"If Elected" Pledge',
        'name'          => 'issue_if_elected',
        'type'          => 'textarea',
        'new_lines'     => 'wpautop',
        'default_value' => $default_if_elected,
    );
    acf_add_local_field_group( array(
        'key'      => 'group_' . $group_key,
        'title'    => $title,
        'fields'   => $fields,
        'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => $template_file ) ) ),
        'menu_order' => 0,
        'position'   => 'normal',
    ) );
}

// 5. Diversify County Revenue
ac_register_issue_subpage(
    'ac_diversify',
    'page-diversify-county-revenue.php',
    'Diversify County Revenue — Page Content',
    '1. Diversifying County Revenue',
    '"We need to bring more money into Washington County — not take more out of our neighbors\' pockets." - Ashley Cavender',
    array(
        "We can't keep balancing the budget on the backs of working families.",
        "Washington County relies too heavily on taxing residents to fund essential services. I will advocate for diversifying county revenue by pursuing grants, partnerships, and smart economic development that brings in outside dollars. This approach reduces pressure on community members while still investing in our schools, infrastructure, and public services.",
        "We deserve the opportunity to thrive. And rising costs make it hard for Washington County Residents to get ahead or even afford basic necessities.",
    ),
    "If elected, I promise to put Washington County residents first, making sure their ability to afford basic necessities is at the forefront of all decisions I make. And I pledge to pursue alternative revenue sources to lift the financial burden from the shoulders of Washington County residents."
);

// 6. Smarter Space Planning
ac_register_issue_subpage(
    'ac_smarter',
    'page-smarter-space-planning.php',
    'Smarter Space Planning — Page Content',
    '2. Smarter Open Space Planning with Community & Environmental Input',
    '"Good planning today saves taxpayers money tomorrow — and protects what makes our community home." - Ashley Cavender',
    array(
        "Growth should strengthen our community, not overwhelm it.",
        "I support thoughtful open space planning that includes public input, protects natural resources, and respects the character of our rural and residential areas. Decisions about development should consider long-term impacts on water quality, flooding, infrastructure, and quality of life.",
        "Washington County is special and as stewards of this land, we should do all we can to protect it for us and future generations.",
    ),
    "If elected, I promise to be a good steward of our land and to ensure the needs of industries vying to open in Washington County don't outweigh the health of Washington County residents or the protection of the land we have been entrusted. I promise to uplift our farmers and protect the land they work."
);

// 7. Stronger Collaboration
ac_register_issue_subpage(
    'ac_stronger',
    'page-stronger-collaboration.php',
    'Stronger Collaboration — Page Content',
    '3. Stronger Collaboration Between the School Board & County Commission',
    '"When the County Commission and School Board pull in the same direction, our schools are stronger." - Ashley Cavender',
    array(
        "Our kids benefit when local leaders work together.",
        "Our students, educators, and community deserve well-funded schools and the support they need to be successful. This means increasing communication between the Washington County Commission and the Washington County School Board.",
        "Increased coordination leads to clearer budgeting, stronger long-term planning, and better outcomes for students, educators, and families.",
    ),
    "If elected, I promise to improve communication and collaboration between the County Commission and the Washington County School Board. Better coordination leads to clearer budgeting, stronger long-term planning, and better outcomes for students, educators, and families."
);

// 8. Bipartisan Leadership
ac_register_issue_subpage(
    'ac_bipartisan',
    'page-bipartisan-leadership.php',
    'Bipartisan Leadership — Page Content',
    '4. Bipartisan, Community-Centered Leadership',
    '"Good ideas don\'t belong to one party — they belong to our community." - Ashley Cavender',
    array(
        "County government shouldn't be about party politics — it should be about people.",
        "I'm non-partisan by nature and committed to working with anyone who wants to move Washington County forward. I believe in listening to different perspectives, finding common ground, and focusing on practical solutions instead of political labels.",
        "We are all Washington County and deserve leadership who don't see us as party identifiers but instead as community members.",
    ),
    "If elected, I promise to put the people I serve in Washington County ahead of partisan politics. I pledge to listen, coordinate, and collaborate with anyone willing to come to the table and share ideas. I pledge to serve every Washington County resident."
);

// 9. Community Engagement
ac_register_issue_subpage(
    'ac_community',
    'page-community-engagement.php',
    'Community Engagement — Page Content',
    '5. Community Engagement & Service Beyond the Commission',
    '"You shouldn\'t have to know the right person to serve — your community should make room for you." - Ashley Cavender',
    array(
        "Representation doesn't stop at the commission table — it grows when more people have a seat at the table.",
        "We can all benefit from increasing and varying the voices around the table. A good idea becomes a great idea when we collaborate together. So many in our community have experience and expertise that can enable the Washington County Commission to make better, community-focused decision.",
        "Our community is strongest when decision-making bodies reflect the people they impact.",
    ),
    "If elected, I promise to help Washington County residents access opportunities to serve on local boards and committees, share information about openings, and lower barriers to participation. I pledge to use my role to open doors, amplify voices, and make civic service accessible to everyone."
);

// 10. Transparency in Budget
ac_register_issue_subpage(
    'ac_transparency',
    'page-transparency-in-budget.php',
    'Transparency in Budget — Page Content',
    '6. Transparency in Budgeting & Long-Term Forecasting',
    '"If we can\'t explain the budget, we haven\'t done our job." - Ashley Cavender',
    array(
        "Taxpayers deserve clear, honest explanations.",
        "Any Washington County resident should be able to read and understand Washington County's budget. This includes having plain language explanations and clear forecasting.",
        "Residents should understand not only what we're funding, but why — and what it means for the future.",
    ),
    "If elected, I pledge to ensure that Washington County's budget includes plain language regarding how tax dollars are spent and clear forecasting to understand the county's financial health."
);

// 11. Investing in Community
ac_register_issue_subpage(
    'ac_investing',
    'page-investing-in-community.php',
    'Investing in Community — Page Content',
    '7. Investing in Community Health & Wellbeing Through Grants',
    '"Grants help us invest in people without raising taxes." - Ashley Cavender',
    array(
        "A healthy community is a strong community.",
        "Strategic grant funding allows us to expand services without increasing the tax burden on residents. Services funded by the Washington County government ensure our infrastructure is maintained, our farmlands are protected, and our industry is supported.",
        "Grants are a viable means to fund and expand services offered by Washington County's government without increasing taxes.",
    ),
    "If elected, I will focus on securing grants and outside funding to support public health, recreation, environmental health, and community wellbeing initiatives."
);

// ------------------------------------------
// 12. Contact Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_contact',
    'title' => 'Contact Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_contact_title', 'label' => 'Page Title', 'name' => 'contact_page_title',
            'type' => 'text', 'default_value' => 'Contact Ashley' ),

        array( 'key' => 'field_ac_contact_bg', 'label' => 'Contact Section Background Image', 'name' => 'contact_bg_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: ashley-friends.jpg' ),

        array( 'key' => 'field_ac_contact_heading', 'label' => 'Contact Heading', 'name' => 'contact_heading',
            'type' => 'text', 'default_value' => 'I want to hear from you!' ),

        array( 'key' => 'field_ac_contact_q1', 'label' => 'Question 1', 'name' => 'contact_question_1',
            'type' => 'text', 'default_value' => 'What issues keep you up at night?' ),

        array( 'key' => 'field_ac_contact_q2', 'label' => 'Question 2', 'name' => 'contact_question_2',
            'type' => 'text', 'default_value' => "What's a project you'd like for the Washington County Commission to tackle?" ),

        array( 'key' => 'field_ac_contact_q3', 'label' => 'Question 3', 'name' => 'contact_question_3',
            'type' => 'text', 'default_value' => 'What has the Washington County Commission done that you wish they hadn\'t?' ),

        array( 'key' => 'field_ac_contact_q4', 'label' => 'Question 4', 'name' => 'contact_question_4',
            'type' => 'text', 'default_value' => 'What are you looking for from your Washington County Commissioner?' ),

        array( 'key' => 'field_ac_contact_subheading', 'label' => 'Sub-Heading (below questions)', 'name' => 'contact_subheading',
            'type' => 'text', 'default_value' => 'Let me know!' ),

        array( 'key' => 'field_ac_contact_form_heading', 'label' => 'Form Heading', 'name' => 'contact_form_heading',
            'type' => 'text', 'default_value' => 'Contact Ashley' ),

        array( 'key' => 'field_ac_contact_cf7', 'label' => 'Contact Form 7 Shortcode', 'name' => 'contact_cf7_shortcode',
            'type' => 'text', 'default_value' => '[contact-form-7 id="YOUR_FORM_ID" title="Contact Ashley"]',
            'instructions' => 'Paste the Contact Form 7 shortcode here after creating your form.' ),

        array( 'key' => 'field_ac_vol_bg', 'label' => 'Volunteer Section Background Image', 'name' => 'volunteer_bg_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: downtown-jonesborough.jpg' ),

        array( 'key' => 'field_ac_vol_heading', 'label' => 'Volunteer Section Heading', 'name' => 'volunteer_section_heading',
            'type' => 'text', 'default_value' => '3 ways you can help me flip this seat' ),

        array( 'key' => 'field_ac_vol_vote_heading', 'label' => 'Vote Box Heading', 'name' => 'vote_box_heading',
            'type' => 'text', 'default_value' => 'Vote!' ),

        array( 'key' => 'field_ac_vol_vote_content', 'label' => 'Vote Box Content', 'name' => 'vote_box_content',
            'type' => 'textarea', 'new_lines' => 'br',
            'default_value' => 'Make a plan to vote for me on <span class="bold green">August 6</span>, during early voting between <span class="bold green">July 17 - August 1</span>, or absentee between <span class="bold green">April 6 - July 27</span>.' ),

        array( 'key' => 'field_ac_vol_donate_heading', 'label' => 'Donate Box Heading', 'name' => 'donate_box_heading',
            'type' => 'text', 'default_value' => 'Donate!' ),

        array( 'key' => 'field_ac_vol_donate_content', 'label' => 'Donate Box Content', 'name' => 'donate_box_content',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Every dollar you donate helps me talk to more voters in the district.' ),

        array( 'key' => 'field_ac_vol_donate_btn_text', 'label' => 'Donate Button Text', 'name' => 'donate_btn_text',
            'type' => 'text', 'default_value' => 'Donate' ),

        array( 'key' => 'field_ac_vol_donate_btn_url', 'label' => 'Donate Button URL', 'name' => 'donate_btn_url',
            'type' => 'url', 'default_value' => 'https://secure.actblue.com/donate/ashleyfordistrict3' ),

        array( 'key' => 'field_ac_vol_vol_heading', 'label' => 'Volunteer Box Heading', 'name' => 'volunteer_box_heading',
            'type' => 'text', 'default_value' => 'Volunteer!' ),

        array( 'key' => 'field_ac_vol_vol_content', 'label' => 'Volunteer Box Content', 'name' => 'volunteer_box_content',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Help me talk to voters and flip this seat on election day!' ),

        array( 'key' => 'field_ac_vol_vol_btn_text', 'label' => 'Volunteer Button Text', 'name' => 'volunteer_btn_text',
            'type' => 'text', 'default_value' => 'Volunteer' ),

        array( 'key' => 'field_ac_vol_vol_btn_url', 'label' => 'Volunteer Button URL', 'name' => 'volunteer_btn_url',
            'type' => 'url', 'default_value' => 'https://forms.gle/DQeMieEwQsRafqx2A' ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 13. Election Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_election',
    'title' => 'Election Page Content',
    'fields' => array(

        // Modal
        array( 'key' => 'field_ac_election_modal_image', 'label' => 'Early Voting Locations Modal Image', 'name' => 'election_modal_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'This image pops up when "Early Voting Locations" button is clicked. Default: early-voting-locations.png' ),

        // Header
        array( 'key' => 'field_ac_election_title', 'label' => 'Page Title', 'name' => 'election_page_title',
            'type' => 'text', 'default_value' => 'Election' ),

        array( 'key' => 'field_ac_election_bg', 'label' => 'Section Background Image', 'name' => 'election_bg_image',
            'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Default: ashley-election-background.jpg' ),

        // Election Day Section
        array( 'key' => 'field_ac_election_day_heading', 'label' => 'Election Day Heading', 'name' => 'election_day_heading',
            'type' => 'text', 'default_value' => 'Election Day - August 6!' ),

        array( 'key' => 'field_ac_election_day_subtext', 'label' => 'Election Day Subtext', 'name' => 'election_day_subtext',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Today is a great day to make a plan to vote! This means deciding if you are going to vote early, absentee, or on election day.' ),

        // Absentee Vote Box
        array( 'key' => 'field_ac_absentee_heading', 'label' => 'Absentee Vote Heading', 'name' => 'absentee_heading',
            'type' => 'text', 'default_value' => 'Absentee Vote' ),

        array( 'key' => 'field_ac_absentee_may_label', 'label' => 'Absentee — May Election Label', 'name' => 'absentee_may_label',
            'type' => 'text', 'default_value' => 'May 5 Election' ),

        array( 'key' => 'field_ac_absentee_may_dates', 'label' => 'Absentee — May Dates', 'name' => 'absentee_may_dates',
            'type' => 'text', 'default_value' => 'February 4 - April 25, 2026' ),

        array( 'key' => 'field_ac_absentee_aug_label', 'label' => 'Absentee — August Election Label', 'name' => 'absentee_aug_label',
            'type' => 'text', 'default_value' => 'August 6 Election' ),

        array( 'key' => 'field_ac_absentee_aug_dates', 'label' => 'Absentee — August Dates', 'name' => 'absentee_aug_dates',
            'type' => 'text', 'default_value' => 'April 6 - July 27, 2026' ),

        array( 'key' => 'field_ac_absentee_requirements', 'label' => 'Absentee Requirements Text', 'name' => 'absentee_requirements',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Your absentee ballot <span class="bold">must</span> be returned by mail or to the Washington County Election Commission office. It <span class="bold">cannot</span> be dropped off at the election commission, an early voting location, or your polling location.' ),

        array( 'key' => 'field_ac_absentee_btn_text', 'label' => 'Absentee Button Text', 'name' => 'absentee_btn_text',
            'type' => 'text', 'default_value' => 'Request Absentee Ballot' ),

        array( 'key' => 'field_ac_absentee_btn_url', 'label' => 'Absentee Button URL', 'name' => 'absentee_btn_url',
            'type' => 'url', 'default_value' => 'https://www.wcecoffice.com/absentee-info/' ),

        // Early Vote Box
        array( 'key' => 'field_ac_early_heading', 'label' => 'Early Vote Heading', 'name' => 'early_vote_heading',
            'type' => 'text', 'default_value' => 'Early Vote' ),

        array( 'key' => 'field_ac_early_may_label', 'label' => 'Early Vote — May Label', 'name' => 'early_may_label',
            'type' => 'text', 'default_value' => 'May 5 Election' ),

        array( 'key' => 'field_ac_early_may_dates', 'label' => 'Early Vote — May Dates', 'name' => 'early_may_dates',
            'type' => 'text', 'default_value' => 'April 15 - April 30, 2026' ),

        array( 'key' => 'field_ac_early_may_hours', 'label' => 'Early Vote — May Hours', 'name' => 'early_may_hours',
            'type' => 'textarea', 'new_lines' => 'br',
            'default_value' => "Monday - Friday 9 AM - 5 PM\nSaturdays 9 AM - 12 Noon" ),

        array( 'key' => 'field_ac_early_aug_label', 'label' => 'Early Vote — August Label', 'name' => 'early_aug_label',
            'type' => 'text', 'default_value' => 'August 6 Election' ),

        array( 'key' => 'field_ac_early_aug_dates', 'label' => 'Early Vote — August Dates', 'name' => 'early_aug_dates',
            'type' => 'text', 'default_value' => 'July 17 - August 1, 2026' ),

        array( 'key' => 'field_ac_early_aug_hours', 'label' => 'Early Vote — August Hours', 'name' => 'early_aug_hours',
            'type' => 'textarea', 'new_lines' => 'br',
            'default_value' => "Monday - Friday 9 AM - 5 PM\nSaturdays 9 AM - 12 Noon" ),

        array( 'key' => 'field_ac_early_btn_text', 'label' => 'Early Voting Locations Button Text', 'name' => 'early_btn_text',
            'type' => 'text', 'default_value' => 'Early Voting Locations',
            'instructions' => 'This button triggers the modal popup with the Early Voting Locations image above.' ),

        // Election Day Box
        array( 'key' => 'field_ac_eday_heading', 'label' => 'On Election Day Heading', 'name' => 'eday_heading',
            'type' => 'text', 'default_value' => 'On Election Day' ),

        array( 'key' => 'field_ac_eday_may_label', 'label' => 'Election Day — May Label', 'name' => 'eday_may_label',
            'type' => 'text', 'default_value' => 'May 5 Election' ),

        array( 'key' => 'field_ac_eday_may_hours', 'label' => 'Election Day — May Hours', 'name' => 'eday_may_hours',
            'type' => 'text', 'default_value' => 'Polls open 8 AM - 8 PM' ),

        array( 'key' => 'field_ac_eday_aug_label', 'label' => 'Election Day — August Label', 'name' => 'eday_aug_label',
            'type' => 'text', 'default_value' => 'August 6 Election' ),

        array( 'key' => 'field_ac_eday_aug_hours', 'label' => 'Election Day — August Hours', 'name' => 'eday_aug_hours',
            'type' => 'text', 'default_value' => 'Polls open 8 AM - 8 PM' ),

        array( 'key' => 'field_ac_eday_polling_heading', 'label' => 'Polling Location Heading', 'name' => 'polling_location_heading',
            'type' => 'text', 'default_value' => 'District 3 Polling Location' ),

        array( 'key' => 'field_ac_eday_polling_name', 'label' => 'Polling Location Name', 'name' => 'polling_location_name',
            'type' => 'text', 'default_value' => 'Old Jonesborough Middle School' ),

        array( 'key' => 'field_ac_eday_polling_addr1', 'label' => 'Polling Location Address', 'name' => 'polling_address_1',
            'type' => 'text', 'default_value' => '308 Forest Dr' ),

        array( 'key' => 'field_ac_eday_polling_city', 'label' => 'Polling Location City/State/Zip', 'name' => 'polling_city_state',
            'type' => 'text', 'default_value' => 'Jonesborough, TN 37659' ),

        array( 'key' => 'field_ac_eday_all_btn_text', 'label' => 'All Polling Locations Button Text', 'name' => 'all_polling_btn_text',
            'type' => 'text', 'default_value' => 'All Polling Locations' ),

        array( 'key' => 'field_ac_eday_all_btn_url', 'label' => 'All Polling Locations Button URL', 'name' => 'all_polling_btn_url',
            'type' => 'url', 'default_value' => 'https://tnmap.tn.gov/voterlookup/' ),

        // Voter Registration Section
        array( 'key' => 'field_ac_voter_reg_heading', 'label' => 'Voter Registration Heading', 'name' => 'voter_reg_heading',
            'type' => 'text', 'default_value' => 'Are You Registered to Vote?' ),

        array( 'key' => 'field_ac_voter_reg_subtext', 'label' => 'Voter Registration Subtext', 'name' => 'voter_reg_subtext',
            'type' => 'text', 'default_value' => "Don't get an Election Day surprise. Make sure you're registered to vote!" ),

        array( 'key' => 'field_ac_check_reg_heading', 'label' => 'Check Registration Heading', 'name' => 'check_reg_heading',
            'type' => 'text', 'default_value' => 'Check your Registration' ),

        array( 'key' => 'field_ac_check_reg_subheading', 'label' => 'Check Registration Sub-heading', 'name' => 'check_reg_subheading',
            'type' => 'text', 'default_value' => 'Will you be able to vote?' ),

        array( 'key' => 'field_ac_check_reg_text', 'label' => 'Check Registration Text', 'name' => 'check_reg_text',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => "If you haven't voted in a while, are a newly registered voter, or want to ensure your voter registration hasn't been purged, take a minute to confirm your voter status before showing up on Election Day." ),

        array( 'key' => 'field_ac_check_reg_btn_text', 'label' => 'Check Status Button Text', 'name' => 'check_reg_btn_text',
            'type' => 'text', 'default_value' => 'Check Your Status' ),

        array( 'key' => 'field_ac_check_reg_btn_url', 'label' => 'Check Status Button URL', 'name' => 'check_reg_btn_url',
            'type' => 'url', 'default_value' => 'https://tnmap.tn.gov/voterlookup/' ),

        array( 'key' => 'field_ac_reg_deadline_heading', 'label' => 'Registration Deadlines Heading', 'name' => 'reg_deadline_heading',
            'type' => 'text', 'default_value' => 'Voter Registration Deadlines' ),

        array( 'key' => 'field_ac_reg_deadline_may_label', 'label' => 'Registration Deadline — May Label', 'name' => 'reg_deadline_may_label',
            'type' => 'text', 'default_value' => 'May 5 Election' ),

        array( 'key' => 'field_ac_reg_deadline_may_date', 'label' => 'Registration Deadline — May Date', 'name' => 'reg_deadline_may_date',
            'type' => 'text', 'default_value' => 'April 6, 2026' ),

        array( 'key' => 'field_ac_reg_deadline_aug_label', 'label' => 'Registration Deadline — August Label', 'name' => 'reg_deadline_aug_label',
            'type' => 'text', 'default_value' => 'August 6 Election' ),

        array( 'key' => 'field_ac_reg_deadline_aug_date', 'label' => 'Registration Deadline — August Date', 'name' => 'reg_deadline_aug_date',
            'type' => 'text', 'default_value' => 'July 7, 2026' ),

        array( 'key' => 'field_ac_register_btn_text', 'label' => 'Register to Vote Button Text', 'name' => 'register_btn_text',
            'type' => 'text', 'default_value' => 'Register to Vote' ),

        array( 'key' => 'field_ac_register_btn_url', 'label' => 'Register to Vote Button URL', 'name' => 'register_btn_url',
            'type' => 'url', 'default_value' => 'https://tnmap.tn.gov/voterlookup/' ),

        // Voting Rights Section
        array( 'key' => 'field_ac_rights_heading', 'label' => 'Voting Rights Heading', 'name' => 'voting_rights_heading',
            'type' => 'text', 'default_value' => 'Know Your Voting Rights' ),

        array( 'key' => 'field_ac_rights_subtext', 'label' => 'Voting Rights Subtext', 'name' => 'voting_rights_subtext',
            'type' => 'text', 'default_value' => "When you go to vote, it's important you know your rights." ),

        array( 'key' => 'field_ac_rights_list', 'label' => 'Voting Rights List', 'name' => 'voting_rights_list',
            'type' => 'repeater', 'layout' => 'table', 'min' => 1, 'button_label' => 'Add Right',
            'sub_fields' => array(
                array( 'key' => 'field_ac_right_text', 'label' => 'Right/Rule', 'name' => 'right_text', 'type' => 'textarea', 'new_lines' => 'wpautop' ),
            ),
        ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-election.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 14. News Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_news',
    'title' => 'News Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_news_title', 'label' => 'Page Title', 'name' => 'news_page_title',
            'type' => 'text', 'default_value' => 'News' ),

        array( 'key' => 'field_ac_news_heading', 'label' => 'Section Heading', 'name' => 'news_heading',
            'type' => 'text', 'default_value' => 'Campaign News' ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-news.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

// ------------------------------------------
// 15. Events Page
// ------------------------------------------
acf_add_local_field_group( array(
    'key'   => 'group_ac_events',
    'title' => 'Events Page Content',
    'fields' => array(

        array( 'key' => 'field_ac_events_title', 'label' => 'Page Title', 'name' => 'events_page_title',
            'type' => 'text', 'default_value' => 'Events' ),

        array( 'key' => 'field_ac_events_heading', 'label' => 'Section Heading', 'name' => 'events_heading',
            'type' => 'text', 'default_value' => 'Upcoming Events' ),

        array( 'key' => 'field_ac_events_subtext', 'label' => 'Section Subtext', 'name' => 'events_subtext',
            'type' => 'textarea', 'new_lines' => 'wpautop',
            'default_value' => 'Join Ashley at an upcoming event! If you\'d like to volunteer at one, email ashleycforcounty@gmail.com.' ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-events.php' ) ) ),
    'menu_order' => 0,
    'position' => 'normal',
) );

endif; // end acf_add_local_field_group check