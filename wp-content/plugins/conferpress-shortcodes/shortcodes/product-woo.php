<?php
function leaf_woo_products( $atts ) {
	if (class_exists('Woocommerce')) {
		global $woocommerce_loop;
		$columns = isset($atts['column']) ? $atts['column'] : 4;
		$cat = isset($atts['cat']) ? $atts['cat'] : '';
		$tag = isset($atts['tag']) ? $atts['tag'] : '';
		$ids = isset($atts['ids']) ? $atts['ids'] : '';
		$count = isset($atts['count']) ? $atts['count'] : 8;
		$order = isset($atts['order']) ? $atts['order'] : 'DESC';
		$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
		$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
		
		$meta_query = WC()->query->get_meta_query();
		$category='new';
		if($ids!=''){
			$ids = explode(",", $ids);	
			$args = array(
				'post_type'				=> 'product',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'category' => 'new',
				'posts_per_page' 		=> $count,
				'orderby' 				=> $orderby,
				'order' 				=> $order,
				'post__in' => $ids,
				'meta_key' => $meta_key,
			);
		}else{
			$args = array(
				'post_type'				=> 'product',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'category' => 'new',
				'posts_per_page' 		=> $count,
				'orderby' 				=> $orderby,
				'order' 				=> $order,
				'meta_key' => $meta_key,
			);
		}
//tag
		if($tag!=''){
			$tags = explode(",",$tag);
			if(is_numeric($tags[0])){$field_tag = 'term_id'; }
			else{ $field_tag = 'slug'; }
			if(count($tags)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($tags as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $tags,
						  )
				  );
			}
		}
//cat
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
		}
		if(isset($texo)){
			$args += array('tax_query' => $texo);
		}
		$args['posts_per_page'] = $count;

		ob_start();
		
		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="sc-woo leaf-product-listing"><div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div></div>';
	}
}
add_shortcode( 'sc_woo', 'leaf_woo_products' );

add_action( 'after_setup_theme', 'reg_sc_woo' );
function reg_sc_woo(){
	if(function_exists('vc_map') && (class_exists('Woocommerce'))){
	vc_map( array(
	   "name" => __("Product Listing"),
	   "base" => "sc_woo",
	   "class" => "",
	   "icon" => "icon-app-woo",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			"type" => "textfield",
			"heading" => __("Columns Number", "leafcolor"),
			"param_name" => "column",
			"value" => "",
			"description" => __("From 1-6 (Default is 4)", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Category", "leafcolor"),
			"param_name" => "cat",
			"value" => "",
			"description" => __("List of cat ID (or slug), separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Tags", "leafcolor"),
			"param_name" => "tag",
			"value" => "",
			"description" => __("list of tags, separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("IDs", "leafcolor"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Specify post IDs to retrieve", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Count", "leafcolor"),
			"param_name" => "count",
			"value" => "8",
			"description" => __("Number of posts to show. Default is 8", 'conferencepro'),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order", 'conferencepro'),
			 "param_name" => "order",
			 "value" => array(
			 	__('DESC', 'conferencepro') => 'DESC',
				__('ASC', 'conferencepro') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order by", 'conferencepro'),
			 "param_name" => "orderby",
			 "value" => array(
			 	__('Date', 'conferencepro') => 'date',
				__('ID', 'conferencepro') => 'ID',
				__('Author', 'conferencepro') => 'author',
			 	__('Title', 'conferencepro') => 'title',
				__('Name', 'conferencepro') => 'name',
				__('Modified', 'conferencepro') => 'modified',
			 	__('Parent', 'conferencepro') => 'parent',
				__('Random', 'conferencepro') => 'rand',
				__('Comment count', 'conferencepro') => 'comment_count',
				__('Menu order', 'conferencepro') => 'menu_order',
				__('Meta value', 'conferencepro') => 'meta_value',
				__('Meta value num', 'conferencepro') => 'meta_value_num',
				__('Post__in', 'conferencepro') => 'post__in',
				__('None', 'conferencepro') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Meta key", "leafcolor"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => __("Name of meta key for ordering", "leafcolor"),
		  ),
	   )
	));
	}
}