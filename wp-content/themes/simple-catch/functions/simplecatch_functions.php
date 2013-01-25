<?php
/**
 * Register jquery scripts
 *
 * @register jquery cycle and custom-script
 * hooks action wp_enqueue_scripts
 */
function simplecatch_scripts_method() {	
	//Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );
	
	//Enqueue Slider Script only in Front Page
	if ( is_home() || is_front_page() ) {
		wp_enqueue_script( 'simplecatch_slider', get_template_directory_uri() . '/js/simplecatch_slider.js', array( 'jquery-cycle' ), '1.0', true );
	}

	//Enqueue Search Script
	wp_enqueue_script ( 'simplecatch_search', get_template_directory_uri() . '/js/simplecatch_search.js', array( 'jquery' ), '1.0', true );

	//Browser Specific Enqueue Script i.e. for IE 1-6
	$simplecatch_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-6]/',$simplecatch_ua)) {
		wp_enqueue_script( 'pngfix', get_template_directory_uri() . '/js/pngfix.min.js' );	  
	}
	 if(preg_match('/(?i)msie [1-8]/',$simplecatch_ua)) {
	 	wp_enqueue_style( 'iebelow8', get_template_directory_uri() . '/css/ie.css', true );
	}
	
} // simplecatch_scripts_method
add_action( 'wp_enqueue_scripts', 'simplecatch_scripts_method' );


/**
 * Register Google Font Style
 *
 * @uses wp_register_style and wp_enqueue_style
 * @action wp_enqueue_scripts
 */
function simplecatch_load_google_fonts() {
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Lobster');
	wp_enqueue_style( 'google-fonts');
}
add_action('wp_enqueue_scripts', 'simplecatch_load_google_fonts');


/**
 * Register script for admin section
 *
 * No scripts should be enqueued within this function.
 * jquery cookie used for remembering admin tabs, and potential future features... so let's register it early
 * @uses wp_register_script
 * @action admin_enqueue_scripts
 */
function simplecatch_register_js() {
	//jQuery Cookie
	wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array( 'jquery' ), '1.0', true );
}
add_action( 'admin_enqueue_scripts', 'simplecatch_register_js' );


/**
 * Enqueue Comment Reply Script
 *
 * We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 * @used comment_form_before action hook 
 */	 
function simplecatch_enqueue_comment_reply_script() {
	if ( comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'simplecatch_enqueue_comment_reply_script' );


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function simplecatch_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'simplecatch' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'simplecatch_wp_title', 10, 2 );


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function simplecatch_excerpt_length( $length ) {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	return $options[ 'excerpt_length' ];
}
add_filter( 'excerpt_length', 'simplecatch_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 */
function simplecatch_continue_reading() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
    
	$more_tag_text = $options[ 'more_tag_text' ];
	return ' <a class="readmore" href="'. esc_url( get_permalink() ) . '">' . sprintf( __( '%s', 'simplecatch' ), esc_attr( $more_tag_text ) ) . '</a>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with simplecatch_continue_reading().
 *
 */
function simplecatch_excerpt_more( $more ) {
	return ' &hellip;' . simplecatch_continue_reading();
}
add_filter( 'excerpt_more', 'simplecatch_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function simplecatch_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= simplecatch_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'simplecatch_custom_excerpt' );


/** 
 * Allows post queries to sort the results by the order specified in the post__in parameter. 
 * Just set the orderby parameter to post__in
 *
 * uses action filter posts_orderby
 */
if ( !function_exists('simplecatch_sort_query_by_post_in') ) : //simple WordPress 3.0+ version, now across VIP

	add_filter('posts_orderby', 'simplecatch_sort_query_by_post_in', 10, 2);
	
	function simplecatch_sort_query_by_post_in($sortby, $thequery) {
		if ( isset($thequery->query['post__in']) && !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' )
			$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
		return $sortby;
	}

endif;


/**
 * Get the header logo Image from theme options
 *
 * @uses header logo 
 * @get the data value of image from theme options
 * @display Header Image logo
 *
 * @uses default logo if logo field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function simplecatch_headerdetails() {
	//delete_transient( 'simplecatch_headerdetails' );	

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;	
		
	if ( ( !$simplecatch_headerdetails = get_transient( 'simplecatch_headerdetails' ) ) && ( empty( $options[ 'remove_header_logo' ] ) || empty( $options[ 'remove_site_title' ] ) || empty( $options[ 'remove_site_description' ] ) ) ) {

		echo '<!-- refreshing cache -->';
		
		$simplecatch_headerdetails = '<div class="logo-wrap">';

		if( empty( $options[ 'remove_header_logo' ] ) || empty( $options[ 'remove_site_title' ] ) ) {
			$simplecatch_headerdetails .= '<h1 id="site-title">'.'<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'">';

			if( empty( $options[ 'remove_header_logo' ] ) ) {
				if ( !empty( $options[ 'featured_logo_header' ] ) ):
					$simplecatch_headerdetails .= '<img src="'.esc_url( $options['featured_logo_header'] ).'" alt="'.get_bloginfo( 'name' ).'" />';
				else:
					// if empty featured_logo_header on theme options, display default logo
					$simplecatch_headerdetails .='<img src="'. get_template_directory_uri().'/images/logo.png" alt="logo" />';
				endif;
			}

			if ( empty( $options[ 'remove_site_title' ] ) ) {
				$simplecatch_headerdetails .= '<span>'.esc_attr( get_bloginfo( 'name', 'display' ) ).'</span>'; 
			}

			$simplecatch_headerdetails .= '</a></h1>';
		}

		if( empty( $options[ 'remove_site_description' ] ) ) {
			$simplecatch_headerdetails .= '<h2 id="site-description">'.esc_attr( get_bloginfo( 'description' ) ).'</h2>';
		}	

		$simplecatch_headerdetails .= '</div><!-- .logo-wrap -->';
		
	set_transient( 'simplecatch_headerdetails', $simplecatch_headerdetails, 86940 );
	}
	echo $simplecatch_headerdetails;	
} // simplecatch_headerdetails


/**
 * Get the footer logo Image from theme options
 *
 * @uses footer logo 
 * @get the data value of image from theme options
 * @display footer Image logo
 *
 * @uses default logo if logo field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function simplecatch_footerlogo() {
	//delete_transient('simplecatch_footerlogo');	
	
	if ( !$simplecatch_footerlogo = get_transient( 'simplecatch_footerlogo' ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_footer_logo' ] == "0" ) :
		
			// if not empty featured_logo_footer on theme options
			if ( !empty( $options[ 'featured_logo_footer' ] ) ) :
				$simplecatch_footerlogo = 
					'<img src="'.esc_url( $options[ 'featured_logo_footer' ] ).'" alt="'.get_bloginfo( 'name' ).'" />';
			else:
				// if empty featured_logo_footer on theme options, display default fav icon
				$simplecatch_footerlogo ='
					<img src="'. get_template_directory_uri().'/images/logo-foot.png" alt="footerlogo" />';
			endif;
		endif;

		
	set_transient( 'simplecatch_footerlogo', $simplecatch_footerlogo, 86940 );										  
	}
	echo $simplecatch_footerlogo;
} // simplecatch_footerlogo


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function simplecatch_favicon() {
	//delete_transient( 'simplecatch_favicon' );	
	
	if( ( !$simplecatch_favicon = get_transient( 'simplecatch_favicon' ) ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_favicon' ] == "0" ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$simplecatch_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$simplecatch_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;
		
	set_transient( 'simplecatch_favicon', $simplecatch_favicon, 86940 );	
	}	
	echo $simplecatch_favicon ;	
} // simplecatch_favicon

//Load Favicon in Header Section
add_action('wp_head', 'simplecatch_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'simplecatch_favicon' );


/**
 * This function to display featured posts on homepage header
 *
 * @get the data value from theme options
 * @displays on the homepage header
 *
 * @useage Featured Image, Title and Content of Post
 *
 * @uses set_transient and delete_transient
 */
function simplecatch_sliders() {	
	global $post;
	//delete_transient( 'simplecatch_sliders' );
		
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$postperpage = $options[ 'slider_qty' ];
	
	if( ( !$simplecatch_sliders = get_transient( 'simplecatch_sliders' ) ) && !empty( $options[ 'featured_slider' ] ) ) {
		echo '<!-- refreshing cache -->';
		
		$simplecatch_sliders = '
		<div class="featured-slider">';
			$get_featured_posts = new WP_Query( array(
				'posts_per_page' => $postperpage,
				'post__in'		 => $options[ 'featured_slider' ],
				'orderby' 		 => 'post__in',
				'ignore_sticky_posts' => 1 // ignore sticky posts
			));
			$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
				$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
				$excerpt = get_the_excerpt();
				if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }
				$simplecatch_sliders .= '
				<div class="'.$classes.'">
					<div class="featured">
						<div class="slide-image">';
							if( has_post_thumbnail() ) {

								$simplecatch_sliders .= '<a href="' . get_permalink() . '" title="Permalink to '.the_title('','',false).'">';

								if( $options[ 'remove_noise_effect' ] == "0" ) {
									$simplecatch_sliders .= '<span class="img-effect pngfix"></span>';
								}

								$simplecatch_sliders .= get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'</a>';
							}
							else {
								$simplecatch_sliders .= '<span class="img-effect pngfix"></span>';	
							}
							$simplecatch_sliders .= '
						</div> <!-- .slide-image -->
					</div> <!-- .featured -->
					<div class="featured-text">';
						if( $excerpt !='') {
							$simplecatch_sliders .= the_title( '<span>','</span>', false ).': '.$excerpt;
						}
						$simplecatch_sliders .= '
					</div><!-- .featured-text -->
				</div> <!-- .slides -->';
			endwhile; wp_reset_query();
		$simplecatch_sliders .= '
		</div> <!-- .featured-slider -->
			<div id="controllers">
			</div><!-- #controllers -->';
			
	set_transient( 'simplecatch_sliders', $simplecatch_sliders, 86940 );
	}
	echo $simplecatch_sliders;	
} // simplecatch_sliders


/**
 * Display slider or breadcrumb on header
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if exist bread
 */
function simplecatch_sliderbreadcrumb() {
	
	// If the page is home or front page  
	if ( is_home() || is_front_page() ) :
		// display featured slider
		if ( function_exists( 'simplecatch_sliders' ) ):
			simplecatch_sliders();
		endif;
	else : 
		// if breadcrumb is not empty, display breadcrumb
		if ( function_exists( 'bcn_display_list' ) ):
			echo '<div class="breadcrumb">
					<ul>';
						bcn_display_list();
			 	echo '</ul>
					<div class="row-end"></div>
				</div> <!-- .breadcrumb -->';			
		endif; 
		
  	endif;
} // simplecatch_sliderbreadcrumb


/**
 * This function for social links display on header
 *
 * @fetch links through Theme Options
 * @use in widget
 * @social links, Facebook, Twitter and RSS
  */
function simplecatch_headersocialnetworks() {
	//delete_transient( 'simplecatch_headersocialnetworks' );
	
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
	
	if ( ( !$simplecatch_headersocialnetworks = get_transient( 'simplecatch_headersocialnetworks' ) ) &&  ( !empty( $options[ 'social_facebook' ] ) || !empty( $options[ 'social_twitter' ] ) || !empty( $options[ 'social_googleplus' ] ) || !empty( $options[ 'social_pinterest' ] ) || !empty( $options[ 'social_youtube' ] ) || !empty( $options[ 'social_linkedin' ] ) || !empty( $options[ 'social_slideshare' ] )  || !empty( $options[ 'social_foursquare' ] ) || !empty( $options[ 'social_rss' ] )   || !empty( $options[ 'social_vimeo' ] ) || !empty( $options[ 'social_flickr' ] ) || !empty( $options[ 'social_tumblr' ] ) || !empty( $options[ 'social_deviantart' ] ) || !empty( $options[ 'social_dribbble' ] ) || !empty( $options[ 'social_myspace' ] ) || !empty( $options[ 'social_wordpress' ] ) || !empty( $options[ 'social_delicious' ] ) || !empty( $options[ 'social_lastfm' ] ) ) )  {
	
		echo '<!-- refreshing cache -->';
		
		$simplecatch_headersocialnetworks .='
			<ul class="social-profile">';
		
				//facebook
				if ( !empty( $options[ 'social_facebook' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'.sprintf( esc_attr__( '%s in Facebook', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Facebook </a></li>';
				}
				//Twitter
				if ( !empty( $options[ 'social_twitter' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'.sprintf( esc_attr__( '%s in Twitter', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
				}
				//Google+
				if ( !empty( $options[ 'social_googleplus' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'.sprintf( esc_attr__( '%s in Google+', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Google+ </a></li>';
				}
				//Linkedin
				if ( !empty( $options[ 'social_linkedin' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'.sprintf( esc_attr__( '%s in Linkedin', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Linkedin </a></li>';
				}
				//Pinterest
				if ( !empty( $options[ 'social_pinterest' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'.sprintf( esc_attr__( '%s in Pinterest', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
				}				
				//Youtube
				if ( !empty( $options[ 'social_youtube' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'.sprintf( esc_attr__( '%s in YouTube', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' YouTube </a></li>';
				}
				//Vimeo
				if ( !empty( $options[ 'social_vimeo' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'.sprintf( esc_attr__( '%s in Vimeo', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vimeo </a></li>';
				}				
				//Slideshare
				if ( !empty( $options[ 'social_slideshare' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'.sprintf( esc_attr__( '%s in Slideshare', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Slideshare </a></li>';
				}				
				//Foursquare
				if ( !empty( $options[ 'social_foursquare' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="foursquare"><a href="'.esc_url( $options[ 'social_foursquare' ] ).'" title="'.sprintf( esc_attr__( '%s in Foursquare', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' foursquare </a></li>';
				}
				//Flickr
				if ( !empty( $options[ 'social_flickr' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'.sprintf( esc_attr__( '%s in Flickr', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Flickr </a></li>';
				}
				//Tumblr
				if ( !empty( $options[ 'social_tumblr' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'.sprintf( esc_attr__( '%s in Tumblr', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Tumblr </a></li>';
				}
				//deviantART
				if ( !empty( $options[ 'social_deviantart' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'.sprintf( esc_attr__( '%s in deviantART', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' deviantART </a></li>';
				}
				//Dribbble
				if ( !empty( $options[ 'social_dribbble' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'.sprintf( esc_attr__( '%s in Dribbble', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Dribbble </a></li>';
				}
				//MySpace
				if ( !empty( $options[ 'social_myspace' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'.sprintf( esc_attr__( '%s in MySpace', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' MySpace </a></li>';
				}
				//WordPress
				if ( !empty( $options[ 'social_wordpress' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'.sprintf( esc_attr__( '%s in WordPress', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' WordPress </a></li>';
				}				
				//RSS
				if ( !empty( $options[ 'social_rss' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'.sprintf( esc_attr__( '%s in RSS', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' RSS </a></li>';
				}
				//Delicious
				if ( !empty( $options[ 'social_delicious' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="delicious"><a href="'.esc_url( $options[ 'social_delicious' ] ).'" title="'.sprintf( esc_attr__( '%s in Delicious', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Delicious </a></li>';
				}				
				//Last.fm
				if ( !empty( $options[ 'social_lastfm' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="lastfm"><a href="'.esc_url( $options[ 'social_lastfm' ] ).'" title="'.sprintf( esc_attr__( '%s in Last.fm', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Last.fm </a></li>';
				}				
		
				$simplecatch_headersocialnetworks .='
			</ul>
			<div class="row-end"></div>';
		
		set_transient( 'simplecatch_headersocialnetworks', $simplecatch_headersocialnetworks, 86940 );	 
	}
	echo $simplecatch_headersocialnetworks;
} // simplecatch_headersocialnetworks


/**
 * Site Verification  and Webmaster Tools
 *
 * If user sets the code we're going to display meta verification
 * @get the data value from theme options
 * @uses wp_head action to add the code in the header
 * @uses set_transient and delete_transient API for cache
 */
function simplecatch_site_verification() {
	//delete_transient( 'simplecatch_site_verification' );

	if ( ( !$simplecatch_site_verification = get_transient( 'simplecatch_site_verification' ) ) )  {

		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;
		echo '<!-- refreshing cache -->';	
		
		$simplecatch_site_verification = '';
		//google
		if ( !empty( $options['google_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="google-site-verification" content="' .  $options['google_verification'] . '" />' . "\n";
		}
		//bing
		if ( !empty( $options['bing_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="msvalidate.01" content="' .  $options['bing_verification']  . '" />' . "\n";
		}
		//yahoo
		 if ( !empty( $options['yahoo_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="y_key" content="' .  $options['yahoo_verification']  . '" />' . "\n";
		}
	
		//site stats, analytics header code
		if ( !empty( $options['analytic_header'] ) ) {
			$simplecatch_site_verification .=  $options[ 'analytic_header' ] ;
		}
		set_transient( 'simplecatch_site_verification', $simplecatch_site_verification, 86940 );
	}
	echo $simplecatch_site_verification;
}
add_action('wp_head', 'simplecatch_site_verification');


/**
 * This function loads the Footer Code such as Add this code from the Theme Option
 *
 * @get the data value from theme options
 * @load on the footer ONLY
 * @uses wp_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function simplecatch_footercode() {
	//delete_transient( 'simplecatch_footercode' );	
	

	if ( ( !$simplecatch_footercode = get_transient( 'simplecatch_footercode' ) ) ) {

		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;
		echo '<!-- refreshing cache -->';	
		
		//site stats, analytics header code
		if ( !empty( $options['analytic_footer'] ) ) {
			$simplecatch_footercode =  $options[ 'analytic_footer' ] ;
		}
			
	set_transient( 'simplecatch_footercode', $simplecatch_footercode, 86940 );
	}
	echo $simplecatch_footercode;
}
add_action('wp_footer', 'simplecatch_footercode');


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Simple Catch 1.2.3
 */
function simplecatch_inline_css() {
	//delete_transient( 'simplecatch_inline_css' );	
	
	if ( ( !$simplecatch_inline_css = get_transient( 'simplecatch_inline_css' ) ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		if( $options[ 'reset_color' ] == "0" ) {
			$simplecatch_inline_css	= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $simplecatch_inline_css .= '<style type="text/css" media="screen">' . "\n";
			$simplecatch_inline_css .= "#main {
										   color: ".  $options[ 'text_color' ] .";
										}
										#main a {
										    color: ". $options[ 'link_color' ] .";
										}
										#main h1 a, #main h2 a, #main h3 a, #main h4 a, #main h5 a, #main h6 a {
										   color: ".  $options[ 'heading_color' ] .";
										}
										#main #content ul.post-by li, #main #content ul.post-by li a {
											color: ".  $options[ 'meta_color' ] .";	
										}
										#sidebar h3, #sidebar h4, #sidebar h5 {
											color: ".  $options[ 'widget_heading_color' ] .";
										}
										#sidebar, #sidebar p, #sidebar a, #sidebar ul li a, #sidebar ol li a {
											color: ".  $options[ 'widget_text_color' ] .";
										}". "\n";
			$simplecatch_inline_css .= '</style>' . "\n";
		}
		

		echo '<!-- refreshing cache -->' . "\n";
		if( !empty( $options[ 'custom_css' ] ) ) {
			$simplecatch_inline_css	= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $simplecatch_inline_css .= '<style type="text/css" media="screen">' . "\n";
			$simplecatch_inline_css .=  $options['custom_css'] . "\n";
			$simplecatch_inline_css .= '</style>' . "\n";
		}
			
	set_transient( 'simplecatch_inline_css', $simplecatch_inline_css, 86940 );
	}
	echo $simplecatch_inline_css;
}
add_action('wp_head', 'simplecatch_inline_css');


/*
 * Function for showing custom tag cloud
 */
function simplecatch_custom_tag_cloud() {
?>
	<div class="custom-tagcloud"><?php wp_tag_cloud('smallest=12&largest=12px&unit=px'); ?></div>
<?php	
}


/**
 * shows footer credits
 */
function simplecatch_footer() {
?>
	<div class="col5 powered-by"> 
        <?php _e( 'Powered By:', 'simplecatch');?> <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'simplecatch' ) ); ?>" target="_blank" title="<?php esc_attr_e( 'Powered By WordPress', 'simplecatch' ); ?>"><?php _e( 'WordPress', 'simplecatch' ); ?></a> | <?php _e( 'Theme:', 'simplecatch');?> <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'simplecatch' ) ); ?>" target="_blank" title="<?php esc_attr_e( 'Simple Catch', 'simplecatch' ); ?>"><?php _e( 'Simple Catch', 'simplecatch' ); ?></a>
  	</div><!--.col5 powered-by-->

<?php
}
add_filter( 'simplecatch_credits', 'simplecatch_footer' );


/**
 * Function to pass the slider value
 */
function simplecatch_pass_slider_value() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$transition_effect = $options[ 'transition_effect' ];
	$transition_delay = $options[ 'transition_delay' ] * 1000;
	$transition_duration = $options[ 'transition_duration' ] * 1000;
	wp_localize_script( 
		'simplecatch_slider',
		'js_value',
		array(
			'transition_effect' => $transition_effect,
			'transition_delay' => $transition_delay,
			'transition_duration' => $transition_duration
		)
	);
}// simplecatch_pass_slider_value


/**
 * Alter the query for the main loop in home page
 * @uses pre_get_posts hook
 */
function simple_catch_alter_home( $query ){
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options[ 'featured_slider' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['post__not_in'] = $options[ 'featured_slider' ];
		}
	}
	if ( !empty( $options[ 'front_page_category' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}
}
add_action( 'pre_get_posts','simple_catch_alter_home' );


/**
 * Add specific CSS class by filter
 * @uses body_class filter hook
 * @since Simple Catch 1.3.2
 */  
function simplecatch_class_names($classes) { 
	global $post;

	if( $post ) {
		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent,'simplecatch-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID,'simplecatch-sidebarlayout', true ); 
		}
	}
	
	if( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout='default';
	}
		
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
		
	$themeoption_layout = $options['sidebar_layout'];
	
	if( ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar') ) ){
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class','simplecatch_class_names');


/**
 * Display the page/post content
 * @since Simple Catch 1.3.2
 */
function simplecatch_content() {
	global $post;
	$layout = get_post_meta( $post->ID,'simplecatch-sidebarlayout', true ); 
	if( empty( $layout ) )
		$layout='default';
		
	get_header(); 
	
	if( $layout=='default') {
		global $simplecatch_options_settings;
		$options = $simplecatch_options_settings;

		$themeoption_layout = $options['sidebar_layout'];
			
		if( $themeoption_layout == 'left-sidebar' ) {
			get_template_part( 'content-sidebar','left' );
		}
		elseif( $themeoption_layout == 'right-sidebar' ) {
			get_template_part( 'content-sidebar','right' );
		}
		else {
			get_template_part( 'content-sidebar','no' );
		}
	}
	elseif( $layout=='left-sidebar' ) { 
		get_template_part( 'content-sidebar','left' );
	}
	elseif( $layout=='right-sidebar' ) {
		get_template_part( 'content-sidebar','right' );
	}
	else{
		get_template_part( 'content-sidebar','no' );
	}
	
	get_footer(); 
}


/**
 * Display the page/post loop part
 * @since Simple Catch 1.3.2
 */
function simplecatch_loop() {

	if( is_page() ): ?>
    
		<div <?php post_class(); ?> >
			<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
       		<?php the_content(); 
			// copy this <!--nextpage--> and paste at the post content where you want to break the page
			 wp_link_pages(array( 
					'before'			=> '<div class="pagination">Pages: ',
					'after' 			=> '</div>',
					'link_before' 		=> '<span>',
					'link_after'       	=> '</span>',
					'pagelink' 			=> '%',
					'echo' 				=> 1 
				) ); ?>
		</div><!-- .post -->
        
    <?php elseif( is_single() ): ?>
    
		<div <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                        
            <ul class="post-by">
                <li class="no-padding-left"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" 
                    title="<?php echo esc_attr( get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'By', 'simplecatch' ); ?>&nbsp;<?php the_author_meta( 'display_name' );?></a></li>
                <li><?php $simplecatch_date_format = get_option( 'date_format' ); the_time( $simplecatch_date_format ); ?></li>
                <li><?php comments_popup_link( __( 'No Comments', 'simplecatch' ), __( '1 Comment', 'simplecatch' ), __( '% Comments', 'simplecatch' ) ); ?></li>
            </ul>
            <?php the_content();
            // copy this <!--nextpage--> and paste at the post content where you want to break the page
			 wp_link_pages(array( 
					'before'			=> '<div class="pagination">Pages: ',
					'after' 			=> '</div>',
					'link_before' 		=> '<span>',
					'link_after'       	=> '</span>',
					'pagelink' 			=> '%',
					'echo' 				=> 1 
				) );
			$tag = get_the_tags();
			if (! $tag ) { ?>
				<div class='tags'><?php _e( 'Categories: ', 'simplecatch' ); ?> <?php the_category(', '); ?> </div>
			<?php } else { 
					 the_tags( '<div class="tags"> Tags: ', ', ', '</div>'); 
			} ?>
		</div> <!-- .post -->
	<?php endif;
}


/**
 * Display the header div
 * @since Simple Catch 1.3.2
 */
function simplecatch_display_div() {
	echo '<div id="main" class="layout-978">';

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
		
	$themeoption_layout = $options['sidebar_layout'];
		
	if( $themeoption_layout == 'left-sidebar' ) {	
		get_sidebar();
		echo '<div id="content" class="col8">';
	}
	elseif( $themeoption_layout == 'right-sidebar' ) {
		echo '<div id="content" class="col8 no-margin-left">';
	}
	else {
		echo '<div id="content" class="col8">';
	}
	return $themeoption_layout;
}


/**
 * Redirect WordPress Feeds To FeedBurner
 */
function simplecatch_rss_redirect() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
	
    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'simplecatch_rss_redirect');


/**
 * function that displays info bar in Theme Options
 */
function simplecatch_infobar() {
?>
    <div id="info-support">
    
    	<div class="upgrade">
        	<a class="upgrade button" href="<?php echo esc_url(__('http://catchthemes.com/themes/simple-catch-pro','simplecatch')); ?>" title="<?php esc_attr_e('Upgrade Simple Catch Pro at Introductory Price $19.99 Only', 'simplecatch'); ?>" target="_blank"><?php printf(__('Upgrade Simple Catch Pro at Introductory Price $19.99 Only','simplecatch')); ?></a>
      	</div>
        
        <div class="theme-social">
            <div class="widget-fb">
                <div data-show-faces="false" data-width="80" data-layout="button_count" data-send="false" data-href="<?php echo esc_url(__('http://facebook.com/catchthemes','simplecatch')); ?>" class="fb-like"></div>
            </div>
            <div class="widget-tw">
                <a data-dnt="true" data-show-screen-name="true" data-show-count="true" class="twitter-follow-button" href="<?php echo esc_url(__('https://twitter.com/catchthemes','simplecatch')); ?>">Follow @catchthemes</a>

            </div>
       	</div>
        
        <div class="clear"></div>
    </div>
                     
<?php
}