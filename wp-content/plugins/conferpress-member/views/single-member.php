<?php
$layout = leaf_get_option('member_sidebar_layout','right');
$event_plural = function_exists('tribe_get_event_label_plural')?tribe_get_event_label_plural():esc_html__('Events','conferpress-member');
get_header();
?>
	<?php get_template_part( 'templates/header/header', 'heading' ); ?>    
    <div id="body">
    	<?php if($layout!='true-full'){ ?>
    	<div class="container">
        <?php }?>
        	<div class="content-pad-4x">
                <div class="row">
                    <div id="content" class="<?php if($layout != 'full' && $layout != 'true-full'){ ?> col-md-9 <?php }else{?> col-md-12 <?php } if($layout == 'left'){ ?> revert-layout <?php }?>" role="main">
                        <article class="single-page-content">
                        	<?php while ( have_posts() ) : the_post();
								the_content();
							endwhile;
							wp_reset_query();
							?>
                        </article>
                        
                        <?php if(leaf_get_option('member_show_event','on')!='off'){ ?>
                        <div class="member-event-list">
                        	<?php
							$args = array(
								'post_type' => 'tribe_events',
								'posts_per_page' => 200,
								'eventDisplay' => '', //or 'past'
								'ignore_sticky_posts' => 1,
								'meta_query' => array (
									array (
										'key' => 'member-id',
										'value' => serialize( strval( get_the_ID() ) ),
										'compare' => 'LIKE'
									)
								)
							);
							$the_query = new WP_Query($args);
							if ( $the_query->have_posts() ) {
								echo do_shortcode('[sc_heading url="" align="left" size="0"]'.esc_html__('Upcoming','conferpress-member').' '.$event_plural.'[/sc_heading]');
								echo '<div class="row">';
								
								while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                                <div class="col-md-4">
								<div class="event-carousel-item event-in-col event-item">
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
                                                <?php if(class_exists('Tribe__Events__Main')){
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
                                                <?php }?>
                                            </a>
                                        </div>
                                        
                                        <div class="event-item-content">
                                            <h3 class="event-title font-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <div class="event-meta small-meta">
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
                                                <?php }?>
                                            </div>
                                            <div class="event-excerpt"><?php the_excerpt(); ?></div>
                                            <a class="btn btn-lighter event-button btn-block" href="<?php the_permalink(); ?>">
                                                <span class="btn-text"><i class="lnr lnr-calendar-full"></i> <?php esc_html_e('Join Now', 'conferpress-member'); ?></span>
                                            </a>
                                        </div>
                                    </div><!--inner-->
                                </div><!--/event-carousel-item-->
                                </div><!--/col-md-4-->
								<?php }//while have_posts
								echo '</div>';//row
							}//if have_posts
							wp_reset_postdata(); ?>
                        </div>
                        <?php }//if show event ?>
                        
                        
                        <?php if(leaf_get_option('member_show_member','on')!='off'){ ?>
                        <div class="sc-single-event-trainer">
                            <?php
                            echo do_shortcode('[sc_heading url="" align="left" size="0"]'.esc_html__('Other ', 'conferpress-member').leaf_get_option('member_label','Trainers').'[/sc_heading]');
                            echo do_shortcode('[sc_post_grid column="3" post_type="sp_member" count="3" orderby="rand"]'); ?>
                        </div>
                        <?php } ?>
                        
                        
                    </div><!--/content-->
                    <?php if($layout != 'full' && $layout != 'true-full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-4x-->
        <?php if($layout!='true-full'){ ?>
        </div><!--/container-->
        <?php }?>
    </div><!--/body-->
<?php get_footer(); ?>