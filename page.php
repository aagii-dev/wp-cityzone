<?php get_header(); ?>
<?php
$white_header = get_post_meta(get_the_ID(), 'page_use_white_header', true);

if ( $white_header ) : ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var navbar = document.getElementById("mainNavbar");
        if(navbar){
          navbar.classList.add("force-white");
        }
      });
    </script>
<?php endif; ?>
<?php
if (have_posts()) :
	while (have_posts()) : the_post();
		the_content();
	endwhile;
endif;
?>
<?php get_footer(); ?>