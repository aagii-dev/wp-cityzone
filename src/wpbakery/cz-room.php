<?php

if (!class_exists('vc_Room') && class_exists('WPBakeryShortCode')) {
	class vc_Room extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Room_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Room', [$this, 'vc_Room_html']);
		}

		public function vc_Room_mapping()
		{
			vc_map([
				'name' => __('Room', 'text-domain'),
				'base' => 'vc_Room',
				'category' => __('CityZone', 'text-domain'),
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
                'param_name' => 'mg_desc',
                'admin_label' => true,
            ),
            [
                'type'        => 'param_group',
                'heading'     => __('List items', 'text-domain'),
                'param_name'  => 'mg_list',
                'params'      => [
                  [
                    'type'       => 'textfield',
                    'heading'    => __('m2', 'text-domain'),
                    'param_name' => 'mg_m2',
                    'admin_label'=> true,
                  ],
                  [
                    'type'       => 'textfield',
                    'heading'    => __('Room', 'text-domain'),
                    'param_name' => 'mg_room',
                    'admin_label'=> true,
                  ],
                  [
                    'type'       => 'textfield',
                    'heading'    => __('More link', 'text-domain'),
                    'param_name' => 'mg_more',
                    'admin_label'=> true,
                  ],
                  [
                    'type'        => 'attach_images',
                    'heading'     => __('Images', 'text-domain'),
                    'param_name'  => 'mg_images',
                  ],
                ]
            ]
				),
			]);
		}

		public function vc_Room_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_desc' => '',
				'mg_list' => '',
			], $atts));


          // Зургийн URL (attach_image -> ID)
          $bg_id  = intval($mg_background);
          $bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'hero_thumb') : '';

      
          $mg_list = vc_param_group_parse_atts($atts['mg_list']);

          // HTML бүтээж буцаана
          ob_start(); ?>
           <section class="section-wrapper">
                <div class="divider"></div>
                <div class="row">
                <div class="col-12 col-md-6">
                    <p class="title"><?php echo $mg_title; ?></p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="room-desc">
                      <?php echo $mg_desc; ?>
                    </p>
                </div>
                </div>
            </section>
             <!-- --- ROOM STACK --- -->
            <div class="room-stack">
              <?php foreach ($mg_list as $val) { ?>
                 <?php 
                  $rand = rand(1000,9999);
                  $mg_room = $val['mg_room'];    
                  $mg_m2 = $val['mg_m2'];  
                  $mg_more = $val['mg_more'];  
                  $images = [];
                  if (!empty($val['mg_images'])) {
                    // attach_images → comma separated IDs
                    $img_ids = explode(',', $val['mg_images']);

                    foreach ($img_ids as $id) {
                      $id = intval(trim($id));
                      if (!$id) continue;

                      $images[] = [
                        'url'      => wp_get_attachment_image_url($id, 'large'),
                        'full'      => wp_get_attachment_image_url($id, 'full'),
                        'title'    => get_the_title($id), // media title
                        'caption'  => wp_get_attachment_caption($id), // media caption
                        'alt'      => get_post_meta($id, '_wp_attachment_image_alt', true),
                      ];
                    }
                  }
                  ?>
                <div class="room-content">
                  <!-- Дээд мэдээллийн мөр -->
                  <div class="room-meta">
                    <div class="row">
                      <div class="col-6 col-md-3"><?php echo $mg_room; ?></div>
                      <div class="col-6 col-md-6 text-end text-md-center"><?php echo $mg_m2; ?></div>
                      <div class="col-12 col-md-3 text-start text-md-end">
                        <a class="more-link" href="<?php echo $mg_more; ?>">
                          Дэлгэрэнгүй
                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M3.333 10H16.667M16.667 10L11.667 5M16.667 10L11.667 15" stroke="#FF6633" stroke-width="0.833" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- Carousel -->
                  <div class="room-carousel"  id="gallery-<?php echo $rand; ?>">
                    <div class="swiper room-swiper">
                      <div class="swiper-wrapper">
                        <?php if (!empty($images)) : ?>
                            <?php foreach ($images as $img) : ?>
                              <div class="swiper-slide" data-caption="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>">
                                <div class="slide-inner">
                                  <a class='gallery-item scale-effect' data-src="<?php echo esc_url($img['full']); ?>">
                                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>" />
                                  </a>
                                </div>
                              </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        

                       
                      </div>
                    </div>

                    <div class="room-bottom flex-column flex-md-row">
                      <div class="room-caption"></div>
                      <div class="room-nav">
                        <button class="nav-btn prev" aria-label="Өмнөх">←</button>
                        <button class="nav-btn next" aria-label="Дараах">→</button>
                      </div>
                    </div>
                  </div>
                </div>
               <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    // --- LIGHTGALLERY ---
                    const container = document.getElementById("gallery-<?php echo $rand; ?>");

                    // 2) LG дөнгөж асахад toolbar-д custom товчнуудыг оруулна
                    const customButtons = `
                    <button type="button" id="lg-toolbar-next" aria-label="Next slide" class="lg-toolbar-next lg-icon"> </button>
                    <button type="button" id="lg-toolbar-prev" aria-label="Previous slide" class="lg-toolbar-prev lg-icon"> </button>`;

                    container.addEventListener("lgInit", (evt) => {
                      const lg = evt.detail.instance;
                      const $toolbar = lg.outer.find(".lg-toolbar"); // LG-ийн utility method

                      // Товчнуудыг toolbar-ийн эхэнд хийе
                      $toolbar.prepend(customButtons);

                      // Click binding
                      document
                        .getElementById("lg-toolbar-next")
                        ?.addEventListener("click", () => {
                          lg.goToNextSlide();
                        });
                      document
                        .getElementById("lg-toolbar-prev")
                        ?.addEventListener("click", () => {
                          lg.goToPrevSlide();
                        });
                    });

                    // 1) LightGallery эхлүүлэх (a.gallery-item-ууд дээр ажиллуулна)
                    lightGallery(container, {
                      selector: ".gallery-item",
                      speed: 500, // animation хугацаа (ms)
                      mode: "lg-fade", // нээгдэх/хаагдах transition төрөл
                      cssEasing: "ease",
                      controls: false, // ← default стрелкүүдийг нууж байна
                      plugins: [lgZoom, lgFullscreen],
                    });
                  })
               </script>
               
              <?php } ?>
             </div>
              <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    document.querySelectorAll(".room-content").forEach((wrap) => {
                      const el = wrap.querySelector(".room-swiper")
                      const capEl = wrap.querySelector(".room-caption")
                      const bottom = wrap.querySelector(".room-bottom")
                      const nextEl = bottom?.querySelector(".next")
                      const prevEl = bottom?.querySelector(".prev")
                      if (!el) return

                      if (el.swiper) {
                        el.swiper.destroy(true, true)
                      }

                      const sw = new Swiper(el, {
                        slidesPerView: 1.5,
                        spaceBetween: 30,
                        centeredSlides: true,
                        freeMode: true,
                        initialSlide: 1,
                        watchSlidesProgress: true,
                        speed: 600,
                        keyboard: { enabled: true, onlyInViewport: true },
                        navigation: { nextEl, prevEl },
                        preloadImages: true,
                        updateOnWindowResize: true,
                        breakpoints: {
                          0: { spaceBetween: 16, slidesPerView: 1.15 },
                          768: { spaceBetween: 24, slidesPerView: 1.35 },
                          1200: { spaceBetween: 30, slidesPerView: 1.5 },
                        },
                        on: {
                          init(s) {
                            onUpdate(s, capEl, bottom, wrap)
                          },
                          slideChange(s) {
                            onUpdate(s, capEl, bottom, wrap)
                          },
                          imagesReady(s) {
                            s.update()
                            onUpdate(s, capEl, bottom, wrap)
                          },
                          resize(s) {
                            s.update()
                            onUpdate(s, capEl, bottom, wrap)
                          },
                        },
                        observer: true,
                        observeParents: true,
                      })
                    })

                    function onUpdate(sw, capEl, bottomEl, root) {
                      // setCaption(sw, capEl)
                      syncBottomWidth(sw, bottomEl, root)
                    }

                    function setCaption(sw, capEl) {
                      if (!capEl) return

                      // 1) Идэвхтэй (clone байж магадгүй)
                      const active = sw.slides[sw.activeIndex]

                      // 2) Жинхэнэ слайд (loop-д clone-уудыг алгасна)
                      const originals = sw.slidesEl.querySelectorAll(".swiper-slide:not(.swiper-slide-duplicate)")
                      const real = originals[sw.realIndex]

                      // 3) Дарааллаар уншина: data-caption → .slide-caption → <img alt>
                      const txt =
                        active?.getAttribute("data-caption") || real?.getAttribute("data-caption") || active?.querySelector(".slide-caption")?.textContent?.trim() || active?.querySelector("img")?.alt || ""

                      capEl.textContent = txt
                    }
                    function syncBottomWidth(sw, bottomEl, root) {
                      if (!bottomEl) return
                      let spv = sw.params.slidesPerView
                      // Swiper дотроос тооцсон жинхэнэ слайдын өргөнийг авч чадвал тэргүүнийг ашиглана
                      const active = sw.slides[sw.activeIndex]
                      let w = active?.swiperSlideSize
                      if (!w) {
                        // нөөц тооцоолол
                        const containerW = sw.width
                        if (typeof spv === "number") w = containerW / spv
                        else w = active?.offsetWidth || containerW // 'auto' үед
                      }
                      root.style.setProperty("--active-w", `${Math.round(w)}px`)
                    }
                  })
                </script>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Room();
}
