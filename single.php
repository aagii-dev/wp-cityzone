<?php get_header(); ?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php
		$post_id = get_the_ID();
		$banner_url = get_the_post_thumbnail_url($post_id, 'full');
		$categories = get_the_category($post_id);
		$category_name = '';
		$category_class = '';
		if (!empty($categories) && !is_wp_error($categories)) {
			$category_name = $categories[0]->name;
			$category_class = $categories[0]->slug;
		}
		?>




		<section class="news-banner">
			<div class="news-banner-image" data-zoom="both">
				<?php if ($banner_url) : ?>
					<img src="<?php echo esc_url($banner_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
				<?php endif; ?>
			</div>
		</section>

		<div class='bg-white'>
			<div class='container news-container'>
				<nav class="breadcrumb" aria-label="Breadcrumb">
					<div class="breadcrumb-container">
						<ol class="breadcrumb-list">
							<li class="breadcrumb-item">
								<a href="<?php echo esc_url(home_url('/')); ?>">Нүүр</a>
							</li>
							<li class="breadcrumb-separator">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<path d="M9 18l6-6-6-6" />
								</svg>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<span><?php echo esc_html(get_the_title()); ?></span>
							</li>
						</ol>
					</div>
				</nav>
			</div>
		</div>

		<article class="news-detail">
			<div class="container news-container">
				<div class="news-meta">
					<?php if ($category_name !== '') : ?>
						<span class="news-category <?php echo esc_attr($category_class); ?>"><?php echo esc_html($category_name); ?></span>
					<?php endif; ?>
					<span class="news-date">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<rect x="3" y="4" width="18" height="18" rx="2" />
							<path d="M16 2v4M8 2v4M3 10h18" />
						</svg>
						<?php echo esc_html(get_the_date('j F Y')); ?>
					</span>
				</div>

				<h1 class="news-title"><?php echo esc_html(get_the_title()); ?></h1>

				<div class="news-content">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
