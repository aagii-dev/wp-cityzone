<?php

if (!class_exists('vc_AppartmentStructure') && class_exists('WPBakeryShortCode')) {
	class vc_AppartmentStructure extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AppartmentStructure_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AppartmentStructure', [$this, 'vc_AppartmentStructure_html']);
		}

		public function vc_AppartmentStructure_mapping()
		{
			vc_map([
				'name' => __('Appartment tructure', 'text-domain'),
				'base' => 'vc_AppartmentStructure',
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

		public function vc_AppartmentStructure_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_text1' => '',
				'mg_text2' => '',
				'mg_specs' => '',
				'mg_stats' => '',
			], $atts));


            $mg_specs = vc_param_group_parse_atts($atts['mg_specs']);
            $mg_stats = vc_param_group_parse_atts($atts['mg_stats']);
      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
           <section class="section-wrapper">
                <div class="divider"></div>
                <div class="d-flex align-items-center justify-content-between mb-5">
                <p class="title"><?php echo $mg_title; ?></p>
                <p class="num">01</p>
                </div>

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
                        <div class="stats grid-3">
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
	new vc_AppartmentStructure();
}
