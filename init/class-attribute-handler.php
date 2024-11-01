<?php

defined( 'ABSPATH' ) || exit;

class WC_Ld_Attribute_Handler {

	function __construct() {
		add_action( 'admin_init', array( $this, 'init_attribute_hooks' ) );
		add_action( 'woocommerce_product_option_terms', array( $this, 'product_option_terms' ), 10, 2 );
	}

	/**
	 * Set all the hooks for adding fields to attribute screen
	 *
	 * Save new term meta
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_attribute_hooks() {

		if ( empty( wc_get_attribute_taxonomies() ) ) {
			return;
		}

		foreach ( wc_get_attribute_taxonomies() as $attribute_taxonomy ) {

			$attribute_taxonomy_name = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );

			add_action( $attribute_taxonomy_name . '_add_form_fields', array( $this, 'wc_add_attribute_fields' ) );
			add_action( $attribute_taxonomy_name . '_edit_form_fields', array(
				$this,
				'wc_edit_attribute_fields'
			), 10, 2 );

			add_filter( 'manage_edit-' . $attribute_taxonomy_name . '_columns', array(
				$this,
				'add_attribute_columns'
			) );
			add_filter( 'manage_' . $attribute_taxonomy_name . '_custom_column', array(
				$this,
				'add_attribute_column_content'
			), 10, 3 );

		}

		add_action( 'created_term', array( $this, 'wc_save_term_meta' ) );
		add_action( 'edit_term', array( $this, 'wc_save_term_meta' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'colorpicker_enqueue' ) );
		add_action( 'admin_print_scripts', array( $this, 'colorpicker_init_inline' ), 20 );

	}


	public function wc_add_attribute_fields(){
		
		 ?> 
		<div class="form-field term-colorpicker-wrap"> 
		<label for="term-colorpicker">Category Color</label> 
		<input name="dig" value="#ffffff" class="colorpicker" id="term-colorpicker" /> 
		<p>This is the field description where you can tell the user how the color is used in the theme.</p> 
		</div>
	<?php 
		
	}
	
	public function wc_edit_attribute_fields($term){
			$color = get_term_meta( $term->term_id,'dig',true);
			//print_r($color );die;
			$color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff'; ?> 
					<tr class="form-field term-colorpicker-wrap"> 
						<th scope="row">
						<label for="term-colorpicker">Select Color</label>
						</th> 
							<td> 
							<input name="dig" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" /> 
							<p class="description">This is the field description where you can tell the user how the color is used in the theme.</p> 
							</td> 
					</tr> 
			<?php
		
	}
	function wc_save_term_meta( $term_id ) { 
		// Save term color if possible 
	
		if( isset( $_POST['dig'] ) && !empty( $_POST['dig'] ) ){ 
		update_term_meta( $term_id, 'dig', sanitize_hex_color_no_hash( $_POST['dig'] ) ); 
		} else {
		delete_term_meta( $term_id, 'dig' ); 
		} 
	}
	
	function colorpicker_enqueue( ) { 
			// Colorpicker Scripts 
			wp_enqueue_script( 'wp-color-picker' ); 
			// Colorpicker Styles 
			wp_enqueue_style( 'wp-color-picker' );

	}
	
	function colorpicker_init_inline() { 
				?> 
		<script> 
		jQuery( document ).ready( function( $ ) {
		 $( '.colorpicker' ).wpColorPicker(); 
		} ); 
		// End Document Ready JQuery 
		</script> 
<?php 
	}
	function add_attribute_column_content( $columns, $column, $term_id ) {
		if('color' == $column){
		$value = get_term_meta( $term_id, "dig", true );
		printf( '<div class="wc-ld-switch-color" style="background-color:#%s;height:34px;width:34px"></div>', esc_attr( $value ) );
		}
	}
	
	function add_attribute_columns( $columns ) {

		$new_columns = array();

		$new_columns['cb'] = ! empty( $columns['cb'] ) ? $columns['cb'] : '';

		$new_columns['color'] = __('color', 'wc-variation-swatches');

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

}

new WC_Ld_Attribute_Handler();
