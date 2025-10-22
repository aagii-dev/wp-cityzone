<?php

if (!class_exists('vc_odHeroBanner') && class_exists('WPBakeryShortCode')) {
	class vc_odHeroBanner extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odHeroBanner_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odHeroBanner', [$this, 'vc_odHeroBanner_html']);
		}

		public function vc_odHeroBanner_mapping()
		{
			vc_map([
				'name' => __('Hero banner', 'text-domain'),
				'base' => 'vc_odHeroBanner',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'attach_image',
						'value' => '',
						'heading' => 'Background image',
						'param_name' => 'mg_background',
					),
					array(
						'type' => 'textfield',
						'heading' => 'Or Video url (mp4)',
						'param_name' => 'mg_video',
						'admin_label' => true,
					),
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
						'heading' => 'Buttons',
						'param_name' => 'mg_buttons',
						'params' => array(
							array(
								'type' => 'vc_link',
								'heading' => __('Button', 'my-text-domain'),
								'param_name' => 'mg_text_readmore_url',
							),
						)
					)
				),
			]);
		}

		public function vc_odHeroBanner_html($atts)
		{
			extract(shortcode_atts([
				'mg_background' => '',
				'mg_video' => '',
				'mg_title' => '',
				'mg_description' => '',
				'mg_buttons' => '',
			], $atts));

		
			$bg_url = wp_get_attachment_image_src($mg_background, 'hero_thumb')[0];
			$bg_blurry = wp_get_attachment_image_src($mg_background, 'hero_blurry')[0];
			
			$video_html = "";
			if($mg_video){
				$video_html = "<video class='video-cover' autoplay muted loop playsinline preload='auto'>
								<source src='$mg_video' type='video/mp4' />
								Your browser does not support the video tag.
							</video>";
			}

			$title = $mg_title;
			$description = $mg_description;
			
			
			$bg_html = "<div class='bg-abs bg-cover index-0' blur-type='bg' data-large='$bg_url' style='background-image: url($bg_url)'></div>";	
			$arrow_html = "<button class='btn btn-icon btn-light' id='scrollToDown'>
							<svg width='18' height='18' viewBox='0 0 18 18' fill='none' xmlns='http://www.w3.org/2000/svg'>
							<path d='M9.75 3C9.75 2.58579 9.41421 2.25 9 2.25C8.58579 2.25 8.25 2.58579 8.25 3V13.1893L5.03033 9.96967C4.73744 9.67678 4.26256 9.67678 3.96967 9.96967C3.67678 10.2626 3.67678 10.7374 3.96967 11.0303L8.46967 15.5303C8.76256 15.8232 9.23744 15.8232 9.53033 15.5303L14.0303 11.0303C14.3232 10.7374 14.3232 10.2626 14.0303 9.96967C13.7374 9.67678 13.2626 9.67678 12.9697 9.96967L9.75 13.1893V3Z' fill='#282828'/>
							</svg>
						</button>";
			$buttons = "";
			$buttons_html = "";
			$mg_buttons = vc_param_group_parse_atts($atts['mg_buttons']);
			foreach ($mg_buttons as $val) {
				// vc_link
				$mg_text_readmore_url = $val['mg_text_readmore_url'];
				$mg_text_readmore_url = ($mg_text_readmore_url == '||') ? '' : $mg_text_readmore_url;
				$mg_text_readmore_url = vc_build_link($mg_text_readmore_url);
				$btn_link = $mg_text_readmore_url['url'];
				$btn_title = ($mg_text_readmore_url['title'] == '') ? '' : $mg_text_readmore_url['title'];
				$btn_target = ($mg_text_readmore_url['target'] == '') ? '' : $mg_text_readmore_url['title'];
				$btn_rel = ($mg_text_readmore_url['rel'] == '') ? '' : $mg_text_readmore_url['rel'];

				if($btn_title && $btn_link){
					$buttons .= "<a href='$btn_link' target='$btn_target' class='btn btn-ghost'>
									$btn_title
								</a>";
				}
				
			
			}

			if(!empty($buttons)){
				$buttons_html = "<div class='d-flex gap-8'>$buttons</div>";
			}
			


			$rand = rand(10000, 99999);
			return "<div class='hero-banner' id='heroBanner'>
						<div class='hero-item '>	
							$bg_html
							$video_html
							<div class='hero-overlay2'></div>
							<div class='d-flex align-items-end h-100 w-100 index-2 position-relative'>
								<div class='container'>
									<div class='d-flex flex-column gap-64 '>
										<div class='row w-100'>
											<div class='col-md-8 col-lg-6'>
												<div class='d-flex flex-column align-items-start gap-64 pe-5'>
													<div>
														<h1 class='hero-title m-0 hero-aos' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='100' >$title</h1>
														<div class='mt-4 hero-aos' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='300'>
															<div class='row'>
																<div class='colcol-lg-9'>
																	<span class='opacity-75'>$description</span>
																</div>
															</div>
														</div>
													</div>
													$btn_html
												</div>
											</div>
										</div>
										<div class='d-flex justify-content-between' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='700'>
											$buttons_html
											$arrow_html
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
					document.getElementById('scrollToDown').addEventListener('click', function () {
						const heroBanner = document.getElementById('heroBanner');
						
						// #heroBanner төгсгөл хүртэл очих байрлал
						const position = heroBanner.offsetTop + heroBanner.offsetHeight;

						window.scrollTo({
							top: position,
							behavior: 'smooth' // зөөлөн гүйлгэх
						});
					});
					</script>";
		}
	}
	new vc_odHeroBanner();
}
