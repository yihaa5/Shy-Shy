jQuery( document ).ready( function() {
	// Colorpicker for Heading
    jQuery('#colorpicker_heading_color').farbtastic('#simplecatch_heading_color');
    
    jQuery('#simplecatch_heading_color').blur( function() {
            jQuery('#colorpicker_heading_color').hide();
    });
    
    jQuery('#simplecatch_heading_color').focus( function() {
            jQuery('#colorpicker_heading_color').show();
    });	
	
	// Colorpicker for Meta Description
    jQuery('#colorpicker_meta_color').farbtastic('#simplecatch_meta_color');
    
    jQuery('#simplecatch_meta_color').blur( function() {
            jQuery('#colorpicker_meta_color').hide();
    });
    
    jQuery('#simplecatch_meta_color').focus( function() {
            jQuery('#colorpicker_meta_color').show();
    });		
								   
	// Colorpicker for Text
    jQuery('#colorpicker_text_color').farbtastic('#simplecatch_text_color');
    
    jQuery('#simplecatch_text_color').blur( function() {
            jQuery('#colorpicker_text_color').hide();
    });
    
    jQuery('#simplecatch_text_color').focus( function() {
            jQuery('#colorpicker_text_color').show();
    });
	// Colorpicker for Link
    jQuery('#colorpicker_link_color').farbtastic('#simplecatch_link_color');
    
    jQuery('#simplecatch_link_color').blur( function() {
            jQuery('#colorpicker_link_color').hide();
    });
    
    jQuery('#simplecatch_link_color').focus( function() {
            jQuery('#colorpicker_link_color').show();
    });	
	
	// Colorpicker for Text
    jQuery('#colorpicker_widget_heading_color').farbtastic('#simplecatch_widget_heading_color');
    
    jQuery('#simplecatch_widget_heading_color').blur( function() {
            jQuery('#colorpicker_widget_heading_color').hide();
    });
    
    jQuery('#simplecatch_widget_heading_color').focus( function() {
            jQuery('#colorpicker_widget_heading_color').show();
    });
	// Colorpicker for Sidebar Widget Text Color
    jQuery('#colorpicker_widget_text_color').farbtastic('#simplecatch_widget_text_color');
    
    jQuery('#simplecatch_widget_text_color').blur( function() {
            jQuery('#colorpicker_widget_text_color').hide();
    });
    
    jQuery('#simplecatch_widget_text_color').focus( function() {
            jQuery('#colorpicker_widget_text_color').show();
    });		
});	