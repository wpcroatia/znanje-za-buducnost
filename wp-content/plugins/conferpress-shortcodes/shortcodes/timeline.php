<?php
function parse_sc_timeline($atts, $content=''){
	//get parameter
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
		<section class="leaf-timeline timeline-<?php echo esc_html($ID);  echo ' '.esc_html($animation_class); ?>" data-delay=<?php echo esc_html($animation_delay); ?>>
        	<div class="timeline-wrap">
                <?php echo do_shortcode($content); ?>
            </div>
        </section><!--/testimonial-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_timeline', 'parse_sc_timeline' );

function parse_sc_timeline_item($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$title = isset($atts['title']) ? $atts['title'] : '';
	$sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
	$background = isset($atts['background']) ? $atts['background'] : '';
	ob_start(); ?>
        <div class="timeline-item timeline-item-<?php echo $ID; ?>">
            <div class="timeline-item-inner">
                    <div class="timeline-box text-center">
                        <div class="timeline-box-title dark-div">
                            <h3 class="font-2"><?php echo esc_attr($title); ?></h3>
                            <span class="small-meta"><?php echo esc_attr($sub_title); ?></span>
                        </div>
                        <div class="timeline-box-content dark-div"
                        <?php
						if(is_numeric($background)){
							$thumbnail = wp_get_attachment_image_src($background,'leaf_thumb_555x472', true);
						}else{
							$thumbnail = array($background);
						}
							if(@$thumbnail[0]){
                             ?> style="background-image:url(<?php echo $thumbnail[0] ?>)"
                        <?php } ?>  >
                            <div class="timeline-box-content-inner">
                                <div class="timeline-excerpt"><?php echo do_shortcode($content); ?></div>
                            </div>
                        </div>
                    </div><!--timeline-box-->
                    <div class="clearfix"></div>
            </div><!--inner-->
        </div><!--/timeline-item-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_timeline_item', 'parse_sc_timeline_item' );

//Visual Composer
add_action( 'after_setup_theme', 'reg_sc_timeline' );
function reg_sc_timeline(){
	if(function_exists('vc_map')){
		//parent
		vc_map( array(
			"name" => esc_html__("Timeline", "leafcolor"),
			"base" => "sc_timeline",
			"as_parent" => array('only' => 'sc_timeline_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-timeline",
			"params" => array(
				// add params same as with any other content element
			),
			"js_view" => 'VcColumnView'
		) );
		
		//child
		vc_map( array(
			"name" => esc_html__("Timeline Item", "leafcolor"),
			"base" => "sc_timeline_item",
			"content_element" => true,
			"as_child" => array('only' => 'sc_timeline_item'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"icon" => "icon-testimonial-item",
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", "leafcolor"),
					"param_name" => "title",
					"value" => "",
					"description" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Sub Title", "leafcolor"),
					"param_name" => "sub_title",
					"value" => "",
					"description" => '',
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Background", "leafcolor"),
					"param_name" => "background",
					"value" => "",
					"description" => esc_html__("", "leafcolor"),
				  ),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Content", "leafcolor"),
					"param_name" => "content",
					"value" => "",
					"description" => '',
				),
			)
		) );
		
	}
	if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortCode_sc_timeline extends WPBakeryShortCodesContainer{}
	class WPBakeryShortCode_sc_timeline_item extends WPBakeryShortCode{}
	}
}