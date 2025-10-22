<?php

if (!class_exists('vc_odCareerJob') && class_exists('WPBakeryShortCode')) {
	class vc_odCareerJob extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odCareerJob_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odCareerJob', [$this, 'vc_odCareerJob_html']);
		}

		public function vc_odCareerJob_mapping()
		{
			vc_map([
				'name' => __('Career job', 'text-domain'),
				'base' => 'vc_odCareerJob',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'Title 1 (colored)',
						'param_name' => 'mg_title1',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => 'Title 2 (colored)',
						'param_name' => 'mg_title2',
						'admin_label' => true,
					),
				
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'list',
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
								'heading' => 'Description',
								'param_name' => 'mg_description',
								'admin_label' => true,
							),
						)
					),
					
				),
			]);
		}

		public function vc_odCareerJob_html($atts)
		{
			extract(shortcode_atts([
				'mg_title1' => '',
				'mg_title2' => '',
			], $atts));


			$q = new WP_Query([
				'post_type'      => 'job',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			]);

			$posts = $q->have_posts() ? $q->posts : [];
			wp_reset_postdata();

		
			$list_html = '';
			foreach ($posts as $p) {
				$title = esc_html(get_the_title($p));
				$link = get_the_permalink($p);

				// ✅ Таксономи нэрүүд
				$cats  = get_the_terms($p, 'job_category');
				$times = get_the_terms($p, 'job_time');

				$cat_name  = (!is_wp_error($cats)  && !empty($cats))  ? esc_html($cats[0]->name)  : '';
  				$time_name = (!is_wp_error($times) && !empty($times)) ? esc_html($times[0]->name) : '';

				$cat_html  = $cat_name  ? "<div class='btn btn-job-cat'>$cat_name</div>" : "";
  				$time_html = $time_name ? "<div class='btn btn-job-time'>$time_name</div>" : "";

				$list_html .= "<div class='col-md-6'>
								<a href='$link' class='job-item'>
									<div class='job-item-title'>
										$title
									</div>
									<div class='d-flex'>
										$cat_html
         								$time_html
									</div>
								</a>
							</div>";
			}
			
			
			
		
		
			return "<div class='position-relative bg-dark text-white' >
						<div class='sticky-item '>
							<div class='container text-center'>
								<div class='medium-title'>$mg_title1 </div>
								<div class='medium-title'><span class='color-green'>$mg_title2</span></div>
								
							</div>
						</div>
						<div class='sticky-overlay mh-auto bg-silver' >
							<div class='section section-d64'>
								<div class='container'>
									<div class='row'>
										$list_html
									</div>
								</div>
							</div>
							
						</div>

						<script>
						
						</script>




					</div>";
		}
	}
	new vc_odCareerJob();
}
