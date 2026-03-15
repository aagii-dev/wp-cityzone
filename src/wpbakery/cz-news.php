<?php

if (!class_exists('vc_News') && class_exists('WPBakeryShortCode')) {
	class vc_News extends WPBakeryShortCode
	{
		public function __construct()
		{
			add_action('vc_before_init', [$this, 'vc_News_mapping']);
			add_shortcode('vc_News', [$this, 'vc_News_html']);
		}

		public function vc_News_mapping()
		{
			vc_map([
				'name' => __('News', 'text-domain'),
				'base' => 'vc_News',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-application-icon-large',
				'params' => [],
			]);
		}

		public function vc_News_html($atts)
		{
			$args = [
				'post_type'           => 'post',
				'posts_per_page'      => 60,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			];

			$news_query = new WP_Query($args);

			ob_start();
			?>
			<section class="news section-wrapper">
				<div class="divider"></div>

				<div class="row">
					<?php if ($news_query->have_posts()) : ?>
						<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
							<?php
								$post_id    = get_the_ID();
								$title      = get_the_title();
								$permalink  = get_permalink();
								$date       = get_the_date('d F Y');
								$image_url  = get_the_post_thumbnail_url($post_id, 'full');

								if (!$image_url) {
									$image_url = get_template_directory_uri() . '/assets/images/placeholder-news.jpg';
								}

								$categories = get_the_category();
								$cat_name   = '';
								$cat_slug   = '';

								if (!empty($categories) && isset($categories[0])) {
									$cat_name = $categories[0]->name;
									$cat_slug = $categories[0]->slug;
								}
							?>

                            <div class="col-md-4">
                                <article class="news-card">
                                    <a href="<?php echo esc_url($permalink); ?>" class="news-card-link">
                                        <div class="news-card-image">
                                            <img
                                                src="<?php echo esc_url($image_url); ?>"
                                                alt="<?php echo esc_attr($title); ?>"
                                            >
                                            <div class="news-card-overlay"></div>
                                        </div>

                                        <div class="news-card-content">
                                            <?php if (!empty($cat_name)) : ?>
                                                <span class="news-card-category <?php echo esc_attr($cat_slug); ?>">
                                                    <?php echo esc_html($cat_name); ?>
                                                </span>
                                            <?php endif; ?>

                                            <h3 class="news-card-title">
                                                <?php echo esc_html($title); ?>
                                            </h3>

                                            <div class="news-card-footer">
                                                <span class="news-card-date">
                                                    <?php echo esc_html($date); ?>
                                                </span>

                                                <span class="news-card-arrow">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            </div>
						<?php endwhile; ?>
					<?php else : ?>
						<p>Нийтлэл олдсонгүй.</p>
					<?php endif; ?>
				</div>
			</section>
			<?php
			wp_reset_postdata();

			return ob_get_clean();
		}
	}

	new vc_News();
}