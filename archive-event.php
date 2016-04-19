<?php
/**
 * Template Name: Events Archives
 * The template for displaying calendar archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package eyebeam2016
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="column column-7 site-main" role="main">
			<div class="page-title">
				Calendar
			</div>
			<h2 class="toggle">Upcoming and current events</h2>


			<?php
			    $now = new DateTime;
			    $todays_date_formatted = $now->format('Ymd');
				$archive_args = array(
					'post_type' => 'event',
					'posts_per_page' => -1,
					'orderby'=> 'meta_value',
					'meta_key' => 'end_date', 

				);

				$output_past_events_header = false; 
				$events = new WP_Query($archive_args);
				if($events->have_posts()){
					$i = 0; 
					while($events->have_posts()) : $events->the_post();

					$event = get_fields();
					if($output_past_events_header==false){
						if($todays_date_formatted > $event['end_date']){
							//If the column div is open, close it before outputing Past Events Header  
							if($i % 2 == 1){ 
								echo "</div>";
								//Since we are closing the div prematurely, modify the counter appropriately.
								$i--;
							} 
							echo '<h2 class="toggle">Past Events</h2>'; 
							$output_past_events_header=true; 
						}
						
					}

					// create 2 columns
 					// output an open <div>
					if($i % 2 == 0) { ?>
					<div class="row">	
						<?php 
					}
						?>

					<div class="column-5 content-event">
						<?php
							                
							$specific_date = eyebeam2016_get_event_date(get_the_ID());
							$image = get_field('image'); 




				
							if($events) : ?>
								<h3> 
									<a href="<?php the_permalink(); ?>">
										<?php echo the_field('title'); ?>
									</a>
								</h3>
							<?php endif;

							if($specific_date): ?>
				                <p>
					              <?= $specific_date ; ?> 
				                </p>	
				            <?php endif;
							

			   				if($events) : ?>
								<p>
									<?php the_field('location'); ?>
			    				</p>
			    			<?php endif;

							if(!empty($image)) : ?>				
								<p>
									 <a href="<?php the_permalink(); ?>">
										 <img src= "<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="80%" height="80%" /> 
									 </a>		
								</p>
							<?php endif; ?>
					</div>

						<?php $i++;
							if($i != 0 && $i % 2 == 0){ ?>
							</div> <!--/.row-->
						
						<div class="clearfix"> </div>	
				
						<?php
							} 
						?>
					<?php endwhile;
				} ?>
			
			<?php wp_reset_query(); ?>

			<?php wp_reset_postdata(); ?>


		</main><!-- #main -->
	</div><!-- #primary -->

	<aside class="sidebar">
		<?php get_sidebar(); ?>
	</aside>
 		
	<?php get_footer(); ?>