<?php
	/**
		* Plugin Initializer
		*
		* @since   1.0.0
		* @package woocommerce image/color switcher 
	*/
	
	// Exit if accessed directly.
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

class WC_Ld_Variation_Switch_init {
	
	function __construct() {
		add_filter('woocommerce_dropdown_variation_attribute_options_html',  array( $this, 'lg_variation_to_image' ) , 20, 2);
		add_filter( 'woocommerce_variation_is_active',array( $this, 'lg_grey_out_variation' ), 10, 2 );
		add_filter( 'woocommerce_ajax_variation_threshold', array( $this, 'lg_wc_ajax_variation_threshold' ), 10, 2 );
		add_action('wp_enqueue_scripts', array( $this, 'ld_scropts' ),10);
	}
	public function ld_scropts(){	
		wp_enqueue_script( 'ld_script', plugins_url( '../assets/js/script.js', __FILE__ ),false, '1.0.0',true );
		wp_register_style( 'ld_style',    plugins_url( '../assets/css/style.css',    __FILE__ ), false, '1.0.0',false );
		wp_enqueue_style ( 'ld_style' );
		
	}

	public function lg_variation_to_image($html, $args) {
	global $ld_switch;
	$images = array();
		$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
		'options'          => false,
		'attribute'        => false,
		'product'          => false,
		'selected'         => false,
		'name'             => '',
		'id'               => '',
		'class'            => '',
		'show_option_none' => __('Choose an option', 'woocommerce'),
		));
		
		if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
			$selected_key     = 'attribute_'.sanitize_title($args['attribute']);
			$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
		}
		
		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
		$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
		$class                 = $args['class'];
		$show_option_none      = (bool)$args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');
		
		if(empty($options) && !empty($product) && !empty($attribute)) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}
		
		$radios = '<div class="variation-radios lg-select">';
		
		$Atrstyle = "ld-style-".$ld_switch['ld-attribute-style'];
		
		if(!empty($options)) {
			if($product && taxonomy_exists($attribute)) {
				$terms = wc_get_product_terms($product->get_id(), $attribute, array(
				'fields' => 'all'
				));
				$lg_product = new WC_Product_Variable( $product->get_id() );
				$lg_variations = $lg_product->get_available_variations();
				foreach ( $lg_variations as $lg_variation ) {
				
					$images[$lg_variation['attributes'][$name]] =  $lg_variation['image']['thumb_src'];
				}
				foreach($terms as $term) {
					if(in_array($term->slug, $options, true)) {
					$color = get_term_meta( $term->term_id,'dig',true);
				
			        $BGcolor = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff';
						if( isset($ld_switch['ld-attribute-data']) && $name == $ld_switch['ld-attribute-data']){
							if(!empty($images[$term->slug])){
								$ld_label = "<img class='ld-switch-img' src=" .$images[$term->slug].">";
								$radios .= '<input type="checkbox"  name="'.esc_attr($name).'" id="lg'.esc_attr($term->slug).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="lg'.esc_attr($term->slug).'" class="color_label '.$Atrstyle.'" title="'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'" >'.$ld_label.'</label>';
							}
							}else{
						     	if( isset($ld_switch['ld-attribute-data-color-bg']) && $name == $ld_switch['ld-attribute-data-color-bg']){
							   $bgClass = "Active-cl";
								$radios .= '<input type="checkbox" name="'.esc_attr($name).'"  id="lg'.esc_attr($term->slug).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label class="lg_label '.$bgClass.' '.$Atrstyle.'" for="lg'.esc_attr($term->slug).'"><span style="background-color:'.$BGcolor.'">&nbsp;</span></label>';
								}else{
								$radios .= '<input type="checkbox" name="'.esc_attr($name).'"  id="lg'.esc_attr($term->slug).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label class="lg_label" for="lg'.esc_attr($term->slug).'"><span>'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</span></label>';
					
								}
								}     
					}
				
				}
			}
		}
		
		$radios .= '</div>';
		
		return $html.$radios;
	}
	
	
	
	// grey_out_variations_when_out_of_stock
	public function lg_grey_out_variation( $grey_out, $variation ) {
		
		if ( ! $variation->is_in_stock() )
		return false;
		
		return true;
	}
	
	
	
	public function lg_wc_ajax_variation_threshold( $qty, $product ) {
		return 200;
	}
	
	
	
}
	add_action('init','wc_ld_switch_active');

	function wc_ld_switch_active(){
		global $ld_switch;
		if($ld_switch['wc-ld-enable']){
	new WC_Ld_Variation_Switch_init();	
		}
	}

    require_once ('class-attribute-handler.php');
	?>