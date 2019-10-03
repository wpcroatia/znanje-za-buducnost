<?php
function parse_sc_post_timeline($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
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
	
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	if($startdate =="week"){
		$startdate = date('m/d/Y', strtotime('-7 days'));
	}elseif($startdate =="month"){
		$startdate = date('m/d/Y', strtotime('-30 days'));
	}elseif($startdate =="year"){
		$startdate = date('m/d/Y', strtotime('-356 days'));
	}
	if($enddate =="week"){
		$enddate = date('m/d/Y', strtotime('+7 days'));
	}elseif($enddate =="month"){
		$enddate = date('m/d/Y', strtotime('+30 days'));
	}elseif($enddate =="year"){
		$enddate = date('m/d/Y', strtotime('+356 days'));
	}
	//echo $startdate;exit;
	//display
	ob_start();
	?>
	<section class="leaf-timeline shortcode-post-timeline-<?php echo esc_html($ID);  echo ' '.esc_html($animation_class); ?>" data-delay=<?php echo esc_html($animation_delay); ?>>
        <div class="timeline-wrap">
		<?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key,$event_display,$startdate,$enddate);
        if ( $the_query->have_posts() ) {
          while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                <div class="timeline-item">
                    <div class="timeline-item-inner">
                    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                            <div class="timeline-box text-center">
                                <div class="timeline-box-title dark-div">
                                    <h3 class="font-2"><?php the_title(); ?></h3>
                                    <?php if ( $post_type =='tribe_events' && class_exists('Tribe__Events__Main') && tribe_event_is_all_day() ){ ?>
                                    	<span class="small-meta"><i class="lnr lnr-clock"></i> <?php echo esc_html__('All day','conferencepro') ?></span>
                                    <?php }elseif($post_type =='tribe_events' && class_exists('Tribe__Events__Main')){
										$startdate = get_post_meta(get_the_ID(), '_EventStartDate', true);
										$enddate = get_post_meta(get_the_ID(), '_EventEndDate', true);
										if($startdate){
											$con_date = new DateTime($startdate);
											$time_st = $con_date->format(get_option( 'time_format' ));
										}
										if($enddate){
											$con_edate = new DateTime($enddate);
											$time_et = $con_edate->format(get_option( 'time_format' ));
										}
										?>
										<span class="small-meta">
											<span class="visible-xs"><i class="lnr lnr-calendar-full"></i> <?php echo date_i18n( get_option( 'date_format' ), strtotime( $startdate ) ); ?></span>
											<span><i class="lnr lnr-clock"></i> <?php echo esc_attr($time_st).' - '.esc_attr($time_et);?></span>
											<?php if (tribe_get_venue() || tribe_get_address()){
													echo '<span><i class="lnr lnr-map-marker"></i> '.(tribe_get_venue()?tribe_get_venue():tribe_get_address()).'</span>'; } ?>
										</span>
                                    <?php }elseif($post_type =='ajde_events'){
										if($startdate = get_post_meta(get_the_id(), 'evcal_srow', true)){
											$time_st = date_i18n( get_option('time_format'), $startdate );
										}
										if($enddate = get_post_meta(get_the_id(), 'evcal_erow', true)){
											
											$time_et = date_i18n( get_option('time_format'), $enddate );
										}
										?>
										<span class="small-meta">
											<span class="visible-xs"><i class="lnr lnr-calendar-full"></i> <?php echo date_i18n( get_option( 'date_format' ), $startdate ); ?></span>
											<span><i class="lnr lnr-clock"></i> <?php echo esc_attr($time_st).' - '.esc_attr($time_et);?></span>
											<?php if(get_the_term_list( get_the_ID(), 'event_location')){
													echo '<span><i class="lnr lnr-map-marker"></i> '.(strip_tags(get_the_term_list( get_the_ID(), 'event_location', ' <span>', '</span><span>, ', '</span>' ) ,'<span>')).'</span>'; } ?>
										</span>
                                    <?php }else{
										$category = get_the_category();
										if(is_array($category) && isset($category[0])){
											$category = $category[0];?>
                                    		<span class="small-meta">
                                    			<span><i class="lnr lnr-inbox"></i> <?php echo esc_attr($category->name);?></span>
                                    			<span><i class="lnr lnr-user"></i> <?php echo get_the_author(); ?></span>
                                    		</span>
                                    <?php }
									}?>
                                </div>
                                <div class="timeline-box-content dark-div"
                                <?php if(has_post_thumbnail()){
                                    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'leaf_thumb_555x472', true); ?> style="background-image:url(<?php echo $thumbnail[0] ?>)"
                                <?php } ?>  >
                                    <div class="timeline-box-content-inner">
                                    	<?php if($post_type =='tribe_events' && class_exists('Tribe__Events__Main')){
											$startdate = get_post_meta(get_the_ID(), '_EventStartDate', true);
											$enddate = get_post_meta(get_the_ID(), '_EventEndDate', true);
											if($startdate){
												$con_date = new DateTime($startdate);
												$month = $con_date->format('M');
												$day = $con_date->format('d');
												$year = $con_date->format('Y');
											}
											?>
                                            <div class="timeline-meta hidden-xs">
                                                <div><i class="lnr lnr-calendar-full"></i> <?php echo date_i18n( get_option( 'date_format' ), strtotime( $startdate ) ); ?></div>
                                            </div><!--timeline-meta-->
                                        <?php }elseif($post_type =='ajde_events'){
											$startdate = get_post_meta(get_the_id(), 'evcal_srow', true);
											?>
                                            <div class="timeline-meta hidden-xs">
                                                <div><i class="lnr lnr-calendar-full"></i> <?php echo date_i18n( get_option( 'date_format' ), $startdate ); ?></div>
                                            </div><!--timeline-meta-->
                                        <?php }else{?>
                                            <div class="timeline-meta hidden-xs">
                                                <div><i class="lnr lnr-calendar-full"></i> <?php the_time( get_option( 'date_format' ) ); ?></div>
                                            </div><!--timeline-meta-->
                                        <?php }?>
                                        <div class="timeline-excerpt"><?php the_excerpt(); ?></div>
                                    </div>
                                </div>
                            </div><!--timeline-box-->
                            <div class="clearfix"></div>
                        </a>
                    </div><!--inner-->
                </div><!--/timeline-item-->
            <?php
            }//while have_posts
        }//if have_posts
        wp_reset_postdata();
        ?>
        </div>
	</section><!--/timeline-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_post_timeline', 'parse_sc_post_timeline' );

add_action( 'after_setup_theme', 'reg_sc_post_timeline' );
function reg_sc_post_timeline(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Post Timeline","leafcolor"),
	   "base" => "sc_post_timeline",
	   "class" => "",
	   "icon" => "icon-post-timeline",
	   "controls" => "full",
	   "category" => esc_html__('Content'),
	   "params" => array(
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