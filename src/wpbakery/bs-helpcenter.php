<?php

if (!class_exists('vc_odHelpcenter') && class_exists('WPBakeryShortCode')) {
	class vc_odHelpcenter extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odHelpcenter_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odHelpcenter', [$this, 'vc_odHelpcenter_html']);
		}

		public function vc_odHelpcenter_mapping()
		{
			vc_map([
				'name' => __('Help center', 'text-domain'),
				'base' => 'vc_odHelpcenter',
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
						'type' => 'textarea',
						'heading' => 'Description',
						'param_name' => 'mg_description',
						'admin_label' => true,
					),
				),
			]);
		}

		public function vc_odHelpcenter_html($atts)
		{
			extract(shortcode_atts([
				'mg_title'       => '',
				'mg_description' => '',
			], $atts));

			// ✅ зөвхөн эх (parent) категориуд
			$parent_terms = get_terms([
				'taxonomy'   => 'help_center_category',
				'hide_empty' => false,
				'parent'     => 0,
				'orderby'    => 'name',
				'order'      => 'ASC',
			]);

			// Давхар ашиглагддаг бол ID зөрөхгүй байлгахын тулд
			$uid = 'hc_' . uniqid();


			$parent_terms = get_terms([
				'taxonomy'   => 'help_center_category',
				'hide_empty' => false,
				'parent'     => 0,
				'orderby'    => 'name',
				'order'      => 'ASC',
			]);


			ob_start(); ?>
			<div class="position-relative section bg-silver">
			<div class="container">
				<div class="small-title lh-1 mb-24 text-center"><?php echo esc_html($mg_title); ?></div>
				<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="fw-light mb-64 text-center"><?php echo wp_kses_post($mg_description); ?></div>
				</div>
				</div>

				<!-- Search -->
				<div class="hc-search-wrapper position-relative">
					<input type="text" class="form-control hc-search-input" placeholder="Хайх утгаа оруулна уу">
					<button class="hs-search-icon" type="button" aria-label="Search">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C13.125 20 15.078 19.2635 16.6177 18.0319L20.2929 21.7071C20.6834 22.0976 21.3166 22.0976 21.7071 21.7071C22.0976 21.3166 22.0976 20.6834 21.7071 20.2929L18.0319 16.6177C19.2635 15.078 20 13.125 20 11C20 6.02944 15.9706 2 11 2ZM4 11C4 7.13401 7.13401 4 11 4C14.866 4 18 7.13401 18 11C18 14.866 14.866 18 11 18C7.13401 18 4 14.866 4 11Z" fill="#282828"/>
						</svg>
					</button>

					<div class="hc-suggest" role="listbox" aria-expanded="false"></div>

				</div>
				<script>
				window.hcSearchCfg = {
					ajaxUrl: "<?php echo esc_url( admin_url('admin-ajax.php') ); ?>",
					nonce: "<?php echo esc_js( hc_search_get_nonce() ); ?>"
				};
				</script>
				<script>
(function(){
  const wrapper = document.currentScript.closest('.section'); // таны блокын root
  const input   = wrapper.querySelector('.hc-search-input');
  const panel   = wrapper.querySelector('.hc-suggest');
  if(!input || !panel) return;

  const cfg = (window.hcSearchCfg || {});
  const ajaxUrl = cfg.ajaxUrl;
  const nonce   = cfg.nonce;

  let timer = null;
  let currentIndex = -1;  // keyboard navigation

  function render(items){
    panel.innerHTML = '';
    currentIndex = -1;

    if(!items || !items.length){
      panel.innerHTML = '<div class="hc-suggest-empty">Үр дүн олдсонгүй</div>';
      panel.setAttribute('aria-expanded', 'true');
      return;
    }

    items.forEach((it, idx) => {
      const a = document.createElement('a');
      a.className = 'hc-suggest-item';
      a.setAttribute('role', 'option');
      a.setAttribute('aria-selected', 'false');
      a.href = it.link;
      a.innerHTML = `
        <span class="title">${escapeHtml(it.title)}</span>
        ${it.term ? `<span class="term">${escapeHtml(it.term)}</span>` : ''}
      `;
      a.addEventListener('mouseenter', () => setActive(idx));
      a.addEventListener('mouseleave', () => setActive(-1));
      panel.appendChild(a);
    });

    panel.setAttribute('aria-expanded', 'true');
  }

  function setActive(idx){
    const items = panel.querySelectorAll('.hc-suggest-item');
    items.forEach(el => el.setAttribute('aria-selected', 'false'));
    currentIndex = idx;
    if(idx >= 0 && items[idx]){
      items[idx].setAttribute('aria-selected', 'true');
    }
  }

  function closePanel(){
    panel.setAttribute('aria-expanded', 'false');
    panel.innerHTML = '';
    currentIndex = -1;
  }

  function escapeHtml(s){
    return s.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
  }

  async function fetchSuggest(q){
    if(!q || q.trim().length < 2){
      closePanel();
      return;
    }
    const url = new URL(ajaxUrl);
    url.searchParams.set('action', 'hc_global_search');
    url.searchParams.set('q', q.trim());
    url.searchParams.set('nonce', nonce);

    try{
      const res = await fetch(url.toString(), { credentials: 'same-origin' });
      if(!res.ok) throw new Error('Network');
      const data = await res.json();
      if(data && data.success){
        render(data.data.items || []);
      }else{
        render([]);
      }
    }catch(e){
      render([]);
    }
  }

  // Debounce input
  input.addEventListener('input', function(){
    clearTimeout(timer);
    timer = setTimeout(() => fetchSuggest(input.value), 220);
  });

  // Focus/outside click
  document.addEventListener('click', function(e){
    if(!wrapper.contains(e.target)){
      closePanel();
    }
  });

  input.addEventListener('focus', function(){
    if(input.value.trim().length >= 2){
      fetchSuggest(input.value);
    }
  });

  // Keyboard navigation
  input.addEventListener('keydown', function(e){
    const items = panel.querySelectorAll('.hc-suggest-item');
    if(panel.getAttribute('aria-expanded') !== 'true' || items.length === 0) return;

    if(e.key === 'ArrowDown'){
      e.preventDefault();
      const next = (currentIndex + 1) % items.length;
      setActive(next);
      items[next].scrollIntoView({ block: 'nearest' });
    }else if(e.key === 'ArrowUp'){
      e.preventDefault();
      const prev = (currentIndex - 1 + items.length) % items.length;
      setActive(prev);
      items[prev].scrollIntoView({ block: 'nearest' });
    }else if(e.key === 'Enter'){
      if(currentIndex >= 0 && items[currentIndex]){
        e.preventDefault();
        window.location.href = items[currentIndex].href;
      }
    }else if(e.key === 'Escape'){
      closePanel();
    }
  });
})();
</script>


				<!-- Tabs (parent only) -->
				<div class="text-center mt-5">
				<ul class="nav nav-tabs justify-content-center" id="<?php echo esc_attr($uid); ?>_tabs" role="tablist">
					<li class="nav-item" role="presentation">
					<button class="nav-link active"
							id="<?php echo esc_attr($uid); ?>-all-tab"
							data-bs-toggle="tab"
							data-bs-target="#<?php echo esc_attr($uid); ?>-all"
							type="button" role="tab"
							aria-controls="<?php echo esc_attr($uid); ?>-all"
							aria-selected="true">
						Бүгд
					</button>
					</li>

					<?php if (!is_wp_error($parent_terms) && !empty($parent_terms)) :
					foreach ($parent_terms as $pt) :
						$pane_id = $uid . '-term-' . intval($pt->term_id); ?>
						<li class="nav-item" role="presentation">
						<button class="nav-link"
								id="<?php echo esc_attr($pane_id); ?>-tab"
								data-bs-toggle="tab"
								data-bs-target="#<?php echo esc_attr($pane_id); ?>"
								type="button" role="tab"
								aria-controls="<?php echo esc_attr($pane_id); ?>"
								aria-selected="false">
							<?php echo esc_html($pt->name); ?>
						</button>
						</li>
					<?php endforeach;
					endif; ?>
				</ul>
				</div>

				<!-- Tab panes -->
				<div class="tab-content mt-64" id="<?php echo esc_attr($uid); ?>_tabcontent">

				<!-- Бүгд -->
				<div class="tab-pane fade show active all-pane" id="<?php echo esc_attr($uid); ?>-all" role="tabpanel" aria-labelledby="<?php echo esc_attr($uid); ?>-all-tab">
					<?php
					if (!is_wp_error($parent_terms) && !empty($parent_terms)) :
						
						$all_parent_terms_ids = wp_list_pluck( $parent_terms, 'term_id' );
						$all_children_ids = [];

						foreach ( $all_parent_terms_ids as $pid ) {
							// fields => 'ids' гэвэл зөвхөн ID-гийн массив буцаана
							$ids = get_terms([
								'taxonomy'   => 'help_center_category',
								'hide_empty' => false,
								'parent'     => (int) $pid,
								'fields'     => 'ids',
							]);

							if ( ! is_wp_error($ids) && ! empty($ids) ) {
								$all_children_ids = array_merge($all_children_ids, $ids);
							}
						}

						$all_children_terms = [];

						foreach ( $all_parent_terms_ids as $pid ) {
							$terms = get_terms([
								'taxonomy'   => 'help_center_category',
								'hide_empty' => false,
								'parent'     => (int) $pid,
							]);

							if ( ! is_wp_error($terms) && ! empty($terms) ) {
								$all_children_terms = array_merge($all_children_terms, $terms);
							}
						}
						

						$all_children_ids = array_values(array_unique(array_map('intval', $all_children_ids)));
						
						?>
						<div class="qa-acc-col">
							<div class="row qa-acc-row">
								<?php foreach ($all_children_terms as $ct) :
								$clink = get_term_link($ct);
									if (is_wp_error($clink)) continue; ?>

									<div class="col-md-6">
										<div class='qa-acc-item' >
											<button class='qa-acc-btn' aria-expanded='false' aria-controls='<?php echo $ct->term_id; ?>-panel'>
												<span class='qa-acc-q'><?php echo esc_html($ct->name); ?></span>
												<span class='qa-acc-icon' aria-hidden='true'>
													<svg width='26' height='27' viewBox='0 0 26 27' fill='none' xmlns='http://www.w3.org/2000/svg'>
														<path fill-rule='evenodd' clip-rule='evenodd' d='M5.73332 9.92277C6.15638 9.4997 6.84231 9.4997 7.26538 9.92277L12.9993 15.6567L18.7333 9.92277C19.1564 9.4997 19.8423 9.4997 20.2654 9.92277C20.6884 10.3458 20.6884 11.0318 20.2654 11.4548L13.7654 17.9548C13.3423 18.3779 12.6564 18.3779 12.2333 17.9548L5.73332 11.4548C5.31025 11.0318 5.31025 10.3458 5.73332 9.92277Z' fill='#282828'/>
													</svg>
												</span>
											</button>
											<div class='qa-acc-panel' id='<?php echo $ct->term_id; ?>-panel' role='region' aria-labelledby='<?php echo $ct->term_id; ?>-btn'>
												<div class='qa-acc-a'>
												<?php
												// Тухайн parent (child-уудтай нь багтаад) постууд
												$q = new WP_Query([
													'post_type'      => 'help_center',
													'post_status'    => 'publish',
													'posts_per_page' => -1, // хүсвэл өөрчил
													'tax_query'      => [[
														'taxonomy'         => 'help_center_category',
														'field'            => 'term_id',
														'terms'            => [$ct->term_id],
														'include_children' => true,
													]],
												]);
												if ($q->have_posts()) :
												while ($q->have_posts()) : $q->the_post(); ?>
													<a href="<?php the_permalink(); ?>" class="qa-sub-title d-block text-decoration-none ">
														<?php the_title(); ?>
													</a>
												<?php endwhile; wp_reset_postdata();
												else : ?>
													<!-- <div class="text-muted small">Контент алга байна.</div> -->
												<?php endif; ?>

												</div>
											</div>
										</div>
									</div>
									
								<?php endforeach; ?>
								
							</div>
						</div>
					<?php endif; ?>
					<script>
					(function(){
					const allpane = document.currentScript.closest('.all-pane');
					const allcols = allpane.querySelectorAll('.qa-acc-col');

					allcols.forEach(col => {
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

				<!-- Parent тус бүрийн tab -->
				<?php if (!is_wp_error($parent_terms) && !empty($parent_terms)) :
					foreach ($parent_terms as $pt) :
						$pane_id = $uid . '-term-' . intval($pt->term_id);

						// Шууд child-ууд
						$children = get_terms([
							'taxonomy'   => 'help_center_category',
							'hide_empty' => false,
							'parent'     => $pt->term_id,
							'orderby'    => 'name',
							'order'      => 'ASC',
						]);

						?>
						<div class="tab-pane fade paned-<?php echo $pane_id; ?>" id="<?php echo esc_attr($pane_id); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($pane_id); ?>-tab">
						
								
							
							
							<div class="qa-acc-col">
								<div class="row qa-acc-row">
									<?php foreach ($children as $ct) :
										$clink = get_term_link($ct);
										if (is_wp_error($clink)) continue; ?>
										<?php  // Постууд (parent + бүх child)
										$q2 = new WP_Query([
											'post_type'      => 'help_center',
											'post_status'    => 'publish',
											'posts_per_page' => -1,
											'tax_query'      => [[
												'taxonomy'         => 'help_center_category',
												'field'            => 'term_id',
    											'terms'            => [$ct->term_id], 
												'include_children' => true,
											]],
										]); ?>
										<div class="col-md-6">
											<div class='qa-acc-item' >
												<button class='qa-acc-btn' aria-expanded='false' aria-controls='<?php echo $ct->term_id; ?>-panel'>
													<span class='qa-acc-q'><?php echo esc_html($ct->name); ?></span>
													<span class='qa-acc-icon' aria-hidden='true'>
														<svg width='26' height='27' viewBox='0 0 26 27' fill='none' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' clip-rule='evenodd' d='M5.73332 9.92277C6.15638 9.4997 6.84231 9.4997 7.26538 9.92277L12.9993 15.6567L18.7333 9.92277C19.1564 9.4997 19.8423 9.4997 20.2654 9.92277C20.6884 10.3458 20.6884 11.0318 20.2654 11.4548L13.7654 17.9548C13.3423 18.3779 12.6564 18.3779 12.2333 17.9548L5.73332 11.4548C5.31025 11.0318 5.31025 10.3458 5.73332 9.92277Z' fill='#282828'/>
														</svg>
													</span>
												</button>
												<div class='qa-acc-panel' id='<?php echo $ct->term_id; ?>-panel' role='region' aria-labelledby='<?php echo $ct->term_id; ?>-btn'>
													<div class='qa-acc-a'>
														
													<?php if ($q2->have_posts()) :
													while ($q2->have_posts()) : $q2->the_post(); ?>
														<a href="<?php the_permalink(); ?>" class="qa-sub-title d-block text-decoration-none ">
															<?php the_title(); ?>
														</a>
													<?php endwhile; wp_reset_postdata();
													else : ?>
														<!-- <div class="text-muted small">Контент алга байна.</div> -->
													<?php endif; ?>

													</div>
												</div>
											</div>
										</div>
										
									<?php endforeach; ?>
									
								</div>
							</div>

						<script>
							(function(){
							const paned = document.currentScript.closest('.paned-<?php echo $pane_id; ?>');
							const cols = paned.querySelectorAll('.qa-acc-col');

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

					<?php endforeach;
				endif; ?>

				</div><!-- /.tab-content -->
			</div><!-- /.container -->
			</div>
			<?php
			return ob_get_clean();
		}

	}
	new vc_odHelpcenter();
}
