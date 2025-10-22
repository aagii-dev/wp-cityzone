<?php

if (!class_exists('vc_odApps') && class_exists('WPBakeryShortCode')) {
	class vc_odApps extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odApps_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odApps', [$this, 'vc_odApps_html']);
		}

		public function vc_odApps_mapping()
		{
			vc_map([
				'name' => __('Scrolled Apps', 'text-domain'),
				'base' => 'vc_odApps',
				'category' => __('BurenScore', 'text-domain'),
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
						'heading' => 'App store link',
						'param_name' => 'mg_appstore_link',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'Play store link',
						'param_name' => 'mg_playstore_link',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'App gallery link',
						'param_name' => 'mg_appgallery_link',
						'admin_label' => true,
					),
				),
			]);
		}

		public function vc_odApps_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_appstore_link' => '',
				'mg_playstore_link' => '',
				'mg_appgallery_link' => '',
			], $atts));


			$apple_html ="";
			$android_html ="";
			$huawei_html ="";

			if(!empty($mg_appstore_link)) {
				$apple_html = "<a href='$mg_appstore_link' target='_blank' class='app-card'>
								<div>
								<svg width='64' height='64' viewBox='0 0 64 64' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path d='M43.5398 2.90918C43.5398 2.90918 39.218 3.01386 35.2551 6.97675C31.2922 10.9396 31.9606 16.2783 31.9606 16.2783C31.9606 16.2783 35.8835 16.9957 40.0704 12.8089C44.2572 8.62221 43.5398 2.90918 43.5398 2.90918ZM32.4137 19.658C29.4926 19.638 27.6982 17.1158 22.7233 17.1158C18.247 17.1158 13.7596 20.0039 11.8515 22.7984C9.95235 25.5799 8.30737 28.6306 8.30737 34.8217C8.30737 41.0128 11.2883 51.6603 18.6184 58.8682C19.8738 60.1026 21.5355 61.0305 23.4312 61.0879C26.8408 61.1912 28.9344 58.6389 33.2412 58.6389C37.5481 58.6389 38.8441 61.0879 42.7322 61.0879C44.5003 61.0879 46.5166 60.2827 48.4747 58.2003C50.987 55.5285 54.1046 50.4399 55.6926 45.5589C55.6926 45.5589 47.7404 42.4878 47.8365 33.6353C47.9163 26.2977 54.1473 22.6887 54.1473 22.6887C54.1473 22.6887 50.5084 16.8864 42.7721 16.8864C37.4285 16.9264 35.0357 19.676 32.4137 19.658Z' fill='#282828'/>
								</svg>
								</div>
								<div class='d-flex justify-content-between'>
									<div>Appstore</div>
									<svg width='44' height='44' viewBox='0 0 44 44' fill='none' xmlns='http://www.w3.org/2000/svg'>
									<rect width='44' height='44' rx='22' fill='#282828'/>
									<path d='M20.5 16.75C20.0858 16.75 19.75 17.0858 19.75 17.5C19.75 17.9142 20.0858 18.25 20.5 18.25H24.6893L16.9697 25.9697C16.6768 26.2626 16.6768 26.7374 16.9697 27.0303C17.2626 27.3232 17.7374 27.3232 18.0303 27.0303L25.75 19.3107V23.5C25.75 23.9142 26.0858 24.25 26.5 24.25C26.9142 24.25 27.25 23.9142 27.25 23.5V17.5C27.25 17.0858 26.9142 16.75 26.5 16.75H20.5Z' fill='white'/>
									</svg>
								</div>
							</a>";
			}
			if(!empty($mg_playstore_link)) {
				$android_html = "<a href='$mg_playstore_link' target='_blank' class='app-card'>
									<div>
									<svg width='64' height='64' viewBox='0 0 64 64' fill='none' xmlns='http://www.w3.org/2000/svg'>
									<path d='M8.36609 9.66826V54.3274C8.36639 54.4242 8.39529 54.5189 8.44916 54.5994C8.50303 54.68 8.57949 54.7428 8.66893 54.7801C8.75837 54.8173 8.85682 54.8273 8.95193 54.8089C9.04705 54.7904 9.13459 54.7442 9.20359 54.6762L32.457 31.9989L9.20359 9.3194C9.13459 9.25137 9.04705 9.20523 8.95193 9.18676C8.85682 9.16829 8.75837 9.17831 8.66893 9.21557C8.57949 9.25282 8.50303 9.31566 8.44916 9.39619C8.39529 9.47672 8.36639 9.57137 8.36609 9.66826Z' fill='#282828'/>
									<path d='M42.2089 22.6836L13.0521 6.61994L13.0339 6.60971C12.5316 6.33699 12.0543 7.01653 12.4657 7.41199L35.3214 29.2665L42.2089 22.6836Z' fill='#282828'/>
									<path d='M12.467 56.5912C12.0534 56.9867 12.5307 57.6662 13.0352 57.3935L13.0534 57.3832L42.208 41.3196L35.3205 34.7344L12.467 56.5912Z' fill='#282828'/>
									<path d='M53.9763 29.1589L45.8343 24.6748L38.1786 31.9998L45.8343 39.3214L53.9763 34.8407C56.1911 33.6169 56.1911 30.3828 53.9763 29.1589Z' fill='#282828'/>
									</svg>

									</div>
									<div class='d-flex justify-content-between'>
										<div>Playstore</div>
										<svg width='44' height='44' viewBox='0 0 44 44' fill='none' xmlns='http://www.w3.org/2000/svg'>
										<rect width='44' height='44' rx='22' fill='#282828'/>
										<path d='M20.5 16.75C20.0858 16.75 19.75 17.0858 19.75 17.5C19.75 17.9142 20.0858 18.25 20.5 18.25H24.6893L16.9697 25.9697C16.6768 26.2626 16.6768 26.7374 16.9697 27.0303C17.2626 27.3232 17.7374 27.3232 18.0303 27.0303L25.75 19.3107V23.5C25.75 23.9142 26.0858 24.25 26.5 24.25C26.9142 24.25 27.25 23.9142 27.25 23.5V17.5C27.25 17.0858 26.9142 16.75 26.5 16.75H20.5Z' fill='white'/>
										</svg>
									</div>
								</a>";
			}
			if(!empty($mg_appgallery_link)) {
				$huawei_html ="<a href='$mg_appgallery_link' target='_blank' class='app-card'>
									<div>
									<svg width='64' height='64' viewBox='0 0 64 64' fill='none' xmlns='http://www.w3.org/2000/svg'>
									<path fill-rule='evenodd' clip-rule='evenodd' d='M20.7659 6.40039C10.2473 6.40039 6.40002 10.247 6.40002 20.7635V43.2373C6.40002 53.7538 10.2473 57.6004 20.7659 57.6004H43.2273C53.7456 57.6004 57.6 53.7538 57.6 43.2373V20.7635C57.6 10.247 53.7528 6.40039 43.2342 6.40039H20.7659Z' fill='#282828'/>
									<path fill-rule='evenodd' clip-rule='evenodd' d='M28.7342 36.0949H30.7897L29.7584 33.6967L28.7342 36.0949ZM28.228 37.3035L27.6182 38.699H26.2297L29.1823 32.0004H30.3823L33.3229 38.699H31.8975L31.2954 37.3035H28.228ZM50.5701 38.694H51.9121V32H50.5701V38.694ZM45.2291 35.8184H47.7027V34.5979H45.2291V33.2259H48.82V32.0049H43.8876V38.6986H48.9492V37.4776H45.2291V35.8184ZM39.8972 36.6093L38.3759 32H37.2656L35.7443 36.6093L34.2636 32.0037H32.816L35.1525 38.7027H36.278L37.8018 34.3024L39.3256 38.7027H40.461L42.7914 32.0037H41.3811L39.8972 36.6093ZM24.1812 35.8369C24.1812 36.9266 23.6401 37.5089 22.6574 37.5089C21.6694 37.5089 21.1254 36.9097 21.1254 35.7904V32.0045H19.7653V35.8369C19.7653 37.722 20.813 38.8031 22.6389 38.8031C24.4829 38.8031 25.54 37.7015 25.54 35.781V32.0004H24.1812V35.8369ZM16.5206 32.0004H17.8798V38.7031H16.5206V35.9809H13.4499V38.7031H12.0898V32.0004H13.4499V34.704H16.5206V32.0004Z' fill='white'/>
									<path fill-rule='evenodd' clip-rule='evenodd' d='M31.9982 23.4679C27.2924 23.4679 23.4648 19.6399 23.4648 14.9346H24.6702C24.6702 18.9749 27.9578 22.2621 31.9982 22.2621C36.0385 22.2621 39.3262 18.9749 39.3262 14.9346H40.5315C40.5315 19.6399 36.7035 23.4679 31.9982 23.4679Z' fill='white'/>
									</svg>

									</div>
									<div class='d-flex justify-content-between'>
										<div>AppGallery</div>
										<svg width='44' height='44' viewBox='0 0 44 44' fill='none' xmlns='http://www.w3.org/2000/svg'>
										<rect width='44' height='44' rx='22' fill='#282828'/>
										<path d='M20.5 16.75C20.0858 16.75 19.75 17.0858 19.75 17.5C19.75 17.9142 20.0858 18.25 20.5 18.25H24.6893L16.9697 25.9697C16.6768 26.2626 16.6768 26.7374 16.9697 27.0303C17.2626 27.3232 17.7374 27.3232 18.0303 27.0303L25.75 19.3107V23.5C25.75 23.9142 26.0858 24.25 26.5 24.25C26.9142 24.25 27.25 23.9142 27.25 23.5V17.5C27.25 17.0858 26.9142 16.75 26.5 16.75H20.5Z' fill='white'/>
										</svg>
									</div>
								</a>";
			}

			return "<div class='position-relative bg-green' >
						<div class='position-absolute inset-0 d-flex align-items-center justify-content-center'>
							<div class='text-center big-title app-title'>$mg_title</div>
						</div>
  <section class='app-scroll-horizontal-wrapper'>
  	
    <div class='app-sticky-scroll'>
      <div class='app-scroll-content'>
        
	  	$apple_html
	  	$android_html
        $huawei_html
		
      </div>
    </div>
  </section>


  <script>
document.addEventListener('DOMContentLoaded', function () {
  const scrollSection = document.querySelector('.app-scroll-horizontal-wrapper')
  const scrollContent = document.querySelector('.app-scroll-content')
  const cards = document.querySelectorAll('.app-card')

  const gap = 64
  const cardWidth = 360
  const paddingX = window.innerWidth * 0.3 // 30vw
  const totalWidth = cards.length * cardWidth + (cards.length - 1) * gap + paddingX * 2
  const maxTranslateX = totalWidth - window.innerWidth

  // scroll хийх зай = scrollSection-ийн өндөр - дэлгэцийн өндөр
  const scrollHeight = scrollSection.offsetHeight 
  const multer = (((cards.length - 1) * gap) + cards.length * cardWidth + window.innerWidth) / scrollHeight
  window.addEventListener('scroll', () => {
    const rect = scrollSection.getBoundingClientRect()
    const contentRect = scrollContent.getBoundingClientRect()
    
    if (contentRect.top > 0 && contentRect.top - window.innerHeight <=0  && Math.abs(contentRect.top) <= scrollHeight) {
      const moveX = cards.length * cardWidth + window.innerWidth - Math.abs(contentRect.top) * multer 
      scrollContent.style.transform = 'translateX(-' + moveX + 'px)'
    }
  })
})
</script>


</div>";

		}
	}
	new vc_odApps();
}
