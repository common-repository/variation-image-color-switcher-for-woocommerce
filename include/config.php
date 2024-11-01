<?php
	/**
     * image swither setting panel
     */
	 
	 
	if ( ! defined( 'ABSPATH' ) ) {
	exit;
    }


	if (!class_exists('Redux'))
    {
    return;
    }
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   
	$opt_name = "ld_switch";
	$theme    = wp_get_theme();
	
	$args = array(
    'opt_name' => $opt_name,
    'display_name' => $theme->get('Name') ,
    'display_version' => $theme->get('Version') ,
    'menu_type' => 'submenu',
    'allow_sub_menu' => true,
    'menu_title' => esc_html__('Logicdigger Image Switch', 'logicdigger'),'page_title'           => esc_html__('ThemeSettings', 'logicdigger') ,
    'google_api_key' => '',
    'google_update_weekly' => false,
    'async_typography' => true,
    'admin_bar' => true,
    'admin_bar_icon' => '',
    'admin_bar_priority' => 50,
    'global_variable' => $opt_name,
    'dev_mode' => false,
    'forced_dev_mode_off' => true,
    'update_notice' => false,
    'customizer' => true,
    'page_priority' => null,
    'page_parent' => 'options-general.php',
    'page_permissions' => 'manage_options',
    'menu_icon' => '',
    'last_tab' => '',
	
    'page_icon' => 'icon-themes',
    'page_slug' => 'logicdigger-switch',
    'save_defaults' => true,
    'default_show' => false,
    'default_mark' => '',
    'show_import_export' => false
);


Redux::setArgs( $opt_name, $args );

$terms = get_terms();
//echo "<pre>"; print_r($terms);
$ld_attribue = array();
if($terms){
foreach($terms as $term){
	if(substr( $term->taxonomy, 0, 3 ) === "pa_"){
		
		$ld_attribue['attribute_'.$term->taxonomy] = substr_replace($term->taxonomy,'',0,3);
		}
	
	
}
}



Redux::setSection( $opt_name, array(
        'title'            => __( 'Logicdigger switch Settings', 'redux-framework-demo' ),
        'id'               => 'basic_settings',
        'customizer_width' => '450px',
		'icon'             => 'el el-home',
		  'desc'             => __( 'For our work you may donate us for coffee ', 'redux-framework-demo' ) . '<a href="//paypal.me/logicdigger" target="_blank">Donate</a>',
        'fields'           => array(
		array(
                'id'       => 'wc-ld-enable',
                'type'     => 'checkbox',
                'title'    => __( 'Enable', 'redux-framework-demo' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
		 array(
                'id'       => 'ld-attribute-style',
                'type'     => 'radio',
                'title'    => __( 'Select Style', 'redux-framework-demo' ),
                 //Must provide key => value pairs for radio options
                'options'  => array(
                    '0' => 'Square',
                    '1' => 'Round',
                   
                ),
                'default'  => '0'
            ),
             array(
                'id'       => 'ld-attribute-data',
                'type'     => 'select',
                'multi'    => false,
                'title'    => __( 'Select attribute for image', 'redux-framework-demo' ),
                'subtitle' => __( 'Image will show on selected attribute.', 'redux-framework-demo' ),
         //'desc' => __( 'Note: Select only one attribute( you can select more then one if both not used together in product)', 'redux-framework-demo' ),
                //Must provide key => value pairs for radio options
                'options'  => $ld_attribue,
                //'required' => array( 'opt-select', 'equals', array( '1', '3' ) ),
            ),
			 array(
                'id'       => 'ld-attribute-data-color-bg',
                'type'     => 'select',
                'multi'    => false,
                'title'    => __( 'Select attribute for color background', 'redux-framework-demo' ),
                'subtitle' => __( 'Background color will be add on selected attribute.', 'redux-framework-demo' ),
                //Must provide key => value pairs for radio options
                'options'  => $ld_attribue,
                //'required' => array( 'opt-select', 'equals', array( '1', '3' ) ),
               
            ),
			  array(
                'id'             => 'id-switch-size',
                'type'           => 'dimensions',
                'units'          => array( 'em', 'px' ),    // You can specify a unit value. Possible: px, em, %
                'units_extended' => 'true',  // Allow users to select any type of unit
                'title'          => __( 'Image height and width', 'redux-framework-demo' ),
				 'output' => array('.lg-select .ld-switch-img,.lg-select .ld-switch-no-img , label.lg_label.Active-cl span'),
     
                'default'        => array(
                    'width'  => 60,
                    'height' => 60,
                )
            ),
			 array(
                'id'             => 'id-switch-padding-img',
                'type'           => 'spacing',
                 'all'      => false,
				 'mode'     => 'padding',
				   'units'          => array( 'em', 'px' ),
                'units_extended' => 'true',  // Allow users to select any type of unit
                'title'          => __( 'Padding for Image variations', 'redux-framework-demo' ),
				 'output' => array('.color_label img'),
                'default'        => array(
                     'padding-top'    => '3px',
                    'padding-right'  => '3px',
                    'padding-bottom' => '3px',
                    'padding-left'   => '3px'   ) 
            ),
              
			   array(
                'id'             => 'id-switch-padding-color',
                'type'           => 'spacing',
                 'all'      => false,
				 'mode'     => 'padding',
				   'units'          => array( 'em', 'px' ),
                'units_extended' => 'true',  // Allow users to select any type of unit
                'title'          => __( 'Padding for color variations', 'redux-framework-demo' ),
				 'output' => array('.variation-radios label.lg_label.Active-cl'),
                'default'        => array(
                     'padding-top'    => '3px',
                    'padding-right'  => '3px',
                    'padding-bottom' => '3px',
                    'padding-left'   => '3px'   ) 
            ),
			 array(
                'id'             => 'id-switch-nargin',
                'type'           => 'spacing',
                 'all'      => false,
				 'mode'     => 'margin',
				   'units'          => array( 'em', 'px' ),
                'units_extended' => 'true',  // Allow users to select any type of unit
                'title'          => __( 'Margin for all variations', 'redux-framework-demo' ),
				'output' => array('.variation-radios.lg-select .lg_label,table.variations label.color_label'),
                'default'        => array(
                    'margin-top'    => '0px',
                    'margin-right'  => '10px',
                    'margin-bottom' => '10px',
                    'margin-left'   => '0px'
                ) 
            ),
			 array(
                'id'             => 'id-switch-label-height',
                'type'           => 'spacing',
                 'all'      => false,
				 'mode'     => 'padding',
				   'units'          => array( 'em', 'px' ),
                'units_extended' => 'true',  // Allow users to select any type of unit
                'title'          => __( 'Padding for Text variations', 'redux-framework-demo' ),
				 'output' => array('.variation-radios.lg-select .lg_label'),
                'default'        => array(
                     'padding-top'    => '10px',
                    'padding-right'  => '10px',
                    'padding-bottom' => '10px',
                    'padding-left'   => '10px'
                )
            ),
			  array(
                'id'       => 'id-switch-label-border',
                'type'     => 'border',
                'title'    => __( 'Border style', 'redux-framework-demo' ),
				'output' => array('.variation-radios.lg-select .lg_label,table.variations label.color_label'),
                'default'  => array(
                    'border-color'  => '#ccc',
                    'border-style'  => 'solid',
                    'border-top'    => '2px',
                    'border-right'  => '2px',
                    'border-bottom' => '2px',
                    'border-left'   => '2px'
                )
			 ),
				array(
                'id'       => 'id-switch-border-hover',
                'type'     => 'border',
                'title'    => __( 'Border Active color', 'redux-framework-demo' ),
				'output' => array('.variation-radios.lg-select input:checked + .color_label,.variation-radios.lg-select input:checked + label'),
                'default'  => array(
                    'border-color'  => '#ff9f00',
					 'border-style'  => 'solid',
                   'border-top'    => '2px',
                    'border-right'  => '2px',
                    'border-bottom' => '2px',
                    'border-left'   => '2px'
                )
				
            ),
			 array(
                'id'       => 'id-switch-text-color',
                'type'     => 'link_color',
                'title'    => __( 'Text Color', 'redux-framework-demo' ),
                //'regular'   => false, // Disable Regular Color
                //'hover'     => false, // Disable Hover Color
                'active'    => false, // Disable Active Color
                'visited'   => false,  // Enable Visited Color
				'output' => array('.variation-radios.lg-select .lg_label'),
                'default'  => array(
                    'regular' => '#000',
                )
            ),
			array(
                'id'       => 'id-switch-text-color-active',
                'type'     => 'link_color',
                'title'    => __( 'Text Active color', 'redux-framework-demo' ),
                //'regular'   => false, // Disable Regular Color
                'hover'     => false, // Disable Hover Color
                'active'    => false, // Disable Active Color
                'visited'   => false,  // Enable Visited Color
				'output' => array('.variation-radios.lg-select input:checked + label'),
                'default'  => array(
                    'regular' => '#ff9f00',
                )
            ),
			array(
                'id'       => 'id-switch-text-bg',
                'type'     => 'color_rgba',
                'title'    => __( 'Background color', 'redux-framework-demo' ),
                //'regular'   => false, // Disable Regular Color
                'hover'     => true, // Disable Hover Color
                //'active'    => false, // Disable Active Color
                //'visited'   => false,  // Enable Visited Color
				 'mode'     => 'background',
				'output' => array('.variation-radios.lg-select .lg_label'),
                'default'  => array(
                    'regular' => '#ff9f00',
                )
            ),
         array(
                'id'       => 'id-switch-text-bg-hover',
                'type'     => 'color_rgba',
                'title'    => __( 'Background color Hover', 'redux-framework-demo' ),
                //'regular'   => false, // Disable Regular Color
                'hover'     => true, // Disable Hover Color
                //'active'    => false, // Disable Active Color
                //'visited'   => false,  // Enable Visited Color
				 'mode'     => 'background',
				'output' => array('.variation-radios.lg-select .lg_label:hover'),
                'default'  => array(
                    'regular' => '#ff9f00',
                )
            ),
    ) 
    ) 
	);
}
