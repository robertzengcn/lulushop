<?php
/**
 * Login Page
 *
 * @package page
 * @copyright Copyright 2007-2008 Numinix http://www.numinix.com
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3 2010-09-18 00:29:43Z numinix $
 */






// This should be first line of the script:
//$zco_notifier->notify('NOTIFY_HEADER_START_LOGIN');
//$zco_notifier->notify('NOTIFY_HEADER_START_EASY_SIGNUP');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
// if ($session_started == false) {
//   zen_redirect(zen_href_link(FILENAME_COOKIE_USAGE));
// }

// if the customer is logged in already, redirect them to the My account page
// if (isset($_SESSION['customer_id']) and $_SESSION['customer_id'] != '') {
//   zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
// }

 require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
 
 if (!defined('IS_ADMIN_FLAG')) {
 	die('Illegal Access');
 }
 
// include(DIR_WS_MODULES . zen_get_module_directory('fec_create_account.php'));

$error = false;
$plaintext="";
$encrypted="";
$iv="";
$key="";
$error = false;
$newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' || ACCOUNT_NEWSLETTER_STATUS == '0' ? false : true);
 if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
$encrypted=base64_decode($_POST['date']);
$iv=base64_decode($_POST['iv']);
$key=base64_decode($_POST['key']);


if(isset($_POST['date'])&&isset($_POST['iv'])&&isset($_POST['key'])){
$plaintext = rtrim(mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv ), "\0..\32");
}


// $arrdate=array('pass'=>$plaintext);
// echo json_encode($arrdate);
// exit();
	


//         $plaintext = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv ), "\t\0 " );
//        $arrdate=array(pass=>$plaintext);
//        echo json_encode($arrdate);
//        exit();
	
  $email_address = zen_db_prepare_input($_POST['email_address']);
  $password = zen_db_prepare_input($plaintext);
 
  if ( ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) && (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3.8)) ) {
    $error = true;
    $errormsg=ERROR_SECURITY_ERROR;
    //$messageStack->add('login', ERROR_SECURITY_ERROR);
  } else {

    // Check if email exists
    $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
                                    customers_email_address, customers_default_address_id,
                                    customers_authorization, customers_referral
                           FROM " . TABLE_CUSTOMERS . "
                           WHERE customers_email_address = :emailAddress
                           AND COWOA_account != 1";

    $check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
    $check_customer = $db->Execute($check_customer_query);

    if (!$check_customer->RecordCount()) {
      $error = true;
      $errormsg=TEXT_LOGIN_ERROR;
    } elseif ($check_customer->fields['customers_authorization'] == '4') {
      // this account is banned
      //$zco_notifier->notify('NOTIFY_LOGIN_BANNED');
      $errormsg=TEXT_LOGIN_BANNED;
    } else {
      // Check that password is good
      if (FEC_MASTER_PASSWORD == 'true' && version_compare(PROJECT_VERSION_MAJOR.".".PROJECT_VERSION_MINOR, "1.5.0") >= 0) {
        // *** start Encrypted Master Password by stagebrace ***
        $get_admin_query = "SELECT admin_id, admin_pass, admin_profile
                            FROM " . TABLE_ADMIN . "
                            WHERE admin_profile = '1' ";
        $check_administrator = $db->Execute($get_admin_query);
        // master password third party plugin
        if (defined('MASTER_PASS') && MASTER_PASS == $password) {
          $administrator = true;
          $ProceedToLogin = true; 
		} else {
		  // encrypted master password plugin
          while(!$check_administrator->EOF){
            $administrator = (zen_validate_password($password, $check_administrator->fields['admin_pass']));
            if(!$administrator){
              $check_administrator->MoveNext();
            } else {
              $administrator = true;
              $ProceedToLogin = true;
              break;
		    }
      	  }
		}
	  }
	  // if admin login didn't work, try the customer
	  if (!$ProceedToLogin) {
	    $customer = (zen_validate_password($password, $check_customer->fields['customers_password']));
        if ($customer) {
          $ProceedToLogin = true;
        }
	  }
      if (!$ProceedToLogin) {
        $error = true;
        $errormsg=TEXT_LOGIN_ERROR;
         $msgarray=array('stuate'=>false,
  		     'errmsg'=>$errormsg
);
  echo json_encode($msgarray);
exit();
      } else {
      	
        if (SESSION_RECREATE == 'True') {
          zen_session_recreate();
        }

        $check_country_query = "SELECT entry_country_id, entry_zone_id
                              FROM " . TABLE_ADDRESS_BOOK . "
                              WHERE customers_id = :customersID
                              AND address_book_id = :addressBookID";

        $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
        $check_country_query = $db->bindVars($check_country_query, ':addressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
        $check_country = $db->Execute($check_country_query);

        $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
        // modified for FEC
        $_SESSION['sendto'] = $_SESSION['cart_address_id'] = $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
        
        $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
        $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
        $_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
        $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
        $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];

        $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
              SET customers_info_date_of_last_logon = now(),
                  customers_info_number_of_logons = customers_info_number_of_logons+1
              WHERE customers_info_id = :customersID";

        $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
        $db->Execute($sql);
        //$zco_notifier->notify('NOTIFY_LOGIN_SUCCESS');

        
        

        // bof: contents merge notice
        // save current cart contents count if required
//         if (SHOW_SHOPPING_CART_COMBINED > 0) {
//           $zc_check_basket_before = $_SESSION['cart']->count_contents();
//         }

//         // bof: not require part of contents merge notice
//         // restore cart contents
//         $_SESSION['cart']->restore_contents();
        // eof: not require part of contents merge notice

        // check current cart contents count if required
//         if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
//           $zc_check_basket_after = $_SESSION['cart']->count_contents();
//           if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
//             if (SHOW_SHOPPING_CART_COMBINED == 2) {
//               // warning only do not send to cart
//               $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
//             }
//             if (SHOW_SHOPPING_CART_COMBINED == 1) {
//               // show warning and send to shopping cart for review
//               $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
//               zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
//             }
//           }
//         }
        // eof: contents merge notice

        if (sizeof($_SESSION['navigation']->snapshot) > 0) {
          //    $back = sizeof($_SESSION['navigation']->path)-2;
          //if (isset($_SESSION['navigation']->path[$back]['page'])) {
          //    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
          
          //$origin_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
          //            $origin_href = zen_back_link_only(true);
          //$snappages=$_SESSION['navigation']->snapshot['page'];
//          if($snappages=='product_info'){
//          	zen_genredirect($origin_href);
//          }else{
//          	zen_redirect($origin_href);
//          }
         
       // header("Content-type: text/html; charset=utf-8");

                            
          $_SESSION['navigation']->clear_snapshot();
          $msgarray=array('stuate'=>true,
          		'errmsg'=>null
          
          );
          echo json_encode($msgarray);
          exit();

         
//           zen_redirect($origin_href);
          
        } else {
          //zen_redirect(zen_href_link(FILENAME_DEFAULT, '', $request_type));
        }
      }
    }
  }
  if ($error == true) {
  	//$zco_notifier->notify('NOTIFY_LOGIN_FAILURE');
  	$msgarray=array('stuate'=>false,
  			'errmsg'=>$errormsg
  	);
  	echo json_encode($msgarray);
  	exit();
  }
}
if(isset($_POST['action']) && ($_POST['action'] == 'register')){
	
	$encrypted=base64_decode($_POST['date']);
	$iv=base64_decode($_POST['iv']);
	$key=base64_decode($_POST['key']);
	if(isset($_POST['date'])&&isset($_POST['iv'])&&isset($_POST['key'])){		
	$plaintext = rtrim(mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv ), "\0..\32");
	$password = zen_db_prepare_input($plaintext);
	}else{
		$error = true;
			$errormsg="the code is not enough";
	}	


	$process = true;
	$antiSpam = isset($_POST['should_be_empty']) ? zen_db_prepare_input($_POST['should_be_empty']) : '';
	$zco_notifier->notify('NOTIFY_CREATE_ACCOUNT_CAPTCHA_CHECK');
	$firstname = zen_db_prepare_input(zen_sanitize_string($_POST['firstname']));
	$lastname = zen_db_prepare_input(zen_sanitize_string($_POST['lastname']));
	
	if (isset($_POST['email_address'])) {
		$email_address = zen_db_prepare_input($_POST['email_address']);		
	}
	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;
		$errormsg=ENTRY_EMAIL_ADDRESS_ERROR;
	} elseif (zen_validate_email($email_address) == false) {
		$error = true;
		$errormsg=ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
	} else {
		$check_email_query = "select count(*) as total
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input($email_address) . "'";
		$check_email = $db->Execute($check_email_query);
	
		if ($check_email->fields['total'] > 0) {
			$error = true;
			$errormsg=ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
		}
	}
	
	if ($error == true) {
		// hook notifier class
		$zco_notifier->notify('NOTIFY_FAILURE_DURING_CREATE_ACCOUNT');
		         $msgarray=array('stuate'=>false,
  		                         'errmsg'=>$errormsg);
		         echo json_encode($msgarray);
		         exit();
		
	} elseif ($antiSpam != '') {
		$zco_notifier->notify('NOTIFY_SPAM_DETECTED_DURING_CREATE_ACCOUNT');
		$messageStack->add_session('header', (defined('ERROR_CREATE_ACCOUNT_SPAM_DETECTED') ? ERROR_CREATE_ACCOUNT_SPAM_DETECTED : 'Thank you, your account request has been submitted for review.'), 'success');
		$msgarray=array('stuate'=>false,
				'errmsg'=>$errormsg);
		echo json_encode($msgarray);
		exit();
		//zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
	} else {
		$newsletter = 1;
		$email_format="TEXT";
		
		$sql_data_array = array('customers_firstname' => $firstname,
				'customers_lastname' => $lastname,
				'customers_email_address' => $email_address,				
				'customers_newsletter' => (int)$newsletter,
				'customers_email_format' => $email_format,
				'customers_default_address_id' => 0,
				'customers_password' => zen_encrypt_password($password),
				'customers_authorization' => (int)CUSTOMERS_APPROVAL_AUTHORIZATION
		);
	
		if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')) $sql_data_array['customers_referral'] = $customers_referral;
		//if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = (empty($_POST['dob']) || $dob_entered == '0001-01-01 00:00:00' ? zen_db_prepare_input('0001-01-01 00:00:00') : zen_date_raw($_POST['dob']));
	
		zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	
		$_SESSION['customer_id'] = $db->Insert_ID();
	
		$zco_notifier->notify('NOTIFY_MODULE_CREATE_ACCOUNT_ADDED_CUSTOMER_RECORD', array_merge(array('customer_id' => $_SESSION['customer_id']), $sql_data_array));
	
		$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created, customers_info_date_of_last_logon)
              values ('" . (int)$_SESSION['customer_id'] . "', '1', now(), now())";
		$customers_authorization = CUSTOMERS_APPROVAL_AUTHORIZATION;
		$db->Execute($sql);
		
		if (SESSION_RECREATE == 'True') {
			zen_session_recreate();
		}
		
		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customers_authorization'] = $customers_authorization;
		
		// restore cart contents
		$_SESSION['cart']->restore_contents();
		
		// hook notifier class
		$zco_notifier->notify('NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT');
		
		$msgarray=array('stuate'=>true,
				'errmsg'=>null);
		echo json_encode($msgarray);
		exit();

			
	}	
}

exit();


?>