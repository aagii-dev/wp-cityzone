<?php

if (!class_exists('vc_odQA') && class_exists('WPBakeryShortCode')) {
	class vc_odQA extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odQA_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odQA', [$this, 'vc_odQA_html']);
		}

		public function vc_odQA_mapping()
		{
			$term_options = [ __('— All Categories —', 'text-domain') => '' ];
			$cats = get_terms([
				'taxonomy'   => 'help_center_category',
				'hide_empty' => false,
				// 'parent'   => 0, // зөвхөн parent-уудыг харуулах бол энэ мөрийг нээгээрэй
				'orderby'    => 'name',
				'order'      => 'ASC',
			]);
			if ( ! is_wp_error($cats) && ! empty($cats) ) {
				foreach ( $cats as $t ) {
					// name (ID) гэж харуулъя
					$term_options[ sprintf('%s (ID: %d)', $t->name, $t->term_id) ] = (string) $t->term_id;
				}
			}
			
			vc_map([
				'name' => __('Question & answers', 'text-domain'),
				'base' => 'vc_odQA',
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
						'type'        => 'dropdown',
						'heading'     => __('Category (includes children)', 'text-domain'),
						'param_name'  => 'category_id',            // ← сонгогдсон term_id энд ирнэ
						'value'       => $term_options,
						'description' => __('Шүүх category-аа сонгоно. Хоосон бол бүх пост гарна.', 'text-domain'),
					 ),
					
				),
			]);
		}

		public function vc_odQA_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'category_id' => '',
			], $atts));

			$args = [
				'post_type'      => 'help_center',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order date',
				'order'          => 'DESC',
			];

			$cat_id = absint($category_id);
			if ( $cat_id ) {
				$args['tax_query'] = [[
					'taxonomy'         => 'help_center_category',
					'field'            => 'term_id',
					'terms'            => [$cat_id],          // ✅ зөвхөн сонгосон нэг ID
					'include_children' => true,               // ✅ child-ууд орно
				]];
			}

			$q = new WP_Query($args);

			$posts = $q->have_posts() ? $q->posts : [];
			wp_reset_postdata();

			// 2 багана руу хуваах
			$half = ceil(count($posts) / 2);
			$left  = array_slice($posts, 0, $half);
			$right = array_slice($posts, $half);

			// Нэг баганын accordion item-уудыг үүсгэх туслах функц
			$render_items = function($arr) {
				$html = '';
				foreach ($arr as $p) {
					$qid   = 'qa-' . $p->ID;
					$title = esc_html(get_the_title($p));
					$post_excerpt  = apply_filters('the_content', get_post_field('post_excerpt', $p));
					$html .= "
					<div class='qa-acc-item' id='{$qid}'>
						<button class='qa-acc-btn' aria-expanded='false' aria-controls='{$qid}-panel'>
						<span class='qa-acc-q'>{$title}</span>
						<span class='qa-acc-icon' aria-hidden='true'>
							<svg width='26' height='27' viewBox='0 0 26 27' fill='none' xmlns='http://www.w3.org/2000/svg'>
							<path fill-rule='evenodd' clip-rule='evenodd' d='M5.73332 9.92277C6.15638 9.4997 6.84231 9.4997 7.26538 9.92277L12.9993 15.6567L18.7333 9.92277C19.1564 9.4997 19.8423 9.4997 20.2654 9.92277C20.6884 10.3458 20.6884 11.0318 20.2654 11.4548L13.7654 17.9548C13.3423 18.3779 12.6564 18.3779 12.2333 17.9548L5.73332 11.4548C5.31025 11.0318 5.31025 10.3458 5.73332 9.92277Z' fill='#282828'/>
							</svg>
						</span>
						</button>
						<div class='qa-acc-panel' id='{$qid}-panel' role='region' aria-labelledby='{$qid}-btn'>
						<div class='qa-acc-a'>{$post_excerpt}</div>
						</div>
					</div>";
				}
				return $html;
			};

			ob_start();
			?>
			<div class='position-relative section section-d64 bg-silver'>
			<div class='container text-center'>
				<div class='row'>
				<div class='col-md-10 offset-md-1'>
					<div class='small-title'><?php echo esc_html($mg_title); ?></div>
				</div>
				</div>
			</div>

			<div class='space64'></div>

			<div class='container'>
				<div class='row qa-acc-row'>
				<div class='col-md-6'>
					<div class='qa-acc-col'>
					<?php echo $render_items($left); ?>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='qa-acc-col'>
					<?php echo $render_items($right); ?>
					</div>
				</div>
				</div>
			</div>

			<style>
				
			</style>

			<script>
				(function(){
				const root = document.currentScript.closest('.section');
				const cols = root.querySelectorAll('.qa-acc-col');

				cols.forEach(col => {
					col.addEventListener('click', function(e){
					const btn = e.target.closest('.qa-acc-btn');
					if(!btn) return;
					const item = btn.closest('.qa-acc-item');

					// тухайн баганад бусдыг хаана
					col.querySelectorAll('.qa-acc-item.active').forEach(it=>{
						if(it !== item){ it.classList.remove('active'); it.querySelector('.qa-acc-btn').setAttribute('aria-expanded','false'); }
					});

					const isActive = item.classList.toggle('active');
					btn.setAttribute('aria-expanded', isActive ? 'true' : 'false');

					// идэвхжүүлсний дараа талбайг бага зэрэг хөдөлгөж, scroll дунд хэсэгт ойртуулж болно (сонголтоор)
					// item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
					});
				});
				})();
			</script>
			</div>
			<?php
			return ob_get_clean();
		}
	}
	new vc_odQA();
}
