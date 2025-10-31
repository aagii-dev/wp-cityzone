<?php

if (!class_exists('vc_FooterText') && class_exists('WPBakeryShortCode')) {
	class vc_FooterText extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_FooterText_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_FooterText', [$this, 'vc_FooterText_html']);
		}

		public function vc_FooterText_mapping()
		{
			vc_map([
				'name' => __('FooterText', 'text-domain'),
				'base' => 'vc_FooterText',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
                    array(
                        'type' => 'textarea',
                        'heading' => 'Text',
                        'param_name' => 'mg_text',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Link label',
                        'param_name' => 'mg_link_text',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Link',
                        'param_name' => 'mg_link',
                        'admin_label' => true,
                    ),
				),
			]);
		}

		public function vc_FooterText_html($atts)
		{
			extract(shortcode_atts([
				'mg_text' => '',
				'mg_link' => '',
				'mg_link_text' => '',
			], $atts));

   

            // HTML бүтээж буцаана
            ob_start(); ?>
            <div class="row">
                <div class="col-12 col-md-10 col-lg-7">
                    <div class="footer-head">
                        <div class="d-flex flex-row align-items-center justify-content-between">
                            <div class="text">
                            <?php echo $mg_text; ?>
                            </div>
                            <a href="<?php echo $mg_link; ?>" ><span><?php echo $mg_link_text; ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_FooterText();
}
