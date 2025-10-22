<?php

if (!class_exists('vc_odProductTypes') && class_exists('WPBakeryShortCode')) {
	class vc_odProductTypes extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odProductTypes_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odProductTypes', [$this, 'vc_odProductTypes_html']);
		}

		public function vc_odProductTypes_mapping()
		{
			vc_map([
				'name' => __('Product types', 'text-domain'),
				'base' => 'vc_odProductTypes',
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
								'heading' => 'Tag',
								'param_name' => 'mg_tag',
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

		public function vc_odProductTypes_html($atts)
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
				$bg_url = wp_get_attachment_image_src($val['mg_background'], 'hero_thumb')[0];
				$bg_blurry = wp_get_attachment_image_src($val['mg_background'], 'hero_blurry')[0];
				
				$mg_video = $val['mg_video'];
				$video_html = "";
				if($mg_video){
					$video_html = "<video class='video-cover' autoplay muted loop playsinline preload='auto'>
									<source src='$mg_video' type='video/mp4' />
									Your browser does not support the video tag.
								</video>";
				}


				$title = $val['mg_title'];
				$tag = $val['mg_tag'];
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
					$btnCls= "btn-light";
					$svgFill ="#282828";
					if($mg_light==='true'){
						$btnCls = 'btn-dark';
						$svgFill ="white";
					}
					$btn_html = "<div class='' >
									<a href='$btn_link' target='$btn_target' class='btn $btnCls btn-has-icon'>
										$btn_title
										<svg width='18' height='19' viewBox='0 0 18 19' fill='none' xmlns='http://www.w3.org/2000/svg'>
											<path d='M11.0303 4.09467C10.7374 3.80178 10.2626 3.80178 9.96967 4.09467C9.67678 4.38756 9.67678 4.86244 9.96967 5.15533L13.1893 8.375H3C2.58579 8.375 2.25 8.71079 2.25 9.125C2.25 9.53921 2.58579 9.875 3 9.875H13.1893L9.96967 13.0947C9.67678 13.3876 9.67678 13.8624 9.96967 14.1553C10.2626 14.4482 10.7374 14.4482 11.0303 14.1553L15.5303 9.65533C15.8232 9.36244 15.8232 8.88756 15.5303 8.59467L11.0303 4.09467Z' fill='$svgFill'/>
										</svg>
									</a>
								</div>";
				}
			
				$bg_html = "<div class='bg-abs bg-cover blurry-load index-0' blur-type='bg' data-large='$bg_url' style='background-image: url($bg_blurry)'></div>";
				$list_html .= "<div class='product-item'>
									<div class='product-item-info'>
										<div id='anchor$rand'>
											<div class='d-flex justify-content-between mb-24' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='100'>
												<div class='product-item-tag'>$tag</div>
											</div>
											<div class='product-item-title' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='300'>
												$title
											</div>
										</div>
										<div class='product-buttons' data-aos='fade-up' data-aos-duration='1500' data-aos-delay='500'>
											$btn_html
											<!-- <a href='#_' class='btn btn-ghost-light'>
												Үнэлгээ өгөх
											</a> -->
										</div>
									</div>
									<div class='product-item-image'>
										<div class='image-wrapper' data-aos='fade-down' data-aos-duration='1500' data-aos-delay='300' data-aos-anchor='#anchor$rand'>
											<div class='bg-view' style='background-image: url($bg_url)'></div>
											$video_html
											<div class='aspect-4-3'></div>
										</div>
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
						<div class='sticky-overlay mh-auto bg-dark text-white $cls' >
							<div class='container'>
								<div class='d-flex gap-160 flex-column'>
									<div></div>
									$list_html
									<div></div>
								</div>
							</div>
						</div>

						<script>
						
						</script>




					</div>";
		}
	}
	new vc_odProductTypes();
}
