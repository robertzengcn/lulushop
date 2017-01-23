<?php
/**
 * functions_customers
 *
 * @package functions
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Tue Aug 14 12:41:22 2012 -0400 Modified in v1.5.1 $
 */

////
// Returns the address_format_id for the given country
// TABLES: countries;
  function zen_get_address_format_id($country_id) {
    global $db;
    $address_format_query = "select address_format_id as format_id
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'";

    $address_format = $db->Execute($address_format_query);

    if ($address_format->RecordCount() > 0) {
      return $address_format->fields['format_id'];
    } else {
      return '1';
    }
  }

////
// Return a formatted address
// TABLES: address_format
  function zen_address_format($address_format_id, $address, $html, $boln, $eoln) {
    global $db;
    $address_format_query = "select address_format as format
                             from " . TABLE_ADDRESS_FORMAT . "
                             where address_format_id = '" . (int)$address_format_id . "'";

    $address_format = $db->Execute($address_format_query);
    $company = zen_output_string_protected($address['company']);
    if (isset($address['firstname']) && zen_not_null($address['firstname'])) {
      $firstname = zen_output_string_protected($address['firstname']);
      $lastname = zen_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && zen_not_null($address['name'])) {
      $firstname = zen_output_string_protected($address['name']);
      $lastname = '';
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = zen_output_string_protected($address['street_address']);
    $suburb = zen_output_string_protected($address['suburb']);
    $city = zen_output_string_protected($address['city']);
    $state = zen_output_string_protected($address['state']);
    if (isset($address['country_id']) && zen_not_null($address['country_id'])) {
      $country = zen_get_country_name($address['country_id']);

      if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {
        $state = zen_get_zone_code($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && zen_not_null($address['country'])) {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    } else {
      $country = '';
    }
    $postcode = zen_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    }
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format->fields['format'];
    eval("\$address_out = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
      $address_out = $company . $cr . $address_out;
    }

    return $address_out;
  }

////
// Return a formatted address
// TABLES: customers, address_book
  function zen_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
    global $db;
    $address_query = "select entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,
                             entry_country_id as country_id
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "'
                      and address_book_id = '" . (int)$address_id . "'";

    $address = $db->Execute($address_query);

    $format_id = zen_get_address_format_id($address->fields['country_id']);
    return zen_address_format($format_id, $address->fields, $html, $boln, $eoln);
  }
  
  //return a address object
  
  
  function zen_address_object($customers_id, $address_id = 1) {
  	global $db;
  	$address_query = "select entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,
                             entry_country_id as country_id,entry_telephone as phonenum
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "'
                      and address_book_id = '" . (int)$address_id . "'";
  
  	$address = $db->Execute($address_query);
  
  	return $address;
  }
  
  ////return customer all address 
  
  function zen_get_all_address($customers_id, $num) {
  	global $db;
  	$address_query = "select address_book_id as addressid, entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,
                             entry_country_id as country_id
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "' ORDER BY address_book_id DESC LIMIT ".(int)$num."";
                      
  	
  	$address = $db->Execute($address_query);
  	return $address;
//   	$array_ids = array();
//   	while (!$address_query->EOF)
//   	{
//   		array_push($array_ids,$address_query->fields);
//   		$address_query->MoveNext();
//   	}
  	
//   	return $array_ids;
  	
  	
  	
  	
  }

////
// Return a customer greeting
  function zen_customer_greeting() {

    if (isset($_SESSION['customer_id']) && $_SESSION['customer_first_name']) {
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, zen_output_string_protected($_SESSION['customer_first_name']), zen_href_link(FILENAME_PRODUCTS_NEW));
    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, zen_href_link(FILENAME_LOGIN, '', 'SSL'), zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }

    return $greeting_string;
  }

  function zen_count_customer_orders($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $orders_check_query = "select count(*) as total
                           from " . TABLE_ORDERS . "
                           where customers_id = '" . (int)$id . "'";

    $orders_check = $db->Execute($orders_check_query);

    return $orders_check->fields['total'];
  }

  function zen_count_customer_address_book_entries($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = "select count(*) as total
                        from " . TABLE_ADDRESS_BOOK . "
                        where customers_id = '" . (int)$id . "'";

    $addresses = $db->Execute($addresses_query);

    return $addresses->fields['total'];
  }

////
// validate customer matches session
  function zen_get_customer_validate_session($customer_id) {
    global $db, $messageStack;
    $zc_check_customer = $db->Execute("SELECT customers_id, customers_authorization from " . TABLE_CUSTOMERS . " WHERE customers_id=" . (int)$customer_id);
    $bannedStatus = $zc_check_customer->fields['customers_authorization'] == 4; // BANNED STATUS is 4
    if ($zc_check_customer->RecordCount() <= 0 || $bannedStatus) {
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET . " WHERE customers_id= " . $customer_id);
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " WHERE customers_id= " . $customer_id);
      $_SESSION['cart']->reset(TRUE);
      unset($_SESSION['customer_id']);
      if (!$bannedStatus) $messageStack->add_session('header', ERROR_CUSTOMERS_ID_INVALID, 'error');
      return false;
    }
    return true;
  }
  
  function zen_get_review(){
  	global $db;
  	$reviewdate=$db->Execute("SELECT r.reviews_id, r.products_id, r.reviews_rating, r.customers_name,r.customers_id, rd.reviews_text
                           FROM " . TABLE_REVIEWS . " r
                             LEFT JOIN " . TABLE_REVIEWS_DESCRIPTION . " rd ON (r.reviews_id = rd.reviews_id)
                           WHERE r.status = '1'" 
                           );
  	
  	return $reviewdate;
  }
  /**
   * Reduce a string by the middle, keeps whole words together
   *
   * @param string $string
   * @param int $max (default 50)
   * @param string $replacement (default [...])
   * @return string
   * @author david at ethinkn dot com
   * @author loic at xhtml dot ne
   * @author arne dot hartherz at gmx dot net
   */
  function strMiddleReduceWordSensitive($string,$max=2,$rep='*'){
  	$strlen = strlen($string);
  	if ($strlen <= $max)
  		return $string;
  	$lengthtokeep = $max - strlen($rep);
  	$start = 0;
  	$end = 0;
  	if (($lengthtokeep % 2) == 0) {
  		$start = $lengthtokeep / 2;
  		$end = $start;
  	} else {
  		$start = intval($lengthtokeep / 2);
  		$end = $start + 1;
  	}
  	$i = $start;
  	$tmp_string = $string;
  	while ($i < $strlen) {
  		if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
  			$tmp_string = substr($tmp_string, 0, $i) . $rep;
  			$return = $tmp_string;
  		}
  		$i++;
  	}
  	$i = $end;
  	$tmp_string = strrev ($string);
  	while ($i < $strlen) {
  		if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
  			$tmp_string = substr($tmp_string, 0, $i);
  			$return .= strrev ($tmp_string);
  		}
  		$i++;
  	}
  	return $return;
  	return substr($string, 0, $start).$rep.substr($string, - $end);
  }

  function substr_cut($user_name){
  	$strlen     = mb_strlen($user_name, 'utf-8');
  	$firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
  	$lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
  	return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
  }
  