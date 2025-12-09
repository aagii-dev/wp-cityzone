<?php

if (!class_exists('vc_PageTitle') && class_exists('WPBakeryShortCode')) {
	class vc_PageTitle extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_PageTitle_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_PageTitle', [$this, 'vc_PageTitle_html']);
		}

		public function vc_PageTitle_mapping()
		{
			vc_map([
				'name' => __('Page title', 'text-domain'),
				'base' => 'vc_PageTitle',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Title',
                        'param_name' => 'mg_title',
                        'admin_label' => true,
                    ),
				),
			]);
		}

		public function vc_PageTitle_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
			], $atts));


    
            // Title / Content sanitize
            $title   = sanitize_text_field($atts['mg_title']);
      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="page-header">
                <h1><?php echo $title; ?></h1>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/devby_tesopro.png" class='devby' />
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_PageTitle();
}
