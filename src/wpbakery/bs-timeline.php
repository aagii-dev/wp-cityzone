<?php

if (!class_exists('vc_odTimeline') && class_exists('WPBakeryShortCode')) {
	class vc_odTimeline extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odTimeline_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odTimeline', [$this, 'vc_odTimeline_html']);
		}

		public function vc_odTimeline_mapping()
		{
			vc_map([
				'name' => __('Timeline', 'text-domain'),
				'base' => 'vc_odTimeline',
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
						'type' => 'param_group',
						'value' => '',
						'heading' => 'List item',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => 'Year',
								'param_name' => 'mg_year',
								'admin_label' => true,
							),
							array(
								'type' => 'textarea',
								'heading' => 'Text',
								'param_name' => 'mg_text',
								'admin_label' => true,
							),
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Thumbnail',
								'param_name' => 'mg_thumbnail',
							),
						)
					),
					
				),
			]);
		}

		public function vc_odTimeline_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_description' => '',
				'mg_list' => '',
			], $atts));


	
			$mg_list = vc_param_group_parse_atts($atts['mg_list']);


			$rand = rand(1000,9999);
			$count = 0;
			$list = "";
			foreach ($mg_list as $val) {
				$year = $val['mg_year'];
				$text = $val['mg_text'];
				$item_thumb_url = wp_get_attachment_image_src($val['mg_thumbnail'], 'size11_thumb')[0];

			
				$list .= "<div class='swiper-slide'>
									<div class='timeline-item'>
										<div class='timeline-tag'>$year</div>
										<div class='timeline-item-image mb-24'>
											<div class='image-wrapper' >
												<div class='bg-view' style='background-image: url($item_thumb_url)'></div>
												<div class='aspect-4-3'></div>
											</div>
										</div>
										<div class=''>$text</div>
									</div>
								</div>";
				$count++; 
			}

			
			ob_start();
			?>
			<div class='position-relative section overflow-hidden' >
				
				<div class='container'>
					<div class='timeline-bg'></div>
					<div class='row'>
						<div class='col-md-6'>
							<div class='timeline-content'>
								<div class='small-title lh-1 mb-24'><?php echo $mg_title; ?></div>
								<div class='fw-light mb-64'><?php echo $mg_description; ?></div>
							
								<div class='d-flex gap-8'>
									<div class="circle-button-prev swiper-button-prev">
										<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.53033 4.28033C9.82322 3.98744 9.82322 3.51256 9.53033 3.21967C9.23744 2.92678 8.76256 2.92678 8.46967 3.21967L3.21967 8.46967C2.92678 8.76256 2.92678 9.23744 3.21967 9.53033L8.46967 14.7803C8.76256 15.0732 9.23744 15.0732 9.53033 14.7803C9.82322 14.4874 9.82322 14.0126 9.53033 13.7197L5.56066 9.75L14.25 9.75C14.6642 9.75 15 9.41421 15 9C15 8.58579 14.6642 8.25 14.25 8.25L5.56066 8.25L9.53033 4.28033Z" fill="white"/>
										</svg>
									</div>
									<div class="circle-button-next swiper-button-next">
										<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.53033 3.21967C9.23744 2.92678 8.76256 2.92678 8.46967 3.21967C8.17678 3.51256 8.17678 3.98744 8.46967 4.28033L12.4393 8.25H3.75C3.33579 8.25 3 8.58579 3 9C3 9.41421 3.33579 9.75 3.75 9.75H12.4393L8.46967 13.7197C8.17678 14.0126 8.17678 14.4874 8.46967 14.7803C8.76256 15.0732 9.23744 15.0732 9.53033 14.7803L14.7803 9.53033C15.0732 9.23744 15.0732 8.76256 14.7803 8.46967L9.53033 3.21967Z" fill="white"/>
										</svg>
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-6'>
							<div class='swiper swiper<?php echo $rand; ?> timeline-swiper' style='overflow: visible'>
								<div class='swiper-wrapper'>
									<?php echo $list; ?>
								</div>
							</div>
							

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
	new vc_odTimeline();
}
