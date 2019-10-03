<?php
function parse_pricingtable($atts, $content)
{
    $id                 	= (isset($atts['id']) && $atts['id'] != '') ? $atts['id'] : '';
    $output_id              = ' id= "' . $id . '"';
    $class                 	= (isset($atts['class']) && $atts['class'] != '') ? $atts['class'] : '';
    $color 					= (isset($atts['color']) && $atts['color'] != '') ? 'color:' . $atts['color'] . ';' : '';
 
	$html = '
	<div ' . $output_id . ' class="container">
		<div class="row ' . $class . '">
			'.do_shortcode(str_replace('<br class="nc" />', '', $content)).'
		</div>
	</div>
	';

	$style = '';	
	$style .= '<style type="text/css">';
	$style .= '#' . $id . '{' . $color . '}';
	$style .= '</style>';

	return $html . $style;
}

function parse_pricingtable_column($atts, $content)
{

 	$rand_ID              	=  rand(1, 9999);
    $id                 	= 'compare-table-colum-' . $rand_ID;
    $output_id              = ' id= "' . $id . '"';

    $class                 	= (isset($atts['class']) && $atts['class'] != '') ? $atts['class'] : '';

    $bg_image = '';
    if (isset($atts['bg_image']) && $atts['bg_image'] != '') {
    	$bg_file = @wp_get_attachment_image_src( $atts['bg_image'], $size = 'leaf_thumb_409x258');
    	$bg_image = isset($bg_file[0]) ? ('background-image:url(' . $bg_file[0] . ');') : '';
    }
    
    $title 					= (isset($atts['title']) && $atts['title'] != '') ? $atts['title'] : '';
	$price					= (isset($atts['price']) && $atts['price'] != '') ? $atts['price'] : '';
	$price_text				= (isset($atts['price_text']) && $atts['price_text'] != '') ? $atts['price_text'] : '';
	
	if((isset($atts['column']) && ($atts['column'] != '')))
	{
		if($atts['column'] == 1)
			$md_column = 12;
		else if($atts['column'] == 2)
			$md_column = 6;
		else if($atts['column'] == 3)
			$md_column = 4;
		else if($atts['column'] == 4)
			$md_column = 3;
		else
			$md_column = 4;
	}
	else
	{
		$md_column = 12;
	}
	

	$md_class = 'class="col-md-' . $md_column . ' ' . $class .' compare-table-wrapper"';

	$html = '
		<div ' . $md_class . '>
			<div class="compare-table" ' . $output_id . '>
				<div class="compare-table-price'. ($bg_image?' price-has-bg main-color-1-bg dark-div':'') .'" style="'.$bg_image.' ">
					<h4 class="ct-price-title">' . $title . '</h4>
					<span class="ct-price main-color-1 h2">' . $price . '</span>
					<span class="ct-price-text">' . $price_text . '</span>
				</div>
				'.do_shortcode(str_replace('<br class="nc" />', '', $content)).'
			</div>
		</div> ';


	$html=str_replace("<p></p>","",$html);
	return $html;
}

function parse_pricingtable_row($atts, $content)
{
	$rand_ID              	=  rand(1, 9999);
    $id                 	= 'compare-table-row-' . $rand_ID;
    $output_id              = ' id= "' . $id . '"';

	$class                 	= (isset($atts['class']) && $atts['class'] != '') ? $atts['class'] : '';
	
	$html ='';
	$html .= '<div class="table-options' . $class . '" ' . $output_id . '>' .do_shortcode( $content) . '</div>';


	$html=str_replace("<p></p>","",$html);
	return $html;
}

add_shortcode( 'pricingtable', 'parse_pricingtable' );
add_shortcode( 'c_column', 'parse_pricingtable_column' );
add_shortcode( 'c_row', 'parse_pricingtable_row' );

add_action( 'after_setup_theme', 'reg_leaf_pricingtable' );
function reg_leaf_pricingtable(){
	if(function_exists('vc_map')){
	vc_map( array(
			"name" => esc_html__("Pricing Table", "leafcolor"),
			"base" => "c_column",
			"content_element" => true,
			"as_parent" => array('only' => 'c_row'),
			"icon" => "icon-pricingtable",
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Column Title", "leafcolor"),
					"param_name" => "title",
					"value" => "",
					"description" => "Ex: Regular",
					"admin_label" => true
				  ),
				  array(
					 "type" => "attach_image",
					 "holder" => "div",
					 "class" => "",
					 "heading" => esc_html__("Background image", 'conferencepro'),
					 "param_name" => "bg_image",
					 "value" => '',
					 "description" => '',
				  ),
				  array(
					"type" => "textfield",
					"heading" => esc_html__("Price", "leafcolor"),
					"param_name" => "price",
					"value" => "",
					"description" => "Ex: $200",
					"admin_label" => true
				  ),
				   array(
					"type" => "textfield",
					"heading" => esc_html__("Price Text", "leafcolor"),
					"param_name" => "price_text",
					"value" => "",
					"description" => "Ex: Per Month",
				  ),
				  
			),
			"js_view" => 'VcColumnView'
		) );
		vc_map( array(
			"name" => esc_html__("Row", "leafcolor"),
			"base" => "c_row",
			"content_element" => true,
			"as_child" => array('only' => 'c_row'),
			"icon" => "icon-comparetable-row",
			"params" => array(
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Row Content", "leafcolor"),
					"param_name" => "content",
					"value" => "Content",
					"description" => "",
					"admin_label" => true
				  ),
				array(
					"type" => "textfield",
					"heading" => esc_html__("CSS Class", "leafcolor"),
					"param_name" => "class",
					"value" => "",
					"description" => "",
				  ),
			),
		) );
	}
	if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer')){
		class WPBakeryShortCode_pricingtable extends WPBakeryShortCodesContainer{}
		class WPBakeryShortCode_c_column extends WPBakeryShortCodesContainer{}
	}
}
