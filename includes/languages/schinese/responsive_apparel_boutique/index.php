<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: index.php 19537 2011-09-20 17:14:44Z drbyte $
 */

define('TEXT_MAIN','This is the main define statement for the page for english when no template defined file exists. It is located in: <strong>/includes/languages/english/index.php</strong>');

// Showcase vs Store
if (STORE_STATUS == '0') {
  define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s">log yourself in</a>?');
} else {
  define('TEXT_GREETING_GUEST', 'Welcome, please enjoy our online showcase.');
}

define('TEXT_GREETING_PERSONAL', 'Hello <span class="greetUser">%s</span>! Would you like to see our <a href="%s">newest additions</a>?');

define('TEXT_INFORMATION', 'Define your main Index page copy here.');

//moved to english
//define('TABLE_HEADING_FEATURED_PRODUCTS','Featured Products');

//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

if ( ($category_depth == 'products') || (zen_check_url_get_terms()) ) {
  // This section deals with product-listing page contents
  define('HEADING_TITLE', '可选商品');
  define('TABLE_HEADING_IMAGE', '商品图片');
  define('TABLE_HEADING_MODEL', '型号');
  define('TABLE_HEADING_PRODUCTS', '产品名');
  define('TABLE_HEADING_MANUFACTURER', '制造商');
  define('TABLE_HEADING_QUANTITY', '数量');
  define('TABLE_HEADING_PRICE', '价格');
  define('TABLE_HEADING_WEIGHT', '重量');
  define('TABLE_HEADING_BUY_NOW', '购买');
  define('TEXT_NO_PRODUCTS', '当前目录下没有产品');
  define('TEXT_NO_PRODUCTS2', '当前没有产品来自所选制造商');
  define('TEXT_NUMBER_OF_PRODUCTS', '产品数量 ');
  define('TEXT_SHOW', '过滤条件');
  define('TEXT_BUY', '购买 1 \'');
  define('TEXT_NOW', '\' 现在');
  define('TEXT_ALL_CATEGORIES', '商品分类');
  define('TEXT_ALL_MANUFACTURERS', '所有制造商');
} elseif ($category_depth == 'top') {
  // This section deals with the "home" page at the top level with no options/products selected
  /*Replace this text with the headline you would like for your shop. For example: 'Welcome to My SHOP!'*/
  define('HEADING_TITLE', '');
} elseif ($category_depth == 'nested') {
  // This section deals with displaying a subcategory
  /*Replace this line with the headline you would like for your shop. For example: 'Welcome to My SHOP!'*/
  define('HEADING_TITLE', ''); 
}
?>