<?php

if (!class_exists('vc_AppartmentSpec') && class_exists('WPBakeryShortCode')) {
	class vc_AppartmentSpec extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AppartmentSpec_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AppartmentSpec', [$this, 'vc_AppartmentSpec_html']);
		}

		public function vc_AppartmentSpec_mapping()
		{
			vc_map([
				'name' => __('Appartment spec', 'text-domain'),
				'base' => 'vc_AppartmentSpec',
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
                        'heading'     => __('List', 'text-domain'),
                        'param_name'  => 'mg_list',
                        'params'      => [
                            [
                                'type'        => 'attach_image',
                                'heading'     => __('Image', 'text-domain'),
                                'param_name'  => 'mg_image',
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Title', 'text-domain'),
                                'param_name' => 'mg_title',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Text', 'text-domain'),
                                'param_name' => 'mg_text',
                                'admin_label'=> true,
                            ],
                        ]
                    ],
				),
			]);
		}

		public function vc_AppartmentSpec_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));


            $mg_list = vc_param_group_parse_atts($atts['mg_list']);
      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
           <section class="spec section-wrapper">
            <div class="divider"></div>
            <div class="d-flex align-items-center justify-content-between mb-5">
            <p class="title"><?php echo $mg_title; ?></p>
            <p class="num">03</p>
            </div>

            <div class="row g-5">
                <?php foreach ($mg_list as $val){ ?>
                    <?php
                    $mg_image_url = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'large') : '';
                    ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="spec-item">
                            <img src="<?php echo $mg_image_url; ?>" alt="spec 1" />
                            <p class="label"><?php echo $val['mg_title']; ?></p>
                            <p class="value"><?php echo $val['mg_text']; ?></p>
                        </div>
                    </div>
                <?php } ?>
             
          
            </div>
        </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_AppartmentSpec();
}
