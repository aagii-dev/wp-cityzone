<?php

if (!class_exists('vc_Gallery') && class_exists('WPBakeryShortCode')) {
	class vc_Gallery extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_Gallery_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_Gallery', [$this, 'vc_Gallery_html']);
		}

		public function vc_Gallery_mapping()
		{
			vc_map([
				'name' => __('Gallery', 'text-domain'),
				'base' => 'vc_Gallery',
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
                      'type'        => 'attach_images',
                      'heading'     => __('Images', 'text-domain'),
                      'param_name'  => 'mg_images',
                    ],
				),
			]);
		}

		public function vc_Gallery_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_images' => '',
			], $atts));

            $rand = rand(1000,9999);
      
            $images = [];
            if (!empty($mg_images)) {
              // attach_images → comma separated IDs
              $img_ids = explode(',', $mg_images);

              foreach ($img_ids as $id) {
                $id = intval(trim($id));
                if (!$id) continue;

                $images[] = [
                  'url'      => wp_get_attachment_image_url($id, 'large'),
                  'title'    => get_the_title($id), // media title
                  'caption'  => wp_get_attachment_caption($id), // media caption
                  'alt'      => get_post_meta($id, '_wp_attachment_image_alt', true),
                ];
              }
            }
            $count =0;
            
      
            // HTML бүтээж буцаана
            ob_start(); ?>
           <section class="gallery-wrap section-wrapper">
              <div class="divider"></div>
              <p class="title mb-5"><?php echo $mg_title; ?></p>

              <div class="gallery-container gallery" id="animated-thumbnails-gallery<?php echo $rand; ?>">
                <?php if (!empty($images)) : ?>
                    <?php foreach ($images as $img) : 
                      $count++; 
                      $bigCls="";
                      if($count==1 || $count===0){
                        $bigCls="big";
                      }?>
                      <a data-lg-size="1600-1067" class="gallery-item <?php echo $bigCls; ?>" data-src="<?php echo esc_url($img['url']); ?>" data-sub-html="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>">
                        <img alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>" class="img-responsive" src="<?php echo esc_url($img['url']); ?>" />
                      </a>
                      
                    <?php endforeach; ?>
                <?php endif; ?> 
               
              </div>

              <!-- </div> -->
            </section>
            <script>
              document.addEventListener("DOMContentLoaded", function () {
                const el = document.getElementById("animated-thumbnails-gallery<?php echo $rand; ?>")
                if (!el) return

                lightGallery(el, {
                  autoplayFirstVideo: false,
                  pager: false,
                  galleryId: "nature",
                  plugins: [lgZoom, lgThumbnail],
                  mobileSettings: {
                    controls: false,
                    showCloseIcon: false,
                    download: false,
                    rotate: false,
                  },
                })
              })
            </script>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_Gallery();
}
