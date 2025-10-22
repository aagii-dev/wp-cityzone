<?php
if (!class_exists('vc_odValuables') && class_exists('WPBakeryShortCode')) {
  class vc_odValuables extends WPBakeryShortCode
  {
    public function __construct()
    {
      add_action('vc_before_init', [$this, 'vc_odValuables_mapping']);
      add_shortcode('vc_odValuables', [$this, 'vc_odValuables_html']);
    }

    public function vc_odValuables_mapping()
    {
      vc_map([
        'name' => __('Valuables', 'text-domain'),
        'base' => 'vc_odValuables',
        'category' => __('BurenScore', 'text-domain'),
        'icon' => 'icon-wpb-slideshow',
        'params' => array(
          array(
            'type' => 'textfield',
            'heading' => 'Title (white)',
            'param_name' => 'mg_title1',
            'admin_label' => true,
          ),
          array(
            'type' => 'attach_image',
            'value' => '',
            'heading' => 'Background',
            'param_name' => 'mg_background',
          ),
          array(
            'type' => 'param_group',
            'value' => '',
            'heading' => 'List item',
            'param_name' => 'mg_list',
            'params' => array(
              array(
                'type' => 'textfield',
                'heading' => 'Title',
                'param_name' => 'mg_title',
                'admin_label' => true,
              ),
              array(
                'type' => 'textarea',
                'heading' => 'Text',
                'param_name' => 'mg_text',
                'admin_label' => true,
              ),
              array(
                'type' => 'attach_image',
                'value' => '',
                'heading' => 'Background',
                'param_name' => 'mg_background',
              ),
              array(
                'type' => 'attach_image',
                'value' => '',
                'heading' => 'Thumbnail',
                'param_name' => 'mg_thumbnail',
              ),
            )
          ),
        ),
      ]);
    }

    public function vc_odValuables_html($atts)
    {
      $atts = shortcode_atts([
        'mg_title1' => '',
        'mg_background' => '',
        'mg_list' => '',
      ], $atts);

      $uid = 'valuables-' . wp_rand(1000, 9999);

      // Background main
      $bg_url = '';
      if (!empty($atts['mg_background'])) {
        $u = wp_get_attachment_image_src($atts['mg_background'], 'hero_thumb');
        if (is_array($u) && !empty($u[0])) $bg_url = $u[0];
      }

      // Parse list
      $mg_list = array();
      if (!empty($atts['mg_list'])) {
        $mg_list = vc_param_group_parse_atts($atts['mg_list']);
        if (!is_array($mg_list)) $mg_list = array();
      }

      $list_html = '';
      foreach ($mg_list as $val) {
        $title = isset($val['mg_title']) ? esc_html($val['mg_title']) : '';
        $text  = isset($val['mg_text'])  ? wp_kses_post($val['mg_text']) : '';

        $item_bg_url = '';
        if (!empty($val['mg_background'])) {
          $t = wp_get_attachment_image_src($val['mg_background'], 'hero_thumb');
          if (is_array($t) && !empty($t[0])) $item_bg_url = $t[0];
        }

        $item_thumb_url = '';
        if (!empty($val['mg_thumbnail'])) {
          $t2 = wp_get_attachment_image_src($val['mg_thumbnail'], 'size11_thumb');
          if (is_array($t2) && !empty($t2[0])) $item_thumb_url = $t2[0];
        }

        $list_html .= "<div class='valueable-scroll-box' data-bg='" . esc_attr($item_bg_url) . "'>
            <div class='valueable-scroll-item'>
              <div class='valueable-scroll-item-image'>
                <div class='image-wrapper'>
                  <div class='bg-view' style='background-image:url(" . esc_url($item_thumb_url) . ")'></div>
                  <div class='aspect-1-1'></div>
                </div>
              </div>
              <div>
                <div class='valueable-scroll-item-title'>{$title}</div>
                <div>{$text}</div>
              </div>
            </div>
          </div>";
      }

      ob_start(); ?>
      <div id="<?php echo esc_attr($uid); ?>-root" class="position-relative bg-black text-white">
        <div class="sticky-item bg-cover" style="background-image:url(<?php echo esc_url($bg_url); ?>)">
          <div class="valueable-overlay"></div>
          <div class="valueable-item-bg" id="<?php echo esc_attr($uid); ?>-bgHost">
            <div id="<?php echo esc_attr($uid); ?>-bgA" class="valueable-bg-layer"></div>
            <div id="<?php echo esc_attr($uid); ?>-bgB" class="valueable-bg-layer"></div>
          </div>
          <div class="valueable-content">
            <div class="container text-center mb-5">
              <div class="small-title"><?php echo esc_html($atts['mg_title1']); ?></div>
            </div>
            <div class="valueable-scroll-wrapper">
              <div class="valueable-scroll">
                <?php echo $list_html; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="d-block" id="<?php echo esc_attr($uid); ?>-empty" style="height:200vh"></div>
      </div>

      <!--noptimize-->
      <script>
      (function(){
        // --- scope by root ---
        const root     = document.getElementById('<?php echo esc_js($uid); ?>-root');
        if (!root) return;

        const el       = document.getElementById('<?php echo esc_js($uid); ?>-empty');
        const wrapper  = root.querySelector('.valueable-scroll-wrapper');
        const scroller = root.querySelector('.valueable-scroll');
        const items    = Array.from(root.querySelectorAll('.valueable-scroll-box'));
        const bgA      = document.getElementById('<?php echo esc_js($uid); ?>-bgA');
        const bgB      = document.getElementById('<?php echo esc_js($uid); ?>-bgB');
        const bgHost   = document.getElementById('<?php echo esc_js($uid); ?>-bgHost');

        if (!el || !wrapper || !scroller || !items.length || !bgA || !bgB || !bgHost) return;

        const clamp = (v,a=0,b=1)=>Math.max(a,Math.min(b,v));
        let vh = window.innerHeight, vw = window.innerWidth;
        let maxTranslate = 0;
        let prevP = 0;

        function measure(){
          vh = window.innerHeight; vw = window.innerWidth;
          const wrapW   = wrapper.clientWidth || 0;
          const scrollW = scroller.scrollWidth || 0;
          maxTranslate = Math.max(0, scrollW - wrapW);
          if (maxTranslate === 0) maxTranslate = 200; // fallback
          update();
        }
        function getProgress(){
          const r = el.getBoundingClientRect();
          return clamp((vh - r.top) / Math.max(1, r.height), 0, 1);
        }
        function applyTranslate(p){
          const tx = -p * maxTranslate;
          scroller.style.transform = `translateX(${tx}px)`;
          scroller.style.willChange = 'transform';
        }

        // BG cross-fade
        let activeIsA = false;
        let currentBg = '';
        let loading = null;

        function crossfadeTo(url){
          if ((url||'') === currentBg) return;
          currentBg = url || '';

          if (!currentBg){
            bgA.classList.remove('is-visible');
            bgB.classList.remove('is-visible');
            return;
          }

          const img = new Image();
          loading = img;
          img.onload = () => {
            if (loading !== img) return;
            const show = activeIsA ? bgB : bgA;
            const hide = activeIsA ? bgA : bgB;
            show.style.backgroundImage = `url("${currentBg}")`;
            show.classList.add('is-visible');
            hide.classList.remove('is-visible');
            activeIsA = !activeIsA;
          };
          img.src = currentBg;
        }

        function updateActiveBg(p){
          const hostRect = el.getBoundingClientRect();
          const inView   = hostRect.top <= vh;
          if (!inView){
            crossfadeTo('');
            prevP = p;
            return;
          }

          const movingLeft  = p > prevP + 1e-6;
          const movingRight = p < prevP - 1e-6;
          const L = vw * 0.70;
          const R = vw * 0.30;

          let candidate = null;

          if (movingLeft){
            let bestLeft = -Infinity;
            for (const it of items){
              const r = it.getBoundingClientRect();
              if (r.right <= 0 || r.left >= vw) continue;
              if (r.left <= L && r.left > bestLeft){
                bestLeft = r.left; candidate = it;
              }
            }
          } else if (movingRight){
            let bestRight = Infinity;
            for (const it of items){
              const r = it.getBoundingClientRect();
              if (r.right <= 0 || r.left >= vw) continue;
              if (r.right >= R && r.right < bestRight){
                bestRight = r.right; candidate = it;
              }
            }
          }

          if (candidate){
            const nextBg = candidate.dataset.bg || '';
            crossfadeTo(nextBg);
          }

          prevP = p;
        }

        const onProgress = (p)=>{ applyTranslate(p); updateActiveBg(p); };

        let ticking = false;
        function update(){ ticking = false; onProgress(getProgress()); }
        function onScroll(){ if(!ticking){ ticking = true; requestAnimationFrame(update); } }

        window.addEventListener('scroll', onScroll, {passive:true});
        window.addEventListener('resize', () => measure(), {passive:true});

        // --- INIT BOOSTER: server дээр resize даралгүй шууд ажиллуулна ---
        function kick(){ measure(); }

        // DOM бэлэн үед
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
          requestAnimationFrame(kick);
        } else {
          window.addEventListener('DOMContentLoaded', kick, { once:true });
        }
        // зураг/asset бүрэн
        window.addEventListener('load', kick, { once:true });

        // фонтууд
        if (document.fonts && document.fonts.ready) {
          document.fonts.ready.then(kick).catch(()=>{});
        }

        // fallback таймаутууд (lazy/optimizer-ийн саатлыг нөхнө)
        setTimeout(kick, 0);
        setTimeout(kick, 250);
        setTimeout(kick, 1000);

        // layout өөрчлөгдвөл автоматаар measure()
        if ('ResizeObserver' in window) {
          const ro = new ResizeObserver(() => measure());
          ro.observe(wrapper);
          ro.observe(scroller);
        }

        // таб/accordion дотор initially hidden байж магадгүй → харагдахад measure()
        if ('IntersectionObserver' in window) {
          const io = new IntersectionObserver((ents) => {
            ents.forEach(e => { if (e.isIntersecting) measure(); });
          }, { threshold: 0.01 });
          io.observe(root);
        }
      })();
      </script>
      <!--/noptimize-->

      <?php
      return ob_get_clean();
    }
  }
  new vc_odValuables();
}
