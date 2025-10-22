<?php

if (!class_exists('vc_odVisions') && class_exists('WPBakeryShortCode')) {
	class vc_odVisions extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odVisions_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odVisions', [$this, 'vc_odVisions_html']);
		}

		public function vc_odVisions_mapping()
		{
			vc_map([
				'name' => __('Visions', 'text-domain'),
				'base' => 'vc_odVisions',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'List',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Icon',
								'param_name' => 'mg_icon',
							),
							array(
								'type' => 'textfield',
								'heading' => 'Title',
								'param_name' => 'mg_title',
								'admin_label' => true,
							),
							array(
								'type' => 'textarea',
								'heading' => 'Description',
								'param_name' => 'mg_description',
								'admin_label' => true,
							),
						)
					),
					
				),
			]);
		}

		public function vc_odVisions_html($atts)
		{
			extract(shortcode_atts([
				'mg_list' => '',
			], $atts));


			$mg_list = vc_param_group_parse_atts($atts['mg_list']);
			if (!is_array($mg_list)) $mg_list = [];

			$uid = uniqid('anchorBtns_');
			$list_html = "";
			$targets = [];

			

			foreach ($mg_list as $val) {
				$title  = $val['mg_title'];
				$description  = $val['mg_description'];
				$icon_url = wp_get_attachment_image_src($val['mg_icon'], 'full')[0];
				$icon_html ="";
				if(!empty($icon_url)){
					$icon_html ="<img src='$icon_url' class='vision-item-icon' />";
				}
	
				$list_html .= "<div class='vision-item'>
									<div class='row'>
										<div class='col-md-6' >
											<div class='mini-title2 mb-3 mb-md-0 color-green' data-aos='fade-right' data-aos-duration='1500' data-aos-delay='100'>$title</div>
										</div>
										<div class='col-md-6'>
										 	<div data-aos='fade-left' data-aos-duration='1500' data-aos-delay='100'>
												$icon_html
												<div>$description</div>
											</div>
										</div>
									</div>
								</div>";
			}
			
		
			return "<div class='section bg-black text-white'>
				<div class='container'>
					$list_html
				</div>
			</div>";
  
		}
	}
	new vc_odVisions();
}
