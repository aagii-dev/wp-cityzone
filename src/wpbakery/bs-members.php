<?php

if (!class_exists('vc_odMember') && class_exists('WPBakeryShortCode')) {
	class vc_odMember extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odMember_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odMember', [$this, 'vc_odMember_html']);
		}

		public function vc_odMember_mapping()
		{
			vc_map([
				'name' => __('Member', 'text-domain'),
				'base' => 'vc_odMember',
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
						'heading' => 'Members',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => 'Name',
								'param_name' => 'mg_name',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Position',
								'param_name' => 'mg_position',
								'admin_label' => true,
							),
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Image',
								'param_name' => 'mg_image',
							),
						)
					),
					
				),
			]);
		}

		public function vc_odMember_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));

			$mg_list = vc_param_group_parse_atts($atts['mg_list']);
			$rand = rand(1000,9999);
			$count = 0;
			$list = "";
			foreach ($mg_list as $val) {
				$name = $val['mg_name'];
				$position = $val['mg_position'];
				$item_thumb_url = wp_get_attachment_image_src($val['mg_image'], 'size11_thumb')[0];

			
				$list .= "<div class='col-md-6'>
							<div class='member-item mb-64'>
								<div class='member-item-image mb-24'>
									<div class='image-wrapper' >
										<div class='bg-view' style='background-image: url($item_thumb_url)'></div>
										<div class='aspect-1-1'></div>
									</div>
								</div>
								<div class='member-item-name'>$name</div>
								<div class=''>$position</div>
							</div>
						</div>";
				$count++; 
			}

			
			ob_start();
			?>
			<div class='position-relative section section-d64' >
				
				<div class='container'>
					<div class='row'>
						<div class='col-md-4'>
							<div class='mini-title2 member-title'><?php echo $mg_title; ?></div>
						</div>
						<div class='col-md-8'>
							<div class='row'>
								<?php echo $list; ?>

							</div>
						</div>
					</div>

				</div>
		
					
			</div>

			
			<?php
			return ob_get_clean();






					
		}
	}
	new vc_odMember();
}
