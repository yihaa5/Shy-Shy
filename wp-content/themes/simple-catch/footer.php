<?php
/**
 * The template for displaying the footer.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
global $simplecatch_options_settings;
$options = $simplecatch_options_settings;

$footer_code = $options[ 'footer_code' ];
?>
<div id="footer">
    <div class="layout-978">
        <?php //Displaying footer logo ?>
        <div class="col7 copyright no-margin-left">
            <?php
            if (function_exists('simplecatch_footerlogo')) :
                simplecatch_footerlogo();
            endif;
            ?>
            
            <span><?= $footer_code ?>                
            </span>    
            
            

        </div><!-- .col7 -->

        <?php //do_action('simplecatch_credits'); ?>

    </div><!-- .layout-978 -->
</div><!-- #footer -->      
<?php wp_footer(); ?>
</body>
</html>