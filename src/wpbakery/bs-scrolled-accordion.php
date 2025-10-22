<?php

if (!class_exists('vc_odScrolledAccordion') && class_exists('WPBakeryShortCode')) {
	class vc_odScrolledAccordion extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odScrolledAccordion_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odScrolledAccordion', [$this, 'vc_odScrolledAccordion_html']);
		}

		public function vc_odScrolledAccordion_mapping()
		{
			vc_map([
				'name' => __('Scrolled accordion', 'text-domain'),
				'base' => 'vc_odScrolledAccordion',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'Title (white)',
						'param_name' => 'mg_title1',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'Title (green)',
						'param_name' => 'mg_title2',
						'admin_label' => true,
					),
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'List item',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'attach_image',
								'value' => '',
								'heading' => 'Image',
								'param_name' => 'mg_image',
							),
							array(
								'type' => 'textfield',
								'heading' => 'Title',
								'param_name' => 'mg_title',
								'admin_label' => true,
							),
							array(
								'type' => 'textarea',
								'heading' => 'Text',
								'param_name' => 'mg_text',
								'admin_label' => true,
							),
						)
					),
					
				),
			]);
		}

		public function vc_odScrolledAccordion_html($atts)
		{
			extract(shortcode_atts([
				'mg_title1' => '',
				'mg_title2' => '',
				'mg_list' => '',
			], $atts));


			
			$mg_list = vc_param_group_parse_atts($atts['mg_list']);


			$rand = rand(1000,9999);
			$count = 0;
			$list = "";
			foreach ($mg_list as $val) {
				$title = $val['mg_title'];
				$text = $val['mg_text'];
				$mg_image = $val['mg_image'];
				$image_url = wp_get_attachment_image_src($mg_image, 'size11_thumb')[0];
				// $image_blurry = wp_get_attachment_image_src($mg_image, 'size11_blurry')[0];
				$active = $count===0?"active":"";
				$list .= "<div class='accordion-section $active' id='acc".$rand.$count."'>
							<div class='accordion-header '>$title</div>
							<div class='accordion-body'><div>$text
							<div class='image-wrapper d-block d-md-none mt-3'>
								<div class='bg-view' style='background-image: url($image_url)'></div>
								<div class='aspect-1-1'></div>
							</div>
							</div>
								</div>
						
							<div class='accordion-line'><div class='line-fill'></div></div>

							<div data-image='$image_url' class='d-none'></div>
						</div>";
				$count++;
			}
			

			return "<div class='position-relative bg-black text-white' >
						<div class='sticky-item'>
							<div class='container text-center'>
								<div class='medium-title'>$mg_title1</div>
								<div class='medium-title'><span class='color-green'>$mg_title2</span></div>
							</div>
						</div>
						<div class='sticky-overlay bg-blackBlur section' >
							<div class='scrolled-accordion'>
								<div class='container'>
									<div class='row'>
										<div class='col-md-6 d-flex flex-column justify-content-center'>
											<div class='accordion '>
												$list
											</div>
										</div>
										<div class='col-md-6'>
											<div class='image-wrapper d-none d-md-block'>
												<div class='bg-view' id='ac-bg-view' style='background-image: url()'></div>
												<div class='aspect-1-1'></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div classs='d-block' id='accordion-empty'  style='height: 100vh'></div>
						</div>
						<style>
						#ac-bg-view{
							background-size: cover;
							background-position: center;
							background-repeat: no-repeat;
							transition: opacity .35s ease; /* fade */
							opacity: 1;
						}
						#ac-bg-view.fading { opacity: 0; }
						</style>
						<script>
						document.addEventListener('DOMContentLoaded', function () {
						const accordions = document.querySelectorAll('.accordion-section');
						const empty = document.getElementById('accordion-empty');

						
						function handleScroll() {
							const rect = empty.getBoundingClientRect();
							const viewportBottom = window.innerHeight;

							let targetIndex;
  							let visibleRatio;

							if (rect.bottom < viewportBottom) {
								targetIndex = accordions.length - 1; // хамгийн сүүлийнх
							} else if (rect.top > viewportBottom) {
								targetIndex = 0; // хамгийн эхнийх
							} else {
								const visibleHeight = Math.min(rect.bottom, viewportBottom) - Math.max(rect.top, 0);
								visibleRatio = visibleHeight / rect.height;
							
								// Нарийн хувь дээр тулгуурласан нээлт
								targetIndex = Math.floor(visibleRatio * (accordions.length - 1) + 0.5);
							}
							
							accordions.forEach((acc, i) => {
								acc.classList.toggle('active', i === targetIndex);
							});
							
						}
						// 🔹 Desktop (≥768px): scroll дээр ажиллана
						if (window.innerWidth >= 767) {
							window.addEventListener('scroll', handleScroll);
							handleScroll();
						} else {
							// 🔹 Mobile (<767px): click дээр active болгоно
							accordions.forEach((acc) => {
							acc.addEventListener('click', () => {
								accordions.forEach(a => a.classList.remove('active'));
								acc.classList.add('active');
							});
							});
						}
						});
						</script>
						<script>
						document.addEventListener('DOMContentLoaded', function () {
							const accordions = document.querySelectorAll('.accordion-section');
							const bgView = document.getElementById('ac-bg-view');

							function updateBgFromActive() {
								const active = document.querySelector('.accordion-section.active');
								if (!active) return;

								
								const holder = active.querySelector('[data-image]') || null;

								if (holder) {
								const url = holder.getAttribute('data-image');
								if (url) {
									bgView.style.backgroundImage = 'url(' + url + ')';
								}
								}
							}

							updateBgFromActive();

							window.addEventListener('scroll', updateBgFromActive);
						});
						</script>




					</div>";
		}
	}
	new vc_odScrolledAccordion();
}
