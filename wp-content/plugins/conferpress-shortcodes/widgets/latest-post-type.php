<?php
class Leaf_Recent_Posts extends WP_Widget {	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'Leaf_Recent_Posts', 
			'description' => esc_html__('Leafcolor Latest Posts ','conferpress')
		);
    	parent::__construct('leaf-recent-posts', esc_html__('Leafcolor Latest Posts ','conferpress'), $widget_ops);
	}
	function widget($args, $instance) {

		//ob_start();
		extract($args);
		
		$ids 			= empty($instance['ids']) ? '' : $instance['ids'];
		$title 			= empty($instance['title']) ? '' : $instance['title'];
		$title          = apply_filters('widget_title', $title);
		$cats 			= empty($instance['cats']) ? '' : $instance['cats'];
		$post_type 			= empty($instance['post_type']) ? 'post' : $instance['post_type'];
		$tags 			= empty($instance['tags']) ? '' : $instance['tags'];
		$number 		= empty($instance['number']) ? 3 : $instance['number'];
		if($ids!=''){
			$ids = explode(",", $ids);
			$gc = array();
			foreach ( $ids as $grid_id ) {
				array_push($gc, $grid_id);
			}
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
				'post__in' =>  $gc,
				'ignore_sticky_posts' => 1,
			);
		}else if($post_type=='tribe_events'){
			if($tags!=''){
				$tax = explode(",",$tags);
				if(is_numeric($tax[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tax)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tax as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'post_tag',
								  'field' => $field_tag,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'post_tag',
								  'field' => $field_tag,
								  'terms' => $tags,
							  )
					  );
				}
			}
			//cats
			if($cats!=''){
				$taxonomy = explode(",",$cats);
				if(is_numeric($taxonomy[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($taxonomy)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($taxonomy as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'tribe_events_cat',
								  'field' => $field,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'tribe_events_cat',
								  'field' => $field,
								  'terms' => $cats,
							  )
					  );
				}
			}
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
			
		} else if($ids=='' && $post_type!='product') {
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
		
			if(!is_array($cats) && $cats!='') {
				$category = explode(",",$cats);
				if(is_numeric($cats[0])){
					$args['category__in'] = $category;
				}else{			 
					$args['category_name'] = $cats;
				}
			}elseif($cats && count($cats) > 0){
				$args['category__in'] = $cats;
			}
			if($tags!=''){
				$args += array('tag' => $tags);
			}
		}else if($post_type=='product'){
			if($tags!=''){
				$tax = explode(",",$tags);
				if(is_numeric($tax[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tax)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tax as $iterm) {
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
			//cats
			if($cats!=''){
				$taxonomy = explode(",",$cats);
				if(is_numeric($taxonomy[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($taxonomy)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($taxonomy as $iterm) {
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
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
			
		}

		$the_query = new WP_Query( $args );
		$html = $before_widget;
		$html .='<div class="leaf-lastest">';
		if ( $title ) $html .= $before_title . $title . $after_title; 
		if($the_query->have_posts()):
			while($the_query->have_posts()): $the_query->the_post();
				$html .='<div class="item">';
					if(has_post_thumbnail(get_the_ID())){
						$html .='<div class="thumb">
							<a href="'.esc_url(get_permalink(get_the_ID())).'" title="'.the_title_attribute('echo=0').'">
								<div class="item-thumbnail">';
								$html .= get_the_post_thumbnail(get_the_ID(),'leaf_thumb_80x80');
								$html .='
									<div class="thumbnail-hoverlay-icon"><i class="fa lnr lnr-magnifier"></i></div>
								</div>
							</a>
						</div>';
					}
					$html .='<div class="leaf-details item-content">
						<h5 class="font-2"><a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'" class="main-color-1-hover">'.the_title_attribute('echo=0').'</a></h5>
						<span class="leaf-widget-meta"><i class="fa fa-clock-o"></i> '.( ($post_type=='tribe_events'&&class_exists('Tribe__Events__Main'))?tribe_events_event_schedule_details():get_the_time(get_option('date_format'),get_the_ID()) ).'</span>
					</div>';
				$html .='<div class="clearfix"></div></div>';
			endwhile;
		endif;
		$html .='</div>';
		$html .= $after_widget;
		echo ''.$html;
		wp_reset_postdata();
		//$cache[$argsxx['widget_id']] = ob_get_flush();
		//wp_cache_set('widget_Leaf_Recent_Posts', $cache, 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ids'] = strip_tags($new_instance['ids']);
		$instance['tags'] = strip_tags($new_instance['tags']);
        $instance['cats'] = strip_tags($new_instance['cats']);
		$instance['post_type'] = $new_instance['post_type'];
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$ids = isset($instance['ids']) ? esc_attr($instance['ids']) : '';
		$cats = isset($instance['cats']) ? esc_attr($instance['cats']) : '';
		$tags = isset($instance['tags']) ? esc_attr($instance['tags']) : '';
		$post_type = isset($instance['post_type']) ? esc_attr($instance['post_type']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','conferpress'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
      	<!-- /**/-->        
        <p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts:','conferpress'); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

      	<!-- /**/-->
        <p>
          <label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e('Post type','conferpress'); ?></label> 
          <select name="<?php echo esc_attr($this->get_field_name('post_type')); ?>" id="<?php echo esc_attr($this->get_field_id('post_type')); ?>">
              <option value="post" <?php if($post_type=='post'){?> selected="selected"<?php }?>><?php esc_html_e('Post','conferpress'); ?></option>
              <option value="tribe_events" <?php if($post_type=='tribe_events'){?> selected="selected"<?php }?>><?php esc_html_e('Event','conferpress'); ?></option>
              <option value="product" <?php if($post_type=='product'){?> selected="selected"<?php }?>><?php esc_html_e('Product','conferpress'); ?></option>
            </select>
        </p>
        <p>
          <label for="<?php echo esc_attr($this->get_field_id('tags')); ?>"><?php esc_html_e('Tags:','conferpress'); ?></label> 
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tags')); ?>" name="<?php echo esc_attr($this->get_field_name('tags')); ?>" type="text" value="<?php echo esc_attr($tags); ?>" />
        </p>
		<!--//-->
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('cats')); ?>" class="app-cat-widget"><?php esc_html_e('Categories:','conferpress');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('cats')); ?>" name="<?php echo esc_attr($this->get_field_name('cats')); ?>" type="text" value="<?php echo esc_attr($cats); ?>" />
        </p>
        <p>
          <label for="<?php echo esc_attr($this->get_field_id('ids')); ?>"><?php esc_html_e('IDs to show:','conferpress'); ?></label> 
          <input class="widefat" id="<?php echo esc_attr($this->get_field_id('ids')); ?>" name="<?php echo esc_attr($this->get_field_name('ids')); ?>" type="text" value="<?php echo esc_attr($ids); ?>" />
        </p>
<?php
	}
}

function leaf_widget_init() {
    return register_widget("Leaf_Recent_Posts");
}
add_action( 'widgets_init', 'leaf_widget_init' );