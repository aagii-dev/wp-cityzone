<?php

if (!class_exists('vc_AppartmentLocation') && class_exists('WPBakeryShortCode')) {
	class vc_AppartmentLocation extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AppartmentLocation_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AppartmentLocation', [$this, 'vc_AppartmentLocation_html']);
		}

		public function vc_AppartmentLocation_mapping()
		{
			vc_map([
				'name' => __('Appartment location', 'text-domain'),
				'base' => 'vc_AppartmentLocation',
				'category' => __('CityZone', 'text-domain'),
				'icon' => 'icon-wpb-slideshow',
				'params' => array(
            array(
                'type' => 'textfield',
                'heading' => 'Title',
                'param_name' => 'mg_title',
                'admin_label' => true,
            ),
            [
                'type'        => 'param_group',
                'heading'     => __('List items 1', 'text-domain'),
                'param_name'  => 'mg_list1',
                'params'      => [
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Name', 'text-domain'),
                        'param_name' => 'mg_name',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lat', 'text-domain'),
                        'param_name' => 'mg_lat',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lon', 'text-domain'),
                        'param_name' => 'mg_lon',
                        'admin_label'=> true,
                    ],
                ]
            ],
            [
                'type'        => 'param_group',
                'heading'     => __('List items 2', 'text-domain'),
                'param_name'  => 'mg_list2',
                'params'      => [
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Name', 'text-domain'),
                        'param_name' => 'mg_name',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lat', 'text-domain'),
                        'param_name' => 'mg_lat',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lon', 'text-domain'),
                        'param_name' => 'mg_lon',
                        'admin_label'=> true,
                    ],
                ]
            ],
            [
                'type'        => 'param_group',
                'heading'     => __('List items 3', 'text-domain'),
                'param_name'  => 'mg_list3',
                'params'      => [
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Name', 'text-domain'),
                        'param_name' => 'mg_name',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lat', 'text-domain'),
                        'param_name' => 'mg_lat',
                        'admin_label'=> true,
                    ],
                    [
                        'type'       => 'textfield',
                        'heading'    => __('Lon', 'text-domain'),
                        'param_name' => 'mg_lon',
                        'admin_label'=> true,
                    ],
                ]
            ],
				),
			]);
		}

		public function vc_AppartmentLocation_html($atts)
    {
      $atts = shortcode_atts([
        'mg_title' => '',
        'mg_list1' => '',
        'mg_list2' => '',
        'mg_list3' => '',
      ], $atts, 'vc_AppartmentLocation');

      // Param groups -> arrays
      $list1 =  vc_param_group_parse_atts($atts['mg_list1']);
      $list2 =  vc_param_group_parse_atts($atts['mg_list2']);
      $list3 =  vc_param_group_parse_atts($atts['mg_list3']);
   

      $title = sanitize_text_field($atts['mg_title']);

      // Unique ID (олон shortcode нэг хуудсанд байж болно)
      $uid = uniqid('czmap_');

      // Pin-үүдийн дараалал/дугаар
      $count1 = 0;
      $count2 = 0;
      $count3 = 0;

      ob_start(); ?>
      <section class="map section-wrapper">
        <div class="divider"></div>
        <div class="d-flex align-items-center justify-content-between mb-5">
          <p class="title"><?php echo esc_html($title); ?></p>
          <p class="num">05</p>
        </div>

        <div class="row g-0">
          <div class="col-12 col-md-8">
            <div class="map-wrapper">
              <div id="<?php echo esc_attr($uid); ?>" class="cz-google-map" style="width:100%;height:480px;"></div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="map-pins" data-map="<?php echo esc_attr($uid); ?>">
              <?php if (!empty($list1)) : ?>
                <div class="loc-title">Үйлчилгээний төв:</div>
                <?php foreach ($list1 as $val) :
                  $name = isset($val['mg_name']) ? sanitize_text_field($val['mg_name']) : '';
                  $lat  = isset($val['mg_lat']) ? floatval($val['mg_lat']) : null;
                  $lon  = isset($val['mg_lon']) ? floatval($val['mg_lon']) : null;
                  if ($name === '' || $lat === null || $lon === null) continue;
                  $count1++; ?>
                  <a href="#"
                    class="loc green"
                    data-lat="<?php echo esc_attr($lat); ?>"
                    data-lon="<?php echo esc_attr($lon); ?>"
                    data-name="<?php echo esc_attr($name); ?>"
                    data-cat="green"
                    data-idx="<?php echo esc_attr($count1); ?>">
                    <span><?php echo sprintf('%02d', $count1); ?></span><?php echo esc_html($name); ?>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php if (!empty($list2)) : ?>
                <div class="loc-title">Сургууль, цэцэрлэг:</div>
                <?php foreach ($list2 as $val) :
                  $name = isset($val['mg_name']) ? sanitize_text_field($val['mg_name']) : '';
                  $lat  = isset($val['mg_lat']) ? floatval($val['mg_lat']) : null;
                  $lon  = isset($val['mg_lon']) ? floatval($val['mg_lon']) : null;
                  if ($name === '' || $lat === null || $lon === null) continue;
                  $count2++; ?>
                  <a href="#"
                    class="loc red"
                    data-lat="<?php echo esc_attr($lat); ?>"
                    data-lon="<?php echo esc_attr($lon); ?>"
                    data-name="<?php echo esc_attr($name); ?>"
                    data-cat="red"
                    data-idx="<?php echo esc_attr($count2); ?>">
                    <span><?php echo sprintf('%02d', $count2); ?></span><?php echo esc_html($name); ?>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php if (!empty($list3)) : ?>
                <div class="loc-title">Төрийн үйлчилгээ:</div>
                <?php foreach ($list3 as $val) :
                  $name = isset($val['mg_name']) ? sanitize_text_field($val['mg_name']) : '';
                  $lat  = isset($val['mg_lat']) ? floatval($val['mg_lat']) : null;
                  $lon  = isset($val['mg_lon']) ? floatval($val['mg_lon']) : null;
                  if ($name === '' || $lat === null || $lon === null) continue;
                  $count3++; ?>
                  <a href="#"
                    class="loc blue"
                    data-lat="<?php echo esc_attr($lat); ?>"
                    data-lon="<?php echo esc_attr($lon); ?>"
                    data-name="<?php echo esc_attr($name); ?>"
                    data-cat="blue"
                    data-idx="<?php echo esc_attr($count3); ?>">
                    <span><?php echo sprintf('%02d', $count3); ?></span><?php echo esc_html($name); ?>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>

      <script>
        (function(){
          // -------- One-time loader for Google Maps JS --------
          if (!window.CZ_mapsLoader) {
            window.CZ_mapsLoader = true;
            window.CZ_onMapsReadyQueue = [];
            window.CZ_initMap = function(cb){ // queue callbacks until maps ready
              if (window.google && window.google.maps) { cb(); }
              else window.CZ_onMapsReadyQueue.push(cb);
            };
            var s = document.createElement('script');
            s.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCcHO4FlWSnWJYfAJO7vqfV-c1ebYDEexg";
            s.async = true; s.defer = true;
            s.onload = function(){
              (window.CZ_onMapsReadyQueue||[]).forEach(function(fn){ try{ fn(); }catch(e){} });
              window.CZ_onMapsReadyQueue = [];
            };
            document.head.appendChild(s);
          }

          // -------- Initialize this instance --------
          window.CZ_initMap(function(){
            var mapElId = "<?php echo esc_js($uid); ?>";
            var mapEl   = document.getElementById(mapElId);
            if (!mapEl) return;

            var map = new google.maps.Map(mapEl, {
              center: {lat: 47.8709141, lng: 106.8379464}, // default UB-ish center
              zoom: 14,
              mapTypeControl: false,
              streetViewControl: false,
              fullscreenControl: true,
            });
            // SVG marker color per category
            function markerIcon(color){
              return {
                path: "M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z",
                fillColor: color,
                fillOpacity: 1,
                strokeWeight: 0,
                rotation: 0,
                scale: 1.6,
                anchor: new google.maps.Point(12, 22),
              };
            }
            var COLORS = {
              green: "#10B981",
              red:   "#EF4444",
              blue:  "#3B82F6"
            };

            // Collect pins from the right column
            var pinsRoot = document.querySelector('.map-pins[data-map="'+mapElId+'"]');
            var links = pinsRoot ? [].slice.call(pinsRoot.querySelectorAll('a.loc')) : [];
            var bounds = new google.maps.LatLngBounds();
            var markers = [];

            links.forEach(function(a, idx){
              var lat = parseFloat(a.getAttribute('data-lat'));
              var lon = parseFloat(a.getAttribute('data-lon'));
              var name= a.getAttribute('data-name') || '';
              var cat = a.getAttribute('data-cat') || 'green';
              var num = a.getAttribute('data-idx') || (idx+1);

              if (isNaN(lat) || isNaN(lon)) return;
              var pos = {lat: lat, lng: lon};

              // --- PIN ICON УУСГЭХ ---
              // num → 2 оронтой формат
              var num2 = String(num).padStart(2, "0");

              // icon path
              var iconUrl = `<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/pin-${cat}-${num2}.png`;

              var marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: name,
                // zIndex: 1,
                icon: {
                  url: iconUrl,
                  scaledSize: new google.maps.Size(40, 40) // хүсвэл өөрчилж болно
                }
              });

              // --- INFOWINDOW ---
              var iw = new google.maps.InfoWindow({
                content: '<div style="min-width:160px"><strong>'+ 
                          (name ? name.replace(/</g,'&lt;'):'') + 
                        '</strong><br></div>'
              });

              marker.addListener('click', function(){
                iw.open(map, marker);
              });

              a.addEventListener('click', function(e){
                e.preventDefault();
                map.panTo(pos);
                map.setZoom(16);
                google.maps.event.trigger(marker, 'click');
                links.forEach(function(x){ x.classList.remove('is-active'); });
                a.classList.add('is-active');
              });

              markers.push(marker);
              bounds.extend(pos);
            });


            var mainMarker = new google.maps.Marker({
              position: {
                lat: 47.8709141,
                lng: 106.8379464
              },
              map: map,
              title: "CityZone",
              zIndex: 2,
              icon: {
                url: `<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/pin-cityzone.png`,
                scaledSize: new google.maps.Size(40, 40) // хүсвэл өөрчилж болно
              }
            });

            // 🔹 mainMarker-ийг bounds дотор нэмнэ
            bounds.extend(mainPos);

            if (!bounds.isEmpty()) {
              map.fitBounds(bounds);
              // zoom хэт ойр бол буцааж 12-оос доош бүү ор
              var l = google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
                if (map.getZoom() > 16) map.setZoom(14);
              });
            }
          }); // end CZ_initMap
        })();
      </script>
      <?php
      return ob_get_clean();
    }

	}
	new vc_AppartmentLocation();
}
