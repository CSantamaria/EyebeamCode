<?php
/**
 * Template Name: Residents Archives
 * The template for displaying resident archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package eyebeam2016
 */
get_header(); ?>

<div id="primary" class="content-area">
	<!-- Residency People Page Hero Image -->
	<div class="mobile-hero" >
	<?php $image = get_field('hero_image_residency'); 
		if(!empty($image)) : ?>
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="100%" height="100%"/>
		<?php endif; ?>
	</div>
	
	<!-- Main Navigation Bar -->		
	<?php include_once('inc/nav.inc.php'); ?>
	<!-- End Main Navigation Bar -->
	
	<!-- Main Content -->
	<main id="main" class="column column-7 site-main" role="main">
		<div class="resident-page-title"><?php the_title(); ?></div>

	<div class="current toggle">
		<a <?php if (strpos($_SERVER['REQUEST_URI'], 'residency-information') > 1) print 'class="current"'; ?> href="residency-information">Information</a> / <a <?php if (strpos($_SERVER['REQUEST_URI'], 'residency') > 1) print 'class="current"'; ?> href="residency">People</a>
	</div>

	<!-- Resident Dropdown Filter -->
	<div class="dropdown">
		<a class="residency-year">Filter by Year</a>
			<div class="submenu-years">
				<ul class="root">
				<li>
					<a href="?resident_year=2017">2017</a>
				</li>
				<li >
					<a href="?resident_year=2016">2016</a>
				</li>
				<li>
					<a href="?resident_year=2015">2015</a>
				</li>
				<li >
					<a href="?resident_year=2014">2014</a>
				</li>
				<li>
					<a href="?resident_year=2013">2013</a>
				</li>
				<li >
					<a href="?resident_year=2012">2012</a>
				</li>
				<li>
					<a href="?resident_year=2011">2011</a>
				</li>
				</ul>
			</div>
		</div>
	<!-- End Resident Dropdown Filter -->

	<?php if ( have_posts() ) : ?>
	<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>	
			<?php
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('resident'); ?>	
		<?php endwhile; ?>
		
	<?php
		$archive_args = array(
		'post_type' => 'resident',
		'posts_per_page' => -1,
		);

		 if(!isset($_GET['resident_year']) and ($_GET['resident_year'])){
				return;
			// Cast the value that was in the URL to an int to avoid SQL injection
			$resident_year = (int)$_GET['resident_year'];

			$archive_args['meta_query'] =  
		     array(
			     array(
				      'key'=> 'start_year',
				      'value'=> $resident_year,
				      'compare'=> '<=' 
			),

			// The value being queried (e.g. 2014) should be less than or equal to 
			// the resident's end year (e.g. 2016)
			array(
				'key'=> 'end_year',
				'value'=> $resident_year, 
				'compare'=> '>=' 
			),
			);
			};
			
		$residents = new WP_Query($archive_args);
		if($residents->have_posts()){
			$i = 0;
			while($residents->have_posts()) : $residents->the_post();
				// create 3 columns
					// output an open <div>
				if($i % 3 == 0) { ?>
					<div class="row">
				<?php
				}
				?>

		<!-- web layout -->
		<div class="column column-3 content-resident-people event-line-height">
			<?php
				$image = get_field('image');
				$specific_date = eyebeam2016_compare_resident_year(get_the_ID());
				//var_dump($specific_date);
		
				if($specific_date) : ?>
					<?= $specific_date ; ?> </br>
		   		 <?php endif;

		   		 if($residents) : ?>
					<?php echo the_field('resident_type'); ?> 
				<?php endif;

				if($residents) : ?>
					<div class="bold-title"> <?php echo the_field('name'); ?> </div>
				<?php endif;

				if(!empty($image)) : ?>			
					<p><img src= "<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="100%" height="100%"/></p>
				<?php endif; ?>
		</div>

		<!-- mobile layout -->
		<div id="mobile-resident-image">		
			<?php $image = get_field('image'); ?>

			<?php
				if(!empty($image)) : ?>			
					<img src= "<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="100%" height="100%"/> 
			<?php endif; ?>
		</div>		
	
		<div id="mobile-resident-name">
			<?php if($residents) : ?>
					<h4> <?php echo the_field('name'); ?> </h4> 
		   	<?php endif;

		   	if($residents) : ?>
				<?php echo the_field('resident_type'); ?> 
			<?php endif; ?>	
	
			<?php 
			$specific_date = eyebeam2016_compare_resident_year(get_the_ID());
			if($specific_date) : ?>
				<?= $specific_date ; ?> 
	   		 <?php endif; ?>	 
		</div>


	<!-- for loop for grid -->	
	<?php 
		$i++;
		if($i != 0 && $i % 3 == 0){ ?>
			</div> <!--/.row-->
			<div class="clearfix"> </div>
			<?php
		} ?>

	<?php endwhile;
	}

	wp_reset_query();?>

	<?php wp_reset_postdata(); ?>

	<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<aside class="sidebar"> <?php get_sidebar(); ?> </aside>

<?php get_footer(); ?>