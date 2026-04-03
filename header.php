<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<section class="background-image nav-header">
    <header>
        <div class="header-content">
            <nav>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'walker'         => new AC_Nav_Walker(),
                ) );
                ?>
            </nav>
        </div>
    </header>
