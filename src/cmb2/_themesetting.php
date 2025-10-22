<?php

/**
 * Hook in and register a submenu options page for the Appearance menu.
 */
add_action('cmb2_admin_init', 'socialmenu_register_options_submenu_appearance_menu2');

function socialmenu_register_options_submenu_appearance_menu2()
{

	/**
	 * Registers options page menu item and form.
	 */
	$cmb = new_cmb2_box(array(
		'id' => 'yld_options_menu',
		'title' => esc_html__('Theme settings', 'cmb2'),
		'object_types' => array('options-page'),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key' => 'yld_options', // The option key and admin menu page slug.
		// 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		'parent_slug' => 'themes.php', // Make options page a submenu item of the themes menu.
		'capability' => 'edit_theme_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	));

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */


	global $polylang;


	// news page url
	if (isset($polylang)) {
		$languages = pll_languages_list();
		foreach ($languages as $value) {
			$cmb->add_field(array(
				'name' => __('Contact /'.$value, 'cmb2'),
				'id' => 'contact_address_'.$value,
				'type' => 'textarea'
			));
		}

		foreach ($languages as $value) {
			$cmb->add_field(array(
				'name' => __('Search page url /'.$value, 'cmb2'),
				'id' => 'search_url_'.$value,
				'type' => 'text_url'
			));
		}
		foreach ($languages as $value) {
			$cmb->add_field(array(
				'name' => __('Login page url /'.$value, 'cmb2'),
				'id' => 'login_url_'.$value,
				'type' => 'text_url'
			));
		}
	}




	$cmb->add_field(array(
		'name' => __('Facebook Url', 'cmb2'),
		'id' => 'social_facebook_url',
		'type' => 'text_url'
	));
	$cmb->add_field(array(
		'name' => __('Twitter Url', 'cmb2'),
		'id' => 'social_twitter_url',
		'type' => 'text_url'
	));
	$cmb->add_field(array(
		'name' => __('Linkedin Url', 'cmb2'),
		'id' => 'social_linkedin_url',
		'type' => 'text_url'
	));
	$cmb->add_field(array(
		'name' => __('Instagram Url', 'cmb2'),
		'id' => 'social_instagram_url',
		'type' => 'text_url'
	));
	$cmb->add_field(array(
		'name' => __('Youtube Url', 'cmb2'),
		'id' => 'social_youtube_url',
		'type' => 'text_url'
	));



}
