    <footer>
        <div class="container">
            <div class="footer-grid">

                <div class="footer-important-links">
                    <h3 class="mb-2"><?php echo esc_html( get_field( 'footer_links_heading', ac_get_settings_id() ) ?: 'Links' ); ?></h3>
                    <ul class="important-links">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/issues/' ) ); ?>">Issues</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/election/' ) ); ?>">Election</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
                    </ul>
                    <div class="footer-mobile-links-grid">
                        <div class="footer-mobile-grid-items">
                            <ul class="important-links-mobile">
                                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/issues/' ) ); ?>">Issues</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a></li>
                            </ul>
                        </div>
                        <div class="footer-mobile-grid-items">
                            <ul class="important-links-mobile">
                                <li><a href="<?php echo esc_url( home_url( '/election/' ) ); ?>">Election</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="footer-follow-ashley">
                    <?php
                    $footer_contact_heading = get_field( 'footer_contact_heading', ac_get_settings_id() ) ?: 'Contact Ashley';
                    $footer_email           = get_field( 'footer_email', ac_get_settings_id() ) ?: 'ashleycforcounty@gmail.com';
                    $footer_follow_heading  = get_field( 'footer_follow_heading', ac_get_settings_id() ) ?: 'Follow Ashley';
                    $footer_fb_url          = get_field( 'footer_facebook_url', ac_get_settings_id() ) ?: 'https://www.facebook.com/AshleyCforCommission';
                    $footer_ig_url          = get_field( 'footer_instagram_url', ac_get_settings_id() ) ?: 'https://www.instagram.com/ashleyc_forcounty';
                    $footer_donate_heading  = get_field( 'footer_donate_heading', ac_get_settings_id() ) ?: 'Help Ashley Win!';
                    $footer_donate_tagline  = get_field( 'footer_donate_tagline', ac_get_settings_id() ) ?: 'Donate and help Ashley flip this seat!';
                    $footer_d10_url         = get_field( 'footer_donate_10_url', ac_get_settings_id() ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
                    $footer_d25_url         = get_field( 'footer_donate_25_url', ac_get_settings_id() ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
                    $footer_d50_url         = get_field( 'footer_donate_50_url', ac_get_settings_id() ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
                    $footer_d100_url        = get_field( 'footer_donate_100_url', ac_get_settings_id() ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
                    $footer_other_url       = get_field( 'footer_donate_other_url', ac_get_settings_id() ) ?: 'https://secure.actblue.com/donate/ashleyfordistrict3';
                    $footer_logo            = get_field( 'footer_logo', ac_get_settings_id() );
                    $footer_logo_url        = $footer_logo ? esc_url( $footer_logo['url'] ) : esc_url( get_template_directory_uri() . '/images/logo-transparent.png' );
                    $footer_logo_alt        = $footer_logo ? esc_attr( $footer_logo['alt'] ) : 'Ashley Cavender Campaign Logo';
                    $footer_copyright       = get_field( 'footer_copyright', ac_get_settings_id() ) ?: 'Paid for by the Committee to elect to Ashley Cavender, Treasurer Ashley Cavender.<br><br>This website was coded by Kate Craig | Copyright 2026';
                    ?>
                    <h3 class="mb-2"><?php echo esc_html( $footer_contact_heading ); ?></h3>
                    <h4><a href="mailto:<?php echo esc_attr( $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a></h4>
                    <h3 class="mb-2 mt-2"><?php echo esc_html( $footer_follow_heading ); ?></h3>
                    <div class="footer-social-icons">
                        <div class="footer-social-icon">
                            <a href="<?php echo esc_url( $footer_fb_url ); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>
                        <div class="footer-social-icon">
                            <a href="<?php echo esc_url( $footer_ig_url ); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-square-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="footer-donate">
                    <h3 class="text-center mb-2"><?php echo esc_html( $footer_donate_heading ); ?></h3>
                    <p class="text-center"><?php echo esc_html( $footer_donate_tagline ); ?></p>
                    <div class="footer-donate-grid">
                        <div><a href="<?php echo esc_url( $footer_d10_url ); ?>" class="btn-donate-footer" target="_blank" rel="noopener noreferrer">$10</a></div>
                        <div><a href="<?php echo esc_url( $footer_d25_url ); ?>" class="btn-donate-footer" target="_blank" rel="noopener noreferrer">$25</a></div>
                        <div><a href="<?php echo esc_url( $footer_d50_url ); ?>" class="btn-donate-footer" target="_blank" rel="noopener noreferrer">$50</a></div>
                        <div><a href="<?php echo esc_url( $footer_d100_url ); ?>" class="btn-donate-footer" target="_blank" rel="noopener noreferrer">$100</a></div>
                    </div>
                    <div class="footer-donate-other">
                        <a href="<?php echo esc_url( $footer_other_url ); ?>" class="btn-donate-footer" target="_blank" rel="noopener noreferrer">Other Amount</a>
                    </div>
                </div>

                <div class="footer-follow-ashley-mobile">
                    <h3 class="mb-2"><?php echo esc_html( $footer_contact_heading ); ?></h3>
                    <h4><a href="mailto:<?php echo esc_attr( $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a></h4>
                    <h3 class="mb-2 mt-2"><?php echo esc_html( $footer_follow_heading ); ?></h3>
                    <div class="footer-social-icons">
                        <div class="footer-social-icon">
                            <a href="<?php echo esc_url( $footer_fb_url ); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>
                        <div class="footer-social-icon">
                            <a href="<?php echo esc_url( $footer_ig_url ); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-square-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="footer-logo">
                <img src="<?php echo $footer_logo_url; ?>" alt="<?php echo $footer_logo_alt; ?>" />
            </div>
            <div class="footer-copyright text-center mb-2">
                <?php echo wp_kses_post( $footer_copyright ); ?>
            </div>

        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>
