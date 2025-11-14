<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<meta http-equiv='X-UA-Compatible' content='ie=edge' />

	<title><?php wp_title('', true, 'right'); ?></title>

	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	
	<!-- fav -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo esc_url(get_template_directory_uri()); ?>/assets/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">


	<?php wp_head(); ?>
</head>

<?php
global $polylang;
?>
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


if (isset($polylang)) {
	$languages = site_languages();
	$current = pll_current_language();
	// Одоогийн хэлээс бусад нь
	foreach ($languages as $lang) {
		if ($lang->slug !== $current) {
			$switch_url = pll_home_url($lang->slug);
		}
	}
}

$bodyCls = "";
?>


<body <?php body_class($bodyCls); ?> >
	<div id="menu">
		<!-- LEFT RAIL -->
		<aside class="rail">
			<a href="<?php echo pll_home_url();?>" class="brand">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.svg" alt="City Zone" />
			</a>
			<button class="menu-btn" id="menuBtn" aria-label="Меню">
				<span></span><span></span><span></span>
			</button>
		</aside>

		<!-- MENU OVERLAY -->
		<div class="menu" id="menuOverlay" data-lenis-prevent>
			<div class="menu-inner container-fluid d-flex flex-column justify-content-end min-vh-100 py-5">
				<div class="row g-5 align-items-end">
				<div class="col-12 col-lg-8">
					<?php 
						wp_nav_menu([
							'theme_location' => 'main_menu',
							'container'      => "nav",
							'container_class'      => "menu-links mb-5 text-uppercase",
							'items_wrap'     => '%3$s', // <ul> бүрхүүл гаргахгүй
							'walker'         => new Main_Nav_Walker(),
						]);
						?>

					<small class="d-none d-md-flex">© 2025 TESO Properties LLC, All Rights Reserved.</small>
				</div>
				<div class="col-12 col-lg-4">
					<div class="menu-side mb-5">
					<div>
						<div class='mb-4'>
							<p class="cap">СОШИАЛ ХАЯГ</p>
							<?php if($facebook_url):?>
								<a href='<?php echo $facebook_url; ?>' target='_blank'>Фэйсбүүк</a><br />
							<?php endif; ?>
							<?php if($instagram_url):?>
								<a href='<?php echo $instagram_url; ?>' target='_blank'>Инстаграм</a><br />
							<?php endif; ?>
						</div>
						<div>
							<p class="cap">ХОЛБОО БАРИХ</p>
							<a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a><br />
							<a href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a>
						</div>
					</div>
					<!-- <a target="_blank" href="https://yld.mn">
					<span class="powered">Developed by <b>YLD</b></span>
					</a> -->
				</div>
				</div>
			</div>
		</div>


	</div>


    <main class="page-wrapper">
