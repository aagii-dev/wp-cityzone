<?php

if (!class_exists('vc_Advantage') && class_exists('WPBakeryShortCode')) {
	class vc_Advantage extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Advantage_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Advantage', [$this, 'vc_Advantage_html']);
		}

		public function vc_Advantage_mapping()
		{
			vc_map([
				'name' => __('Advantage', 'text-domain'),
				'base' => 'vc_Advantage',
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
                                'heading'     => __('Icon', 'text-domain'),
                                'param_name'  => 'mg_icon',
                            ],
                            [
                                'type'        => 'attach_image',
                                'heading'     => __('Image', 'text-domain'),
                                'param_name'  => 'mg_image',
                            ],
                            [
                                'type'       => 'textfield',
                                'heading'    => __('Title', 'text-domain'),
                                'param_name' => 'mg_title',
                                'admin_label'=> true,
                            ],
                            [
                                'type'       => 'textarea',
                                'heading'    => __('Text', 'text-domain'),
                                'param_name' => 'mg_text',
                            ],
                            [
                                'type'       => 'textarea',
                                'heading'    => __('Check list', 'text-domain'),
                                'param_name' => 'mg_checklist',
                            ],
                        ],
                    ],
				),
			]);
		}

		public function vc_Advantage_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_list' => '',
			], $atts));

            $mg_list = vc_param_group_parse_atts($atts['mg_list']);

            $count = 0;
            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="section-wrapper">
                <div class="divider"></div>
                <p class="title mb-5"><?php echo $mg_title; ?></p>

                <div class="advantage">
                    <?php foreach ($mg_list as $val) {  $count += 1; ?>
                        <?php 
                        $mg_icon = $val['mg_icon'];    
                        $mg_image = $val['mg_image'];    
                        $mg_title = $val['mg_title'];    
                        $mg_text = $val['mg_text'];    
                        $mg_checklist = $val['mg_checklist'];    
                        $mg_icon_url = $mg_icon ? wp_get_attachment_image_url($mg_icon, 'full') : '';
                        $mg_image_url = $mg_image ? wp_get_attachment_image_url($mg_image, 'large') : '';
                        $mg_image_url_blurry = $mg_image ? wp_get_attachment_image_url($mg_image, 'large_blurry') : '';
                        
                        $checklist = [];
                        if ($mg_checklist) {
                            // Windows newline \r\n, Mac \r, Linux \n бүгдийг хүлээж авна
                            $lines = preg_split('/\r\n|\r|\n/', trim($mg_checklist));
                            foreach ($lines as $line) {
                                $item = trim($line);
                                if ($item !== '') {
                                $checklist[] = sanitize_text_field($item);
                                }
                            }
                        }
                        ?>
                         <div class="advantage-item">
                            <div class="row gy-5">
                            <div class="col-12 col-md-7">
                                <div class="d-flex flex-column gap-4 gap-3 gap-lg-3">
                                    <div class="d-flex align-items-center gap-4  mb-4" style="max-width: 80%">
                                        <div class="advantage-icon">
                                            <img src="<?php echo $mg_icon_url; ?>" alt="" style="max-width: 24px;max-height: 24px;">
                                        </div>
                                        <h3 class="advantage-title"><?php echo $mg_title; ?></h3>
                                    </div>
                                
                                    <div class="advantage-text ">
                                       
                                        <div class='d-flex flex-column gap-3'>
                                            <div class="excerpt"><?php echo yld_clean_textarea($mg_text); ?></div>
                                            <?php if (!empty($checklist)) : ?>
                                                <ul class="excerpt">
                                                    <?php foreach ($checklist as $item) : ?>
                                                    <li>
                                                        <?php echo esc_html($item); ?>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="advantage-content">
                                    <img 
                                        class="blurry-load"
                                        blur-type="img" data-large="<?php echo esc_url($mg_image_url); ?>"
                                        src="<?php echo esc_url($mg_image_url_blurry); ?>"
                                    >
                                </div>
                            </div>
                            </div>
                        </div>

                        <?php if(sizeof($mg_list)!==$count){ ?>
                            <div class="line"></div>
                        <?php } ?>

                    <?php } ?>
                  

                </div>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Advantage();
}
