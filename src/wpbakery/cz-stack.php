<?php

if (!class_exists('vc_Stack') && class_exists('WPBakeryShortCode')) {
	class vc_Stack extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Stack_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Stack', [$this, 'vc_Stack_html']);
		}

		public function vc_Stack_mapping()
		{
			vc_map([
				'name' => __('Stack', 'text-domain'),
				'base' => 'vc_Stack',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					
                    [
                        'type'        => 'param_group',
                        'heading'     => __('Stack items', 'text-domain'),
                        'param_name'  => 'mg_stacks',
                        'params'      => [
                            array(
                                'type' => 'attach_image',
                                'value' => '',
                                'heading' => 'Stack background',
                                'param_name' => 'stack_background',
                            ),
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Label', 'text-domain'),
                                'param_name' => 'stack_label',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Title', 'text-domain'),
                                'param_name' => 'stack_title',
                            ],
                            [
                                'type'       => 'textarea',
                                'heading'    => __('Text', 'text-domain'),
                                'param_name' => 'stack_text',
                            ],
                        ],
                    ],
				),
			]);
		}

		public function vc_Stack_html($atts)
		{
			extract(shortcode_atts([
				'mg_stacks' => '',
			], $atts));




            $mg_stacks = vc_param_group_parse_atts($atts['mg_stacks']);
            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="stack">
                <div class="stack-bg">
                <div class="stack-img-wrapper">
                    <img class="stack-img img-front" alt="bg" />
                    <img class="stack-img img-back" alt="bg" />
                </div>
                </div>

                <div class="stack-right">
                    <?php foreach ($mg_stacks as $val) { ?>
                        <?php
                        $stack_background = $val['stack_background'] ? wp_get_attachment_image_url($val['stack_background'], 'full') : '';
                        ?>
                        <div class="stack-item-section" >
                            <div class="stack-item d-flex align-items-center justify-content-center sticky-top" data-bg="<?php echo $stack_background; ?>">
                                <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row ">
                                    <p class="stack-label"><?php echo $val['stack_label']; ?></p>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/star.svg" alt="star" class="stack-star d-none d-lg-flex" />
                                    <div class="stack-desc">
                                    <p>
                                    <?php echo $val['stack_title']; ?>
                                    </p>
                                    <p class="desc">
                                    <?php echo $val['stack_text']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </section>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll(".stack").forEach((section) => {
                    const wrap = section.querySelector(".stack-img-wrapper")
                    const imgA = wrap?.querySelector(".img-front")
                    const imgB = wrap?.querySelector(".img-back")
                    const items = section.querySelectorAll(".stack-item")
                    if (!wrap || !imgA || !imgB || !items.length) return

                    // 1) Эхний зургаар хоёуланг нь ижил эхлүүл (фликергүй болгоно)
                    const firstUrl = items[0].dataset.bg || ""
                    if (firstUrl) {
                    imgA.src = firstUrl
                    imgB.src = firstUrl
                    wrap.dataset.current = firstUrl
                    }

                    // 2) Preload (сонголтоор — үлдээсэн нь дээр)
                    items.forEach((it) => {
                    const u = it.dataset.bg
                    if (u) {
                        const im = new Image()
                        im.src = u
                    }
                    })

                    // 3) Кросс-фэйд (DOM class-уудыг заавал сольж өгнө)
                    const crossfadeTo = (url) => {
                    if (!url || wrap.dataset.current === url) return

                    const front = wrap.querySelector(".img-front")
                    const back = wrap.querySelector(".img-back")

                    back.src = url

                    const doFade = () => {
                        wrap.classList.add("fading")

                        const onDone = () => {
                        wrap.classList.remove("fading")
                        // 👉 DOM role-уудын class-ыг сольж, дараагийн удаа зөв img анимдуулна
                        front.classList.remove("img-front")
                        front.classList.add("img-back")
                        back.classList.remove("img-back")
                        back.classList.add("img-front")

                        wrap.dataset.current = url
                        }

                        // transitionend барих + fallback
                        back.addEventListener("transitionend", onDone, { once: true })
                        setTimeout(onDone, 550)
                    }

                    ;(back.decode ? back.decode() : Promise.resolve()).then(doFade).catch(doFade)
                    }

                    // 4) Төвийн бүсэд ормогц зураг солих
                    const io = new IntersectionObserver(
                    (entries) => {
                        for (const e of entries) if (e.isIntersecting) crossfadeTo(e.target.dataset.bg)
                    },
                    { root: null, threshold: 0, rootMargin: "-50% 0px -50% 0px" }
                    )
                    items.forEach((it) => io.observe(it))
                })
                })
            </script>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Stack();
}
