<?php get_header(); ?>
<?php
while (have_posts()) {
	the_post();
	$title = get_the_title();

	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$cat_id   = $categories[0]->term_id; // ID
		$cat_name = $categories[0]->name;    // Нэр
	} 
	?>
	<div class="post-header bg-black text-white">
		<div class="container">
			<div class='mb-24 d-flex justify-content-between'>
				<a href='#_' class='news-item-tag'><?php echo esc_html( $cat_name ); ?></a>
				<div class='news-item-date'><?php echo esc_html(get_the_date("Y.m.d")); ?></div>
			</div>
			<div class='post-title mini-title mb-24'>
				<?php echo $title; ?>
			</div>
			<div class='post-share d-flex'>
				<a href="#" onclick="window.open( 'http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>', 'Share on Facebook', 'width=600,height=400' )" class="btn btn-icon">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9.75 16.463C9.50332 16.4875 9.25312 16.5 9 16.5C8.74688 16.5 8.49668 16.4875 8.25 16.463V10.5H7.5C7.08579 10.5 6.75 10.1642 6.75 9.75C6.75 9.33579 7.08579 9 7.5 9H8.25V7.5C8.25 6.25736 9.25736 5.25 10.5 5.25H11.25C11.6642 5.25 12 5.58579 12 6C12 6.41421 11.6642 6.75 11.25 6.75H10.5C10.0858 6.75 9.75 7.08579 9.75 7.5V9H11.25C11.6642 9 12 9.33579 12 9.75C12 10.1642 11.6642 10.5 11.25 10.5H9.75V16.463Z" fill="white"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M9 15C12.3137 15 15 12.3137 15 9C15 5.68629 12.3137 3 9 3C5.68629 3 3 5.68629 3 9C3 12.3137 5.68629 15 9 15ZM9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" fill="white"/>
					</svg>
				</a>
				<a href="#" onclick="window.open( 'http://twitter.com/intent/tweet?status=<?php the_title(); ?>+<?php the_permalink(); ?>', 'Tweet on Twitter', 'width=600,height=400' )" class="btn btn-icon">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_7091_7839)">
					<path d="M14.8144 3.49389C15.0872 3.18216 15.0556 2.70834 14.7439 2.43558C14.4322 2.16282 13.9583 2.1944 13.6856 2.50613L9.47926 7.31335L10.448 8.48407L14.8144 3.49389Z" fill="white"/>
					<path d="M8.5207 10.6867L7.55193 9.51602L3.18558 14.5061C2.91282 14.8179 2.9444 15.2917 3.25613 15.5644C3.56786 15.8372 4.04168 15.8056 4.31444 15.4939L8.5207 10.6867Z" fill="white"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M2.59918 4.7063C1.78993 3.72837 2.48547 2.25 3.75481 2.25H5.55792C6.0049 2.25 6.42859 2.44934 6.71356 2.79371L15.4023 13.2937C16.2115 14.2716 15.516 15.75 14.2467 15.75H12.4436C11.9967 15.75 11.573 15.5507 11.288 15.2063L2.59918 4.7063ZM3.75481 3.75L3.75481 3.75L12.4436 14.25L14.2467 14.25L5.55792 3.75H3.75481Z" fill="white"/>
					</g>
					<defs>
					<clipPath id="clip0_7091_7839">
					<rect width="18" height="18" fill="white"/>
					</clipPath>
					</defs>
					</svg>
				</a>
				<a href="#" data-url='<?php the_permalink(); ?>'  class="btn btn-icon btn-copy-link" onclick="navigator.clipboard.writeText(this.getAttribute('data-url'));">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M12.1557 5.84451C12.4486 6.1374 12.4486 6.61227 12.1557 6.90517L6.90567 12.1552C6.61278 12.4481 6.1379 12.4481 5.84501 12.1552C5.55212 11.8623 5.55212 11.3874 5.84501 11.0945L11.095 5.84451C11.3879 5.55161 11.8628 5.55161 12.1557 5.84451Z" fill="white"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M4.7577 7.93919C5.05059 8.23209 5.05059 8.70696 4.7577 8.99985L3.69704 10.0605C2.52547 11.2321 2.52547 13.1316 3.69704 14.3032C4.86861 15.4747 6.76811 15.4747 7.93968 14.3032L9.00034 13.2425C9.29323 12.9496 9.76811 12.9496 10.061 13.2425C10.3539 13.5354 10.3539 14.0103 10.061 14.3032L9.00034 15.3638C7.24298 17.1212 4.39374 17.1212 2.63638 15.3638C0.879019 13.6065 0.87902 10.7572 2.63638 8.99985L3.69704 7.93919C3.98993 7.6463 4.46481 7.6463 4.7577 7.93919Z" fill="white"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M9.00034 2.63589C10.7577 0.878532 13.6069 0.878531 15.3643 2.63589C17.1217 4.39325 17.1217 7.24249 15.3643 8.99985L14.3036 10.0605C14.0107 10.3534 13.5359 10.3534 13.243 10.0605C12.9501 9.76762 12.9501 9.29274 13.243 8.99985L14.3036 7.93919C15.4752 6.76762 15.4752 4.86812 14.3036 3.69655C13.1321 2.52498 11.2326 2.52498 10.061 3.69655L9.00034 4.75721C8.70745 5.0501 8.23257 5.0501 7.93968 4.75721C7.64679 4.46432 7.64679 3.98944 7.93968 3.69655L9.00034 2.63589Z" fill="white"/>
					</svg>
				</a>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class='mt-64'>
					<div class='image-wrapper'>
						<?php the_post_thumbnail('full'); ?>
					</div>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	<div class='section bg-silver'>
		<div class='container post-content'>
			<?php the_content(); ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
} //end while
?>
<?php get_footer(); ?>