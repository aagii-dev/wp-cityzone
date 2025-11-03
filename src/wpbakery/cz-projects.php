<?php

if (!class_exists('vc_Projects') && class_exists('WPBakeryShortCode')) {
	class vc_Projects extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Projects_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Projects', [$this, 'vc_Projects_html']);
		}

		public function vc_Projects_mapping()
		{
			vc_map([
				'name' => __('Projects', 'text-domain'),
				'base' => 'vc_Projects',
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
                                'heading'    => __('Name', 'text-domain'),
                                'param_name' => 'mg_name',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('View url', 'text-domain'),
                                'param_name' => 'mg_url',
                                'admin_label'=> true,
                            ],
                        ]
                    ],
				),
			]);
		}

		public function vc_Projects_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));

            $mg_list = vc_param_group_parse_atts($atts['mg_list']);

            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="project section-wrapper">
                <div class="divider"></div>
                <p class="title"><?php echo $mg_title; ?></p>
                <div class="row g-4 mt-3 mt-lg-5">
                     <?php foreach ($mg_list as $val) { ?>
                        <?php
                        $mg_image = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'large') : '';
                        $mg_image_blurry = $val['mg_image'] ? wp_get_attachment_image_url($val['mg_image'], 'large_blurry') : '';
                        ?>
                         <div class="col-12 col-md-6">
                            <a href='<?php echo $val['mg_url']; ?>' class="project-card">
                                <div class="project-media">
                                    <img 
                                        class="blurry-load"
                                        blur-type="img" data-large="<?php echo esc_url($mg_image); ?>"
                                        src="<?php echo esc_url($mg_image_blurry); ?>"
                                        alt="" />
                                </div>
                                <div
                                    class="project-info flex-column flex-md-row align-items-start align-md-center"
                                >
                                    <p class="label"><?php echo $val['mg_name'];?></p>
                                    <p class="more-btn d-none d-md-flex">Дэлгэрэнгүй</p>
                                </div>
                            </a>
                        </div>
                     <?php }?>
                </div>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Projects();
}
