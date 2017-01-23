<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
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
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
//  $Id: alipay.php v1.5.1 2013-05-31 AdamGuan $
//



require_once(DIR_FS_CATALOG.DIR_WS_INCLUDES.'alipay.config.php');

//require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'alipay_submit.class.php');

 class alipay {
   var $code, $title, $description, $enabled;
  /**
   * order status setting for pending orders
   *
   * @var int
   */
   var $order_pending_status = 1;
  /**
   * order status setting for completed orders
   *
   * @var int
   */
   var $order_status = DEFAULT_ORDERS_STATUS_ID;


// class constructor
   function alipay() {
     global $order;
       $this->code = 'alipay';
    if ($_GET['main_page'] != '') {
       $this->title = MODULE_PAYMENT_ALIPAY_TEXT_CATALOG_TITLE; // Payment Module title in Catalog
    } else {
       $this->title = MODULE_PAYMENT_ALIPAY_TEXT_ADMIN_TITLE; // Payment Module title in Admin
    }
       $this->description = MODULE_PAYMENT_ALIPAY_TEXT_DESCRIPTION;
       $this->sort_order = MODULE_PAYMENT_ALIPAY_SORT_ORDER;
       $this->enabled = ((MODULE_PAYMENT_ALIPAY_STATUS == 'True') ? true : false);
       if ((int)MODULE_PAYMENT_ALIPAY_ORDER_STATUS_ID > 0) {
         $this->order_status = MODULE_PAYMENT_ALIPAY_ORDER_STATUS_ID;
       }
       if (is_object($order)) $this->update_status();
       $this->form_action_url = MODULE_PAYMENT_ALIPAY_HANDLER;

   }

// class methods
   function update_status() {
     global $order, $db;     
     if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_ALIPAY_ZONE > 0) ) {
       $check_flag = false;
       $check_query = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_ALIPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
       while (!$check_query->EOF) {
         if ($check_query->fields['zone_id'] < 1) {
           $check_flag = true;
           break;
         } elseif ($check_query->fields['zone_id'] == $order->billing['zone_id']) {
           $check_flag = true;
           break;
         }
                 $check_query->MoveNext();
       }

       if ($check_flag == false) {
         $this->enabled = false;
       }
     }
   }

   function javascript_validation() {
     return false;
   }

   function selection() {
     return array('id' => $this->code,
                   'module' => MODULE_PAYMENT_ALIPAY_TEXT_CATALOG_LOGO,
                   'icon' => MODULE_PAYMENT_ALIPAY_TEXT_CATALOG_LOGO
                   );
   }

   function pre_confirmation_check() {
     return false;
   }

   function confirmation() {
      return array('title' => MODULE_PAYMENT_ALIPAY_TEXT_DESCRIPTION);
   }
   
   /*
    * 插入订单表的代码位置
    * return $order_id
    * */
   
   function beforemakepay($customerid,$customername,$sendto,$currency,$ordertotal,$orderip,$order_stute=1){
   	global $db;
   	
   	$customsql="SELECT * FROM " . TABLE_CUSTOMERS . "
                           WHERE customers_id = :customers_id";
   	$customsql  =$db->bindVars($customsql, ':customers_id', $customerid, 'integer');
   	$customdetail = $db->Execute($customsql);
   	//$customdetail->fields['customers_email_address'];

   //echo $customdetail->fields['customers_email_address'];

   
   	$sendaddress = "SELECT * FROM " . TABLE_ADDRESS_BOOK . "
                           WHERE address_book_id = :address_book_id";
   	$sendaddress  =$db->bindVars($sendaddress, ':address_book_id', $sendto, 'integer');
   	$sendaddressdetail = $db->Execute($sendaddress);
   if($sendaddressdetail->fields['entry_country_id']!=0||$sendaddressdetail->fields['entry_country_id']!=null||$sendaddressdetail->fields['entry_country_id']!=44){
   	$sendcountrysql ="SELECT countries_name FROM ".TABLE_COUNTRIES." WHERE countries_id =:countries_id";
   	$sendcountrysql  =$db->bindVars($sendcountrysql, ':countries_id', $sendaddressdetail->fields['entry_country_id'], 'integer');
   	$sendcountrydetail=$db->Execute($sendcountrysql);
   	$country=$sendcountrydetail->fields['countries_name'];

   }else{
   	$country="中国";
   }
   
   	$currencysql="SELECT value from ".TABLE_CURRENCIES." WHERE code =:code";
   	$currencysql  =$db->bindVars($currencysql, ':code', $currency, 'string');
   	$currencydetail = $db->Execute($currencysql);


   

   	
   	$sql_data_array=array(array('fieldName'=>'customers_id', 'value'=>(int)$customerid, 'type'=>'integer'),
   			array('fieldName'=>'customers_name', 'value'=>$customername, 'type'=>'string'),
   			array('fieldName'=>'customers_street_address', 'value'=>$sendaddressdetail->fields['entry_street_address'], 'type'=>'string'),
   			array('fieldName'=>'customers_city', 'value'=>$sendaddressdetail->fields['entry_city'], 'type'=>'string'),
   			array('fieldName'=>'customers_postcode', 'value'=>$sendaddressdetail->fields['entry_postcode'], 'type'=>'string'),
   			array('fieldName'=>'customers_country', 'value'=>$country, 'type'=>'string'),
   			array('fieldName'=>'customers_telephone', 'value'=>$sendaddressdetail->fields['entry_telephone'], 'type'=>'string'),
   			array('fieldName'=>'customers_email_address', 'value'=>$customdetail->fields['customers_email_address'], 'type'=>'string'),
   			array('fieldName'=>'customers_address_format_id', 'value'=>1, 'type'=>'integer'),
   			array('fieldName'=>'delivery_name', 'value'=>$customername, 'type'=>'string'),
   			array('fieldName'=>'delivery_street_address', 'value'=>$sendaddressdetail->fields['entry_street_address'], 'type'=>'string'),
   			array('fieldName'=>'delivery_city', 'value'=>$sendaddressdetail->fields['entry_city'], 'type'=>'string'),
   			array('fieldName'=>'delivery_postcode', 'value'=>$sendaddressdetail->fields['entry_postcode'], 'type'=>'string'),
   			array('fieldName'=>'delivery_country', 'value'=>$country, 'type'=>'string'),
   			array('fieldName'=>'delivery_address_format_id', 'value'=>1, 'type'=>'integer'),
   			array('fieldName'=>'payment_method', 'value'=>"支付宝", 'type'=>'string'),
   			array('fieldName'=>'shipping_method', 'value'=>"快递", 'type'=>'string'),
   			array('fieldName'=>'date_purchased', 'value'=>'now()', 'type'=>'noquotestring'),
   			array('fieldName'=>'orders_status', 'value'=>1, 'type'=>'integer'),
   			array('fieldName'=>'currency', 'value'=>$currency, 'type'=>'string'),
   			array('fieldName'=>'currency_value', 'value'=>$currencydetail->fields['value'], 'type'=>'float'),
   			array('fieldName'=>'order_total', 'value'=>$ordertotal, 'type'=>'float'),
   			array('fieldName'=>'ip_address', 'value'=>$orderip, 'type'=>'string'),
   			array('fieldName'=>'shipping_telephone', 'value'=>$sendaddressdetail->fields['entry_telephone'], 'type'=>'string')
   	);
   	
   	
   	//zen_db_perform(TABLE_ORDERS, $sql_data_array);
   	$db->perform(TABLE_ORDERS, $sql_data_array);
   	$order_id = mysql_insert_id();
   	
   	

   	$sql_data_array= array(array('fieldName'=>'orders_id', 'value'=>(int)$customerid, 'type'=>'integer'),
   			array('fieldName'=>'orders_status_id', 'value'=>$order_stute, 'type'=>'integer'),
   			array('fieldName'=>'date_added', 'value'=>'now()', 'type'=>'noquotestring'),
   			array('fieldName'=>'customer_notified', 'value'=>0, 'type'=>'integer'),
   			array('fieldName'=>'comments', 'value'=>$_SESSION['comments'], 'type'=>'string'));
   	$db->perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
   	
   	
   

   	return $order_id;
   }
   
   public function create_order(){
   	
   	$this->make_order();
   }
   
   
   /**
    * 生成订单,及在相关表插入信息
    */
   private function make_order() {
   	global $order, $order_totals;
   	$order->info['payment_method'] = MODULE_PAYMENT_ALIPAY_TEXT_ADMIN_TITLE;
   	$order->info['payment_module_code'] = $this->code;
   	$order->info['order_status'] = 1;


 
   	//		echo $_SESSION['currency'].'<br/>';
   	//		echo MODULE_PAYMENT_FASHIONPAY_MONEYTYPE;
   	$order->info['currency'] = $_SESSION[currency];
   	//$order->info['currency'] = $_SESSION['currency'];
   	$_SESSION['_alipay_order_id'] = $order->create($order_totals, 2);
   	//print_r($order_totals);
   	$order->create_add_products($_SESSION['_alipay_order_id']);

   
   }

   function process_button() {
     global $db, $order, $currencies;

	 $alipay_charset = 'utf-8';
     $alipay_out_trade_no = date('YMDHis').$_SESSION['customer_id'].rand(1000,9999);
     $alipay_currency = 'CNY';

     $alipay_body = '';
     for ($i=0; $i<sizeof($order->products); $i++) {
        $alipay_body = $order->products[$i]["name"] . "+" . $alipay_body;
     }
     $alipay_body = substr($alipay_body,0,-1);
     if (strlen($alipay_body) < 250) {
        $alipay_body = substr($alipay_body,0,strlen($alipay_body));
     } else {
        $alipay_body = substr($alipay_body,250);
     }
     $alipay_body = preg_replace('/\n/','',$alipay_body); 
	 
     $alipay_partner = MODULE_PAYMENT_ALIPAY_PARTNER;
     $alipay_seller_email = MODULE_PAYMENT_ALIPAY_SELLER;
     $alipay_service = 'create_partner_trade_by_buyer';
	 $alipay_return_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
	
     $alipay_subject = STORE_NAME."商品购买,业务交易号:".$alipay_out_trade_no;
     $alipay_price = number_format($order->info['total'] * $currencies->get_value($alipay_currency), $currencies->get_decimal_places($alipay_currency),'.','');

     $alipay_show_url = zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');
     $alipay_quantity = '1';
     $alipay_payment_type = '1';

     $alipay_logistics_type = 'EXPRESS';
     $alipay_logistics_fee = '0.00';
     $alipay_logistics_payment = 'SELLER_PAY'; 
	 
     $alipay_receive_name = $order->customer['firstname'] . $order->customer['lastname'];
     $alipay_receive_address = $order->customer['state'] . $order->customer['city'] . $order->customer['street_address'];
     $alipay_receive_zip = $order->customer['postcode'];
	 $alipay_body='No:'.$alipay_out_trade_no;

     $request_string = 	'_input_charset='    . $alipay_charset           . '&' .
						'body='              . $alipay_body              . '&' .
						'logistics_fee='     . $alipay_logistics_fee     . '&' .
						'logistics_payment=' . $alipay_logistics_payment . '&' .
						'logistics_type='    . $alipay_logistics_type    . '&' .
						'out_trade_no='      . $alipay_out_trade_no      . '&' .
						'partner='           . $alipay_partner           . '&' .
						'payment_type='      . $alipay_payment_type      . '&' .
						'price='             . $alipay_price             . '&' .
						'quantity='          . $alipay_quantity          . '&' .
					//	'receive_address='   . $alipay_receive_address   . '&' .
					//	'receive_name='      . $alipay_receive_name      . '&' .
					//	'receive_zip='       . $alipay_receive_zip       . '&' .
						'return_url='        . $alipay_return_url        . '&' .
						//'seller_email='      . $alipay_seller_email      . '&' .
						'service='           . $alipay_service           . '&' .
						'show_url='          . $alipay_show_url          . '&' .
						'subject='           . $alipay_subject . MODULE_PAYMENT_ALIPAY_MD5KEY;

	$process_button_string =  zen_draw_hidden_field('_input_charset', $alipay_charset) .
							  zen_draw_hidden_field('body', $alipay_body) .
                              zen_draw_hidden_field('logistics_fee', $alipay_logistics_fee) .
                              zen_draw_hidden_field('logistics_payment', $alipay_logistics_payment) . 
                              zen_draw_hidden_field('logistics_type', $alipay_logistics_type) .
							  zen_draw_hidden_field('out_trade_no', $alipay_out_trade_no) .
                              zen_draw_hidden_field('partner', $alipay_partner) .
                              zen_draw_hidden_field('payment_type', $alipay_payment_type) .
                              zen_draw_hidden_field('price', $alipay_price) .
                              zen_draw_hidden_field('quantity', $alipay_quantity) .
                        //      zen_draw_hidden_field('receive_address', $alipay_receive_address) .
                        //      zen_draw_hidden_field('receive_name', $alipay_receive_name) .
                        //      zen_draw_hidden_field('receive_zip', $alipay_receive_zip) .
                              zen_draw_hidden_field('return_url', $alipay_return_url) .
                              //zen_draw_hidden_field('seller_email', $alipay_seller_email) .
                              zen_draw_hidden_field('service', $alipay_service) .
                              zen_draw_hidden_field('show_url', $alipay_show_url) .
                              zen_draw_hidden_field('subject', $alipay_subject) .
                              zen_draw_hidden_field('sign', md5($request_string)) . 
                              zen_draw_hidden_field('sign_type', 'MD5');
     return $process_button_string;
   }

   function before_process() {

    global $order_total_modules, $messageStack, $_GET;

	$arg = "";
	$sort_get= $this->arg_sort($_GET);
	while (list ($key, $val) = each ($sort_get)) {
		if($key != "sign" && $key != "sign_type" && $key != "main_page")
			$arg.=$key."=".$val."&";
	}
	$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
	$this->mysign = md5($prestr.MODULE_PAYMENT_ALIPAY_MD5KEY);

//用于写入Zen Cart后台订单历史记录中的数据
	$this->trade_no = $_GET["trade_no"];

	if ($this->mysign == $_GET["sign"]) {
	   return true;
	}else{
		$messageStack->add_session('checkout_payment', '校验码不正确，支付失败', 'error');
        zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
	}
	}

   function after_process() {
   	global $db, $order;
   	$out_trade_nos=zen_db_prepare_input($_SESSION['out_trade_no']);
    $trade_nos=zen_db_prepare_input($_SESSION['trade_no']);
   
    
    $update_table_order = "UPDATE " . TABLE_ORDERS . " set orders_status =2 WHERE orders_id = :orderid";
    
    $update_table_order  =$db->bindVars($update_table_order, ':orderid', $out_trade_nos, 'integer');
    $db->Execute($update_table_order);
 
   		// PDT found order to be approved, so add a new OSH record for this order's PP details
   		
   		$sql_data_array= array(array('fieldName'=>'orders_id', 'value'=>$out_trade_nos, 'type'=>'integer'),
   				array('fieldName'=>'orders_status_id', 'value'=>2, 'type'=>'integer'),
   				array('fieldName'=>'date_added', 'value'=>'now()', 'type'=>'noquotestring'),
   				array('fieldName'=>'customer_notified', 'value'=>0, 'type'=>'integer'),
   				array('fieldName'=>'comments', 'value'=>'支付宝交易号: ' . $trade_nos , 'type'=>'string'));
   		$db->perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
   		
   	
   		// store the PayPal order meta data -- used for later matching and back-end processing activities   
   		unset($_SESSION['out_trade_no']);
   		unset($_SESSION['trade_no']);
	$_SESSION['order_created'] = '';
	return true;
   }

   function output_error() {
     return false;
   }

   function check() {
     global $db;
     if (!isset($this->_check)) {
       $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_STATUS'");
       $this->_check = $check_query->RecordCount();
     }
     return $this->_check;
   }

   function install() {
     global $db, $language, $module_type;
	 if (!defined('MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $this->code . '.php');

     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_ALIPAY_STATUS', 'True', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_ALIPAY_SELLER', '".STORE_OWNER_EMAIL_ADDRESS."', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_2_2 . "', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_ALIPAY_MD5KEY', '0123456789', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_3_2 . "', '6', '4', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_4_1 . "', 'MODULE_PAYMENT_ALIPAY_PARTNER', '1234567890123456', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_4_2 . "', '6', '5', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_5_1 . "', 'MODULE_PAYMENT_ALIPAY_ZONE', '0', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_5_2 . "', '6', '6', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_6_1 . "', 'MODULE_PAYMENT_ALIPAY_PROCESSING_STATUS_ID', '2', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_6_2 . "', '6', '8', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_7_1 . "', 'MODULE_PAYMENT_ALIPAY_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_7_2 . "', '6', '10', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_ALIPAY_SORT_ORDER', '0', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_8_2 . "', '6', '12', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_ALIPAY_HANDLER', 'https://www.alipay.com/cooperate/gateway.do?_input_charset=utf-8', '" . MODULE_PAYMENT_ALIPAY_TEXT_CONFIG_9_2 . "', '6', '18', '', now())");
}

   function remove() {
     global $db;
     $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE_PAYMENT_ALIPAY%'");
   }

   function keys() {
     return array(
         'MODULE_PAYMENT_ALIPAY_STATUS',
         'MODULE_PAYMENT_ALIPAY_SELLER',
         'MODULE_PAYMENT_ALIPAY_MD5KEY',
         'MODULE_PAYMENT_ALIPAY_PARTNER',
         'MODULE_PAYMENT_ALIPAY_ZONE',
         'MODULE_PAYMENT_ALIPAY_PROCESSING_STATUS_ID',
         'MODULE_PAYMENT_ALIPAY_ORDER_STATUS_ID',
         'MODULE_PAYMENT_ALIPAY_SORT_ORDER',
         'MODULE_PAYMENT_ALIPAY_HANDLER'
         );
   }

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}

	//实现多种字符解码方式
	function charset_decode($input,$_input_charset ,$_output_charset="utf-8"  ) {
		$output = "";
		if(!isset($_input_charset) )$_input_charset  = $this->_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset changes.");
		return $output;
	}
	/**
	 * 把支付宝交易错误的记录写入文件
	 * 
	 */
	function write_log($msg,$orderid,$tradeid){
		

		$thetimes=date('y-m-d h:i:s',time());
		$orderidtxt='网站订单号:'.$orderid."\n";
		$tradeidtxt='支付宝交易号:'.$tradeid."\n";
		$msgtxt='错误信息:'.$msg."\n";
		$recordfile=DIR_FS_CATALOG.DIR_WS_MODULES.'payment/alipay/logs/alipay_'.time().'_'.rand(1000,9999).'.log';
			    	    $myfile = @fopen( $recordfile, "w");
			    	    $timetxt = $thetimes."\n";
			    	    fwrite($myfile, $timetxt);
			    	    fwrite($myfile, $orderidtxt);
			    	    fwrite($myfile, $tradeidtxt);
			    	    fwrite($myfile, $msgtxt);
			    	    fclose($myfile);
			    	    
	}

 }
?>