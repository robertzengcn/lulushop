<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007-2008 Numinix Technology http://www.numinix.com    |
// |                                                                      |
// | Portions Copyright (c) 2003-2006 Zen Cart Development Team           |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: header_php.php 136 2010-09-28 01:22:49Z numinix $
//
  $zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT');

  require_once(DIR_WS_CLASSES . 'http_client.php');
  require(DIR_WS_CLASSES . 'order.php');
  $order = new order();

  $total_weight = $_SESSION['cart']->show_weight();
  $total_count = $_SESSION['cart']->count_contents();
  
  $check_province_query = "SELECT zone_id,zone_code,zone_name
                           FROM " . TABLE_ZONES . "
                           WHERE zone_country_id = 44";
  $check_province = $db->Execute($check_province_query);

  if (FEC_ONE_PAGE == 'true') {
    $checkout_confirmation = FILENAME_FEC_CONFIRMATION;
  } else {
    $checkout_confirmation = FILENAME_CHECKOUT_CONFIRMATION;
  }

  // set template style
  if (FEC_SPLIT_CHECKOUT == 'true' and $credit_covers == false) {
    $checkoutStyle = 'split';
  }

  // test for weight or quantity errors due to redirects
  if (isset($_SESSION['total_weight']) || isset($_SESSION['total_count'])) {
    if ((round((float)$_SESSION['total_weight'], 2) != round((float)$total_weight, 2)) || (round((float)$_SESSION['total_count'], 2) != round((float)$total_count, 2))) {
     if (isset($_SESSION['shipping'])) {
       // shipping is inccorect, therefore unset
       unset($_SESSION['shipping']);
     }
    }
  }

  // set the sessions for total weight and total count to be used during redirects
  $_SESSION['total_weight'] = $total_weight;
  $_SESSION['total_count'] = $total_count;


  //if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($_SESSION['cart']->count_contents() <= 0) {
    zen_redirect(zen_href_link(FILENAME_TIME_OUT));
  }

  if ($_SESSION['free_virtual']) {
    // check if cart is free + virtual
    if ($_SESSION['cart']->get_content_type() != 'virtual' || $_SESSION['cart']->in_cart_check('product_is_free','1') != $_SESSION['cart']->count_contents()) {
      // unset session to force regular registration
      unset($_SESSION['customer_id']);
      unset($_SESSION['free_virtual']);
    }
  }

  // if the customer is not logged on, redirect them to the login page
  if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));

  } else {
  // validate customer
	  if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
		  $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT));
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));


	  }
  }

  // Validate Cart for checkout
  $_SESSION['valid_to_checkout'] = true;
  $_SESSION['cart']->get_products(true);
  if ($_SESSION['valid_to_checkout'] == false) {
    $messageStack->add('header', ERROR_CART_UPDATE, 'error');
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
  }



  // Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
	  $products = $_SESSION['cart']->get_products();
	  for ($i=0, $n=sizeof($products); $i<$n; $i++) {

      // Added to allow individual stock of different attributes
      unset($attributes);
      if(is_array($products[$i]['attributes'])) {
        $attributes = $products[$i]['attributes'];
      } else  {
        $attributes = '';
      }
      // End change

      if (zen_check_stock($products[$i]['id'], $products[$i]['quantity'], $attributes)) {
        zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }


  // register a random ID in the session to check throughout the checkout procedure
  // against alterations in the shopping cart contents
  $_SESSION['cartID'] = $_SESSION['cart']->cartID;

  // load all enabled shipping modules
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping();

  // if no shipping destination address was selected, use the customers own address as default
  if (!$_SESSION['sendto']) {
    $_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
  } else {
  // verify the selected shipping address
    $check_address_query = "SELECT count(*) AS total
                            FROM   " . TABLE_ADDRESS_BOOK . "
                            WHERE  customers_id = :customersID
                            AND    address_book_id = :addressBookID";

    $check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
    $check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['sendto'], 'integer');
    $check_address = $db->Execute($check_address_query);

    if ($check_address->fields['total'] != '1') {
      $_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
      $_SESSION['shipping'] = '';
    }
  }

  // if no billing destination address was selected, use the customers own address as default
  if (!$_SESSION['billto']) {
    $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
  } else {
    // verify the selected billing address
    $check_address_query = "SELECT count(*) AS total FROM " . TABLE_ADDRESS_BOOK . "
                            WHERE customers_id = :customersID
                            AND address_book_id = :addressBookID";

    $check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
    $check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['billto'], 'integer');
    $check_address = $db->Execute($check_address_query);

    if ($check_address->fields['total'] != '1') {
      $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
      $_SESSION['payment'] = '';
    }
  }

  // get all available shipping quotes
  $quotes = $shipping_modules->quote();
  //print_r($quotes);

  // if the order contains only virtual products, hide shipping input information
  // a shipping address is not needed
  if ($order->content_type == 'virtual') {
    if ($_SESSION['shipping'] != 'free_free') {
      $_SESSION['shipping'] = 'free_free';
      $_SESSION['shipping']['title'] = 'free_free';
      $_SESSION['sendto'] = false;
      if (!($messageStack->size('checkout_payment') > 0) && !($messageStack->size('checkout_shipping') > 0) && !($messageStack->size('redemptions') > 0) ) {
        zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'fecaction=null', 'SSL'));
      }
    }
  }

  // support for cart containing only ALWAYS FREE SHIPPING items
  //if ($_SESSION['cart']->count_contents() == $_SESSION['cart']->free_shipping_items()) {
    //$_SESSION['shipping'] = 'free_free';
    //$_SESSION['shipping']['title'] = 'free_free';
  //}

  // load all enabled payment modules
  require(DIR_WS_CLASSES . 'payment.php');
  
  // BEGIN REWARDS POINTS
  // if credit does not cover order total or isn't selected
  if ($_SESSION['credit_covers'] != true) {
    // check that a gift voucher isn't being used that is larger than the order
    if ($_SESSION['cot_gv'] < $order->info['total']) {
      $credit_covers = false;
    }
  } else {
    $credit_covers = true;
  }
  // END REWARDS POINTS
 
  $payment_modules = new payment;
  if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) && ($error = ${$_GET['payment_error']}->get_error())) {
    $messageStack->add('checkout_payment', $error['error'], 'error');
    unset($_SESSION['payment']);
  }

  // redirect to calculate shipping on initial load
  if ( !$_SESSION['shipping'] || ( $_SESSION['shipping'] && ($_SESSION['shipping'] == false) && (zen_count_shipping_modules() > 1) ) ) {
    $_SESSION['shipping'] = $shipping_modules->cheapest();
    if (!($messageStack->size('checkout_payment') > 0) && !($messageStack->size('checkout_shipping') > 0) && !($messageStack->size('redemptions') > 0) && $_SESSION['shipping']) {
      zen_redirect(zen_href_link(FILENAME_CHECKOUT, zen_get_all_get_params(), 'SSL'));
    }
  }

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total();
  $order_total_modules->collect_posts();
  $order_total_modules->pre_confirmation_check();

  if ($credit_covers) {
    unset($_SESSION['payment']);
  } 

  // get coupon code
  if ($_SESSION['cc_id']) {
    $discount_coupon_query = "SELECT coupon_code
                              FROM " . TABLE_COUPONS . "
                              WHERE coupon_id = :couponID";

    $discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
    $discount_coupon = $db->Execute($discount_coupon_query);
  }
  // load all enabled shipping modules
  if ( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') ) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
      case 'national':
        if ($order->delivery['country_id'] == STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'international':
        if ($order->delivery['country_id'] != STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'both':
        $pass = true;
        break;
    }

    $free_shipping = false;
    if ( ($pass == true) && ($_SESSION['cart']->show_total() >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {
      $free_shipping = true;
    }
  } else {
    $free_shipping = false;
  }

  // Should address-edit button be offered?
  $displayAddressEdit = (MAX_ADDRESS_BOOK_ENTRIES >= 2);

  // if shipping-edit button should be overridden, do so
  $editShippingButtonLink = zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');
  if (isset($_SESSION['payment']) && method_exists($$_SESSION['payment'], 'alterShippingEditButton')) {
    $theLink = $$_SESSION['payment']->alterShippingEditButton();
    if ($theLink) {
      $editShippingButtonLink = $theLink;
      $displayAddressEdit = true;
    }
  }
  
  $comments = $_SESSION['comments'];
  $flagOnSubmit = sizeof($payment_modules->selection());

  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

  if (isset($_POST['payment'])) $_SESSION['payment'] = $_POST['payment'];
  if (isset($_POST['comments'])) $_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);

  // update customers_referral with $_SESSION['gv_id']
  if ($_SESSION['cc_id']) {
    $discount_coupon_query = "SELECT coupon_code
                              FROM " . TABLE_COUPONS . "
                              WHERE coupon_id = :couponID";

    $discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
    $discount_coupon = $db->Execute($discount_coupon_query);

    $customers_referral_query = "SELECT customers_referral
                                 FROM " . TABLE_CUSTOMERS . "
                                 WHERE customers_id = :customersID";

    $customers_referral_query = $db->bindVars($customers_referral_query, ':customersID', $_SESSION['customer_id'], 'integer');
    $customers_referral = $db->Execute($customers_referral_query);

    // only use discount coupon if set by coupon
    if ($customers_referral->fields['customers_referral'] == '' and CUSTOMERS_REFERRAL_STATUS == 1) {
      $sql = "UPDATE " . TABLE_CUSTOMERS . "
              SET customers_referral = :customersReferral
              WHERE customers_id = :customersID";

      $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
      $sql = $db->bindVars($sql, ':customersReferral', $discount_coupon->fields['coupon_code'], 'string');
      $db->Execute($sql);
    } else {
      // do not update referral was added before
    }
  }
  
  
  //coupon process function
  
  if($_POST['dc_redeem_code']){
  
  
  	$varPromotion_Code =  zen_db_prepare_input($_POST['dc_redeem_code']);
  
  
  	$discount_coupon_query = "SELECT coupon_id, coupon_amount, coupon_type, coupon_minimum_order, uses_per_coupon, uses_per_user,
  
                						 restrict_to_products, restrict_to_categories, coupon_zone_restriction
  
  							  FROM " . TABLE_COUPONS . "
  
  							  WHERE coupon_code = :couponID and coupon_start_date <= now() and coupon_expire_date >= now()";
  
  	$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $varPromotion_Code, 'string');
  
  	$discount_coupon = $db->Execute($discount_coupon_query);
  
  	if($discount_coupon->RecordCount() < 1)
  	{
  		//     			unset($_SESSION['promotion_code']);
  		//     			unset($_SESSION['discount_in_cart']);
  		//     			unset($_SESSION['total_in_cart']);
  		//     			unset($_SESSION['cc_id']);
  
  		//     			$strDiscountCoupon = '';
  		//     			$strDiscountCoupon .= '<b><br class="clearBoth" />';
  		//     			$strDiscountCoupon .= '<div style="float:right;">';
  		//     			$strDiscountCoupon .= 'Invalid Coupon Code';
  		//     			$strDiscountCoupon .= '</div>';
  		//     			$strDiscountCoupon .= '<br class="clearBoth" /></b>';
  		$arrresult=array('stute'=>false,
  				'msg'=>"Invalid Coupon Code"
  		);
  		echo json_encode($arrresult);
  		die();
  
  		 
  	}
  	else if ($_SESSION['cart']->total < $discount_coupon->fields['coupon_minimum_order'])
  	{
  
  
  		$strDiscountCoupon =  'The minimum redeem amount for this coupon should be' . $currencies->format($discount_coupon->fields['coupon_minimum_order']);
  
  		$arrresult=array('stute'=>false,
  				'msg'=>$strDiscountCoupon
  		);
  		echo json_encode($arrresult);
  		die();
  
  
  
  	}
  	else
  	{
  
  
  
  		// JTD - added missing code here to handle coupon product restrictions
  
  		// look through the items in the cart to see if this coupon is valid for any item in the cart
  
  		$products = $_SESSION['cart']->get_products();
  
  
  
  		$valid_products_total = 0;
  
  		for ($i=0; $i<sizeof($products); $i++) {
  			if (is_product_valid($products[$i]['id'], $discount_coupon->fields['coupon_id']))
  				$valid_products_total += $products[$i]['final_price'] * $products[$i]['quantity'];
  		}
  
  
  
  		if($valid_products_total == 0)
  		{
  
  			$strDiscountCoupon =  'None of this products are valid for given coupon code';
  
  			$arrresult=array('stute'=>false,
  					'msg'=>$strDiscountCoupon
  			);
  			echo json_encode($arrresult);
  			die();
  
  		}
  		else
  		{
  
  			if ($discount_coupon->fields['coupon_type'] == 'P') {
  				$discount = round($valid_products_total * ($discount_coupon->fields['coupon_amount'] / 100), 2);
  				$discount = ($valid_products_total > $discount) ? $discount : $valid_products_total;
  			} elseif ($discount_coupon->fields['coupon_type'] == 'F') {
  				$discount = $discount_coupon->fields['coupon_amount'] * ($valid_products_total > 0); // multiple by 1 if total is greater than 0
  				$discount = ($valid_products_total > $discount) ? $discount : $valid_products_total;
  			}
  
  			$total = (float)$_SESSION['cart']->total - $discount;
  
  			//     				$_SESSION['cc_id'] = $discount_coupon->fields['coupon_id'];
  
  			$coucode = $varPromotion_Code;
  
  			$coudiscount = $currencies->format($discount);
  
  			if($discount > (float)$_SESSION['cart']->total)
  				$total_in_cart = $currencies->format(0);
  			else
  				$total_in_cart = $currencies->format($total);
  
  
  			//     				$strDiscountCoupon = '';
  			//     				$strDiscountCoupon .= '<b><br class="clearBoth" />';
  			//     				$strDiscountCoupon .= '<div id="otcoupon">';
  			//     				$strDiscountCoupon .= '<div class="totalBox larger forward">-' . $_SESSION['discount_in_cart'] . '</div>';
  			//     				$strDiscountCoupon .= '<div class="lineTitle larger forward">Discount for Code (' . $_SESSION['promotion_code'] . '):</div>';
  			//     				$strDiscountCoupon .= '</div><br class="clearBoth" />';
  			//     				$strDiscountCoupon .= '<div id="ottotal">';
  			//     				$strDiscountCoupon .= '<div class="totalBox larger forward">' . $_SESSION['total_in_cart'] . '</div>';
  			//     				$strDiscountCoupon .= '<div class="lineTitle larger forward">Total:</div>';
  			//     				$strDiscountCoupon .= '</div>';
  			//     				$strDiscountCoupon .= '<br class="clearBoth" /></b>';
  			$arrresult=array('stute'=>true,
  					'msg'=>Null,
  					'discount'=>$coudiscount,
  					'code'=>$coucode,
  					'total'=>$total_in_cart
  			);
  			echo json_encode($arrresult);
  			die();
  
  
  
  		}//else valid total ends
  	} //else coupon applying ends
  	exit();
  
  }

  // initialize modules
  $qc_init_dir_full = DIR_FS_CATALOG . DIR_WS_MODULES . 'quick_checkout_init/';
  $qc_init_dir = DIR_WS_MODULES . 'quick_checkout_init/';
  if ($dir = @dir($qc_init_dir_full)) {
    while ($file = $dir->read()) {
      if (!is_dir($qc_init_dir_full . $file)) {
        if (preg_match('/\.php$/', $file) > 0) {
          //include init file
          include($qc_init_dir . $file);
        }
      }
    }
    $dir->close();
  }

  switch ($_GET['fecaction']) {
  case 'update':
    $bool = true; //tell a freand
    $form_action_url = zen_href_link(FILENAME_CHECKOUT, '', 'SSL');
    if (zen_not_null($_POST['comments'])) {
      $_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);
    }
    $comments = $_SESSION['comments'];
    // process modules
    $qc_process_dir_full = DIR_FS_CATALOG . DIR_WS_MODULES . 'quick_checkout_process/';
    $qc_process_dir = DIR_WS_MODULES . 'quick_checkout_process/';
    if ($dir = @dir($qc_process_dir_full)) {
      while ($file = $dir->read()) {
        if (!is_dir($qc_process_dir_full . $file)) {
          if (preg_match('/\.php$/', $file) > 0) {
            //include init file
            include($qc_process_dir . $file);
          }
        }
      }
      $dir->close();
    }

    if ( (zen_count_shipping_modules() > 0) || ($free_shipping == true) ) {
      if ( (isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')) ) {
        $_SESSION['shipping'] = $_POST['shipping']; // process shipping
        list($module, $method) = explode('_', $_SESSION['shipping']);
        if ( is_object($$module) || ($_SESSION['shipping'] == 'free_free') ) {
          if ($_SESSION['shipping'] == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else if ($_SESSION['shipping'] == 'tellafriend_tellafriend') { //bof tell a frend
            foreach($_POST["tell_a_friend_email"] as $key => $email) {
              $_POST["tell_a_friend_email"][$key] = trim(strtolower($email));
              $_POST["tell_a_friend_email_f_name"][$key] = trim($_POST["tell_a_friend_email_f_name"][$key]);
              $_POST["tell_a_friend_email_l_name"][$key] = trim($_POST["tell_a_friend_email_l_name"][$key]);
            }

            $tell_a_friend_email = $_POST["tell_a_friend_email"];
            $tell_a_friend_email = array_unique($tell_a_friend_email);

            $un_bool = true;
            foreach($tell_a_friend_email as $key => $email) {
              if(trim($email) == "")  {
                $tell_a_friend_email_error .= "Please fill all of the email fields before selecting this shipping method.<br>";
                $bool = false;
              } else if(!preg_match("/^[a-z0-9]+[a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,6}$/i", trim($email))) {
                $tell_a_friend_email_error .= "$email is not properly formed.<br>";
                $bool = false;
              } else if (is_object($captcha) && !$captcha->validateCaptchaCode()) { //add if for CAPTCHA check
                $tell_a_friend_email_error .= ERROR_CAPTCHA;
                $bool = false;
              } else {
                $query = "select * from " . TABLE_FREE_SHIPPING_REFERRALS . " where referral_to_address = '$email'";
                $result = mysql_query($query);
                if(mysql_num_rows($result) > 0)
                {
                  //$tell_a_friend_email_error .= "$email is already in database.<br>";
                  if($un_bool)
                  {
                    $tell_a_friend_email_error .= "Please make each email address unique.<br>";
                    $un_bool = false;
                  }
                  $tell_a_friend_email_error .= "$email, is already in use.<br>";
                  $tell_a_friend_email[$key] = "";
                  $bool = false;
                }
              }
            }

            $_SESSION["tell_a_friend_email"] = "";
            $_SESSION["tell_a_friend_email"] = $tell_a_friend_email;
            $_SESSION["tell_a_friend_email_f_name"] = $_POST["tell_a_friend_email_f_name"];
            $_SESSION["tell_a_friend_email_l_name"] = $_POST["tell_a_friend_email_l_name"];

            if(count($tell_a_friend_email) < zen_get_configuration_key_value("MODULE_SHIPPING_TELL_A_FRIEND_NO_OF_EMAILS"))
            {
              $tell_a_friend_email_error .= "Please fill all the email fields.<br>";
              $bool = false;
            }
            if ($tell_a_friend_email_error != '') {
              $messageStack->add_session('checkout_shipping', $tell_a_friend_email_error, 'error');
              $_SESSION['shipping'] = $shipping_modules->cheapest();
              zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
            }
            if($bool)
            {
              $quote = $shipping_modules->quote($method, $module);
            }
            //eof tell a freand
          } else {
            // avoid incorrect calculations during redirect
            $shipping_modules = new shipping();
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            $_SESSION['shipping'] = '';
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $_SESSION['shipping'] = array('id' => $_SESSION['shipping'],
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);
                zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'fecaction=null', 'SSL'));
            }
          }
        } else {
          $_SESSION['shipping'] = false;
        }
      }
    } else {
      $_SESSION['shipping'] = false;
	    zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
    }
    break;
    case 'ajaxupdate':
    	$bool = true; //tell a freand
    	$form_action_url = zen_href_link(FILENAME_CHECKOUT, '', 'SSL');
//     	if (zen_not_null($_GET['comments'])) {
//     		$_SESSION['comments'] = zen_db_prepare_input($_GET['comments']);
//     	}
//     	$comments = $_SESSION['comments'];
    	// process modules
    	$qc_process_dir_full = DIR_FS_CATALOG . DIR_WS_MODULES . 'quick_checkout_process/';
    	$qc_process_dir = DIR_WS_MODULES . 'quick_checkout_process/';
    	if ($dir = @dir($qc_process_dir_full)) {
    		while ($file = $dir->read()) {
    			if (!is_dir($qc_process_dir_full . $file)) {
    				if (preg_match('/\.php$/', $file) > 0) {
    					//include init file
    					include($qc_process_dir . $file);
    				}
    			}
    		}
    		$dir->close();
    	}

    
    	if ( (zen_count_shipping_modules() > 0) || ($free_shipping == true) ) {
    		
    		if (isset($_GET['id'])&&($_GET['id'])){
    			$addid=(int)zen_db_prepare_input($_GET['id']);
    			global $db;
    		$sql = "update " . TABLE_CUSTOMERS . "
	              set customers_default_address_id = :addressid
	              where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
    		$sql = $db->bindVars($sql, ':addressid', $addid, 'integer');
    		$db->Execute($sql);
    		$_SESSION['customer_default_address_id']=$addid;
    		$_SESSION['cart_address_id']=$addid;
    		$_SESSION['sendto']=$addid; 
    		$_SESSION['billto']=$addid;
    		$sqla="SELECT entry_country_id,entry_zone_id,entry_state
                           FROM " . TABLE_ADDRESS_BOOK . "
                           WHERE address_book_id = :addresssid";
    		$sqla = $db->bindVars($sqla, ':addresssid', $addid, 'integer');
    		$adddates=$db->Execute($sqla);
                  
    		$addary=$adddates->fields;
    		$_SESSION['customer_country_id']=$addary['entry_country_id'];
    		$_SESSION['customer_zone_id']=$addary['entry_zone_id'];    		    		
    		}


    		if ( (isset($_GET['shipping'])) && (strpos($_GET['shipping'], '_')) ) {

    			$_SESSION['shipping'] = $_GET['shipping']; // process shipping


    			list($module, $method) = explode('_', $_SESSION['shipping']);

    			if ( is_object($$module) || ($_SESSION['shipping'] == 'free_free') ) {
    				if ($_SESSION['shipping'] == 'free_free') {
    					$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
    					$quote[0]['methods'][0]['cost'] = '0';
    				} else if ($_SESSION['shipping'] == 'tellafriend_tellafriend') { //bof tell a frend
//     					foreach($_GET["tell_a_friend_email"] as $key => $email) {
//     						$_POST["tell_a_friend_email"][$key] = trim(strtolower($email));
//     						$_POST["tell_a_friend_email_f_name"][$key] = trim($_POST["tell_a_friend_email_f_name"][$key]);
//     						$_POST["tell_a_friend_email_l_name"][$key] = trim($_POST["tell_a_friend_email_l_name"][$key]);
//     					}
    
//     					$tell_a_friend_email = $_POST["tell_a_friend_email"];
//     					$tell_a_friend_email = array_unique($tell_a_friend_email);
    
//     					$un_bool = true;
//     					foreach($tell_a_friend_email as $key => $email) {
//     						if(trim($email) == "")  {
//     							$tell_a_friend_email_error .= "Please fill all of the email fields before selecting this shipping method.<br>";
//     							$bool = false;
//     						} else if(!preg_match("/^[a-z0-9]+[a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,6}$/i", trim($email))) {
//     							$tell_a_friend_email_error .= "$email is not properly formed.<br>";
//     							$bool = false;
//     						} else if (is_object($captcha) && !$captcha->validateCaptchaCode()) { //add if for CAPTCHA check
//     							$tell_a_friend_email_error .= ERROR_CAPTCHA;
//     							$bool = false;
//     						} else {
//     							$query = "select * from " . TABLE_FREE_SHIPPING_REFERRALS . " where referral_to_address = '$email'";
//     							$result = mysql_query($query);
//     							if(mysql_num_rows($result) > 0)
//     							{
//     								//$tell_a_friend_email_error .= "$email is already in database.<br>";
//     								if($un_bool)
//     								{
//     									$tell_a_friend_email_error .= "Please make each email address unique.<br>";
//     									$un_bool = false;
//     								}
//     								$tell_a_friend_email_error .= "$email, is already in use.<br>";
//     								$tell_a_friend_email[$key] = "";
//     								$bool = false;
//     							}
//     						}
//     					}
    
//     					$_SESSION["tell_a_friend_email"] = "";
//     					$_SESSION["tell_a_friend_email"] = $tell_a_friend_email;
//     					$_SESSION["tell_a_friend_email_f_name"] = $_POST["tell_a_friend_email_f_name"];
//     					$_SESSION["tell_a_friend_email_l_name"] = $_POST["tell_a_friend_email_l_name"];
    
//     					if(count($tell_a_friend_email) < zen_get_configuration_key_value("MODULE_SHIPPING_TELL_A_FRIEND_NO_OF_EMAILS"))
//     					{
//     						$tell_a_friend_email_error .= "Please fill all the email fields.<br>";
//     						$bool = false;
//     					}
//     					if ($tell_a_friend_email_error != '') {
//     						$messageStack->add_session('checkout_shipping', $tell_a_friend_email_error, 'error');
//     						$_SESSION['shipping'] = $shipping_modules->cheapest();
//     						zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
//     					}
//     					if($bool)
//     					{
//     						$quote = $shipping_modules->quote($method, $module);
//     					}
    					//eof tell a freand
    				} else {
    					// avoid incorrect calculations during redirect
    					$shipping_modules = new shipping();
    					$quote = $shipping_modules->quote($method, $module);
    					
    				}
    				if (isset($quote['error'])) {
    					$_SESSION['shipping'] = '';
    				} else {
    					if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
    						$_SESSION['shipping'] = array('id' => $_SESSION['shipping'],
    								'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
    								'cost' => $quote[0]['methods'][0]['cost']);
    						//zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'fecaction=null', 'SSL'));
    					
    					
//     						if (MODULE_ORDER_TOTAL_INSTALLED) {
//     							$order_totals = $order_total_modules->process();
//     							$shipcost=$order_total_modules->outputstring();
//     						}
//     						print_r($order_totals);
   


    						
    						$arrresult=array('stute'=>true,
    								'detail'=>$_SESSION['shipping']
    						);
    						echo json_encode($arrresult);
    						exit();
    					}
    				}
    			} else {
    				$_SESSION['shipping'] = false;
    			}
    		}
    	} else {
    		$_SESSION['shipping'] = false;
    		//zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
    	}
    	break;
  case 'submit':
    if (isset($$_SESSION['payment']->form_action_url)) {
	    $form_action_url = $$_SESSION['payment']->form_action_url;
    } else {
	  $form_action_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
    }
    // process comments
	  if (zen_not_null($_POST['comments'])) {
      $_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);
    }
    $comments = $_SESSION['comments'];

    // BEGIN FEC v1.24a DROP DOWN
    if (FEC_DROP_DOWN == 'true') {
      if (zen_not_null($_POST['dropdown'])) {
        $_SESSION['dropdown'] = zen_db_prepare_input($_POST['dropdown']);
      }
      $dropdown = $_SESSION['dropdown'];
    }
    if (FEC_GIFT_MESSAGE == 'true') {
      if (zen_not_null($_POST['gift-message'])) {
        $_SESSION['gift-message'] = zen_db_prepare_input($_POST['gift-message']);
      }
      $gift_message = $_SESSION['gift-message'];
    }
    // END DROP DOWN

    // BEGIN OPTIONAL CHECKBOX
    if (FEC_CHECKBOX == 'true') {
      if (zen_not_null($_POST['fec_checkbox'])) {
        $_SESSION['fec_checkbox'] = $_POST['fec_checkbox'];
      } else {
        unset($_SESSION['fec_checkbox']);
      }
    }

    // process shipping
    if ( (zen_count_shipping_modules() > 0) || ($free_shipping == true) ) {
      if ( (isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')) ) {
        $_SESSION['shipping'] = $_POST['shipping']; // process shipping
        list($module, $method) = explode('_', $_SESSION['shipping']);
        if ( is_object($$module) || ($_SESSION['shipping'] == 'free_free') ) {
          if ($_SESSION['shipping'] == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            $_SESSION['shipping'] = '';
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $_SESSION['shipping'] = array('id' => $_SESSION['shipping'],
                                            'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                            'cost' => $quote[0]['methods'][0]['cost']);

                if (isset($$_SESSION['payment']->form_action_url)) {
  			          zen_redirect($$_SESSION['payment']->form_action_url);
  		  	      } else {
  			          zen_redirect(zen_href_link(FILENAME_CHECKOUT_PROCESS, 'ajax=off', 'SSL'));
  		          }

            }
          }
        } else {
          $_SESSION['shipping'] = false;
        }
      }
    } else {
      $_SESSION['shipping'] = false;

        if (isset($$_SESSION['payment']->form_action_url)) {
  	      zen_redirect($$_SESSION['payment']->form_action_url);
  	    } else {
  	      zen_redirect(zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL'));
        }
    }
    break;
  case 'null':
    $form_action_url = zen_href_link($checkout_confirmation, 'fecaction=process', 'SSL');
    break;
  default:
    $form_action_url = zen_href_link(FILENAME_CHECKOUT, 'fecaction=null', 'SSL');
    if (!($messageStack->size('checkout_payment') > 0) && !($messageStack->size('checkout_shipping') > 0) && !($messageStack->size('redemptions') > 0) ) {
      zen_redirect($form_action_url);
    }
    $form_action_url = zen_href_link($checkout_confirmation, 'fecaction=process', 'SSL');
    break;
  }

  $breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
  // last line of script
  $zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT');
?>