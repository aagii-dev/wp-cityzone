<?php
/* Template Name: Simple page */
get_header();
?>
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


	?>

	<div class='section bg-silver'>
		<div class='container post-content'>
			<div class='post-title mini-title mb-24'>
				<?php echo $title; ?>
			</div>

			<?php the_content(); ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
} //end while
?>
<?php get_footer(); ?>