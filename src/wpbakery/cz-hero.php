<?php

if (!class_exists('vc_Hero') && class_exists('WPBakeryShortCode')) {
	class vc_Hero extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Hero_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Hero', [$this, 'vc_Hero_html']);
		}

		public function vc_Hero_mapping()
		{
			vc_map([
				'name' => __('Hero item', 'text-domain'),
				'base' => 'vc_Hero',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					
					array(
                        'type' => 'attach_image',
                        'value' => '',
                        'heading' => 'Background image',
                        'param_name' => 'mg_background',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Title',
                        'param_name' => 'mg_title',
                        'admin_label' => true,
                    ),
				),
			]);
		}

		public function vc_Hero_html($atts)
		{
			extract(shortcode_atts([
				'mg_background' => '',
				'mg_title' => '',
			], $atts));


            // Зургийн URL (attach_image -> ID)
            $bg_id  = intval($mg_background);
            $bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'hero_thumb') : '';

            // Title / Content sanitize
            $title   = sanitize_text_field($atts['mg_title']);
      
            
            // HTML бүтээж буцаана
            ob_start(); ?>
            <section class="page-hero hero" data-zoom="both">
                <?php if ($bg_url): ?>
                <img src="<?php echo esc_url($bg_url); ?>" alt="<?php echo esc_attr($title ?: 'hero'); ?>" />
                <?php endif; ?>

                <?php if (!empty($title)): ?>
                    <div class="hero-content">
                        <p class="hero-title"><?php echo esc_html($title); ?></p>
                    </div>
                <?php endif; ?>
            </section>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Hero();
}
