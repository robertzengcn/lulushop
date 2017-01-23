<?php
/**
 * featured_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: featured_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$featured_products_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ")";
  }
}
if ($featured_products_query != '') $featured_products = $db->ExecuteRandomMulti($featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  switch (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS) {
    case 1: $col_width = 'col_12_of_12'; break;
    case 2: $col_width = 'col_1_of_2'; break;
    case 3: $col_width = 'col_1_of_3'; break;  
    case 4: $col_width = 'col_1_of_4'; break;  
    case 5: $col_width = 'col_1_of_5'; break; 
    case 6: $col_width = 'col_1_of_6'; break;
    case 7: $col_width = 'col_1_of_7'; break;
    case 8: $col_width = 'col_1_of_8'; break;  
    case 9: $col_width = 'col_1_of_9'; break;
    case 10: $col_width = 'col_1_of_10'; break;
        
    default: $col_width = 'col_12_of_12'; break;
  }
  
  $currentListingPage = "featuredProducts";

  while (!$featured_products->EOF) {
    $products_price = zen_get_products_display_price_mars($featured_products->fields['products_id']);
    if (!isset($productsInCategory[$featured_products->fields['products_id']])) $productsInCategory[$featured_products->fields['products_id']] = zen_get_generated_category_path_rev($featured_products->fields['master_categories_id']);

    $featured_product_carousel_class = ($homepage_options->fields['homepage_featured_products_display'] == 1) ? 'centerBoxContentsFeatured' : 'centerBoxContentsFeatured col '.$col_width;

    $link = '<a href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
    $buy_now_button = ($homepage_options->fields['homepage_featured_products_buy_now_button_display'] == 1) ? '<div class="buyNowCont">'.$link.'</div>' : '';

    // Effect 1
    if($homepage_options->fields['homepage_featured_products_hover_effect'] == 1){
      $list_box_contents[$row][$col] = array(
        'params' => 'class="'.$featured_product_carousel_class.'"',
        'text' => (($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a class="listingProductLink" href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) . '</a><br />') . '<h3 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">' . $featured_products->fields['products_name'] . '</a></h3><br /><span class="price">' . $products_price.'</span>'.$buy_now_button
      );

      $sliderEffect = 'featured_he_1';
    }
    
    // Effect 2
    if($homepage_options->fields['homepage_featured_products_hover_effect'] == 2){
      $list_box_contents[$row][$col] = array(
        'params' => 'class="'.$featured_product_carousel_class.'"',      
        'text' => '
          <div class="productStyle_2">
            ' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) . '
            <a href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">
              <div class="info">
                <h4>' . $featured_products->fields['products_name'] . '</h4>
                <h6>' . $products_price.'</span></h6>
              </div>
            </a>
          </div>          
        '      
      );

      $sliderEffect = 'featured_he_2';
    }

    // Effect 3
    if($homepage_options->fields['homepage_featured_products_hover_effect'] == 3){
      $list_box_contents[$row][$col] = array(
        'params' => 'class="'.$featured_product_carousel_class.'"',              
        'text' => '          
          <figure class="productStyle_3">
            ' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) . '
            <figcaption>
              <a href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '"><h4>' . $featured_products->fields['products_name'] . '</h4></a>
              <h6>' . $products_price.'</h6>
              <div class="button_cont">'.$buy_now_button.'</div>
            </figcaption>
          </figure>      
        '
      );

      $sliderEffect = 'featured_he_3';
    }

    // Effect 4
    if($homepage_options->fields['homepage_featured_products_hover_effect'] == 4){
      $list_box_contents[$row][$col] = array(
        'params' => 'class="'.$featured_product_carousel_class.'"',      
        'text' => '          
          <figure class="productStyle_4">
            <a href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT) . '</a>
            <figcaption>
              <h4><a href="' . zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">' . $featured_products->fields['products_name'] . '</a></h4>
              <h6>' . $products_price.'</h6>            
            </figcaption>
          </figure>            
        '
      );

      $sliderEffect = 'featured_he_4';
    }

    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $featured_products->MoveNextRandom();
  }

  if ($featured_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id !=0) {
      $category_title = zen_get_categories_name((int)$new_products_category_id);
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . ($category_title != '' ? ' - ' . $category_title : '') . '</h2>';
    } else {
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . '</h2>';
    }
    $zc_show_featured = true;
  }
}
?>