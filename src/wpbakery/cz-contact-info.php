<?php

if (!class_exists('vc_ContactInfo') && class_exists('WPBakeryShortCode')) {
	class vc_ContactInfo extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_ContactInfo_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_ContactInfo', [$this, 'vc_ContactInfo_html']);
		}

		public function vc_ContactInfo_mapping()
		{
			vc_map([
				'name' => __('Contact info', 'text-domain'),
				'base' => 'vc_ContactInfo',
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

		public function vc_ContactInfo_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
			], $atts));

        $contact_email = cmb2_get_option('yld_options', 'contact_email');
        $contact_phone = cmb2_get_option('yld_options', 'contact_phone');
        $facebook_url = cmb2_get_option('yld_options', 'facebook_url');
        $instagram_url = cmb2_get_option('yld_options', 'instagram_url');
        $address = cmb2_get_option('yld_options', 'address' . pll_current_language('slug'));
            
            // HTML бүтээж буцаана
            ob_start(); ?>
         <div class="section-wrapper">
          <div class="divider"></div>

          <div class="row g-5">
            <div class="col-12 col-lg-6">
              <p class="title"><?php echo $mg_title;  ?></p>
            </div>
            <div class="col-12 col-lg-6">
              <!-- - -->
              <div class="row">
                <div class="col-4">
                  <p class="info-label">Холбогдох</p>
                </div>
                <div class="col-8">
                  <div class="info-item">
                    <p>Email: <?php echo $contact_email; ?></p>
                    <p>Утас: <?php echo $contact_phone; ?></p>
                  </div>
                </div>
              </div>
              <!-- - -->
              <div class="row">
                <div class="col-4">
                  <p class="info-label">Сошиал</p>
                </div>
                <div class="col-8">
                  <div class="info-item">
                    <?php if($facebook_url):?>
                      <p><a href='<?php echo $facebook_url; ?>' target='_blank'>Фэйсбүүк</a></p>
                    <?php endif; ?>
                    <?php if($instagram_url):?>
                      <p><a href='<?php echo $instagram_url; ?>' target='_blank'>Инстаграм</a></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- - -->
              <div class="row">
                <div class="col-4">
                  <p class="info-label">Хаяг</p>
                </div>
                <div class="col-8">
                  <div class="info-item">
                    <p>
                      <?php echo $address; ?>
                    </p>
                    <p>Утас: <?php echo $contact_phone; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_ContactInfo();
}
