<?php
function parse_button($atts, $content=''){
	$ID = isset($atts['id']) ? $atts['id'] : rand(10,9999);
	$size = isset($atts['size']) ? $atts['size'] : '';
	$style = isset($atts['style']) ? $atts['style'] : '';
	$link = isset($atts['link']) ? $atts['link'] : '#';

	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$color = isset($atts['color']) ? $atts['color'] : '';
	$target = isset($atts['target']) ? $atts['target'] : '';
	
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); 
		if($color && $color!='#'){
			if($style=='1'){
				echo '<style>
					.button-button_'.$ID.'.btn-primary{background-color:'.$color.';}
					.button-button_'.$ID.'.btn-primary:hover{box-shadow: 0 0 25px -3px '.$color.';}
				</style>';
			}else{
				echo '<style>
					.button-button_'.$ID.'.btn-default:hover{background-color:'.$color.';color:#fff;box-shadow: 0 0 25px -3px '.$color.';}
					.button-button_'.$ID.'.btn-default{color:'.$color.';}
					.button-button_'.$ID.'.btn-default .btn-icon{color:'.$color.';}
					.button-button_'.$ID.'.btn-default:hover .btn-icon{color:#fff;}
				</style>';

			}
		}
		?>
    	<a class="btn skew-btn<?php echo $ID?' button-button_'.$ID:''; echo $style?' btn-primary':' btn-default'; echo $size=='big'?' btn-lg':''; echo ' '.$animation_class;  echo $icon?' has-icon':'';?>" href="<?php echo $link ?>" <?php if($animation_delay){?> data-delay=<?php echo $animation_delay; ?> <?php } if($target){?> target="_blank"<?php } ?>>
        <?php
			echo '<span class="btn-text">'.$content.'</span>';
			echo $icon?'<span class="btn-icon"><i class="fa '.$icon.'"></i></span>':'';
		?>
        </a>
        <?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_button', 'parse_button' );

add_action( 'after_setup_theme', 'reg_sc_button' );
function reg_sc_button(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Button",'conferencepro'),
	   "base" => "sc_button",
	   "class" => "",
	   "icon" => "icon-button",
	   "controls" => "full",
	   "category" => esc_html__('Content'),
	   "params" => array(
	   	  array(
			"type" => "textfield",
			"heading" => esc_html__("Button Text", "leafcolor"),
			"param_name" => "content",
			"value" => "",
			"description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Button Link", "leafcolor"),
			"param_name" => "link",
			"value" => "",
			"description" => "",
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Open in new tab?", "leafcolor"),
			 "param_name" => "target",
			 "value" => array(
			 	esc_html__('No', 'conferencepro') => '',
				esc_html__('Yes', 'conferencepro') => '1',
			 ),
			 "description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Icon", "leafcolor"),
			"param_name" => "icon",
			"value" => "",
			"description" => esc_html__("Font Awesome Icon (ex: fa-apple)", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Button Size", "leafcolor"),
			 "param_name" => "size",
			 "value" => array(
			 	esc_html__('Small', 'conferencepro') => 'small',
				esc_html__('Big', 'conferencepro') => 'big',
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Style", 'conferencepro'),
			 "param_name" => "style",
			 "value" => array(
			 	esc_html__('Light', 'conferencepro') => 0,
				esc_html__('Dark', 'conferencepro') => 1,
			 ),
			 "description" => '',
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Button Color", 'conferencepro'),
			 "param_name" => "color",
			 "value" => '',
			 "description" => '',
		  )
	   )
	));
	}
}