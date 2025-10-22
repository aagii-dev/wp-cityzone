<?php

if (!class_exists('vc_odReport') && class_exists('WPBakeryShortCode')) {
	class vc_odReport extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odReport_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odReport', [$this, 'vc_odReport_html']);
		}

		public function vc_odReport_mapping()
		{
			vc_map([
				'name' => __('Report', 'text-domain'),
				'base' => 'vc_odReport',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'Title',
						'param_name' => 'mg_title',
						'admin_label' => true,
					),
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'list',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Image',
								'param_name' => 'mg_background',
							),
							array(
								'type' => 'textfield',
								'heading' => 'Title',
								'param_name' => 'mg_title',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Tag',
								'param_name' => 'mg_tag',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Download link',
								'param_name' => 'mg_link',
								'admin_label' => true,
							),
						)
					),
					
				),
			]);
		}

		public function vc_odReport_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));


			
			$mg_list = vc_param_group_parse_atts($atts['mg_list']);


			$list_html = "";
			foreach ($mg_list as $val) {
				$rand = rand(1000,9999);
			
				
				$title = $val['mg_title'];
				$tag = $val['mg_tag'];
				$link = $val['mg_link'];
				$item_thumb_url = wp_get_attachment_image_src($val['mg_background'], 'large')[0];
				
				$download = "";
				if(!empty($link)){
					$download = "download";
				}
			
				$list_html .= "<div class=' col-sm-6 col-lg-4 col-xl-3 mb-4'>
									<a href='$link' $download class='report-item '>
										<div>
											<div class='image-wrapper' >
												<div class='bg-view' style='background-image: url($item_thumb_url)'></div>
												<div class='aspect-4-3'></div>
											</div>
											<div class='report-item-title'>
												$title
											</div>
										</div>
										<div class='mini-title report-item-tag'>
											$tag
										</div>
									</a>
								</div>";
			}
		
			return "<div class='position-relative bg-dark text-white ' >

						<div class='section section-d64'>
							<div class='container text-center mb-64'>
								<div class='mini-title'>$mg_title </div>
							</div>
					
							<div class='container'>
								<div class='row'>
									$list_html
								</div>
							</div>
						</div>

					</div>";
		}
	}
	new vc_odReport();
}
