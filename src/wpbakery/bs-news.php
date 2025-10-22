<?php
if (!class_exists('vc_odNews') && class_exists('WPBakeryShortCode')) {
  class vc_odNews extends WPBakeryShortCode
  {
    public function __construct()
    {
      add_action('vc_before_init', [$this, 'vc_odNews_mapping']);
      add_shortcode('vc_odNews', [$this, 'vc_odNews_html']);
    }

    public function vc_odNews_mapping()
    {
      vc_map([
        'name'     => __('News', 'text-domain'),
        'base'     => 'vc_odNews',
        'category' => __('BurenScore', 'text-domain'),
        'icon'     => 'icon-wpb-slideshow',
        'params'   => [
          [
            'type'        => 'textfield',
            'heading'     => 'Title',
            'param_name'  => 'mg_title',
            'admin_label' => true,
          ],
        ],
      ]);
    }

    public function vc_odNews_html($atts)
    {
      $atts = shortcode_atts([
        'mg_title' => '',
      ], $atts);

      $title = $atts['mg_title'];

      // -------- Featured (sticky эсвэл хамгийн сүүлийн 1) --------
      $sticky_ids = get_option('sticky_posts');
      $featured_post = null;
      $featured_id = 0;

      if (!empty($sticky_ids)) {
        rsort($sticky_ids); // хамгийн сүүлийн sticky-г сонгоё
        $featured_q = new WP_Query([
          'post__in'            => $sticky_ids,
          'posts_per_page'      => 1,
          'ignore_sticky_posts' => 1,
          'orderby'             => 'date',
          'order'               => 'DESC',
        ]);
      } else {
        $featured_q = new WP_Query([
          'posts_per_page'      => 1,
          'ignore_sticky_posts' => 1,
          'orderby'             => 'date',
          'order'               => 'DESC',
        ]);
      }

      if ($featured_q->have_posts()) {
        $featured_q->the_post();
        $featured_post = get_post();
        $featured_id = $featured_post->ID;
      }
      wp_reset_postdata();

      // -------- Доорх 3 нийтлэл (featured-ийг хасна) --------
      $latest_q = new WP_Query([
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
        'post__not_in'        => $featured_id ? [$featured_id] : [],
        'orderby'             => 'date',
        'order'               => 'DESC',
      ]);

      // -------- Туслах функцууд --------
      $get_bg_url = function ($post_id) {
        $img = get_the_post_thumbnail_url($post_id, 'large');
        if (!$img) {
          // Хэрэв thumbnail байхгүй бол fallback (хоосон үлдээгээд CSS-ээр өнгө тавьж болно)
          $img = '';
        }
        return esc_url($img);
      };

      $get_cat_html = function ($post_id) {
        $cats = get_the_category($post_id);
        if (!empty($cats)) {
          $cat = $cats[0];
          $cat_link = get_category_link($cat->term_id);
        //   return '<a class="news-item-tag" href="' . esc_url($cat_link) . '">' . esc_html($cat->name) . '</a>';
          return '<a class="news-item-tag" href="#">' . esc_html($cat->name) . '</a>';
        }
        return '<span class="news-item-tag">Мэдээ</span>';
      };

      $get_date = function ($post_id) {
        return esc_html(get_the_date('Y.m.d', $post_id));
      };

      $get_excerpt = function ($post_id, $len = 160) {
        $excerpt = has_excerpt($post_id) ? get_the_excerpt($post_id) : wp_strip_all_tags(get_post_field('post_content', $post_id));
        $excerpt = wp_trim_words($excerpt, 30, '…');
        return esc_html($excerpt);
      };

      ob_start();
      ?>
      <div class='section bg-black text-white'>
        <div class='container text-center'>
          <div class='small-title'><?php echo esc_html($title); ?></div>
        </div>

        <div class='container mt-64'>
          <?php if ($featured_post): ?>
            <?php
              $f_id   = $featured_post->ID;
              $f_url  = get_permalink($f_id);
              $f_bg   = $get_bg_url($f_id);
              $f_ttl  = get_the_title($f_id);
              $f_cat  = $get_cat_html($f_id);
              $f_date = $get_date($f_id);
              $f_exc  = $get_excerpt($f_id);
            ?>
            <div class='news-item featured'>
              <a href='<?php echo esc_url($f_url); ?>' class='news-item-link'></a>
              <div class='row'>
                <div class='col-md-8'>
                  <div class='image-wrapper'>
                    <div class='bg-view' style='background-image: url(<?php echo $f_bg; ?>)'></div>
                    <div class='aspect-3-2'></div>
                  </div>
                </div>
                <div class='col-md-4'>
                  <div class='news-item-content'>
                    <div class='news-item-top d-flex justify-content-between'>
                      <?php echo $f_cat; ?>
                      <div class='news-item-date'><?php echo $f_date; ?></div>
                    </div>
                    <div class='news-item-bottom'>
                      <div class='news-item-title'><?php echo esc_html($f_ttl); ?></div>
                      <div class='news-item-excerpt'><?php echo $f_exc; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <div class='row'>
            <?php if ($latest_q->have_posts()): ?>
              <?php while ($latest_q->have_posts()): $latest_q->the_post(); ?>
                <?php
                  $p_id  = get_the_ID();
                  $p_url = get_permalink($p_id);
                  $p_bg  = $get_bg_url($p_id);
                  $p_ttl = get_the_title($p_id);
                  $p_cat = $get_cat_html($p_id);
                  $p_date = $get_date($p_id);
                  $p_exc = $get_excerpt($p_id);
                ?>
                <div class='col-md-4'>
                  <div class='news-item'>
                    <a href='<?php echo esc_url($p_url); ?>' class='news-item-link'></a>
                    <div class='row'>
                      <div class='col-12'>
                        <div class='image-wrapper'>
                          <div class='bg-view' style='background-image: url(<?php echo $p_bg; ?>)'></div>
                          <div class='aspect-3-2'></div>
                        </div>
                      </div>
                      <div class='col-12'>
                        <div class='news-item-content'>
                          <div class='news-item-top d-flex justify-content-between'>
                            <?php echo $p_cat; ?>
                            <div class='news-item-date'><?php echo $p_date; ?></div>
                          </div>
                          <div class='news-item-bottom'>
                            <div class='news-item-title'><?php echo esc_html($p_ttl); ?></div>
                            <div class='news-item-excerpt'><?php echo $p_exc; ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
              <div class='col-12'>
                <p><?php esc_html_e('Одоогоор нийтлэл алга байна.', 'text-domain'); ?></p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php
      return ob_get_clean();
    }
  }
  new vc_odNews();
}
