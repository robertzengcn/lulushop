<?php
// +----------------------------------------------------------------------+
// |Snap Affiliates for Zen Cart                                          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2013, Vinos de Frutas Tropicales (lat9) for ZC 1.5.0+  |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// +----------------------------------------------------------------------+

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// -----
// This function, called from /YOUR_ADMIN/orders.php, determines if the specified order resulted in a commission to one 
// of the store's affiliates, returning an image with a link to the affiliate's details if so.  Returns '' if no
// commission payment was generated by the order.
// 
function snap_affiliates_image( $oID = 'none' ) {
  global $db;
  $image_info = '';
  
  // -----
  // If the caller requested a link to the referrer associated with the order id ...
  //
  if ($oID != 'none') {
 
    // -----
    // Check to see if the specified order has an associated referrer commission ...
    //
    $sa_sql = 'SELECT c.customers_id as id, c.customers_firstname, c.customers_lastname, r.referrer_banned, rc.commission_rate, rc.commission_paid 
                 FROM ' . TABLE_REFERRERS . ' r, ' . TABLE_CUSTOMERS . ' c, ' . TABLE_COMMISSION . ' rc 
                 WHERE rc.commission_orders_id = ' . (int)$oID . '
                 AND rc.commission_referrer_key = r.referrer_key
                 AND r.referrer_customers_id = c.customers_id';
    $sa_info = $db->Execute($sa_sql);
    if (!$sa_info->EOF) {
      $image_info = '<a href="' . zen_href_link(FILENAME_REFERRERS, 'referrer=' . $sa_info->fields['id'] . '&amp;mode=details') . '">' . zen_image(DIR_WS_ICONS . 'cash.jpg', TEXT_COMMISSIONED_ORDER) . '</a>&nbsp;';  /*v2.4.1c*/
    }
  // -----
  // Otherwise, just output the image with text to use a guidance for the display.
  //
  } else {
    $image_info = '&nbsp;&nbsp;' . zen_image(DIR_WS_ICONS . 'cash.jpg', TEXT_COMMISSIONED_ORDER) . '&nbsp;&nbsp;' . TEXT_COMMISSIONED_ORDER;
    
  }
  return $image_info;
}