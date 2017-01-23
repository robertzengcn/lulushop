<?php
/**
 * shopping_cart header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 19098 2011-07-13 15:19:52Z wilt $
 */

// This should be first line of the script:




require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE);



$country = zen_db_prepare_input($_GET['zone_country_id']);
$productprice_ship_check=zen_db_prepare_input($_GET['product_price_ship']);




	if($productprice_ship_check<=100){
$check_query = "SELECT ship_way, ship_country, ship_time, ship_fee, ship_val FROM shoppingway where ship_country=:zone_country_id AND ship_val=100";
    $check_ship_query = $db->bindVars($check_query, ':zone_country_id', $country, 'integer');
    $check = $db->Execute($check_ship_query);
	}else if($productprice_ship_check>100&&$productprice_ship_check<=200){

$check_query = "SELECT ship_way, ship_country, ship_time, ship_fee, ship_val FROM shoppingway where ship_country=:zone_country_id AND ship_val=200";
    $check_ship_query = $db->bindVars($check_query, ':zone_country_id', $country, 'integer');

    $check = $db->Execute($check_ship_query);
	}else if($productprice_ship_check>200&&$productprice_ship_check<=500){
$check_query = "SELECT ship_way, ship_country, ship_time, ship_fee, ship_val FROM shoppingway where ship_country=:zone_country_id AND ship_val=500";
    $check_ship_query = $db->bindVars($check_query, ':zone_country_id', $country, 'integer');
    $check = $db->Execute($check_ship_query);
	}else{
$check_query = "SELECT ship_way, ship_country, ship_time, ship_fee, ship_val FROM shoppingway where ship_country=:zone_country_id AND ship_val=9999";
    $check_ship_query = $db->bindVars($check_query, ':zone_country_id', $country, 'integer');
    $check = $db->Execute($check_ship_query);
  }
if (!$check->RecordCount()){
	echo "There are not detail current";
}else{

	while(!$check->EOF){
		echo '<tr><td>'.$check->fields['ship_way'].'</td><td>'.$check->fields['ship_fee'].'</td><td>'.$check->fields['ship_time'].' Days</td></tr>';
		$check->MoveNext();
	}	
}

	
	exit();


?>