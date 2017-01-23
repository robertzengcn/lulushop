<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_order_totals.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
 ?>
<?php 
/**
 * Displays order-totals modules' output
 */
//print_r($GLOBALS[$class]);


  for ($i=0; $i<$size; $i++) { ?>
 


<div class="product_price total textalri" <?php if($GLOBALS[$class]->title=="运费"){?>id="shippricediv"<?php }?>>
    <strong><span <?php if($GLOBALS[$class]->title=="运费"){ echo 'id="shipway"'; }elseif($GLOBALS[$class]->title=="小计"){echo 'id="subcost"'; }else{echo 'id="totalcost"';}?>><?php echo $GLOBALS[$class]->output[$i]['title']; ?></span></strong>
    <div style="display: inline-block"><span <?php if($GLOBALS[$class]->title=="运费"){echo 'id="shipprice"';}elseif($GLOBALS[$class]->title=="小计"){echo 'id="subcostnum"';}elseif($GLOBALS[$class]->title=="总额"){echo 'id="totalcostnum"';}elseif($GLOBALS[$class]->title=="Discount Coupon"){echo 'id="discounamount"';}else{}?> class="total_price"><?php echo $GLOBALS[$class]->output[$i]['text']; ?></span></div>
</div>

<?php }?>

