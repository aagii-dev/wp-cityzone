<?php
if(function_exists('cmb2_get_option') && function_exists('pll_current_language')) {
	$social_facebook_url = cmb2_get_option('yld_options', 'social_facebook_url');
	$social_instagram_url = cmb2_get_option('yld_options', 'social_instagram_url');
	$social_linkedin_url = cmb2_get_option('yld_options', 'social_linkedin_url');
	$social_twitter_url = cmb2_get_option('yld_options', 'social_twitter_url');
	$social_youtube_url = cmb2_get_option('yld_options', 'social_youtube_url');



	$contact_address = cmb2_get_option('yld_options', 'contact_address_'.pll_current_language('slug'));
	
}

?>
</main>

<!-- footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<a class="navbar-brand navbar-center-logo mb-48" href="#">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/footer-logo.svg" />
				</a>	
				<div class="mt-32">
					<?php echo wpautop(esc_html($contact_address)); ?>
				</div>

				<ul class="social-links">
					<?php echo $social_facebook_url ? "<li><a href='$social_facebook_url' class='footer-link'><img src='".esc_url(get_template_directory_uri())."/assets/images/social-facebook.svg' /></a></li>" : ""; ?>
					<?php echo $social_instagram_url ? "<li><a href='$social_instagram_url' class='footer-link'><img src='".esc_url(get_template_directory_uri())."/assets/images/social-instagram.svg' /></a></li>" : ""; ?>
					<?php echo $social_youtube_url ? "<li><a href='$social_youtube_url' class='footer-link'><img src='".esc_url(get_template_directory_uri())."/assets/images/social-youtube.svg' /></a></li>" : ""; ?>
					<?php echo $social_twitter_url ? "<li><a href='$social_twitter_url' class='footer-link'><img src='".esc_url(get_template_directory_uri())."/assets/images/social-twitter.svg' /></a></li>" : ""; ?>
					<?php echo $social_linkedin_url ? "<li><a href='$social_linkedin_url' class='footer-link'><img src='".esc_url(get_template_directory_uri())."/assets/images/social-linkedin.svg' /></a></li>" : ""; ?>
				</ul>
			</div>
			<div class="col-lg-7">
				<?php
				$footerarg = array(
					'container' => '',
					'theme_location' => 'footer-menu-1',
					'menu_class' => 'footer-nav',
					'walker' => new Footer_Menu_Walker()
				);
				wp_nav_menu($footerarg);
				?>
			</div>
		</div>
		<div class="footer-bottom d-flex justify-content-between">
			<div class="copyright">
				© <?php echo date("Y"); ?>. <?php echo pll__("copy_right"); ?>
			</div>
			<div class="d-flex footer-second-menu">
				<?php
				$footerarg = array(
					'container' => '',
					'theme_location' => 'footer-menu-2',
					'menu_class' => 'footer-nav2',
				);
				wp_nav_menu($footerarg);
				?>
				<div style="margin-top: -4px">		
					<a
						target="_blank"
						href="https://yld.mn"
						id="poweredBy"
						style="
						text-transform: unset;
						display: inline-flex;
						font-size: 11px;
						font-weight: 400;
						align-items: center;
						gap: 4px;
						color: #fff;
						text-decoration: none;
						padding: 8px 10px;
						border-radius: 5px;
						white-space: nowrap;
						background-color: hsl(0deg 0% 51.61% / 14%);
						"
					>
						<span style="opacity: 0.8">Developed by &nbsp;</span>
						<svg
						style="width: auto; height: 12px"
						width="847"
						height="232"
						viewBox="0 0 847 232"
						fill="white"
						xmlns="http://www.w3.org/2000/svg"
						>
						<path
							d="M271 0H228.81C228.81 52.4067 186.917 95.1056 135.5 95.1056C84.0829 95.1056 42.1903 52.4067 42.1903 0H0C0 68.8643 49.7057 126.049 114.368 136.439V232H156.558V136.439C221.294 126.049 271 68.8643 271 0Z"
						></path>
						<path
							d="M733.261 0H578V232H733.187C795.993 231.772 847 179.804 847 116C847 52.1962 796.068 0.303466 733.261 0ZM732.813 188.984H620.344V43.0164H732.813C772.469 43.0164 804.656 75.7907 804.656 116C804.656 156.285 772.469 188.984 732.813 188.984Z"
						></path>
						<path
							d="M423.112 188.984C383.557 188.984 351.316 156.285 351.316 116V0H309V116V116.455C309.224 179.956 359.973 231.621 422.44 232H542V188.984H423.112Z"
						></path>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>


<!-- sources -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    AOS.init({
        offset: 100,      // 0 биш, илүү дээр
		duration: 800,
		easing: 'ease-out',
		delay: 100,
		once: false,
		mirror: false
    });
  });
</script>

<?php wp_footer(); ?>


<!-- smooth-content -->
</div>
</body>

</html>