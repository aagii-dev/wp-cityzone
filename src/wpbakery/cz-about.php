<?php

if (!class_exists('vc_About') && class_exists('WPBakeryShortCode')) {
	class vc_About extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_About_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_About', [$this, 'vc_About_html']);
		}

		public function vc_About_mapping()
		{
			vc_map([
				'name' => __('About', 'text-domain'),
				'base' => 'vc_About',
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
                        'type' => 'textarea',
                        'heading' => 'Text (big)',
                        'param_name' => 'mg_text1',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => 'Text ',
                        'param_name' => 'mg_text2',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'More link ',
                        'param_name' => 'mg_more',
                        'admin_label' => true,
                    ),
                    [
                        'type'        => 'param_group',
                        'heading'     => __('Specs items', 'text-domain'),
                        'param_name'  => 'mg_specs',
                        'params'      => [
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Label', 'text-domain'),
                                'param_name' => 'mg_label',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Text', 'text-domain'),
                                'param_name' => 'mg_text',
                                'admin_label'=> true,
                            ],
                        ]
                    ],
                    [
                        'type'        => 'param_group',
                        'heading'     => __('Stats items', 'text-domain'),
                        'param_name'  => 'mg_stats',
                        'params'      => [
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Stat', 'text-domain'),
                                'param_name' => 'mg_stat',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('label', 'text-domain'),
                                'param_name' => 'mg_label',
                                'admin_label'=> true,
                            ],
                        ]
                    ]
				),
			]);
		}

		public function vc_About_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_text1' => '',
				'mg_text2' => '',
				'mg_more' => '',
				'mg_specs' => '',
				'mg_stats' => '',
			], $atts));

            $mg_specs = vc_param_group_parse_atts($atts['mg_specs']);
            $mg_stats = vc_param_group_parse_atts($atts['mg_stats']);

            // HTML бүтээж буцаана
            ob_start(); ?>
            <section>
                <div class="about section-wrapper">
                    <div class="divider"></div>
                    <p class="title mb-5"><?php echo $mg_title; ?></p>

                    <div class="intro-specs">
                        <div class="row">
                        <!-- Зүүн тал -->
                        <div class="col-12 col-md-6">
                            <div class="col-left">
                            <div class="desc">
                                <?php echo wpautop($mg_text1); ?>
                            </div>
                            <p>
                                <?php echo wpautop($mg_text2); ?>
                            </p>
                            <?php if(!empty($mg_more)) : ?>
                                <a href="<?php echo $mg_more; ?>" class="about-btn">
                                    Дэлгэрэнгүй
                                    <svg
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    >
                                    <path
                                        d="M3.33398 10H16.6673M16.6673 10L11.6673 5M16.6673 10L11.6673 15"
                                        stroke="white"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        
                            </div>
                        </div>

                        <!-- Баруун тал -->
                        <div class="col-12 col-md-6">
                            <div class="col-right">
                                <!-- Specs -->
                                <dl class="specs">
                                    <?php foreach ($mg_specs as $val){ ?>
                                        <div class="spec">
                                            <dt><?php echo $val['mg_label']; ?></dt>
                                            <dt><?php echo $val['mg_text']; ?></dt>
                                        </div>
                                    <?php } ?>
                                </dl>

                                <!-- Статистик картууд -->
                                <div class="stats">
                                    <?php foreach ($mg_stats as $val){ ?>
                                        <div class="stat-card">
                                            <div class="count"><?php echo $val['mg_stat']; ?></div>
                                            <div class="caption"><?php echo $val['mg_label']; ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_About();
}
