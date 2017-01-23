<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING 04/04/2006
 * Modified for admin control of customer option by Glenn Herbert (gjh42) 2012-09-21   2012-11-17 grid sorter
 */
 include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
?>
<div id="productListing">
<?php
// only show when there is something to submit and enabled
    if ($show_top_submit_button == true) {
?>
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"'); ?></div>
<br class="clearBoth" />
<?php
    } // show top submit
?>

<?php if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
<div class="navSplitPagesWrapper"> 
<div id="productsListingTopNumber" class="navSplitPagesResult back"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
<div id="productsListingListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
</div>

<?php
}
?>

<?php
/**
 * load the list_box_content template to display the products
 */
if ($product_listing_layout_style == 'columns') {
  if (PRODUCT_LISTING_GRID_SORT) { 
    echo "\n" . '<div id="gridSorter"><label class="inputLabelSort">'. PRODUCT_LISTING_GRID_SORT_TEXT . '</label><ul>';

    $col_small = 'col_1_of_4';
    $col_big = 'col_2_of_4';
    $array_size = sizeof($grid_sort)-2;
    switch ($array_size) {
      case 1:
          $col_small = 'col_12_of_12';
          $col_big = 'col_12_of_12';
        break;
      case 2:
          $col_small = 'col_1_of_3';
          $col_big = 'col_2_of_3';
        break;
      case 3:
          $col_small = 'col_1_of_4';
          $col_big = 'col_2_of_4';
        break;  
      case 4:
          $col_small = 'col_1_of_6';
          $col_big = 'col_3_of_6';
        break;  
      case 5:
          $col_small = 'col_1_of_7';
          $col_big = 'col_3_of_7';
        break; 
      case 6:
          $col_small = 'col_1_of_8';
          $col_big = 'col_3_of_8';
        break;
      case 7:
          $col_small = 'col_1_of_9';
          $col_big = 'col_3_of_9';
        break;
          
      default:
          $col_small = 'col_1_of_4';
          $col_big = 'col_2_of_4';
        break;
    }


    for ($col=0;$col<sizeof($grid_sort);$col++) {
      if ($grid_sort[$col]['text']){
        $col_class = ($col==1) ? $col_big : $col_small;
        echo '<li class="item col '.$col_class.'">' . $grid_sort[$col]['text'] . '</li>';
      }
    }
    echo '</ul></div>' . "\n";
  }
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
} else {// (PRODUCT_LISTING_LAYOUT_STYLE == 'rows')
  require($template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php');
}
?>

<?php if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
<div class="navSplitPagesWrapper">
<div id="productsListingBottomNumber" class="navSplitPagesResult back"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
<div  id="productsListingListingBottomLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></div>
</div>
<?php
  }
?>

<?php
// only show when there is something to submit and enabled
    if ($show_bottom_submit_button == true) {
?>
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?></div>
<br class="productClear clearBoth" />
<?php
    } // show_bottom_submit_button
?>
</div>

<?php
// if ($show_top_submit_button == true or $show_bottom_submit_button == true or (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0 and $show_submit == true and $listing_split->number_of_rows > 0)) {
  if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } ?>