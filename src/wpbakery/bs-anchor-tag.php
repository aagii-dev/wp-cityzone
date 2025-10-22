<?php

if (!class_exists('vc_odAnchorTagss') && class_exists('WPBakeryShortCode')) {
	class vc_odAnchorTagss extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odAnchorTagss_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odAnchorTagss', [$this, 'vc_odAnchorTagss_html']);
		}

		public function vc_odAnchorTagss_mapping()
		{
			vc_map([
				'name' => __('Anchor tags', 'text-domain'),
				'base' => 'vc_odAnchorTagss',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Tag list',
						'param_name' => 'mg_list',
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => 'Title',
								'param_name' => 'mg_title',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'target ID (ex: company)',
								'param_name' => 'mg_target',
								'admin_label' => true,
							),
						)
					),
					
				),
			]);
		}

		public function vc_odAnchorTagss_html($atts)
		{
			extract(shortcode_atts([
        'mg_list' => '',
    ], $atts));

    $mg_list = vc_param_group_parse_atts($atts['mg_list']);
    if (!is_array($mg_list)) $mg_list = [];

    $uid = uniqid('anchorBtns_');
    $list_html = "";
    $targets = [];

    foreach ($mg_list as $val) {
        $title  = isset($val['mg_title'])  ? esc_html($val['mg_title'])  : '';
        $target = isset($val['mg_target']) ? preg_replace('/[^A-Za-z0-9\-\_\:\.]/', '', $val['mg_target']) : '';
        if (!$target) continue;

        $targets[] = $target;
        $list_html .= "<a href='#{$target}' class='btn anchor-btn'>{$title}</a>";
    }

    $targets_json = wp_json_encode(array_values(array_unique($targets)));

    ob_start(); ?>
    <div id="<?php echo esc_attr($uid); ?>" class="anchor-buttons-wrapper">
        <div class="anchor-buttons">
            <?php echo $list_html; ?>
        </div>
    </div>

  

  <script>
(function(){
  const wrapper = document.getElementById('<?php echo esc_js($uid); ?>');
  const ids = <?php echo $targets_json ?: '[]'; ?>;
  if (!wrapper || !ids.length) return;

  const sections = ids.map(id => document.getElementById(id)).filter(Boolean);
  const anchors  = Array.from(wrapper.querySelectorAll('.anchor-btn'));

  // id -> anchor map
  const anchorMap = new Map();
  anchors.forEach(a => {
    const id = decodeURIComponent((a.getAttribute('href') || '').replace(/^#/, ''));
    if (id) anchorMap.set(id, a);
  });

  let ticking = false;

  function setActive(idOrNull) {
    anchors.forEach(a => a.classList.remove('btn-dark', 'active'));
    if (idOrNull && anchorMap.has(idOrNull)) {
      anchorMap.get(idOrNull).classList.add('btn-dark', 'active');
    }
  }

  function update() {
    const vh = window.innerHeight;
    let show = false;
    let bestId = null;
    let bestScore = -1;

    sections.forEach(el => {
      const r = el.getBoundingClientRect();
      const visiblePx = Math.max(0, Math.min(r.bottom, vh) - Math.max(r.top, 0));
      const containsMiddle = r.top < vh/2 && r.bottom > vh/2;

      // wrapper харагдах эсэх (тал буюу 50%+)
      if (visiblePx >= vh/2) show = true;

      // идэвхтэйг сонгох оноо (талын шугамыг агуулах бол boost)
      const score = visiblePx + (containsMiddle ? vh : 0);
      if (score > bestScore) {
        bestScore = score;
        bestId = el.id;
      }
    });

    wrapper.classList.toggle('show', show);
    setActive(show ? bestId : null);

    ticking = false;
  }

  function onScroll() {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(update);
    }
  }

  // Зөөлөн scroll + дармагц түр зуур active тавина
  wrapper.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e){
      const id = this.getAttribute('href').slice(1);
      const target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();

      const HEADER_OFFSET = 80; // fixed header өндөр
      const y = target.getBoundingClientRect().top + window.pageYOffset - HEADER_OFFSET;
      window.scrollTo({ top: y, behavior: 'smooth' });

      // Дарсан даруйд UI feedback
      setActive(id);
    });
  });

  document.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  update(); // эхний төлөв
})();
</script>

    <?php
    return ob_get_clean();
		}
	}
	new vc_odAnchorTagss();
}
