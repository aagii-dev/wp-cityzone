<?php get_header(); ?>
<?php
while (have_posts()) {
	the_post();
	$title = get_the_title();

	$categories  = get_the_terms(get_the_ID(), 'job_category');
	$times = get_the_terms(get_the_ID(), 'job_time');
	$job_link = get_post_meta(get_the_ID(), 'job_link', true);
	if ( ! empty( $categories ) ) {
		$cat_id   = $categories[0]->term_id; // ID
		$cat_name = $categories[0]->name;    // Нэр
	} 
	?>
	<div class="post-header bg-black text-white">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class='mb-24 d-flex justify-content-between'>
						<div class='news-item-tag'><?php echo esc_html( $cat_name ); ?></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class='mb-24 d-flex justify-content-end'>
						<div class='news-item-date'><?php echo esc_html(get_the_date("Y.m.d")); ?></div>
						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class='post-title mini-title mb-24'>
						<?php echo $title; ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class='mb-24 d-flex justify-content-end'>
						<a href="<?php echo $job_link; ?>" target='blank' class='btn btn-light'>Анкет бөглөх</a>
					</div>
				</div>
			</div>
		
			

			<?php if ( has_post_thumbnail() ) : ?>
				<div class='mt-64'>
					<div class='image-wrapper'>
						<?php the_post_thumbnail('medium'); ?>
					</div>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	<div class='section bg-silver'>
		<div class='container post-content'>
			<!-- <div class='mini-title mb-24'>
				<?php echo $title; ?>
			</div> -->
			<?php the_content(); ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
} //end while
?>
<?php get_footer(); ?>