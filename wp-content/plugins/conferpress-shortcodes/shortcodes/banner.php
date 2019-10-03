<?php
function parse_sc_banner($atts, $content=''){
	//get parameter
	global $muber_item;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$muber_item = isset($atts['number']) ? $atts['number'] : '';

	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
    	<div class="leaf-banner banner-<?php echo esc_html($ID);  echo ' '.esc_html($animation_class); ?>" data-delay=<?php echo esc_html($animation_delay); ?>>
			<div class="row row-no-padding">
                    <?php echo do_shortcode($content); ?>
            </div>
        </div>
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_banner', 'parse_sc_banner' );

function parse_sc_banner_item($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$small_title = isset($atts['small_title']) ? $atts['small_title'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$url = isset($atts['url']) ? $atts['url'] : '#';
	$bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
	$title_size = isset($atts['title_size']) ? $atts['title_size'] : '';
	global $muber_item;
	$css_cl ='';
	if($muber_item=='2'){ $css_cl = 'col-sm-6';}
	elseif($muber_item=='3'){ $css_cl = 'col-sm-4';}
	elseif($muber_item=='4'||$muber_item=='5'){ $css_cl = 'col-sm-3';}
	elseif($muber_item=='6'){ $css_cl = 'col-sm-2';}
	ob_start(); ?>
    	<div class="leaf-banner-col <?php echo $css_cl; ?>">
			<?php $thumbnail = wp_get_attachment_image_src($bg_image,'large', true); ?>
            <div class="leaf-banner-item banner-item-<?php echo esc_html($ID); ?> dark-div" style="background-image:url(<?php echo esc_url($thumbnail[0]) ?>)">
                <a href="<?php echo esc_url($url); ?>" class="leaf-banner-content">
                    <div class="leaf-banner-content-inner">
                    	<?php echo $icon?'<i class="banner-icon fa '.$icon.'"></i>':''; ?>
                        <h2 class="<?php echo ($title_size=='small')?'h2':'h1'; ?>"><?php echo esc_html($title) ?></h2>
                        <h3 class="h5"><?php echo esc_html($small_title) ?></h3>
                    </div>
                </a>
            </div><!--/leaf-banner-item-->
        </div>
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_banner_item', 'parse_sc_banner_item' );

//Visual Composer
add_action( 'after_setup_theme', 'reg_sc_banner' );
function reg_sc_banner(){
	if(function_exists('vc_map')){
		//parent
		vc_map( array(
			"name" => esc_html__("Banner", "leafcolor"),
			"base" => "sc_banner_item",
			"controls" => "full",
			"category" => esc_html__('Content'),
			"icon" => "icon-banner",
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", "leafcolor"),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__("Title Banner", "leafcolor"),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Small Title", "leafcolor"),
					"param_name" => "small_title",
					"value" => "",
					"description" => ""
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Icon", "leafcolor"),
					"param_name" => "icon",
					"value" => "",
					"description" => esc_html__("Font Awesome Icon (ex: fa-apple)", "leafcolor"),
				  ),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Background Image", "leafcolor"),
					"param_name" => "bg_image",
					"value" => "",
					"description" => esc_html__("", "leafcolor"),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("URL", "leafcolor"),
					"param_name" => "url",
					"value" => "",
					"description" => "",
				),
				array(
					 "type" => "dropdown",
					 "holder" => "div",
					 "class" => "",
					 "heading" => esc_html__("Title Size", "leafcolor"),
					 "param_name" => "title_size",
					 "value" => array(
					 	esc_html__('Big', 'leafcolor') => '',
						esc_html__('Small', 'leafcolor') => 'small',
					)
				),
			),
		) );
	}
}