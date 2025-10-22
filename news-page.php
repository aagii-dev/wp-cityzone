<?php
/* Template Name: News page */
get_header();

$page_id    = get_queried_object_id();
$page_title = get_the_title($page_id);
$page_slug = get_post_field( 'post_name', $page_id );

// Сонгогдсон ангилал (query string ?cat=ID)
$selected_cat = isset($_GET['cat']) ? absint($_GET['cat']) : 0;

// Тухайн хуудсын одоогийн page дугаар
$paged = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);
?>
<div class="bg-black text-white section">
  <div class="container">

    <!-- Гарчиг -->
    <div class="small-title text-center text-uppercase mb-4">
      <?php echo esc_html($page_title); ?>
    </div>

    <!-- Бүгд + Ангиллууд -->
    <div class="news-categories mb-64 text-center">
      <?php
      // “Бүгд” линк
      $base_url = get_permalink($page_id);
      $is_all   = $selected_cat === 0;
      ?>
      <div class="">
		<div class="anchor-buttons dark">
			<a class="btn anchor-btn <?php echo $is_all ? 'btn-light' : ''; ?>"
				href="<?php echo esc_url(remove_query_arg(['cat','paged'], $base_url)); ?>">
			Бүгд
			</a>
			<?php
			$cats = get_categories([
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			]);
			foreach ($cats as $cat) :
			$active = $selected_cat === (int)$cat->term_id;
			$link   = add_query_arg(['cat' => $cat->term_id], $base_url);
			?>
			<a class="btn anchor-btn <?php echo $active ? 'btn-light' : ''; ?>"
				href="<?php echo esc_url($link); ?>">
				<?php echo esc_html($cat->name); ?>
			</a>
       	 	<?php endforeach; ?>
		</div>
      </div>
    </div>

    <?php
    // ------------------------------------------------------------
    // Онцгой/feature хэсэг
    // - Ангилал СОНГОГДСОН: тухайн ангиллын хамгийн сүүлийн 1 пост
    // - Ангилал СОНГОГДООГҮЙ: sticky-оос 1 пост (байвал)
    // ------------------------------------------------------------
    $featured_post_id = 0;


      // Sticky-оос 1-г feature болгоно
      $sticky_ids = get_option('sticky_posts');
      if (!empty($sticky_ids)) {
        rsort($sticky_ids);
		$sticky_arg = [
          'post__in'            => [$sticky_ids[0]],
          'posts_per_page'      => 1,
          'ignore_sticky_posts' => 0,
        ];
		if ($selected_cat) {
			$sticky_arg['cat'] = $selected_cat;
		}

        $sticky_q = new WP_Query($sticky_arg);
		
        if ($sticky_q->have_posts()) : ?>
			<?php while ($sticky_q->have_posts()) : $sticky_q->the_post();
				$featured_post_id = get_the_ID();
				$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
			  	<?php
				// Эхний ангилал авах
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
					$cat_id   = $categories[0]->term_id; // ID
					$cat_name = $categories[0]->name;    // Нэр

					// Мэдээний хуудсын линк (өөрийн News page-ийн slug/id-г энд тохируулна)
					$news_page_url = get_permalink( get_page_by_path( $page_slug ) );

					// Filter-тэй линк
					$cat_link = add_query_arg( 'cat', $cat_id, $news_page_url );
					?>
				<?php } ?>
				<div class='news-item featured'>
					<a href='<?php the_permalink(); ?>' class='news-item-link'></a>
					<div class='row'>
						<div class='col-md-8'>
							<div class='image-wrapper'>
								<div class='bg-view' style='background-image: url(<?php echo $thumb_url;  ?>)'></div>
								<div class='aspect-3-2'></div>
							</div>

						</div>
						<div class='col-md-4'>
							<div class='news-item-content'>
								<div class='news-item-top d-flex justify-content-between'>
									<a href='<?php echo esc_url( $cat_link ); ?>' class='news-item-tag'><?php echo esc_html( $cat_name ); ?></a>
									<div class='news-item-date'><?php echo esc_html(get_the_date("Y.m.d")); ?></div>
								</div>
								<div class='news-item-bottom'>
									<div class='news-item-title'>
									 <?php the_title(); ?>
									</div>
									<div class='news-item-excerpt'>
										<?php echo esc_html(wp_trim_words(get_the_excerpt(), 50)); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
      
             
            <?php endwhile; ?>
        <?php endif;
        wp_reset_postdata();
      }
    

    // ------------------------------------------------------------
    // Үлдсэн мэдээнүүд (grid)
    // - Хэрвээ feature пост байна → түүнийг list-ээс хасна
    // - Хэрвээ ангилал сонгогдсон бол тухайн ангиллаар шүүнэ
    // ------------------------------------------------------------
    $grid_args = [
      'post_type'           => 'post',
    //   'posts_per_page'      => 9,
      'paged'               => $paged,
    ];
    if ($selected_cat) {
      $grid_args['cat'] = $selected_cat;
    } else {
      // Ангилал сонгогдоогүй бол sticky-г давтаж гаргахгүй
      $sticky_ids = get_option('sticky_posts');
      if (!empty($sticky_ids)) {
        $grid_args['post__not_in'] = $sticky_ids;
      }
    }
    if ($featured_post_id) {
      $grid_args['post__not_in'] = array_unique(array_merge($grid_args['post__not_in'] ?? [], [$featured_post_id]));
    }

    $news_q = new WP_Query($grid_args);
    if ($news_q->have_posts()) : ?>
      <div class="row">
        <?php while ($news_q->have_posts()) : $news_q->the_post(); ?>
			<?php   $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
			<?php
			// Эхний ангилал авах
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				$cat_id   = $categories[0]->term_id; // ID
				$cat_name = $categories[0]->name;    // Нэр

				// Мэдээний хуудсын линк (өөрийн News page-ийн slug/id-г энд тохируулна)
				$news_page_url = get_permalink( get_page_by_path( $page_slug ) );

				// Filter-тэй линк
				$cat_link = add_query_arg( 'cat', $cat_id, $news_page_url );
				?>
			<?php } ?>
          <div class="col-12 col-md-4">
			<div class='news-item '>
				<a href='<?php the_permalink(); ?>' class='news-item-link'></a>
				<div class='row'>
					<div class='col-12'>
						<div class='image-wrapper'>
							<div class='bg-view' style='background-image: url(<?php echo $thumb_url; ?>)'></div>
							<div class='aspect-3-2'></div>
						</div>

					</div>
					<div class='col-12'>
						<div class='news-item-content'>
							<div class='news-item-top d-flex justify-content-between'>
								<a href='<?php echo esc_url( $cat_link ); ?>' class='news-item-tag'><?php echo esc_html( $cat_name ); ?></a>
								<div class='news-item-date'><?php echo esc_html(get_the_date("Y.m.d")); ?></div>
							</div>
							<div class='news-item-bottom'>
								<div class='news-item-title'>
									<?php the_title(); ?>
								</div>
								<div class='news-item-excerpt'>
									<?php echo esc_html(wp_trim_words(get_the_excerpt(), null)); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            
          </div>
        <?php endwhile; ?>
      </div>

      <!-- Хуудаслалт -->
		<?php
// ⚠️ Энэ хэсгийг $news_q дууссаны дараа, wp_reset_postdata() хийхийн өмнө байрлуул
$max_pages = (int) $news_q->max_num_pages;
$current   = (int) $paged; // таны дээр тооцсон $paged

// Мэдээний хуудсын үндсэн URL (энэ template-ийн page)
$page_url = get_permalink( get_queried_object_id() );

// query арг бэлдэх (cat хадгалах)
$base_args = [];
if ( ! empty($selected_cat) ) {
  $base_args['cat'] = (int) $selected_cat;
}

// Prev/Next линкүүд
$prev_link = $current > 1
  ? add_query_arg( array_merge($base_args, ['paged' => $current - 1]), $page_url )
  : '';
$next_link = $current < $max_pages
  ? add_query_arg( array_merge($base_args, ['paged' => $current + 1]), $page_url )
  : '';
?>

<?php if ( $max_pages > 1 ) : ?>
  <div class="d-flex justify-content-center mt-5 gap-2">
    <div>
      <?php if ( $prev_link ) : ?>
        <a class="btn btn-light" href="<?php echo esc_url($prev_link); ?>">« Өмнөх</a>
      <?php endif; ?>
    </div>
    <div>
      <?php if ( $next_link ) : ?>
        <a class="btn btn-light" href="<?php echo esc_url($next_link); ?>">Дараах »</a>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

    <?php else : ?>
      <p class="text-center text-secondary my-5">Одоогоор нийтлэл алга байна.</p>
    <?php endif;
    wp_reset_postdata();
    ?>

  </div>
</div>

<?php get_footer(); ?>
