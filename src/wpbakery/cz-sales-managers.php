<?php

if (!class_exists('vc_ASalesManagers') && class_exists('WPBakeryShortCode')) {
	class vc_ASalesManagers extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_ASalesManagers_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_ASalesManagers', [$this, 'vc_ASalesManagers_html']);
		}

		public function vc_ASalesManagers_mapping()
		{
			vc_map([
				'name' => __('Sales managers', 'text-domain'),
				'base' => 'vc_ASalesManagers',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
          array(
              'type' => 'textfield',
              'heading' => 'Title',
              'param_name' => 'mg_title',
              'admin_label' => true,
          ),
          [
              'type'        => 'param_group',
              'heading'     => __('Managers', 'text-domain'),
              'param_name'  => 'mg_list',
              'params'      => [
                  [
                      'type'        => 'attach_image',
                      'heading'     => __('Image', 'text-domain'),
                      'param_name'  => 'mg_image',
                  ],
                  [
                      'type'       => 'textfield',
                      'heading'    => __('Name', 'text-domain'),
                      'param_name' => 'mg_name',
                      'admin_label'=> true,
                  ],
                  [
                      'type'       => 'textfield',
                      'heading'    => __('Position', 'text-domain'),
                      'param_name' => 'mg_position',
                      'admin_label'=> true,
                  ],
              ]
          ],
				),
			]);
		}

		public function vc_ASalesManagers_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));


      
            
            $mg_list = vc_param_group_parse_atts($atts['mg_list']);
            // HTML бүтээж буцаана
            ob_start(); ?>
           <div class="section-wrapper">
          <div class="divider"></div>

          <div class="row g-5">
            <div class="col-12 col-lg-6">
              <p class="title"><?php echo $mg_title; ?></p>
            </div>
            <div class="col-12 col-lg-6">
              <div class="d-block d-md-flex gap-4">

                <?php foreach ($mg_list as $val) { 
                  $mg_image_url = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'large') : '';
                  ?>
                  <div class="staff-item mb-5 mb-lg-0">
                    <img src="<?php echo $mg_image_url; ?>" alt="" />
                    <div class="staff-info">
                      <div><?php echo $val['mg_name']; ?></div>
                      <p class="rank"><?php echo $val['mg_position']; ?></p>
                    </div>
                  </div>
                <?php }?>
                

                
                
              </div>
            </div>
          </div>
        </div>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_ASalesManagers();
}
