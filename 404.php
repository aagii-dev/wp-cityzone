<?php get_header(); ?>
<!-- main -->

<div class='d-flex flex-column align-items-center justify-content-center' style="min-height: 100vh;">
	<h1 class="text-dark text-center">404</h1>
	<div class="space space-32"></div>


	<div class="text-center">

		<div class="text-large text-center ">
			<?php echo pll__("oops"); ?><br>
			<strong><?php echo pll__("not_found"); ?></strong>
		</div>

	</div>
	<div class="space space-32 mb-5"></div>
	<div class="d-flex gap12 justify-content-center ">
		<a href="<?php echo pll_home_url(); ?>" class="btn btn-outline-primary"><span><?php echo pll__("home_page"); ?></span></a>
	</div>
</div>


<?php get_footer(); ?>