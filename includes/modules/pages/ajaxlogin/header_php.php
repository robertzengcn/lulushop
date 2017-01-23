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


$getUserId=zen_db_prepare_input($_REQUEST["uid"]);
$passw = zen_db_prepare_input($_REQUEST["passw"]);
	
	 $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
                                    customers_email_address, customers_default_address_id,
                                    customers_authorization, customers_referral
                           FROM " . TABLE_CUSTOMERS . "
                           WHERE customers_email_address = :emailAddress";

    $check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $getUserId, 'string');
    $check_customer = $db->Execute($check_customer_query);
	
	if (!$check_customer->RecordCount()) 
     echo "notvalid";
    elseif ($check_customer->fields['customers_authorization'] == '4')    // this account is banned
         echo "notvalid";
    else
	{

      if (!zen_validate_password($_REQUEST["passw"], $check_customer->fields['customers_password'])) 
        echo "notvalid";
      else
	    echo "valid";
	 
	  
	  // echo zen_validate_password($passw, $check_customer->fields['customers_password']);
	}
	
	exit();


?>