<?php

if (!class_exists('vc_odStructure') && class_exists('WPBakeryShortCode')) {
	class vc_odStructure extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odStructure_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odStructure', [$this, 'vc_odStructure_html']);
		}

		public function vc_odStructure_mapping()
		{
			vc_map([
				'name' => __('Company structure', 'text-domain'),
				'base' => 'vc_odStructure',
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
						'type' => 'textarea',
						'heading' => 'Description',
						'param_name' => 'mg_description',
						'admin_label' => true,
					),
					array(
						'type' => 'attach_image',
						'value' => '',
						'heading' => 'Image',
						'param_name' => 'mg_image',
					),
					array(
						'type' => 'checkbox',
						'param_name' => 'mg_dark',
						'heading' => 'Dark background',
						'value' => false
					),
					
				),
			]);
		}

		public function vc_odStructure_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_description' => '',
				'mg_image' => '',
				'mg_dark' => '',
			], $atts));


			$mg_image_url = wp_get_attachment_image_src($mg_image, 'full')[0];
		

			$cls = "";
			if($mg_dark==='true'){
				$cls = 'bg-dark text-white ';
			}else{
				$cls = 'bg-silver ';
			}

			ob_start();
			?>
			<div class='position-relative section overflow-hidden <?php echo $cls; ?>' >
				
				<div class='container'>
					<div class='small-title lh-1 mb-24 text-center'><?php echo $mg_title; ?></div>
					<div class='row'>
						<div class='col-md-6 offset-md-3'>
							<div class='fw-light mb-64  text-center'><?php echo $mg_description; ?></div>
						</div>
					</div>
					

					<div class=''>
						<div class='image-wrapper'>
							<img src='<?php echo $mg_image_url; ?>' class='img-view'  alt='' />
						</div>
					</div>

				</div>
		
					
			</div>

			<script>
			document.addEventListener('DOMContentLoaded', function () {
				var swiper = new Swiper('.swiper<?php echo $rand; ?>', {
					spaceBetween: 64,
					navigation: {
						nextEl: '.circle-button-next',
						prevEl: '.circle-button-prev',
					},
				
				})
			})
			</script>
			<?php
			return ob_get_clean();






					
		}
	}
	new vc_odStructure();
}
