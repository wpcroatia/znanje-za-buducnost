<?php
function parse_sc_post_carousel($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$title = isset($atts['title']) ? $atts['title'] : '';
	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$link_text = isset($atts['link_text']) ? $atts['link_text'] : 'VIEW ALL';
	$link_url = isset($atts['link_url']) ? $atts['link_url'] : '';
	$show_header = isset($atts['show_header']) ? $atts['show_header'] : '';
	$header_bg = isset($atts['header_bg']) ? $atts['header_bg'] : '';
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 8;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	
	$event_display = isset($atts['event_display']) ? $atts['event_display'] : 'list';
	$startdate = isset($atts['startdate']) ? $atts['startdate'] : 'week';
	$enddate = isset($atts['enddate']) ? $atts['enddate'] : 'week';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$visible = isset($atts['visible']) ? $atts['visible'] : 4;
	$show_extra = isset($atts['show_extra']) ? $atts['show_extra'] : 1;
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//echo $startdate;exit;
	//display
	if($header_bg!=''){$header_bg = wp_get_attachment_image_src($header_bg,'leaf_thumb_500x500', true);}
	ob_start();
	?>
    	<section class="leaf-event-carousel shortcode-carousel-<?php echo $ID;  echo ' '.$animation_class;?>"  data-delay="<?php echo $animation_delay; ?>">
        <div class="event-carousel-wrap">
            <div class="init-carousel carousel-has-control" data-items=<?php echo esc_attr($visible)?> data-navigation=1>
            	<?php if($show_header!='no' && !is_rtl() ){ ?>
            	<div class="event-carousel-item header-carousel-item">
                	<div class="header-carousel-item-inner text-center" style="background-image:url(<?php if($header_bg){ echo esc_url($header_bg[0]);} ?>)">
                    	<div class="header-carousel-item-content">
                        	<div class="header-carousel-item-content-inner dark-div">
                    			<?php if($icon!=''){?><i class="fa <?php echo $icon;?> fa-4x"></i><?php }?>
                        		<h3 class="h2"><?php echo esc_attr($title);?></h3>
                                <?php if($link_url!=''){?>
                                    <a class="btn skew-btn btn-primary has-icon" href="<?php echo esc_url($link_url);?>">
                                        <span class="btn-text"><?php echo esc_attr($link_text);?></span>
                                        <span class="btn-icon"><i class="fa fa-chevron-right"></i></span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
				<?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key,$event_display,$startdate,$enddate);
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                    <div class="event-carousel-item event-item">
                        <div class="event-item-inner">
                            <div class="event-item-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                    <?php if(has_post_thumbnail()){
                                        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'leaf_thumb_262x183', true);
                                    }elseif( get_post_type(get_the_ID())=='attachment' ){
                                        $thumbnail = wp_get_attachment_image_src(get_the_ID(),'leaf_thumb_262x183', true);
                                    }else{
                                        $thumbnail = leaf_print_default_thumbnail();
                                    }?>
                                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php if($post_type =='tribe_events' && class_exists('Tribe__Events__Main')){
										$startdate = get_post_meta(get_the_ID(), '_EventStartDate', true);
										if($startdate){
											$con_date = new DateTime($startdate);
											$month = $con_date->format('M');
											$day = $con_date->format('d');
											$year = $con_date->format('Y');
										}
										?>
										<div class="event-date-block font-2 text-center">
											<div class="day"><?php echo $day; ?></div>
											<div class="month"><?php echo date_i18n( 'M', strtotime( $startdate ) ); ?></div>
                                            <div class="year" style="display:none"><?php echo date_i18n( 'Y', strtotime( $startdate ) ); ?></div>
										</div>
                                    <?php }elseif($post_type == 'ajde_events'){
										if( $startdate = get_post_meta(get_the_id(), 'evcal_srow', true) ){
											$month = date_i18n( 'M', $startdate);
											$day = date_i18n( 'd', $startdate);
											$year = date_i18n( 'Y', $startdate);
										}?>
										<div class="event-date-block font-2 text-center">
											<div class="day"><?php echo $day; ?></div>
											<div class="month"><?php echo $month ; ?></div>
                                            <div class="year" style="display:none"><?php echo $year; ?></div>
										</div>
                                    <?php } ?>
                                </a>
                            </div>
                            
                            <div class="event-item-content">
                                <h3 class="event-title font-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="event-meta small-meta">
                                	<?php if($post_type =='tribe_events'&& class_exists('Tribe__Events__Main')){
										if($startdate = get_post_meta(get_the_ID(), '_EventStartDate', true)){
											$con_date = new DateTime($startdate); ?>
                                    		<div>
                                            	<i class="lnr lnr-calendar-full"></i>
												<?php echo date_i18n( get_option('date_format'), strtotime( $startdate ) ); ?>
											</div>
										<?php }
										if (tribe_get_venue() || tribe_get_address()){ ?>
                                            <div class="venue-details">
                                                <i class="lnr lnr-map-marker"></i><?php echo tribe_get_venue()?tribe_get_venue():tribe_get_address(); ?>
                                            </div>
                                        <?php } ?>

                                    <?php }elseif($post_type == 'ajde_events' && class_exists('EventON')){
                                    	if($startdate = get_post_meta(get_the_id(), 'evcal_srow', true)){ ?>
                                    		<div>
                                            	<i class="lnr lnr-calendar-full"></i>
												<?php echo date_i18n( get_option('date_format'), $startdate ); ?>
											</div>
										<?php }
										if (get_the_term_list( get_the_ID(), 'event_location')){ ?>
                                            <div class="venue-details">
                                                <i class="lnr lnr-map-marker"></i><?php echo strip_tags(get_the_term_list( get_the_ID(), 'event_location', ' <span>', '</span><span>, ', '</span>' ) ,'<span>'); ?>
                                            </div>
                                        <?php } ?>

                                    <?php }elseif($post_type =='product'){ ?>
										<div><?php wc_get_template( 'loop/price.php' ); ?></div>
									<?php }else{ ?>
                                        <div><i class="lnr lnr-user"></i> <?php echo esc_html__('By ','conferencepro').get_the_author(); ?></div>
                                        <div><i class="lnr lnr-calendar-full"></i> <?php esc_html_e('At ','conferencepro'); the_time( get_option( 'date_format' ) ); ?></div>
                                    <?php }?>
                                </div>
                                <div class="event-excerpt"><?php the_excerpt(); ?></div>
                                <a class="btn btn-lighter event-button btn-block" href="<?php the_permalink(); ?>">
                                	<?php if($post_type=='tribe_events' || $post_type=='ajde_events'){?>
                                    <span class="btn-text"><i class="lnr lnr-calendar-full"></i> <?php esc_html_e('Join Now', 'conferencepro'); ?></span>
                                    <?php }elseif($post_type =='product'){?>
                                    <span class="btn-text"><i class="lnr lnr-cart"></i> <?php esc_html_e('Buy Now', 'conferencepro'); ?></span>
                                    <?php }else{?>
                                    <span class="btn-text"><i class="lnr lnr-magnifier"></i> <?php esc_html_e('Read More', 'conferencepro'); ?></span>
                                    <?php }?>
                                    
                                </a>
                            </div>
                        </div><!--inner-->
                    </div><!--/event-carousel-item-->
				  <?php
                  }//while have_posts
              }//if have_posts
              wp_reset_postdata();
              ?>

            	<?php if($show_header!='no' && is_rtl() ){ ?>
            	<div class="event-carousel-item header-carousel-item">
                	<div class="header-carousel-item-inner text-center" style="background-image:url(<?php if($header_bg){ echo esc_url($header_bg[0]);} ?>)">
                    	<div class="header-carousel-item-content">
                        	<div class="header-carousel-item-content-inner dark-div">
                    			<?php if($icon!=''){?><i class="fa <?php echo $icon;?> fa-4x"></i><?php }?>
                        		<h3 class="h2"><?php echo esc_attr($title);?></h3>
                                <?php if($link_url!=''){?>
                                    <a class="btn skew-btn btn-primary has-icon" href="<?php echo esc_url($link_url);?>">
                                        <span class="btn-text"><?php echo esc_attr($link_text);?></span>
                                        <span class="btn-icon"><i class="fa fa-chevron-right"></i></span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

              </div>
        </div>
	</section><!--/event-carousel-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_post_carousel', 'parse_sc_post_carousel' );

add_action( 'after_setup_theme', 'reg_sc_post_carousel' );
function reg_sc_post_carousel(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Post Carousel","leafcolor"),
	   "base" => "sc_post_carousel",
	   "class" => "",
	   "icon" => "icon-post-carousel",
	   "controls" => "full",
	   "category" => esc_html__('Content'),
	   "params" => array(
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Title", "leafcolor"),
			"param_name" => "title",
			"value" => "",
			"description" => esc_html__("Title of carousel header", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Icon", "leafcolor"),
			"param_name" => "icon",
			"value" => "",
			"description" => esc_html__("Font Awesome Icon (ex: fa-calendar)", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Link text", "leafcolor"),
			"param_name" => "link_text",
			"value" => "",
			"description" => esc_html__("Link text (ex: 'View All')", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Link URL", "leafcolor"),
			"param_name" => "link_url",
			"value" => "",
			"description" => esc_html__("If not set, link will not appear", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Show Carousel Header", "leafcolor"),
			 "param_name" => "show_header",
			 "value" => array(
			 	esc_html__('Yes', 'conferencepro') => '',
				esc_html__('No', 'conferencepro') => 'no',
			 )
		  ),
		  array(
			"type" => "attach_image",
			"heading" => esc_html__("Carousel Header Background", "leafcolor"),
			"param_name" => "header_bg",
			"value" => "",
			"description" => esc_html__("", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Post Type", "leafcolor"),
			 "param_name" => "post_type",
			 "value" => array(
			 	esc_html__('Post', 'conferencepro') => 'post',
				esc_html__('Tribe Events', 'conferencepro') => 'tribe_events',
				esc_html__('Product', 'conferencepro') => 'product',
				esc_html__('Attachment', 'conferencepro') => 'attachment',
				esc_html__('EventOn Events', 'conferencepro') => 'ajde_events',
			 ),
			 "description" => esc_html__('Choose post type','conferencepro')
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Category", "leafcolor"),
			"param_name" => "cat",
			"value" => "",
			"description" => esc_html__("List of cat ID (or slug), separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Tags", "leafcolor"),
			"param_name" => "tag",
			"value" => "",
			"description" => esc_html__("list of tags, separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("IDs", "leafcolor"),
			"param_name" => "ids",
			"value" => "",
			"description" => esc_html__("Specify post IDs to retrieve", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Count", "leafcolor"),
			"param_name" => "count",
			"value" => "8",
			"description" => esc_html__("Number of posts to show. Default is 8", 'conferencepro'),
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Visible items", "leafcolor"),
			"param_name" => "visible",
			"value" => "4",
			"description" => esc_html__("Number of items visible in Carousel. Default is 4", 'conferencepro'),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Order", 'conferencepro'),
			 "param_name" => "order",
			 "value" => array(
			 	esc_html__('DESC', 'conferencepro') => 'DESC',
				esc_html__('ASC', 'conferencepro') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Order by", 'conferencepro'),
			 "param_name" => "orderby",
			 "value" => array(
			 	esc_html__('Date', 'conferencepro') => 'date',
				esc_html__('ID', 'conferencepro') => 'ID',
				esc_html__('Author', 'conferencepro') => 'author',
			 	esc_html__('Title', 'conferencepro') => 'title',
				esc_html__('Name', 'conferencepro') => 'name',
				esc_html__('Modified', 'conferencepro') => 'modified',
			 	esc_html__('Parent', 'conferencepro') => 'parent',
				esc_html__('Random', 'conferencepro') => 'rand',
				esc_html__('Comment count', 'conferencepro') => 'comment_count',
				esc_html__('Menu order', 'conferencepro') => 'menu_order',
				esc_html__('Meta value', 'conferencepro') => 'meta_value',
				esc_html__('Meta value num', 'conferencepro') => 'meta_value_num',
				esc_html__('Post__in', 'conferencepro') => 'post__in',
				esc_html__('None', 'conferencepro') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => esc_html__("Meta key", "leafcolor"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => esc_html__("Name of meta key for ordering", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Event display", 'conferencepro'),
			 "param_name" => "event_display",
			 "value" => array(
			 	esc_html__('Upcoming', 'conferencepro') => '',
				esc_html__('Recent', 'conferencepro') => 'past',
				esc_html__('Custom', 'conferencepro') => 'custom',
			 ),
			 "description" => esc_html__('Only work with post type is Event', 'conferencepro')
		  ),
		  array(
			"type" => "dropdown",
			"heading" => __("Event display custom start date", "leafcolor"),
			"param_name" => "startdate",
			"value" => array(
			 	esc_html__('Week ago', 'conferencepro') => 'week',
				esc_html__('Month ago', 'conferencepro') => 'month',
				esc_html__('Year ago', 'conferencepro') => 'year',
			 ),
			"description" => esc_html__("", "leafcolor"),
		  ),
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Event display custom end date", "leafcolor"),
			"param_name" => "enddate",
			"value" => array(
			 	esc_html__('Next Week', 'conferencepro') => 'week',
				esc_html__('Next Month', 'conferencepro') => 'month',
				esc_html__('Next Year', 'conferencepro') => 'year',
			 ),
			"description" => esc_html__("", "leafcolor"),
		  ),
	   )
	));
	}
}