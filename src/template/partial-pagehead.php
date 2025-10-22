<?php

$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
$large_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

?>
<div class="page-head-title-wrap d-flex align-items-center">
	<div class="page-head-title-bg bg-cover" style="background-image: url(<?php echo $large_url; ?>)"></div>

	<div class="page-head-title w-100">
		<div class="container">
			<div class='d-flex w-100 flex-column justify-content-center align-items-center'>
				<!-- <span><?php echo pll__('text_home');  ?> | <?php the_title(); ?></span> -->
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</div>