<?php

if (!class_exists('vc_AppartmentRoom') && class_exists('WPBakeryShortCode')) {
	class vc_AppartmentRoom extends WPBakeryShortCode
	{
		public function __construct()
		{	
			// ✅ vc_before_init ашиглана!
			add_action('vc_before_init', [$this, 'vc_AppartmentRoom_mapping']);
			// ✅ Shortcode ажиллуулах
			add_shortcode('vc_AppartmentRoom', [$this, 'vc_AppartmentRoom_html']);
		}

		public function vc_AppartmentRoom_mapping()
		{
			vc_map([
				'name' => __('Appartment room', 'text-domain'),
				'base' => 'vc_AppartmentRoom',
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
                        'heading'     => __('Rooms', 'text-domain'),
                        'param_name'  => 'mg_rooms',
                        'params'      => [
                            array(
                                'type' => 'textfield',
                                'heading' => 'Name',
                                'param_name' => 'mg_room_name',
                                'admin_label' => true,
                            ),
                            [
                                'type'        => 'param_group',
                                'heading'     => __('Загварууд', 'text-domain'),
                                'param_name'  => 'mg_zagwar',
                                'params'      => [
                                    array(
                                        'type' => 'textfield',
                                        'heading' => 'Name',
                                        'param_name' => 'mg_name',
                                        'admin_label' => true,
                                    ),
                                     [
                                        'type'        => 'attach_image',
                                        'heading'     => __('Image', 'text-domain'),
                                        'param_name'  => 'mg_image',
                                    ],
                                    [
                                        'type'        => 'param_group',
                                        'heading'     => __('Specs', 'text-domain'),
                                        'param_name'  => 'mg_specs',
                                        'group' => '2room',
                                        'params'      => [
                                            array(
                                                'type' => 'textfield',
                                                'heading' => 'Name',
                                                'param_name' => 'mg_spec_name',
                                                'admin_label' => true,
                                            ),
                                            array(
                                                'type' => 'textfield',
                                                'heading' => 'Value',
                                                'param_name' => 'mg_spec_value',
                                                'admin_label' => true,
                                            ),
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]



                    
				),
			]);
		}

		public function vc_AppartmentRoom_html($atts)
		{
			extract(shortcode_atts([
				'mg_title' => '',
				'mg_rooms' => '',
               
			], $atts));


            $mg_rooms = vc_param_group_parse_atts($atts['mg_rooms']);
            
            // HTML бүтээж буцаана
            ob_start(); ?>
           <section class="section-wrapper">
            <div class="divider"></div>
            <div class="d-flex align-items-center justify-content-between mb-5">
            <p class="title"><?php echo $mg_title; ?></p>
            <p class="num">02</p>
            </div>

            <div class="d-flex gap-4 flex-row align-items-start justify-content-between">
                <!-- LEFT: үндсэн табууд -->
                <ul class="nav app-room flex-lg-column nav-pills roomTabs gap-3" id="roomTabs" role="tablist">
                    <?php foreach ($mg_rooms as $key=>$val) {  ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo $key==0?'active':''; ?>" id="r<?php echo $key; ?>-tab" data-bs-toggle="pill" data-bs-target="#r<?php echo $key; ?>" type="button" role="tab"><?php echo $val['mg_room_name'];?></button>
                        </li>
                    <?php } ?>
                </ul>
                <!-- </div> -->

                <!-- RIGHT: өрөө бүрийн агууламж -->
                <div class="w-100">
                    <!-- <div class="col-12 col-lg-10"> -->
                    <div class="tab-content" id="roomTabsContent">
                        <?php foreach ($mg_rooms as $key=>$val) {  ?>
                            <?php
                            $mg_zagwar = vc_param_group_parse_atts($val['mg_zagwar']);
                    
                            ?>
                            <div class="tab-pane fade <?php echo $key==0?'show active':''; ?>" id="r<?php echo $key; ?>" role="tabpanel" aria-labelledby="r<?php echo $key; ?>tab">
                                <div class="row g-3">
                                    <div class="col-lg-8">
                                        <?php if(!empty($mg_zagwar)){ 
                                             $mg_first_image_url = wp_get_attachment_image_url($mg_zagwar[0]['mg_image'], 'full'); ?>
                                             <img class="w-100" src="<?php echo $mg_first_image_url; ?>" id='zagwar-img' alt="" />
                                        <?php } ?>
                                       
                                    </div>
                                    <div class="col-lg-4">
                                        <ul class="nav subtabs border-bottom mb-3" id="r<?php echo $key; ?>-variants" role="tablist">
                                            <?php foreach($mg_zagwar as $zkey=>$zval){ ?>
                                                <?php
                                                $mg_image_url = wp_get_attachment_image_url($zval['mg_image'], 'full');
                                                ?>
                                                <li class="nav-item">
                                                    <button class="nav-link zagwar-link <?php echo $zkey==0?'active':''; ?>" data-image="<?php echo $mg_image_url;?>" data-bs-toggle="tab" data-bs-target="#r<?php echo $key; ?>-<?php echo $zkey; ?>" type="button"><?php echo $zval['mg_name']?></button>
                                                </li>
                                            <?php } ?>
                                        </ul>

                                        <div class="tab-content">
                                            <?php foreach($mg_zagwar as $zkey=>$zval){ ?>
                                                <?php 
                                                $mg_specs = vc_param_group_parse_atts($zval['mg_specs']); 
                                                ?>
                                            <!-- r3-E -->
                                            <div class="tab-pane fade <?php echo $zkey==0?'show active':''; ?>" id="r<?php echo $key; ?>-<?php echo $zkey; ?>">
                                                <table class="table specs-table">
                                                    <tbody>
                                                        <?php foreach($mg_specs as $sval){ ?>
                                                            <tr>
                                                                <th><?php echo $sval['mg_spec_name'];?></th>
                                                                <td><?php echo $sval['mg_spec_value'];?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </section>
        <script>
document.addEventListener('DOMContentLoaded', function() {
  // Бүх загварын линкүүдийг сонгоно
  const zagwarLinks = document.querySelectorAll('.zagwar-link');
  const mainImage = document.getElementById('zagwar-img');

  zagwarLinks.forEach(link => {
    link.addEventListener('click', function() {
      const imageUrl = this.getAttribute('data-image');
      if (imageUrl && mainImage) {
        mainImage.setAttribute('src', imageUrl);
      }

      // active class солих
      zagwarLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });
});
</script>
            <?php
            return ob_get_clean();
    
    
        }
	}
	new vc_AppartmentRoom();
}
