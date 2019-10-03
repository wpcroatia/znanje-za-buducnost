<?php
function parse_sc_blog($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 4;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$event_display = isset($atts['event_display']) ? $atts['event_display'] : 'list';
	$startdate = isset($atts['startdate']) ? $atts['startdate'] : 'week';
	$enddate = isset($atts['enddate']) ? $atts['enddate'] : 'week';
	
	$column = isset($atts['column']) ? $atts['column'] : '2';
	$big_item = isset($atts['big_item']) ? $atts['big_item'] : '1';

	$animation_class = (isset($atts['css_animation']) && $atts['css_animation'])?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="leaf-post-news shortcode-news-<?php echo $ID;  echo ' '.$animation_class;?>">
        <div class="post-news-wrap">
        	<div class="row">
            	<?php if($column=='2' && $big_item!='0'){?>
            	<div class="col-md-6">
                <?php }?>
                <?php if($column=='1'){?>
            	<div class="col-md-12">
                <?php }?>
                	<?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key, $event_display,$startdate,$enddate);
					if ( $the_query->have_posts() ) {
						$news_count = 0;
						while ( $the_query->have_posts() ) {
							$news_count++;
							$the_query->the_post();
							if($column=='2' && $big_item=='0'){ ?>
                            <div class="col-md-6">
                            <?php }?>
							<div class="post-news-item<?php echo $news_count==1 && $big_item!='0'?' post-news-big-item':''; ?>">
								<div class="post-news-item-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
										<?php
										if(!($news_count==1 && $big_item=='1')){ $thumbsize = 'leaf_thumb_177x177';}
										else{$thumbsize = 'leaf_thumb_555x472';}
										if(has_post_thumbnail()){
											$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),$thumbsize, true);
										}elseif( get_post_type(get_the_ID())=='attachment' ){
											$thumbnail = wp_get_attachment_image_src(get_the_ID(),$thumbsize, true);
										}else{
											$thumbnail = leaf_print_default_thumbnail();
										}?>
										<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                        <div class="event-date-block font-2 text-center">
                                        	<?php if($post_type =='tribe_events' && class_exists('Tribe__Events__Main')){
												$startdate = get_post_meta(get_the_ID(), '_EventStartDate', true);
												$startdate = date_i18n( get_option( 'date_format' ), strtotime( $startdate ) );
												if($startdate){
													$con_date = new DateTime($startdate);
													$month = $con_date->format('M');
													$day = $con_date->format('d');
													$year = $con_date->format('Y');
												}
											}else{
												$startdate = get_the_date( get_option( 'date_format' ) );
												if($startdate){
													$month = get_the_date('M');
													$day = get_the_date('d');
													$year = get_the_date('Y');
												}
											} ?>
											<div class="day"><?php echo $day; ?></div>
											<div class="month"><?php echo date_i18n( 'M', strtotime($month) ); ?></div>
                                            <div class="year" style="display:none"><?php echo date_i18n( 'Y', strtotime( $startdate ) ); ?></div>
										</div>
									</a>
								</div>
								<div class="post-news-item-content">
									<h3 class="font-2"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<div class="news-meta small-meta">
										<span><i class="lnr lnr-user"></i> <?php echo get_the_author(); ?></span>
                                        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ){?>
										<span><i class="lnr lnr-bubble"></i> <?php echo get_comments_number(get_the_ID());?></span>
                                        <?php }
										$cat_name = get_the_category_list(', ', '', '');
										if($cat_name!=''){?>
										<span><i class="lnr lnr-layers"></i> <?php echo $cat_name;?></span>
                                        <?php }?>
									</div>
									<?php if(!($news_count==1 && $big_item=='1')){ ?>
									<div class="news-excerpt"><?php the_excerpt(); ?></div>
									<?php } ?>
								</div>
								<div class="clearfix"></div>
							</div><!--/post-news-item-->
						<?php if($news_count==1 && $column=='2' && $big_item!='0'){//big post ?>
							</div><div class="col-md-6">
						<?php } if($column=='2' && $big_item=='0'){ ?>
                            </div>
                        <?php }
						}//while have_posts
					}//if have_posts
					wp_reset_postdata();
					?>
            	<?php if($column=='2' && $big_item!='0'){ ?>
            		</div>
            	<?php } ?>
                <?php if($column=='1'){?>
            		</div>
                <?php }?>
            </div><!--/row-->
        </div>
	</section><!--/post-blog-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'sc_blog', 'parse_sc_blog' );

add_action( 'after_setup_theme', 'reg_sc_blog' );
function reg_sc_blog(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Blog"),
	   "base" => "sc_blog",
	   "class" => "",
	   "icon" => "icon-blog",
	   "controls" => "full",
	   "category" => 'Content',
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
			 ),
			 "description" => esc_html__('Choose post type','conferencepro')
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Column", "leafcolor"),
			 "param_name" => "column",
			 "value" => array(
			 	esc_html__('2 Column', 'conferencepro') => '2',
				esc_html__('1 Column', 'conferencepro') => '1',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => esc_html__("Enable big item", "leafcolor"),
			 "param_name" => "big_item",
			 "value" => array(
			 	esc_html__('Yes', 'conferencepro') => '1',
				esc_html__('No', 'conferencepro') => '0',
			 ),
			 "description" => ''
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
			"value" => "4",
			"description" => esc_html__("Number of posts to show. Default is 4", 'conferencepro'),
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