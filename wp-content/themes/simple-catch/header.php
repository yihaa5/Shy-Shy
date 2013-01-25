<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section 
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


        <?php
        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */

        wp_head();
        ?>
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/bootstrap/css/bootstrap.min.css"/> 
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/wp-member-boostrap.css"/> 
        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body <?php body_class(); ?>>

        <div id="header">
            <div class="top-bg"></div>
            <div class="layout-978">
                <?php
// Funcition to show the header logo, site title and site description
                if (function_exists('simplecatch_headerdetails')) :
                    simplecatch_headerdetails();
                endif;
                ?>

                <!--<div class="social-search">-->
                <div style="float:right;width:200px;padding-top:5px;text-align:right;">

                    <?php
                    if (!is_user_logged_in()) {
                        if (WPMEM_REGURL != null) {
                            ?>
                            <button class="btn-mini btn-success" onclick="window.location='<?php echo WPMEM_REGURL; ?>'"><?php _e('Sign Up', 'wp-members'); ?></button>

                            <?php
                        }
                        if (WPMEM_MSURL != null) {
                            $link = wpmem_chk_qstr(WPMEM_MSURL);
                            $resetlink = $link . '?a=pwdreset';
                            ?>
                            <button class="btn btn-mini" onclick="window.location='<?php echo $link; ?>'"><?php _e('Login', 'wp-members'); ?></button>
                            <button class="btn btn-mini" onclick="window.location='<?php echo $resetlink; ?>'"><?php _e('Forgot?', 'wp-members'); ?></button>
                            <?php
                        }
                    } else {
                        if (WPMEM_MSURL != null) {
                            $link = wpmem_chk_qstr(WPMEM_MSURL);
                            $editlink = $link . '?a=edit';
                            $logoutlink = $link . '?a=logout';
                            ?>
                            <button class="btn btn-mini" onclick="window.location='<?php echo $editlink; ?>'"><?php _e('Edit Profile', 'wp-members'); ?></button>
                            <button class="btn btn-mini" onclick="window.location='<?php echo $logoutlink; ?>'"><?php _e('Logout', 'wp-members'); ?></button>
                            <?php
                        }
                    }
                    ?>

                </div>
                <div id="mainmenu">
                    <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                </div><!-- #mainmenu-->  
                <?php
// simplecatch_headersocialnetworks displays social links given from theme option in header 
//if ( function_exists( 'simplecatch_headersocialnetworks' ) ) :
//  simplecatch_headersocialnetworks(); 
//endif;
// get search form
//get_search_form();
                ?>      
                <!--</div>-->

                <div class="row-end"></div>

                <?php
// This function passes the value of slider effect to js file 
                if (function_exists('simplecatch_pass_slider_value')) {
                    simplecatch_pass_slider_value();
                }
// Display slider in home page and breadcrumb in other pages 
                if (function_exists('simplecatch_sliderbreadcrumb')) :
                    simplecatch_sliderbreadcrumb();
                endif;
                ?> 
            </div><!-- .layout-978 -->
        </div><!-- #header -->

