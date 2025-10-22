<?php

if (!class_exists('vc_odPartners') && class_exists('WPBakeryShortCode')) {
	class vc_odPartners extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odPartners_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odPartners', [$this, 'vc_odPartners_html']);
		}

		public function vc_odPartners_mapping()
		{
			vc_map([
				'name' => __('Partners', 'text-domain'),
				'base' => 'vc_odPartners',
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
						'type' => 'textfield',
						'heading' => 'Description',
						'param_name' => 'mg_description',
						'admin_label' => true,
					),
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Нэвтэрсэн',
						'param_name' => 'mg_already',
						'params' => array(
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Logo',
								'param_name' => 'mg_logo',
							),
							array(
								'type' => 'textfield',
								'heading' => 'Url address',
								'param_name' => 'mg_url',
								'admin_label' => true,
							),
						)
					),
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Тун удахгүй',
						'param_name' => 'mg_coming',
						'params' => array(
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Logo',
								'param_name' => 'mg_logo',
							),
							array(
								'type' => 'textfield',
								'heading' => 'Url address',
								'param_name' => 'mg_url',
								'admin_label' => true,
							),
						)
					)
					
				),
			]);
		}

		public function vc_odPartners_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_description' => '',
				'mg_already' => '',
				'mg_coming' => '',
			], $atts));


			$already_list = "";
			$coming_list = "";
			$mg_already = vc_param_group_parse_atts($atts['mg_already']);
			$mg_coming = vc_param_group_parse_atts($atts['mg_coming']);
			foreach ($mg_already as $val) {
				$mg_url = $val['mg_url'];
				$mg_logo = wp_get_attachment_image_src($val['mg_logo'], 'full')[0];
				$already_list .= "<div class='col-6 col-sm-4'>
									<a href='$mg_url' target='_blank' class='partner-item'>
										<img src='$mg_logo' />
									</a>
								</div>";
			}
			foreach ($mg_coming as $val) {
				$mg_url = $val['mg_url'];
				$mg_logo = wp_get_attachment_image_src($val['mg_logo'], 'full')[0];
				$coming_list .= "<div class='col-6 col-sm-4'>
									<a href='$mg_url' target='_blank' class='partner-item'>
										<img src='$mg_logo' />
									</a>
								</div>";
			}


			return "<div class='section bg-silver section-d64' >
						<div class='container text-center '>
							<div class='small-title mb-24'>".$mg_title."</div>
							<div class='row'>
								<div class='offset-md-2 col-md-8 offset-lg-3 col-lg-6'>".$mg_description."</div>
							</div>
						</div>
					 	<div class='container mt-32'>
							<div class='text-center'>
								<ul class='nav nav-tabs' id='myTab' role='tablist'>
									<li class='nav-item' role='presentation'>
										<button class='nav-link active' id='already-tab' data-bs-toggle='tab' data-bs-target='#already'
										type='button' role='tab' aria-controls='already' aria-selected='true'>
										".pll__('already')."
										</button>
									</li>
									<li class='nav-item' role='presentation'>
										<button class='nav-link' id='coming-tab' data-bs-toggle='tab' data-bs-target='#coming'
										type='button' role='tab' aria-controls='coming' aria-selected='false'>
										".pll__('coming')."
										</button>
									</li>
									
								</ul>
							</div>

							<!-- Tab Content -->
							<div class='tab-content mt-64' >
								<div class='tab-pane fade show active' id='already' role='tabpanel' aria-labelledby='already-tab'>
									<div class='row'>
										$already_list
									</div>
								</div>
								<div class='tab-pane fade' id='coming' role='tabpanel' aria-labelledby='coming-tab'>
									<div class='row'>
										$coming_list
									</div>
								</div>
							</div>


						</div>
					</div>";
		}
	}
	new vc_odPartners();
}
