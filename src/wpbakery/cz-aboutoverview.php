<?php

if (!class_exists('vc_AboutOverview') && class_exists('WPBakeryShortCode')) {
	class vc_AboutOverview extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AboutOverview_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AboutOverview', [$this, 'vc_AboutOverview_html']);
		}

		public function vc_AboutOverview_mapping()
        {
            vc_map([
                'name' => __('About overview', 'text-domain'),
                'base' => 'vc_AboutOverview',
                'category' => __('CityZone', 'text-domain'),
                'icon' => 'icon-wpb-slideshow',
                'params' => [

                // ---------- Ерөнхий ----------
                // [
                //     'type'        => 'attach_image',
                //     'heading'     => __('Background image', 'text-domain'),
                //     'param_name'  => 'mg_background',
                // ],
                [
                    'type'        => 'textfield',
                    'heading'     => __('Section title (Жижиг гарчиг)', 'text-domain'),
                    'param_name'  => 'mg_section_title',
                    'value'       => '',
                ],

                // ---------- Текст блок ----------
                [
                    'type'        => 'textarea',
                    'heading'     => __('Paragraph #1', 'text-domain'),
                    'param_name'  => 'mg_desc1',
                    'value'       => '',
                ],
                [
                    'type'        => 'textarea',
                    'heading'     => __('Paragraph #2', 'text-domain'),
                    'param_name'  => 'mg_desc2',
                    'value'       => '',
                ],

                // ---------- Товч ба Modal ----------
                [
                    'type'        => 'textfield',
                    'heading'     => __('Button label', 'text-domain'),
                    'param_name'  => 'mg_btn_label',
                ],
                [
                    'type'        => 'attach_image',
                    'heading'     => __('Modal image', 'text-domain'),
                    'param_name'  => 'mg_modal_image',
                ],
                [
                    'type'        => 'textarea',
                    'heading'     => __('Modal title', 'text-domain'),
                    'param_name'  => 'mg_modal_title',
                ],
                [
                    'type'        => 'textarea',
                    'heading'     => __('Modal text', 'text-domain'),
                    'param_name'  => 'mg_modal_text',
                ],

                // ---------- Статистик (3 item) ----------
                [
                    'type'        => 'param_group',
                    'heading'     => __('Stats items', 'text-domain'),
                    'param_name'  => 'mg_stats',
                    
                    'params'      => [
                         [
                            'type'        => 'attach_image',
                            'heading'     => __('Icon', 'text-domain'),
                            'param_name'  => 'mg_icon',
                        ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Number', 'text-domain'),
                        'param_name' => 'stat_number',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Label', 'text-domain'),
                        'param_name' => 'stat_label',
                    ],
                    ],
                    'description' => __('Тоон үзүүлэлтүүдээ жагсааж оруулна (icon SVG нь кодонд хэвээр)', 'text-domain'),
                ],

                // ---------- Зургууд (image stack) ----------
                [
                    'type'        => 'attach_image',
                    'heading'     => __('Stack base image', 'text-domain'),
                    'param_name'  => 'mg_stack_base',
                ],
                [
                    'type'        => 'attach_image',
                    'heading'     => __('Stack top image', 'text-domain'),
                    'param_name'  => 'mg_stack_top',
                ],

              
                ],
            ]);
        }


		public function vc_AboutOverview_html($atts)
		{
			extract(shortcode_atts([
                'mg_background'   => '',
                'mg_section_title'=> '',
                'mg_desc1'        => '',
                'mg_desc2'        => '',
                'mg_btn_label'    => '',
                'mg_modal_image'  => '',
                'mg_modal_title'  => '',
                'mg_modal_text'   => '',
                'mg_stats'        => '', // param_group
                'mg_stack_base'   => '',
                'mg_stack_top'    => '',
			], $atts));


            // Зургийн URL (attach_image -> ID)
            $bg_id  = intval($mg_background);
            $bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'hero_thumb') : '';
            $modal_image = $mg_modal_image ? wp_get_attachment_image_url(intval($mg_modal_image), 'large') : '';
            $stack_base = $mg_stack_base ? wp_get_attachment_image_url(intval($mg_stack_base), 'full') : '';
            $stack_top = $mg_stack_top ? wp_get_attachment_image_url(intval($mg_stack_top), 'full') : '';
            $mg_stats = vc_param_group_parse_atts($atts['mg_stats']);
           

            // HTML бүтээж буцаана
            ob_start(); ?>
            <!-- --------------------------------------- ABOUT -------------------------------------- -->
            <section class="about-overview section-wrapper">
                <div class="divider"></div>
                <p class="title"><?php echo esc_html($mg_title); ?></p>

                <!-- STAR -->
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/m-star.svg" alt="star" class="star d-none d-lg-flex" />
                <span class="center-line d-none d-lg-flex" aria-hidden="true"></span>
                <!-- LEFT: текст/стат -->
                <div class="about-left mt-5">
                <div class="mb-5">
                    
                    <?php if (!empty($mg_desc1)) echo "<p class='desc mb-5 mt-0'>$mg_desc1</p>"; ?>
                    <?php if (!empty($mg_desc2)) echo "<p class='zone-brand mb-5 mt-0 mt-md-5'>$mg_desc2</p>"; ?>
                      

                    <a href="#_" class="about-btn" id="openModalBtn">
                        <div><?php echo $mg_btn_label; ?></div>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M3.33398 10H16.6673M16.6673 10L11.6673 5M16.6673 10L11.6673 15" stroke="#FF6633" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    <!-- Modal -->
                    <div id="myModal" class="modal">
                    <div class="modal-content">
                        <!-- <span class="close">&times;</span> -->
                         <?php if(!empty($modal_image)){?>
                                <img src="<?php echo $modal_image; ?>" alt="" />
                         <?php } ?>
                    
                        <div class="desc mb-3 mt-0 w-100">
                        <?php echo $mg_modal_title; ?>
                        </div>
                        <div class='zone-brand mb-5  w-100'>
                            <?php echo wpautop($mg_modal_text); ?>
                        </div>
                    </div>
                    </div>
                </div>

                <script>
                    const modal = document.getElementById("myModal")
                    const btn = document.getElementById("openModalBtn")
                    const closeBtn = document.querySelector(".close") // Хэрэв close span-аа буцааж ашиглавал

                    function openModal(e) {
                    if (e) e.preventDefault()
                    modal.style.display = "grid"
                    document.body.classList.add("modal-open")
                    }

                    function closeModal() {
                    modal.style.display = "none"
                    document.body.classList.remove("modal-open")
                    }

                    btn.addEventListener("click", openModal)

                    // overlay дээр дарвал хаах
                    modal.addEventListener("click", (e) => {
                    if (e.target === modal) closeModal()
                    })

                    // Escape дарвал хаах
                    window.addEventListener("keydown", (e) => {
                    if (e.key === "Escape" && modal.style.display !== "none") closeModal()
                    })
                </script>


                <div class="stat-wrap">
                    <div class="row g-2 g-md-0">
                    <?php foreach ($mg_stats as $val) { ?>
                        <?php
                        $icon_url = $val['mg_icon'] ? wp_get_attachment_image_url(intval($val['mg_icon']), 'full') : '';
                        ?>
                        <div class="col-12 col-lg-3">
                            <div class="d-flex flex-row align-items-start">
                                <img src='<?php echo $icon_url; ?>' style="width: 40px; height: 'auto';" alt=''>

                                <div class="stat">
                                    <div class="stat-number"><?php echo $val['stat_number']; ?></div>
                                    <p class="mb-0 flex-shrink-0 text-nowrap"><?php echo $val['stat_label']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                  
                    </div>
                </div>

                <div class="image-stack-wrapper d-none d-lg-block">
                    <figure class="image-stack" tabindex="0" aria-label="Зураг харуулах">
                        <img src="<?php echo $stack_base; ?>" alt="" class="img-base" loading="lazy" />
                        <img src="<?php echo $stack_top; ?>" alt="" class="img-top" loading="lazy" />
                    </figure>
                </div>
                </div>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_AboutOverview();
}
