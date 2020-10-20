<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

defined("ABSPATH") || exit();


function load_scripts_styles() {
	$vn = wp_get_theme()->get( 'Version' );
	// Styles
	wp_enqueue_style( 'font-awesome',     get_template_directory_uri()."/config-layerslider/LayerSlider/static/font-awesome/css/font-awesome.min.css", $vn, 'all' );
	wp_enqueue_style( 'bootstrap' , get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'custom-styles' , get_stylesheet_directory_uri() . '/css/custom-styles.css');
	// Scripts
	wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery'), $vn , true );
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles');


function myaparat($atts) {
	extract( shortcode_atts( array(
		'id' => '',
		'width' => '100%',
		'height' => 450,
		'style' => 'margin: 10px;'
	), $atts ) );
	$servertype = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');

	return "<center style='{$style}'><iframe src='".$servertype."://www.aparat.com/video/video/embed/videohash/{$id}/vt/frame' width='{$width}' height='{$height}' allowfullscreen='true' style='border:none!important'></iframe></center>";
}
add_shortcode( 'aparat', 'myaparat' );



add_shortcode('show_product_tags', 'product_tags');
function product_tags($attr , $content){
	$output = array();
	$terms = wp_get_post_terms( get_the_id(), 'product_tag' );
	if( count($terms) > 0 ){
		foreach($terms as $term){
			$term_id = $term->term_id; // Product tag Id
			$term_name = $term->name; // Product tag Name
			$term_slug = $term->slug; // Product tag slug
			$term_link = get_term_link( $term, 'product_tag' ); // Product tag link
			$output[] = '<a href="'.$term_link.'" class="product-tag">'.$term_name.'</a>';
		}
		// Set the array in a coma separated string of product tags for example
		$output = implode( ', ', $output );
		// Display the coma separated string of the product tags
		echo 'برچسب ها: ' . $output;
	}
}


/**
 * Add extra fields to register form.
 */
function wooc_extra_register_fields() {?>
	<p class="form-row form-row-first">
		<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name"
		       value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>
	<p class="form-row form-row-last">
		<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name"
		       value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>
	<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php _e( 'Phone Number', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone"
		       value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" maxlength="11"
		       onkeyup="this.value = this.value.replace(/[^\d\.]+/g, '');"/>
	</p>
	<div class="clear"></div>
	<?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
/**
 * Below code save extra fields.
 */
function wooc_save_extra_register_fields( $customer_id ) {
	if ( isset( $_POST['billing_phone'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}
	if ( isset( $_POST['billing_first_name'] ) ) {
		//First name field which is by default
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		// First name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		// Last name field which is by default
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		// Last name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );



/*
 * Replace 'textdomain' with your plugin's textdomain. e.g. 'woocommerce'.
 * File to be named, for example, yourtranslationfile-en_GB.mo
 * File to be placed, for example, wp-content/lanaguages/textdomain/yourtranslationfile-en_GB.mo
 */
add_filter( 'load_textdomain_mofile', 'load_custom_plugin_translation_file', 10, 2 );
function load_custom_plugin_translation_file( $mofile, $domain ) {
	if ( 'textdomain' === $domain ) {
		$mofile = WP_LANG_DIR . '/woocommerce/woocommerce-fa_IR-' . get_locale() . '.mo';
	}
	return $mofile;
}

add_filter( 'get_shortlink', function( $shortlink ) {return $shortlink;} );


function avs_posts_tag_cb() {
	global $post;
	$the_tags = get_the_tags( $post->ID );
	$output = '';
	foreach($the_tags as $tag) {
		$taglink = get_tag_link($tag->term_id);
		if(!next($the_tags)) {
			$output .= '<span class="post_tag"><a href='.$taglink.'>'.$tag->name.' </a></span>';
		}else{
			$output .= '<span class="post_tag"><a href='.$taglink.'>'.$tag->name.' </a>،</span>';
		}
	}
	return 'برچسب ها: ' . $output;
}
add_shortcode('avs_posts_tag', 'avs_posts_tag_cb');


/**
 * Remove the generated product schema markup from Product Category and Shop pages.
 */
function wc_remove_product_schema_product_archive() {
	remove_action( 'woocommerce_shop_loop', array( WC()->structured_data, 'generate_product_data' ), 10, 0 );
}
add_action( 'woocommerce_init', 'wc_remove_product_schema_product_archive' );
