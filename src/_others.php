<?php
function mcs_login_logo()
{ ?>
  <style type="text/css">
    #login h1 a,
    .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/admin-logo.svg);
      height: 45px;
      width: 300px;
      background-size: contain;
      background-repeat: no-repeat;
      padding-bottom: 10px;
    }
  </style>
  <?php }
add_action('login_enqueue_scripts', 'mcs_login_logo');






function mcs_login_logo_url()
{
  return home_url();
}
add_filter('login_headerurl', 'mcs_login_logo_url');

function mcs_login_logo_url_title()
{
  return 'AAIP';
}
add_filter('login_headertitle', 'mcs_login_logo_url_title');







?>