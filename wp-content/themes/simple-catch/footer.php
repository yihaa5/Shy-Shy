<?php
/**
 * The template for displaying the footer.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
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
            
            <span>Sentosa Club Network Sdn. Bhd. <br>Wisma Sentosa, Jalan Kampong Perak, 05100 Alor Setar, Kedah Darul Aman, Malaysia. <br>Tel: +604-7311333 Fax: +604-7334333 
                <?php _e('Email:', 'simplecatch'); ?>&nbsp;<?= get_settings('admin_email') ?><br><?php _e('Copyright', 'simplecatch'); ?> &copy; <?php echo date("Y"); ?>. <?php _e('All Rights Reserved.', 'simplecatch'); ?>
            </span>    
            
            

        </div><!-- .col7 -->

        <?php //do_action('simplecatch_credits'); ?>

    </div><!-- .layout-978 -->
</div><!-- #footer -->      
<?php wp_footer(); ?>
</body>
</html>