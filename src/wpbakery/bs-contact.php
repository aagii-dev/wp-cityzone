<?php

if (!class_exists('vc_odContact') && class_exists('WPBakeryShortCode')) {
	class vc_odContact extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_odContact_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_odContact', [$this, 'vc_odContact_html']);
		}

		public function vc_odContact_mapping()
		{
			vc_map([
				'name' => __('Contact', 'text-domain'),
				'base' => 'vc_odContact',
				'category' => __('BurenScore', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Contact info',
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
								'heading' => 'Detail',
								'param_name' => 'mg_detail',
								'admin_label' => true,
							),
						)
					),
					array(
						'type' => 'param_group',
						'value' => '',
						'heading' => 'Map info',
						'param_name' => 'mg_list2',
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => 'Title',
								'param_name' => 'title',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Phone',
								'param_name' => 'phone',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Email',
								'param_name' => 'email',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Time',
								'param_name' => 'time',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Address',
								'param_name' => 'address',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Google map latitude',
								'param_name' => 'google_map_lat',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => 'Google map longitude',
								'param_name' => 'google_map_lng',
								'admin_label' => true,
							),
						)
					),
				),
			]);
		}

		public function vc_odContact_html($atts)
		{
			extract(shortcode_atts([
				'mg_list' => '',
			], $atts));


			$mg_list = vc_param_group_parse_atts($atts['mg_list']);
			$mg_list2 = vc_param_group_parse_atts($atts['mg_list2']);


			$list_html = "";
			foreach ($mg_list as $val) {
				$rand = rand(1000,9999);
			
				
				$title = $val['mg_title'];
				$detail = $val['mg_detail'];
			
			
				$list_html .= "<div class='contact-item'>
									<div class='contact-item-title'>
										$title
									</div>
									<div class='contact-item-desc'>
										$detail
									</div>
								</div>";
			
			}

			$locations_arr = array();
			foreach ($mg_list2 as $val) {
				$lat = $val['google_map_lat'];
				$lng = $val['google_map_lng'];

				$title = $val['title'];
				$phone = $val['phone'];
				$email = $val['email'];
				$time = $val['time'];
				$address = $val['address'];

				if($lat && $lng){
					array_push($locations_arr, array(
						"id" => "branch-map-" . get_the_ID(),
						"title" => $title,
						"phone" => $phone,
						"email" => $email,
						"time" => $time,
						"address" => $address,
						"lat" => floatval($lat),
						"lng" => floatval($lng),
						// "icon" => esc_url(get_template_directory_uri())."/assets/images/location_pin.png"
						"icon" => array(
							"url" => esc_url(get_template_directory_uri())."/assets/images/map_pin.png",
							"scaledSize" => array("width" => 32, "height" => 33) // Өргөн, өндөр
						)
					));
				}

				
				
			
			}


			ob_start(); ?>
			<div class='position-relative bg-silver section' >
				<div class='container'>
					<div class='row'>
						<div class='col-md-5'>
							<?php echo $list_html; ?>
						</div>
						<div class='col-md-1'></div>
						<div class='col-md-6'>
							<div class="branch-map big">
								<div id="mapall" class="branch-map-item"></div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<script>


				function initMaps() {
					var locations = <?php echo json_encode($locations_arr); ?>;
					console.log('locations: ', locations);
					var map = new google.maps.Map(document.getElementById("mapall"), {
						zoom: 12,
						center: { lat: locations[0].lat, lng: locations[0].lng }, // АНУ-ын төв байршил
						mapTypeControl: false,       // mapTypeControl-ийг арилгах
						fullscreenControl: false,    // fullscreenControl-ийг арилгах
						streetViewControl: false     // streetViewControl-ийг арилгах (нэмэлт)
					});


					// Маркеруудыг нэмэх
					locations.forEach(function (location) {
						// Маркер үүсгэх
						var marker = new google.maps.Marker({
							position: { lat: location.lat, lng: location.lng },
							map: map,
							title: location.title, // Маркерийн title
							icon: location.icon // Custom зураг ашиглах
						});

						// Инфо цонх үүсгэх
						var infoWindow = new google.maps.InfoWindow({
							content: '<h6 class="mb-2">' + location.title + '</h6><p>' + location.phone + '</p><p>' + location.email + '</p><p>' + location.time + '</p><p>' + location.address + '</p>' // Title болон description
						});

						// Маркер дээр дарсан үед инфо цонхыг харуулах
						marker.addListener('click', function () {
							infoWindow.open(map, marker);
						});
					});






					// Газрын зургийг давталтаар үүсгэх
					locations.forEach(function (location) {
						var map = new google.maps.Map(document.getElementById(location.id), {
							zoom: 15,
							center: { lat: location.lat, lng: location.lng },
							mapTypeControl: false,       // mapTypeControl-ийг арилгах
							fullscreenControl: false,    // fullscreenControl-ийг арилгах
							streetViewControl: false     // streetViewControl-ийг арилгах (нэмэлт)
						});

						// Маркер нэмэх
						var marker = new google.maps.Marker({
							position: { lat: location.lat, lng: location.lng },
							icon: {
								url: '<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/location_pin.png',
								scaledSize: new google.maps.Size(38, 47), // scaled size
							},
							map: map,
						});
						// Инфо цонх үүсгэх
						var infoWindow = new google.maps.InfoWindow({
							content: '<h6 class="mb-2">' + location.title + '</h6><p>' + location.phone + '</p><p>' + location.email + '</p><p>' + location.time + '</p><p>' + location.address + '</p>' // Title болон description
						});
						// Маркер дээр дарсан үед инфо цонхыг харуулах
						marker.addListener('click', function () {
							infoWindow.open(map, marker);
						});
					});
				}

			</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcHO4FlWSnWJYfAJO7vqfV-c1ebYDEexg&callback=initMaps" async defer></script>
			<?php
    		return ob_get_clean();
		}
	}
	new vc_odContact();
}
