<?php
if(function_exists('cmb2_get_option') && function_exists('pll_current_language')) {
	$contact_email = cmb2_get_option('yld_options', 'contact_email');
	$contact_phone = cmb2_get_option('yld_options', 'contact_phone');
	$facebook_url = cmb2_get_option('yld_options', 'facebook_url');
	$instagram_url = cmb2_get_option('yld_options', 'instagram_url');
	$address = cmb2_get_option('yld_options', 'address' . pll_current_language('slug'));
	$footer_text = cmb2_get_option('yld_options', 'footer_text_' . pll_current_language('slug'));
	$brochure_link = cmb2_get_option('yld_options', 'brochure_link_' . pll_current_language('slug'));
            


}

?>
</main>

<!-- footer -->
<div id="footer">
	<footer>

	<div class="site-footer text-white">
		<!-- NAVIGATION -->
		<div
		class="d-none d-md-flex flex-column flex-md-row align-items-center justify-content-between mb-5"
		>
		<?php
			wp_nav_menu([
			'theme_location' => 'main_menu',
			'container'      => 'nav',
			'container_class'=> 'footer-nav d-flex flex-column flex-md-row justify-content-center justify-content-lg-start gap-5 mb-5',
			'items_wrap'     => '%3$s', // <ul> бүрхүүл гаргахгүй
			'walker'         => new Main_Nav_Walker(),
			]);
		?>
		

		<img
			id="scrollTop"
			src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/arrow-up.png"
			alt="arrow"
			role="button"
			tabindex="0"
			class="arrow-up"
		/>
		</div>

		<!-- LOGO - CONTACT -->
		<div class="row gap-5 gap-md-0 mb-5">
		<div class="col-12 col-lg-8">
			<h1 class="footer-logo">CITYZONE</h1>
		</div>
		<div class="col-12 col-lg-4">
			<div class="row">
			<div class="col-6">
				<p class="cap">СОШИАЛ ХАЯГ</p>
				<?php if($facebook_url):?>
					<a href='<?php echo $facebook_url; ?>' target='_blank'>Фэйсбүүк</a><br />
				<?php endif; ?>
				<?php if($instagram_url):?>
					<a href='<?php echo $instagram_url; ?>' target='_blank'>Инстаграм</a><br />
				<?php endif; ?>
				
			</div>
			<div class="col-6">
				<p class="cap">ХОЛБОО БАРИХ</p>
				<a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a><br />
				<a href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a>
			</div>
			</div>
		</div>
		</div>
		<!-- YLD -->
		<div class="row g-3">
		<div class="col-12 col-md-8 text-center text-md-start">
			<small>© 2025 TESO Properties LLC, All Rights Reserved.</small>
		</div>
		<div class="col-12 col-md-4 text-center text-md-start">
			<a target="_blank" href="https://yld.mn">
			<div class="powered">
				Developed by <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/yld.svg" />
			</div>
			</a>
		</div>
		</div>
	</div>
	</footer>
</div>


<!-- lightGallery CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2/css/lightgallery-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2/lightgallery.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/zoom/lg-zoom.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/fullscreen/lg-fullscreen.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>

<?php wp_footer(); ?>


<!-- smooth-content -->
</div>
</body>

</html>