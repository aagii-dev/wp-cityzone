<?php

if (!class_exists('vc_odCareerSelection') && class_exists('WPBakeryShortCode')) {
	class vc_odCareerSelection extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odCareerSelection_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odCareerSelection', [$this, 'vc_odCareerSelection_html']);
		}

		public function vc_odCareerSelection_mapping()
		{
			vc_map([
				'name' => __('Career selection', 'text-domain'),
				'base' => 'vc_odCareerSelection',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'Title 1 (colored)',
						'param_name' => 'mg_title1',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'Title 2 (colored)',
						'param_name' => 'mg_title2',
						'admin_label' => true,
					),
					array(
						'type' => 'checkbox',
						'param_name' => 'mg_light',
						'heading' => 'White background',
						'value' => false
					),
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'list',
						'param_name' => 'mg_list',
						'params' => array(
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

		public function vc_odCareerSelection_html($atts)
		{
			extract(shortcode_atts([
				'mg_title1' => '',
				'mg_title2' => '',
				'mg_light' => '',
				'mg_list' => '',
			], $atts));


			
			$mg_list = vc_param_group_parse_atts($atts['mg_list']);


			$list_html = "";
			foreach ($mg_list as $val) {
				$rand = rand(1000,9999);
			
				
				$title = $val['mg_title'];
				$description = $val['mg_description'];
			
			
				$list_html .= "<div class='career-selection-item'>
									<div class='career-selection-item-title'>
										$title
									</div>
									<div class='career-selection-item-desc'>
										$description
									</div>
								</div>";
				
			
			}
		
			$cls = "";
			if($mg_light==='true'){
				$cls = 'white-background';
			}
			return "<div class='position-relative bg-dark text-white $cls' >
						<div class='sticky-item '>
							<div class='container text-center'>
								<div class='medium-title'>$mg_title1 </div>
								<div class='medium-title'><span class='color-green'>$mg_title2</span></div>
								
							</div>
						</div>
						<div class='sticky-overlay mh-auto $cls' >
							<div class='section'>
								<div class='container'>
									<div class='d-flex gap-64 flex-column align-items-center '>
										$list_html
									</div>
								</div>
							</div>
							
						</div>

						<script>
						
						</script>




					</div>";
		}
	}
	new vc_odCareerSelection();
}
