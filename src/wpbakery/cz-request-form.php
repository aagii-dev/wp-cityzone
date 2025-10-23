<?php

if (!class_exists('vc_RequestForm') && class_exists('WPBakeryShortCode')) {
	class vc_RequestForm extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_RequestForm_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_RequestForm', [$this, 'vc_RequestForm_html']);
		}

		public function vc_RequestForm_mapping()
		{
			vc_map([
				'name' => __('Request form', 'text-domain'),
				'base' => 'vc_RequestForm',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					
                    array(
                        'type' => 'textfield',
                        'heading' => 'Title',
                        'param_name' => 'mg_title',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Contact form shortcode',
                        'param_name' => 'mg_form',
                        'admin_label' => true,
                    ),
				),
			]);
		}

		public function vc_RequestForm_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_form' => '',
			], $atts));


      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
          <div class="section-wrapper">
          <div class="divider"></div>

          <div class="row g-5">
            <div class="col-12 col-lg-6">
              <p class="title"><?php echo $mg_title; ?></p>
            </div>
            <div class="col-12 col-lg-6">
              <?php 
              $contact_form = cmb2_get_option('yld_options', 'contact_form_' . pll_current_language('slug'));
              echo do_shortcode($contact_form);
              ?>
            </div>
          </div>
        </div>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_RequestForm();
}
