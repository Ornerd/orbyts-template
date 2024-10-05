<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CT_Custom
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- <title>Coalition Theme</title> -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ct-custom' ); ?></a>

	<header>
    <section class="contact-us">
        <div class="wrapper">
            <div>
                <p>Call us now!</p>
                <p><?php echo esc_html(get_option('c_custom_phone_number')); ?></p>
            </div>
            <div>
                <p><a href="">Login</a></p> 
                <p><a href="">Signup</a></p> 
            </div>
        </div>
    </section>
    <section class="header-links">
        <div class="wrapper">
            <a href="<?php echo home_url(); ?>">
                <?php 
                 $logo = get_option('c_custom_logo');
                 if ($logo) { //prioritizing the logo from the logo url that can be edited in the c-theme settings menu
                    ?>
                    <img src=" <?php echo esc_url($logo)?>" alt="Logo" 
                    style= "width: <?php echo esc_attr(get_option('c_custom_logo_width')) ?>px ; height: <?php echo esc_attr(get_option('c_custom_logo_height')) ?>px ">
                    <?php
                }else if (has_custom_logo()) { //if that url is non-existent, then we fall back to the wp-customzer's logo edit.
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id);
                    ?>
                    <img src="<?php echo $logo[0] ?>" alt="Your logo">
                    <?php
                }else { // if the above aren't present, then a placeholder logo is hardcoded.
                    ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/YOURLOGO.png" alt="Your logo">
                    <?php 
                } 
               
               
                ?>
            </a>
            <label class="ham-menu">
                <input type="checkbox">
            </label>

            <nav> <!-- first menu -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-1', 
                    'container' => false,
                    'menu_class' => 'nav-element',
					'items_wrap' => '%3$s',  // by ChatGPT, to helpemove the automatic wrapping <ul>
					'walker' => new Coalition_Nav_Walker(),
                ));
                ?>
            </nav>
        </div>
    </section>

    <nav class="content-nav wrapper"> <!-- sub menu -->
		<?php
		wp_nav_menu(array(
			'theme_location' => 'menu-2',
			'container' => false,
			'items_wrap' => '%3$s',
			'walker' => new Mini_Nav_Walker(),
		));
    	?>
    </nav>
</header><!-- #masthead -->

	<div id="content" class="site-content wrapper">
