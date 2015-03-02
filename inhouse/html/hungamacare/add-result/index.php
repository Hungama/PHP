<?php
  //<!--/* Revive Adserver Local Mode Tag v3.0.2 */-->

  // The MAX_PATH below should point to the base of your Revive Adserver installation
/*   define('MAX_PATH', '/var/www/html/hungamacare/revive-adserver');
  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
      $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 0, 3, 5, '', '', '0', $phpAds_context, '');
  }

  echo $phpAds_raw['html']; */
  
$wallpaperurl = "http://192.168.100.212/hungamacare/adserver/www/delivery/avw.php?campaignid=3&mwidth=168";
$ch1 = curl_init($wallpaperurl);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$wallpaperdata = curl_exec($ch1);
echo  $wallpaperdata;
?>
<!--/* Revive Adserver No Cookie Image Tag v3.0.2 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://119.82.69.212/hungamacare/adserver/www/delivery/...'
  * to
  *   'https://119.82.69.212/hungamacare/adserver/www/delivery/...'
  *
  */-->

<img src='http://192.168.100.212/hungamacare/adserver/www/delivery/avw.php?campaignid=3&mwidth=168' border='0' alt='' >

