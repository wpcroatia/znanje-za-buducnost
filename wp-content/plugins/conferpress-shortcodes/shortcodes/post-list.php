<?php
function parse_sc_post_list($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$column = isset($atts['column']) ? $atts['column'] : '2';
	$show_share = isset($atts['show_share']) ? $atts['show_share'] : '1';

	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 8;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$event_display = isset($atts['event_display']) ? $atts['event_display'] : 'list';
	$startdate = isset($atts['startdate']) ? $atts['startdate'] : 'week';
	$enddate = isset($atts['enddate']) ? $atts['enddate'] : 'week';
	
	
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="leaf-post-list shortcode-post-list-<?php echo $ID;  echo ' '.$animation_class; if($show_share=='1'){ echo ' leaf-show-share';} ?>" data-delay="<?php echo $animation_delay; ?>">
        <div class="post-list-wrap">
        	<div class="row">
				<?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key,$event_display,$startdate,$enddate);
                if ( $the_query->have_posts() ) {
                    $count_p = 0;
                    while ( $the_query->have_posts() ) { $the_query->the_post(); $count_p++;
                    	$feature_class = '';
                    	$_this_post_ID = get_the_ID();
                    	if ($post_type =='tribe_events'&& class_exists('Tribe__Events__Main') && tribe( 'tec.featured_events' )->is_featured( get_the_ID() ) ) {
							$feature_class = 'leaf-event-featured dark-div';
						}
                    	?>
                        <div class="post-list-item <?php if($column==1){ echo 'col-md-12';}elseif($column==3){ echo 'col-md-4';}else{ echo 'col-md-6';}?>">
                        <div class="event-item <?php esc_html_e($feature_class); ?>">
	                        <div class="event-item-inner">
	                            <div class="event-item-thumbnail">
	                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
	                                    <?php if(has_post_thumbnail()){
	                                    	$thumbsize = $feature_class?'large':'leaf_thumb_500x500';
	                                        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $thumbsize, true);
	                                    }elseif( get_post_type(get_the_ID())=='attachment' ){
	                                        $thumbnail = wp_get_attachment_image_src(get_the_ID(),'leaf_thumb_500x500', true);
	                                    }else{
	                                        $thumbnail = leaf_print_default_thumbnail();
	                                    }?>
	                                    <div class="placeholder-thumbnail-bg" style="background-image: url(<?php echo $thumbnail[0] ?>);"></div>
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
											if (tribe_get_venue() || tribe_get_address()){ ?>
	                                            <span class="venue-details">
	                                                <i class="lnr lnr-map-marker"></i><?php echo tribe_get_venue()?tribe_get_venue():tribe_get_address(); ?>
	                                            </span>
	                                        <?php }
											if($startdate = get_post_meta(get_the_ID(), '_EventStartDate', true)){
												$con_date = new DateTime($startdate); ?>
	                                    		<span>
	                                            	<i class="lnr lnr-calendar-full"></i>
													<?php echo date_i18n( get_option('date_format'), strtotime( $startdate ) ); ?>
												</span>
											<?php }
											if ( ($ticket_product_id=get_post_meta(get_the_ID(),'product-id',true)) || tribe_get_cost() ){ ?>
												<span class="main-color-1">
	                                            	<i class="lnr lnr-tag"></i>
	                                            	<?php if(function_exists('wc_get_product') && ($ticket_product = wc_get_product($ticket_product_id)) ){
	                                            		if($ticket_product->is_type('variable')){
	                                            			echo wc_price($ticket_product->get_variation_price('min',true));
	                                            		}else{
					                                		echo $ticket_product->get_price_html();
					                                	}
					                                }else{
					                                	echo tribe_get_cost( null, true ); 
					                                }?>
	                                            </span>
				                            <?php }//if cost ?>
	                                    <?php }elseif($post_type =='ajde_events'){
											if (get_the_term_list( get_the_ID(), 'event_location')){ ?>
	                                            <span class="venue-details">
	                                                <i class="lnr lnr-map-marker"></i><?php echo strip_tags(get_the_term_list( get_the_ID(), 'event_location', ' <span>', '</span><span>, ', '</span>' ) ,'<span>'); ?>
	                                            </span>
	                                        <?php }
											if($startdate = get_post_meta(get_the_id(), 'evcal_srow', true)){ ?>
	                                    		<span>
	                                            	<i class="lnr lnr-calendar-full"></i>
													<?php echo date_i18n( get_option('date_format'), $startdate ); ?>
												</span>
											<?php } ?>
	                                    <?php }elseif($post_type =='product'){ ?>
											<span><?php wc_get_template( 'loop/price.php' ); ?></span>
										<?php }else{ ?>
	                                        <span><i class="lnr lnr-user"></i> <?php echo esc_html__('By ','conferencepro').get_the_author(); ?></span>
	                                        <span><i class="lnr lnr-calendar-full"></i> <?php esc_html_e('At ','conferencepro'); the_time( get_option( 'date_format' ) ); ?></span>
	                                    <?php }?>
	                                </div>
	                                <div class="event-excerpt"><?php the_excerpt(); ?></div>
	                                <?php if($show_share){ ?>
	                                <div class="social-share-hover pull-right hidden-xs">
	                                	<span class="hover-share-label"><?php esc_html_e('Share','conferencepro') ?> 
	                                		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 481.6 481.6" xml:space="preserve" width="16px" height="16px"><g>
											<path d="M381.6,309.4c-27.7,0-52.4,13.2-68.2,33.6l-132.3-73.9c3.1-8.9,4.8-18.5,4.8-28.4c0-10-1.7-19.5-4.9-28.5l132.2-73.8   c15.7,20.5,40.5,33.8,68.3,33.8c47.4,0,86.1-38.6,86.1-86.1S429,0,381.5,0s-86.1,38.6-86.1,86.1c0,10,1.7,19.6,4.9,28.5   l-132.1,73.8c-15.7-20.6-40.5-33.8-68.3-33.8c-47.4,0-86.1,38.6-86.1,86.1s38.7,86.1,86.2,86.1c27.8,0,52.6-13.3,68.4-33.9   l132.2,73.9c-3.2,9-5,18.7-5,28.7c0,47.4,38.6,86.1,86.1,86.1s86.1-38.6,86.1-86.1S429.1,309.4,381.6,309.4z M381.6,27.1   c32.6,0,59.1,26.5,59.1,59.1s-26.5,59.1-59.1,59.1s-59.1-26.5-59.1-59.1S349.1,27.1,381.6,27.1z M100,299.8   c-32.6,0-59.1-26.5-59.1-59.1s26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1S132.5,299.8,100,299.8z M381.6,454.5   c-32.6,0-59.1-26.5-59.1-59.1c0-32.6,26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1C440.7,428,414.2,454.5,381.6,454.5z" /></g>
											<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
	                                	</span>
	                                	<ul class="list-inline social-light">
											<?php leaf_social_share(); ?>
										</ul>
	                                </div>
	                                <?php }//if show_share ?>

	                                <a class="btn <?php if($feature_class){echo 'btn-primary';}else{echo 'btn-lighter';} ?> event-button" href="<?php echo get_the_permalink($_this_post_ID); ?>">
	                                	<?php if($post_type =='tribe_events' || $post_type =='ajde_events'){?>
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
                        </div><!--/post-list-item-->

                    <?php
                    }//while have_posts
                }//if have_posts
                wp_reset_postdata(); ?>
            </div><!--/row-->
        </div>
	</section><!--/post-grid-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_post_list', 'parse_sc_post_list' );
add_action( 'after_setup_theme', 'reg_sc_post_list' );
function reg_sc_post_list(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Post List", "leafcolor"),
	   "base" => "sc_post_list",
	   "class" => "",
	   "icon" => "icon-post-list",
	   "controls" => "full",
	   "category" => esc_html__('Content'),
	   "params" => array(
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns Number", "leafcolor"),
			"param_name" => "column",
			"value" => array(
			 	esc_html__('2 Column', 'conferencepro') => '',
				esc_html__('1 Column', 'conferencepro') => '1',
				esc_html__('3 Column', 'conferencepro') => '3',
			 ),
			"description" => esc_html__("Default is 2", "leafcolor"),
		  ),
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Show Social Share?", "leafcolor"),
			"param_name" => "show_share",
			"value" => array(
			 	esc_html__('Yes', 'conferencepro') => '1',
				esc_html__('No', 'conferencepro') => '0',
			 ),
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
				esc_html__('Member', 'conferencepro') => 'sp_member',
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