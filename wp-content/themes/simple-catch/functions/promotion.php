<?php

/**
 * Extends class wp_widget
 * 
 * Creates a function CustomTagWidget
 * $widget_ops option array passed to wp_register_sidebar_widget().
 * $control_ops option array passed to wp_register_widget_control().
 * $name, Name for this widget which appear on widget bar.
 */
class PromotionWidget extends WP_Widget {

    public function PromotionWidget() {
        $widget_ops = array('description' => __('Display Promotion Overlay', 'simplecatch'));
        //$control_ops = array('width' => 400, 'height' => 500);
        parent::WP_Widget('promotion_widget', $name = 'Promotion Widget', $widget_ops); //$control_ops);
    }

    /** Displays the Widget in the front-end.
     * 
     * $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * $instance The settings for the particular instance of the widget
     */
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $content = $instance['content'];
        $url = urldecode($instance['url']);
        ?>

        <?php
        $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $currentUrl = strpos($currentUrl, "/",strlen($currentUrl)-1)? substr($currentUrl,0,strlen($currentUrl)-1): $currentUrl;
        if ($url == $currentUrl) {
            ?>

            <div id="promotionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="promotionLabel" aria-hidden="true">
                <div class="modal-header" align="center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="promotionLabel"><?= $title ?></h3>
                </div>
                <div class="modal-body">
                    <?php
                    echo $content;
                    ?>
                </div>
            </div>
            <script type="text/javascript">
                                                
                jQuery(document).ready(function(){
                                                
                    jQuery('#promotionModal').modal('show');
                                                
                });

            </script>
            <?
           }
           
    }

    /**
     * update the particular instant  
     * 
     * This function should check that $new_instance is set correctly.
     * The newly calculated value of $instance should be returned.
     * If "false" is returned, the instance won't be saved/updated.
     *
     * $new_instance New settings for this instance as input by the user via form()
     * $old_instance Old settings for this instance
     * Settings to save or bool false to cancel saving
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = stripslashes($new_instance['title']);
        $instance['url'] = urldecode($new_instance['url']);
        $instance['content'] = $new_instance['content']; //empty($new_instance['content'])? "OMG":"NOT EMPY";
        return $instance;
    }

    /**
     * Creates the form for the widget in the back-end which includes the Title 
     * $instance Current settings
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => 'Custom Tag', 'url' => 'URL to display promotion.', 'content' => 'HTML Content'));
        $title = sanitize_title($instance['title']);
        $url = urldecode($instance['url']);
        $content = esc_textarea($instance['content']);

        /**
         * Constructs title attributes  for use in form() field
         * @return string Name attribute for $field_name
         */
        echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' .
        $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /> </p>';

        echo '<p><label for="' . $this->get_field_id('url') . '">' . 'URL to display Promotion (include http://):' . '</label><input class="widefat" id="' .
        $this->get_field_id('url') . '" name="' . $this->get_field_name('url') . '" type="text" value="' . $url . '" /> </p>';

        //wp_editor($content, $this->get_field_id('content'));
        ?>
        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
        <?php
    }

}

// end CustomTagWidget class
?>