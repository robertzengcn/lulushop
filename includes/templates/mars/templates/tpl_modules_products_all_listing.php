<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_all.<br />
 * Displays listing of All Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_all_listing.php 6096 2007-04-01 00:43:21Z ajeh $
 */
?>
<ul class="productListingList allListingList">

<?php
  $group_id = zen_get_configuration_key_value('PRODUCT_ALL_LIST_GROUP_ID');

  if ($products_all_split->number_of_rows > 0) {
    $products_all = $db->Execute($products_all_split->sql_query);
    $row_counter = 0;
    while (!$products_all->EOF) {
      $row_counter++;

      if (PRODUCT_ALL_LIST_IMAGE != '0') {
        if ($products_all->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $display_products_image = str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_IMAGE, 3, 1));
        } else {
          $display_products_image = '<a class="listingProductLink" href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $products_all->fields['products_image'], $products_all->fields['products_name'], IMAGE_PRODUCT_ALL_LISTING_WIDTH, IMAGE_PRODUCT_ALL_LISTING_HEIGHT) . '</a>';
        }
      } else {
        $display_products_image = '';
      }
      if (PRODUCT_ALL_LIST_NAME != '0') {
        $display_products_name = '<h3 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . $products_all->fields['products_name'] . '</a></h3>';
      } else {
        $display_products_name = '';
      }

      if (PRODUCT_ALL_LIST_MODEL != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'model')) {
        $display_products_model = TEXT_PRODUCTS_MODEL . $products_all->fields['products_model'] . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_MODEL, 3, 1));
      } else {
        $display_products_model = '';
      }

      if (PRODUCT_ALL_LIST_WEIGHT != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'weight')) {
        $display_products_weight = TEXT_PRODUCTS_WEIGHT . $products_all->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_WEIGHT, 3, 1));
      } else {
        $display_products_weight = '';
      }

      if (PRODUCT_ALL_LIST_QUANTITY != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'quantity')) {
        if ($products_all->fields['products_quantity'] <= 0) {
          $display_products_quantity = TEXT_OUT_OF_STOCK . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
        } else {
          $display_products_quantity = TEXT_PRODUCTS_QUANTITY . $products_all->fields['products_quantity'] . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
        }
      } else {
        $display_products_quantity = '';
      }

      if (PRODUCT_ALL_LIST_DATE_ADDED != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'date_added')) {
        $display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($products_all->fields['products_date_added']) . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_DATE_ADDED, 3, 1));
      } else {
        $display_products_date_added = '';
      }

      if (PRODUCT_ALL_LIST_MANUFACTURER != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'manufacturer')) {
        $display_products_manufacturers_name = ($products_all->fields['manufacturers_name'] != '' ? TEXT_MANUFACTURER . ' ' . $products_all->fields['manufacturers_name'] . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_MANUFACTURER, 3, 1)) : '');
      } else {
        $display_products_manufacturers_name = '';
      }

      if ((PRODUCT_ALL_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') and zen_check_show_prices() == true) {
        $products_price = zen_get_products_display_price($products_all->fields['products_id']);
        $display_products_price = TEXT_PRICE. ' <span class="price">'. $products_price .'</span>'. str_repeat('<br clear="all" />', substr(PRODUCT_ALL_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_all->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_all->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
      } else {
        $display_products_price = '';
      }

// more info in place of buy now
      if (PRODUCT_ALL_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') {
        if (zen_has_product_attributes($products_all->fields['products_id'])) {
          $link = '<a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        } else {
//          $link= '<a href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_all->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</a>';
          if (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART > 0 && $products_all->fields['products_qty_box_status'] != 0) {
//            $how_many++;
            $link = TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART . "<input type=\"text\" name=\"products_id[" . $products_all->fields['products_id'] . "]\" value=\"0\" size=\"4\" />";
          } else {
            $link = '<a href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_all->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
          }
        }

        $the_button = $link;
        $products_link = '<a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_all->fields['products_id']) . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_BUY_NOW, 3, 1));
      } else {
        $link = '<a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $the_button = $link;
        $products_link = '<a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_all->fields['products_id']) . str_repeat('<br clear="all" />', substr(PRODUCT_ALL_BUY_NOW, 3, 1));
      }

      if (PRODUCT_ALL_LIST_DESCRIPTION > '0') {
        $disp_text = zen_get_products_description($products_all->fields['products_id']);
        $disp_text = zen_clean_html($disp_text);

        $display_products_description = '<div class="listingDescription">'.stripslashes(zen_trunc_string($disp_text, PRODUCT_ALL_LIST_DESCRIPTION, '<a href="' . zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($products_all->fields['master_categories_id']) . '&products_id=' . $products_all->fields['products_id']) . '"> ' . MORE_INFO_TEXT . '</a>')).'</div>';
      } else {
        $display_products_description = '';
      }

?>
           <li class="section group">
            <div class="col col_1_of_4">
              <?php echo $display_products_image; ?>
            </div>   
            <div class="col col_2_of_4">
              <?php
                echo $display_products_name;

                if (PRODUCT_ALL_LIST_DESCRIPTION > '0') { 
                    echo $display_products_description; 
                }

                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 1000 and configuration_value <= 1999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {                  
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_BUY_NOW') {
                    echo $display_products_button;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_MODEL') {
                    echo $display_products_model;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_PRICE') {
                    echo $display_products_price;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_WEIGHT') {
                    echo $display_products_weight;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_DATE_ADDED') {
                    echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
              ?>
            </div>            
            <div class="col col_1_of_4">
              <?php
                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 2000 and configuration_value <= 2999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_BUY_NOW') {
                    echo $display_products_button;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_MODEL') {
                    echo $display_products_model;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_PRICE') {
                    echo $display_products_price;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_WEIGHT') {
                    echo $display_products_weight;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_ALL_LIST_DATE_ADDED') {
                    echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
              ?>
            </div>
          </li>
<?php  
      $products_all->MoveNext();
    }
  } else {
?>
          <li><?php echo TEXT_NO_ALL_PRODUCTS; ?></li>
<?php
  }
?>
</ul>
