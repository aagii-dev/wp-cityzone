<?php

if (!class_exists('vc_odVersion2') && class_exists('WPBakeryShortCode')) {
	class vc_odVersion2 extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odVersion2_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odVersion2', [$this, 'vc_odVersion2_html']);
		}

		public function vc_odVersion2_mapping()
		{
			vc_map([
				'name' => __('Version 2.0', 'text-domain'),
				'base' => 'vc_odVersion2',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'Video url (mp4)',
						'param_name' => 'mg_video',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'Video url (webm)',
						'param_name' => 'mg_video2',
						'admin_label' => true,
					),
				),
			]);
		}

		public function vc_odVersion2_html($atts)
		{
			extract(shortcode_atts([
				'mg_video' => '',
				'mg_video2' => '',
			], $atts));


			


			return "<div class='version2' >
						<div class='sticky-item'>
							<div class='container text-center'>
								<div class='big-title'>Version <span class='color-green'>2.0</span></div>
							</div>
						</div>
					 	<div class='version-video-wrapper'>
							<video id='version-video' class='video-cover '  muted='' loop='' playsinline='' preload='auto'>
								<source src='$mg_video2' type='video/webm'>
								<source src='$mg_video' type='video/mp4'>
								Your browser does not support the video tag.
							</video>

							<div class='video-sound-icon'>
								<svg xmlns='http://www.w3.org/2000/svg' class='icon-play-max' width='18' height='18' viewBox='0 0 18 18' fill='none'>
								<path d='M14.8109 3.74995C15.8739 5.22762 16.5 7.04067 16.5 8.99994C16.5 10.9592 15.8739 12.7723 14.8109 14.2499M11.809 5.99995C12.4021 6.85032 12.75 7.88451 12.75 8.99994C12.75 10.1154 12.4021 11.1496 11.809 11.9999M7.22574 3.27421L4.85147 5.64847C4.72176 5.77819 4.6569 5.84304 4.58121 5.88943C4.51411 5.93055 4.44095 5.96085 4.36442 5.97922C4.27811 5.99995 4.18639 5.99995 4.00294 5.99995H2.7C2.27996 5.99995 2.06994 5.99995 1.90951 6.08169C1.76839 6.1536 1.65365 6.26833 1.58175 6.40945C1.5 6.56989 1.5 6.77991 1.5 7.19995V10.7999C1.5 11.22 1.5 11.43 1.58175 11.5904C1.65365 11.7316 1.76839 11.8463 1.90951 11.9182C2.06994 11.9999 2.27996 11.9999 2.7 11.9999H4.00294C4.18639 11.9999 4.27811 11.9999 4.36442 12.0207C4.44095 12.039 4.51411 12.0693 4.58121 12.1105C4.6569 12.1568 4.72176 12.2217 4.85147 12.3514L7.22574 14.7257C7.54702 15.047 7.70766 15.2076 7.84558 15.2185C7.96525 15.2279 8.08219 15.1794 8.16015 15.0882C8.25 14.983 8.25 14.7558 8.25 14.3014V3.69847C8.25 3.24411 8.25 3.01693 8.16015 2.91173C8.08219 2.82045 7.96525 2.77201 7.84558 2.78143C7.70766 2.79229 7.54702 2.95293 7.22574 3.27421Z' stroke='#fff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/>
								</svg>
								<svg xmlns='http://www.w3.org/2000/svg' class='icon-play-x' width='18' height='18' viewBox='0 0 18 18' fill='none'>
								<path d='M16.5 6.74995L12 11.2499M12 6.74995L16.5 11.2499M7.22574 3.27421L4.85147 5.64847C4.72176 5.77819 4.6569 5.84304 4.58121 5.88943C4.51411 5.93055 4.44095 5.96085 4.36442 5.97922C4.27811 5.99995 4.18639 5.99995 4.00294 5.99995H2.7C2.27996 5.99995 2.06994 5.99995 1.90951 6.08169C1.76839 6.1536 1.65365 6.26833 1.58175 6.40945C1.5 6.56989 1.5 6.77991 1.5 7.19995V10.7999C1.5 11.22 1.5 11.43 1.58175 11.5904C1.65365 11.7316 1.76839 11.8463 1.90951 11.9182C2.06994 11.9999 2.27996 11.9999 2.7 11.9999H4.00294C4.18639 11.9999 4.27811 11.9999 4.36442 12.0207C4.44095 12.039 4.51411 12.0693 4.58121 12.1105C4.6569 12.1568 4.72176 12.2217 4.85147 12.3514L7.22574 14.7257C7.54702 15.047 7.70766 15.2076 7.84558 15.2185C7.96525 15.2279 8.08219 15.1794 8.16015 15.0882C8.25 14.983 8.25 14.7558 8.25 14.3014V3.69847C8.25 3.24411 8.25 3.01693 8.16015 2.91173C8.08219 2.82045 7.96525 2.77201 7.84558 2.78143C7.70766 2.79229 7.54702 2.95293 7.22574 3.27421Z' stroke='#fff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/>
								</svg>
							</div>
						
						</div>
					</div>
					<script>
					document.addEventListener('DOMContentLoaded', function () {
						const card = document.querySelector('.version-video-wrapper')
						const video = document.querySelector('#version-video')
						function handleScroll() {
							const rect = card.getBoundingClientRect()
							const viewportCenter = window.innerHeight / 2
							const cardCenter = rect.top + rect.height / 2
							const distance = Math.abs(viewportCenter - cardCenter)

							if (distance < 100) {
								card.classList.add('no-radius')
								card.style.transform = 'scale(1)'
								if (video && video.paused) video.play()
							} else {
								card.classList.remove('no-radius')
								card.style.transform = 'scale(0.5)'
								if (video && !video.paused) video.pause()
							}
						}

						window.addEventListener('scroll', handleScroll)
						handleScroll() // initialize on load

						
					});
					</script>
					
					<script>
document.addEventListener('DOMContentLoaded', function () {
  const card  = document.querySelector('.version-video-wrapper')
  const video = document.querySelector('#version-video')
  const soundBtn = document.querySelector('.video-sound-icon')

  // --- Дууны төлвийг UI-д тусгах туслах функц
  function syncSoundUI () {
    const isMuted = video.muted
    card.classList.toggle('sound-on', !isMuted)       // wrapper дээр sound-on нэмэх/хасах
    soundBtn.classList.toggle('on', !isMuted)         // икон солиход хэрэгтэй class
    // (CSS-гүйгээр control хийе гэвэл доорх 2 мөрийг ашиглаж болно)
    // soundBtn.querySelector('.icon-play-max').style.display = isMuted ? 'inline' : 'none'
    // soundBtn.querySelector('.icon-play-x').style.display   = isMuted ? 'none'   : 'inline'
  }

  // --- Scroll дээр play/pause хийдэг байсан логик
  function handleScroll() {
    const rect = card.getBoundingClientRect()
    const viewportCenter = window.innerHeight / 2
    const cardCenter = rect.top + rect.height / 2
    const distance = Math.abs(viewportCenter - cardCenter)

    if (distance < 100) {
      card.classList.add('no-radius')
      card.style.transform = 'scale(1)'
      if (video && video.paused) video.play().catch(() => {})
    } else {
      card.classList.remove('no-radius')
      card.style.transform = 'scale(0.5)'
      if (video && !video.paused) video.pause()
    }
  }

  // --- Дуу унтраах/асаах товчлуур
  function toggleSound () {
    // iOS/Safari дээр unmute хийхэд заавал consumer gesture шаарддаг → энэ click нь хангана
    if (video.paused) {
      video.play().catch(() => {})   // зарим браузер дээр need gesture
    }
    video.muted = !video.muted
    // Хэрэв unmute болвол дагавар байдлаар volume-ыг 1 болгоё
    if (!video.muted) video.volume = 1
    syncSoundUI()
  }

  if (soundBtn && video) {
    // Accessibility
    soundBtn.setAttribute('role', 'button')
    soundBtn.setAttribute('tabindex', '0')
    soundBtn.setAttribute('aria-pressed', String(!video.muted))

    soundBtn.addEventListener('click', () => {
      toggleSound()
      soundBtn.setAttribute('aria-pressed', String(!video.muted))
    })

    soundBtn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault()
        toggleSound()
        soundBtn.setAttribute('aria-pressed', String(!video.muted))
      }
    })
  }

  // Эхлэхэд UI-гаа төлөвтэй нь нийцүүлж шинэчлэх
  syncSoundUI()

  // Scroll handler
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll() // initialize on load
})
</script>

";
		}
	}
	new vc_odVersion2();
}
