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



                    array(
                        'type' => 'textarea',
                        'heading' => 'Event Text',
                        'param_name' => 'mg_event_box_text',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Event Location',
                        'param_name' => 'mg_event_box_location',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Event Date (day)',
                        'param_name' => 'mg_event_box_day',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Event Date (time)',
                        'param_name' => 'mg_event_box_time',
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
				'mg_event_box_text' => '',
				'mg_event_box_location' => '',
				'mg_event_box_day' => '',
				'mg_event_box_time' => '',

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
              <?php if(!empty($mg_event_box_text)): ?>
                <div class="mb-4"><?php echo $mg_event_box_text; ?></div>
              <?php endif;?>
              <div class="row">
                <?php if(!empty($mg_event_box_location)): ?>
                  <div class="col-sm-6 mb-4">
                    <div class='event-box'>
                      <h5 class="text-uppercase mb-4">📍 Байршил</h5>
                      <?php echo $mg_event_box_location; ?>
                    </div>
                  </div>
                <?php endif;?>
                <?php if(!empty($mg_event_box_day) || !empty($mg_event_box_time)): ?>
                  <div class="col-sm-6 mb-4">
                    <div class='event-box'>
                      <h5 class="text-uppercase mb-4">📅 Огноо</h5>
                      <?php echo "<div><b>$mg_event_box_day</b></div>"; ?>
                      <?php echo "$mg_event_box_time"; ?>
                    </div>
                  </div>
                <?php endif;?>
              </div>
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
