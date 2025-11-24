<?php

if (!class_exists('vc_AppartmentProgress') && class_exists('WPBakeryShortCode')) {
	class vc_AppartmentProgress extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AppartmentProgress_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AppartmentProgress', [$this, 'vc_AppartmentProgress_html']);
		}

		public function vc_AppartmentProgress_mapping()
		{
			vc_map([
				'name' => __('Appartment progress', 'text-domain'),
				'base' => 'vc_AppartmentProgress',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
              array(
                  'type' => 'textfield',
                  'heading' => 'Title',
                  'param_name' => 'mg_title',
                  'admin_label' => true,
              ),
              [
                  'type'        => 'param_group',
                  'heading'     => __('List items', 'text-domain'),
                  'param_name'  => 'mg_list',
                  'params'      => [
                      [
                          'type'        => 'attach_image',
                          'heading'     => __('Image', 'text-domain'),
                          'param_name'  => 'mg_image',
                      ],
                      [
                          'type'       => 'textfield',
                          'heading'    => __('Date', 'text-domain'),
                          'param_name' => 'mg_date',
                          'admin_label'=> true,
                      ],
                  ]
              ],
				),
			]);
		}

		public function vc_AppartmentProgress_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));


            $mg_list = vc_param_group_parse_atts($atts['mg_list']);
      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="section-wrapper overflow-hidden">
              <div class="divider"></div>
              <div class="d-flex align-items-center justify-content-between mb-5">
                <p class="title"><?php echo $mg_title; ?></p>
                <p class="num">04</p>
              </div>

              <div class="progress-wrap">
                <div class="swiper progress-swiper">
                  <div class="swiper-wrapper">
                    <?php foreach ($mg_list as $val){ ?>
                        <?php
                        $mg_image_url = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'full') : '';
                        $mg_image_url_blurry = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'large_blurry') : '';
                        ?>
                          <div class="swiper-slide">
                            <figure class="progress-card">
                              <div class="frame">
                                <img 
                                class="blurry-load"
                                        blur-type="img" data-large="<?php echo esc_url($mg_image_url); ?>"
                                        src="<?php echo esc_url($mg_image_blurry); ?>"
                                        alt="" 
                                         />
                              </div>
                              <figcaption class="caption"><?php echo $val['mg_date']; ?></figcaption>
                            </figure>
                          </div>
                    <?php } ?>
                  </div>
                </div>

                <div class="progress-bottom">
                  <div class=''></div>
                  <!-- <span class="count" id="imgCount"><?php echo $mg_list ? sizeof($mg_list): "0"; ?> зураг</span> -->
                  <div class="nav">
                    <button class="nav-btn prev" aria-label="Өмнөх">←</button>
                    <button class="nav-btn next" aria-label="Дараах">→</button>
                  </div>
                </div>
              </div>

              <script>
                const a = document.querySelectorAll(".progress-swiper .swiper-slide").length
                const countEl = document.getElementById("imgCount")
                if (countEl) countEl.textContent = `${a} зураг`

                new Swiper(".progress-swiper", {
                  slidesPerView: "auto",
                  spaceBetween: 30,
                  // loop: true,
                  // loopPreventsSliding: false,
                  // freeMode: true,
                  mousewheel: { forceToAxis: true },
                  keyboard: { enabled: true },
                  navigation: {
                    nextEl: ".progress-bottom .next",
                    prevEl: ".progress-bottom .prev",
                  },
                  preloadImages: true,
                  updateOnWindowResize: true,
                  on: {
                    imagesReady(s) {
                      s.update()
                    },
                    resize(s) {
                      s.update()
                    },
                  },
                  breakpoints: {
                    0: { 
                      slidesPerView: 1,
                      spaceBetween: 16
                     },
                    768: { 
                      slidesPerView: "auto",
                      spaceBetween: 24
                     },
                    1200: { 
                      slidesPerView: "auto",
                      spaceBetween: 30 
                    },
                  },
                })
              </script>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_AppartmentProgress();
}
