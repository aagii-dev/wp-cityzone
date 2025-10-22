<?php
if (!function_exists('getallheaders')) {
	function getallheaders()
	{
		$headers = [];
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}
if (getallheaders()['X-Custom-Header'] == "modal") {

	$showHeader = false;
} else {
	$showHeader = true;
}
?>



<?php
while (have_posts()) {
	the_post();
?>
	<?php
	get_template_part('src/template/partial', 'pagehead');
	?>
	<div class="container">
		<?php the_content(); ?>
	</div>
<?php
	wp_reset_postdata();
} //end while
?>