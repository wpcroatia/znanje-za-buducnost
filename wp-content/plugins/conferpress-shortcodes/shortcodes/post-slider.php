<?php
function parse_sc_post_slider($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$show_meta = isset($atts['show_meta']) ? $atts['show_meta'] : '';
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 3;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	
	$event_display = isset($atts['event_display']) ? $atts['event_display'] : 'list';
	$startdate = isset($atts['startdate']) ? $atts['startdate'] : 'week';
	$enddate = isset($atts['enddate']) ? $atts['enddate'] : 'week';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$auto_play = isset($atts['auto_play']) ? $atts['auto_play'] : 0;
	$height = isset($atts['height']) ? $atts['height'] : 0;

	$style = isset($atts['style']) ? $atts['style'] : '';
	$kenburns = isset($atts['kenburns']) ? $atts['kenburns'] : '';
	
	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="leaf-post-slider leaf-post-slider-<?php echo $ID; echo ' '.$animation_class; echo $kenburns!='no'?' kenburns-on':''; echo $style?' slider-style-'.$style:''; ?>" data-delay=<?php echo $animation_delay; ?>>
            <div class="post-slider-wrap">
                <div class="init-carousel post-slider-carousel carousel-has-control single-carousel" data-navigation="1" data-autoplay="<?php echo $auto_play?$auto_play:'false'; ?>">
                <?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key,$event_display,$startdate,$enddate);
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                    <div class="post-slider-item">
                        <div class="slider-item-content" <?php if($height){ ?> style="max-height:<?php echo $height; ?>px;"<?php } ?> >
                            <div class="slider-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                    <?php if(has_post_thumbnail()){
                                        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full', true);
                                    }elseif( get_post_type(get_the_ID())=='attachment' ){
                                        $thumbnail = wp_get_attachment_image_src(get_the_ID(),'full', true);
                                    }else{
                                        $thumbnail = leaf_print_default_thumbnail();
                                    }?>
                                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                </a>
                            </div><!--slider-thumbnail-->
                            <div class="post-slider-overlay dark-div">
                                <a class="post-slider-overlay-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                	<h4 class="h1 post-slider-title"><?php the_title(); ?></h4>

                                	<?php if($post_type == 'tribe_events' && $show_meta!='yes'){ ?>
                                		<div class="slider-cats-meta h5">
                                			<?php if(class_exists('Tribe__Events__Main')){
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
		                                    <?php } ?>
                                		</div>

                                	<?php }elseif($post_type == 'ajde_events'){ ?>
                                		<div class="slider-cats-meta h5">
                                			<?php if(class_exists('EventON')){
												if($startdate = get_post_meta(get_the_id(), 'evcal_srow', true)){ ?>
		                                    		<div>
		                                            	<i class="lnr lnr-calendar-full"></i>
														<?php echo date_i18n( get_option('date_format'), $startdate ); ?>
													</div>
												<?php }
												if (get_the_term_list( get_the_ID(), 'event_location')){ ?>
		                                            <div class="venue-details">
		                                                <i class="lnr lnr-map-marker"></i>
		                                                <?php echo strip_tags(get_the_term_list( get_the_ID(), 'event_location', ' <span>', '</span><span>, ', '</span>' ) ,'<span>'); ?>
		                                            </div>
		                                        <?php } ?>
		                                    <?php } ?>
                                		</div>

                                	<?php }else{//if show meta ?>
	                                	<div class="slider-cats h5"><i class="lnr lnr-layers"></i>
		                                	<?php if($post_type == 'tribe_events'){
												echo strip_tags(get_the_term_list( get_the_ID(), 'tribe_events_cat', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}elseif($post_type == 'product'){
												echo strip_tags(get_the_term_list( get_the_ID(), 'product_cat', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}elseif($post_type == 'post' || $post_type == ''){
												echo strip_tags(get_the_term_list( get_the_ID(), 'category', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}?>
										</div>
                                    <?php } //else show meta ?>
                                    <div class="clearfix"></div>
                                </a>
                                <div class="post-slider-overlay-buttons">
                                	<?php if($post_type == 'tribe_events'){ ?>
										<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<i class="lnr lnr-calendar-full"></i> <?php esc_html_e('Detail','conferencepro'); ?></a>
										<a class="btn btn-default btn-lg hidden-xs" href="<?php the_permalink(); ?>#event-cart" title="<?php the_title_attribute(); ?>">
											<i class="lnr lnr-cart"></i> <?php esc_html_e('Get Ticket','conferencepro'); ?></a>

									<?php }elseif($post_type == 'ajde_events'){ ?>
										<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<i class="lnr lnr-calendar-full"></i> <?php esc_html_e('Detail','conferencepro'); ?></a>
										<?php if(get_post_meta(get_the_ID(),'evotx_tix',true)){ ?>
										<a class="btn btn-default btn-lg hidden-xs" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<i class="lnr lnr-cart"></i> <?php esc_html_e('Get Ticket','conferencepro'); ?></a>
										<?php }//if has ticket ?>
									<?php }elseif($post_type == 'product'){ ?>
										<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<i class="lnr lnr-cart"></i> <?php esc_html_e('Buy now','conferencepro'); ?>
											<?php if(class_exists('Woocommerce') && $show_meta=='yes'){ 
		                                    	global $product;
		                                        if($product->is_type('variable')){
		                                            $price_html = $product->get_price(); ?>
		                                                <span class="price"><?php _e('From  ','conferencepro') ?><?php  echo get_woocommerce_currency_symbol(); echo $price_html; ?></span>
		                                            <?php 
		                                        }else{
		                                            if ( $price_html = $product->get_price_html() ) : ?>
		                                                <span class="price"><?php echo $price_html; ?></span>
		                                            <?php endif; 	
		                                        }
		                                    }?>
										</a>
									<?php }elseif($post_type == 'post' || $post_type == ''){ ?>
										<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e('Detail','conferencepro'); ?></a>
									<?php }?>
                                </div>
                            </div>
                            <?php if($post_type == 'tribe_events' && $show_meta=='yes'){ ?>
                            <div class="slider-event-meta heading-event-meta hidden-xs dark-div">
                                <div class="heading-meta-col">
                                    <div class="heading-event-meta-title h2 main-color-1-border"><i class="lnr lnr-calendar-full"></i> <?php esc_html_e('Time','conferencepro'); ?></div>
                                    <div class="heading-event-meta-content">
                                        <?php echo tribe_events_event_schedule_details( get_the_ID(), '', '' ); ?>
                                    </div>
                                </div>
                                
                                <?php if ( tribe_address_exists() ) : ?>
                                <div class="heading-meta-col">
                                    <div class="heading-event-meta-title h2"><i class="lnr lnr-map-marker"></i> <?php esc_html_e('Venue','conferencepro'); ?></div>
                                    <div class="heading-event-meta-content">
                                    	<dl>
                                            <dt><?php echo tribe_get_venue() ?></dt>
                                            <dd>
                                                <address>
                                                    <?php echo tribe_get_full_address(); ?>
                                                    <?php if ( tribe_show_google_map_link() ) : ?>
                                                        <div><?php echo tribe_get_map_link_html(); ?></div>
                                                    <?php endif; ?>
                                                </address>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ( tribe_get_cost() ) : ?>
                                <div class="heading-meta-col">
                                    <div class="heading-event-meta-title h2"><i class="lnr lnr-file-add"></i> <?php esc_html_e('Ticket','conferencepro'); ?></div>
                                    <div class="heading-event-meta-content">
                                        <div class="tribe-events-cost">
                                            <?php echo tribe_get_cost( null, true ) ?>
                            				<div><a href="<?php the_permalink(); ?>"><?php esc_html_e('Get it now','conferencepro'); ?> <i class="fa fa-angle-right"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                            </div><!--/heading-event-meta-->
                            <?php }?>
                        </div><!--/app-item-->
                    </div><!--/post-carousel-item-->
                <?php
                    }//while have_posts
                }//if have_posts
                wp_reset_postdata();
                ?>
                </div>
            </div>
        </section><!--/leaf-post-slider-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_post_slider', 'parse_sc_post_slider' );

add_action( 'after_setup_theme', 'reg_sc_post_slider' );
function reg_sc_post_slider(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => __("Post Slider"),
	   "base" => "sc_post_slider",
	   "class" => "",
	   "icon" => "icon-post-slider",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Slider Style", "leafcolor"),
			 "param_name" => "style",
			 "value" => array(
			 	esc_html__('Centered', 'conferencepro') => '',
				esc_html__('Align Left', 'conferencepro') => 'left',
				esc_html__('Align Right', 'conferencepro') => 'right',
			 )
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Auto play", "leafcolor"),
			"param_name" => "auto_play",
			"value" => "0",
			"description" => __("Auto play timeout miliseconds (Ex: 3000 for 3 seconds, or 0 for no autoplay)", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Enable Ken-Burns Effect (zoom effect)", "leafcolor"),
			 "param_name" => "kenburns",
			 "value" => array(
			 	esc_html__('Yes', 'conferencepro') => '',
				esc_html__('No', 'conferencepro') => 'no',
			 )
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Show Extra Meta", "leafcolor"),
			 "param_name" => "show_meta",
			 "value" => array(
			 	esc_html__('No', 'conferencepro') => '',
				esc_html__('Yes', 'conferencepro') => 'yes',
			 )
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Custom Max Height", "leafcolor"),
			"param_name" => "height",
			"value" => "0",
			"description" => __("Enter slider max height in number of px (ex: 600), default is auto", "leafcolor"),
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
			"value" => "3",
			"description" => esc_html__("Number of posts to show. Default is 3", 'conferencepro'),
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