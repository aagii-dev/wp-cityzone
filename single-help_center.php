<?php get_header(); ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {
	var navbar = document.getElementById("mainNavbar");
	if(navbar){
		navbar.classList.add("force-white");
	}
	});
</script>
<?php
while (have_posts()) {
	the_post();
	$title = get_the_title();

	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$cat_id   = $categories[0]->term_id; // ID
		$cat_name = $categories[0]->name;    // Нэр
	} 
	?>
	
	<div class='section bg-silver'>
		<div class='container post-content'>
			<div class='mini-title mb-24'>
				<?php echo $title; ?>
			</div>
			<div class='mb-64'>
				<?php the_excerpt(); ?>
			</div>
			<?php the_content(); ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
} //end while
?>
<?php get_footer(); ?>