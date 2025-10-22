<?php

if (!class_exists('vc_odHeroslider') && class_exists('WPBakeryShortCode')) {
	class vc_odHeroslider extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odHeroslider_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odHeroslider', [$this, 'vc_odHeroslider_html']);
		}

		public function vc_odHeroslider_mapping()
		{
			vc_map([
				'name' => __('Hero slider', 'text-domain'),
				'base' => 'vc_odHeroslider',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Slider',
						'param_name' => 'mg_list',
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
								'type' => 'vc_link',
								'heading' => __('Button', 'my-text-domain'),
								'param_name' => 'mg_text_readmore_url',
							),
						)
					),
				),
			]);
		}

		public function vc_odHeroslider_html($atts)
		{
			extract(shortcode_atts([
				'mg_list' => '',
			], $atts));


			$slides = "";
			$mg_list = vc_param_group_parse_atts($atts['mg_list']);
			foreach ($mg_list as $val) {
				$bg_url = wp_get_attachment_image_src($val['mg_background'], 'hero_thumb')[0];
				$bg_blurry = wp_get_attachment_image_src($val['mg_background'], 'hero_blurry')[0];
				
				
				$title = $val['mg_title'];
				$description = $val['mg_description'];
				$mg_video = $val['mg_video'];

				$video_html = "";
				if($mg_video){
					$video_html = "<video class='video-cover' autoplay muted loop playsinline preload='auto'>
									<source src='$mg_video' type='video/mp4' />
									Your browser does not support the video tag.
								</video>";
				}


				// vc_link
				$mg_text_readmore_url = $val['mg_text_readmore_url'];
				$mg_text_readmore_url = ($mg_text_readmore_url == '||') ? '' : $mg_text_readmore_url;
				$mg_text_readmore_url = vc_build_link($mg_text_readmore_url);
				$btn_link = $mg_text_readmore_url['url'];
				$btn_title = ($mg_text_readmore_url['title'] == '') ? '' : $mg_text_readmore_url['title'];
				$btn_target = ($mg_text_readmore_url['target'] == '') ? '' : $mg_text_readmore_url['title'];
				$btn_rel = ($mg_text_readmore_url['rel'] == '') ? '' : $mg_text_readmore_url['rel'];

				$btn_html = "";
				if($btn_title && $btn_link){
					$btn_html = "<div class='hero-aos' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='500'>
									<a href='$btn_link' target='$btn_target' class='btn btn-light w-100'>
										<span>$btn_title</span>
										<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
										<path d='M4 12H20M20 12L14 6M20 12L14 18' stroke='#2F2F2F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
										</svg>

									</a>
								</div>";
				}
			
				$bg_html = "<div class='bg-abs bg-cover  index-0' blur-type='bg' data-large='$bg_url' style='background-image: url($bg_url)'></div>";
				$slides .= "<div class='swiper-slide'>
								<div class='hero-item'>	
									$bg_html
									$video_html
									<div class='hero-overlay1'></div>
									<div class='d-flex align-items-end h-100 w-100 index-2 position-relative'>
										<div class='container'>
											
											<div class='row'>
												<div class='col-md-6 col-lg-4'>
													<div class='d-flex flex-column align-items-start gap-64 pe-5'>
														<div>
															<h1 class='hero-title m-0 hero-aos' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='100' >$title</h1>
															<div class='mt-4 hero-aos' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='300'>
																<span class='opacity-75'>$description</span>
															</div>
														</div>
														$btn_html
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>";
				
			
			}


			$rand = rand(10000, 99999);
			return "<div class='swiper swiper$rand hero-swiper'>
						<div class='swiper-wrapper'>
							$slides
						</div>
						<div class='swiper-pagination wide-pagination'></div>
					</div>
					<script>
					document.addEventListener('DOMContentLoaded', function () {
						var swiper = new Swiper('.swiper$rand', {
							slidesPerView: 1,
							spaceBetween: 0,
							effect: 'fade',
							autoplay: {
								delay: 5000,
							},
							loop: true,
							pagination: {
								el: '.swiper-pagination',
							},
							on: {
								slideChangeTransitionStart: function () {
									$('.hero-aos').hide(0);
									$('.hero-aos').removeClass('aos-init').removeClass('aos-animate');
								},
								slideChangeTransitionEnd: function () {
									$('.hero-aos').show(0);
									AOS.refresh();
								},
							} 
						})
					})
					</script>";
		}
	}
	new vc_odHeroslider();
}
