<?php
function parse_sc_post_grid($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$column = isset($atts['column']) ? $atts['column'] : '3';
	$has_padding = isset($atts['has_padding']) ? $atts['has_padding'] : '1';
	$show_title = isset($atts['show_title']) ? $atts['show_title'] : '';

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
    	<section class="leaf-post-grid shortcode-grid-<?php echo $ID;  echo ' '.$animation_class; if($has_padding=='0'){ echo ' leaf-no-padding';}; if($show_title=='1'){ echo ' show-title';}?>" data-delay="<?php echo $animation_delay; ?>">
        <div class="post-grid-wrap">
        	<div class="row">
				<?php $the_query = sc_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key,$event_display,$startdate,$enddate);
                if ( $the_query->have_posts() ) {
                    $count_p = 0;
                    while ( $the_query->have_posts() ) { $the_query->the_post(); $count_p++; ?>
                        <div class="post-grid-item <?php if($column==2){ echo 'col-md-6';}elseif($column==4){ echo 'col-md-3';}else{ echo 'col-md-4';}?> col-sm-6">
                            <div class="post-grid-item-inner">
                                <div class="post-grid-item-thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                        <?php if(has_post_thumbnail()){
                                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'leaf_thumb_500x500', true);
                                        }elseif( get_post_type(get_the_ID())=='attachment' ){
                                            $thumbnail = wp_get_attachment_image_src(get_the_ID(),'leaf_thumb_500x500', true);
                                        }else{
                                            $thumbnail = leaf_print_default_thumbnail();
                                        }?>
                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                    </a>
                                </div>
                                <div class="post-grid-item-content dark-div">
                                    <a class="post-grid-title text-center" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <h3 class="h3"><?php the_title(); ?></h3>
                                        <div class="post-grid-cats small-meta">
		                                	<?php if($post_type == 'tribe_events'){
												echo strip_tags(get_the_term_list( get_the_ID(), 'tribe_events_cat', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}elseif($post_type == 'ajde_events'){
												echo strip_tags(get_the_term_list( get_the_ID(), 'event_location', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}elseif($post_type == 'product'){
												echo strip_tags(get_the_term_list( get_the_ID(), 'product_cat', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}elseif($post_type == 'post' || $post_type == ''){
												echo strip_tags(get_the_term_list( get_the_ID(), 'category', ' <span>', '</span><span>, ', '</span>' ) ,'<span>');
											}?>
										</div>
                                    </a>
                                </div>
                            </div><!--inner-->
                        </div><!--/post-grid-item-->

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
add_shortcode( 'sc_post_grid', 'parse_sc_post_grid' );
add_action( 'after_setup_theme', 'reg_sc_post_grid' );
function reg_sc_post_grid(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("Post Grid", "leafcolor"),
	   "base" => "sc_post_grid",
	   "class" => "",
	   "icon" => "icon-post-grid",
	   "controls" => "full",
	   "category" => esc_html__('Content'),
	   "params" => array(
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Grid Columns Number", "leafcolor"),
			"param_name" => "column",
			"value" => array(
			 	esc_html__('3 Column', 'conferencepro') => '',
				esc_html__('2 Column', 'conferencepro') => '2',
				esc_html__('4 Column', 'conferencepro') => '4',
			 ),
			"description" => esc_html__("Default is 3", "leafcolor"),
		  ),
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Has Padding", "leafcolor"),
			"param_name" => "has_padding",
			"value" => array(
			 	esc_html__('Yes', 'conferencepro') => '1',
				esc_html__('No', 'conferencepro') => '0',
			 ),
			"description" => esc_html__("", "leafcolor"),
		  ),
		  array(
			"type" => "dropdown",
			"heading" => esc_html__("Show title without hover?", "leafcolor"),
			"param_name" => "show_title",
			"value" => array(
			 	esc_html__('No', 'conferencepro') => '',
				esc_html__('Yes', 'conferencepro') => '1',
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