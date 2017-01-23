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

$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_CONFIRMATION');
$zco_notifier->notify('NOTIFY_HEADER_START_FEC_CONFIRMATION');

require_once(DIR_WS_CLASSES . 'http_client.php');
$messageStack->reset();
// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() <= 0) {
    zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}

// if the customer is not logged on, redirect them to the login page
  if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT));
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  } else {
    // validate customer
    if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
      $_SESSION['navigation']->set_snapshot();
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID']) {
  if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
    zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
  }
}


$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

require(DIR_WS_CLASSES . 'order.php');
$order = new order;
// load the selected shipping module
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();

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




// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!$_SESSION['shipping']) {
	$messageStack->add_session('checkout_shipping', "Please select a shipping method", 'error');
	zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
}


// load the selected payment module
require(DIR_WS_CLASSES . 'payment.php');

// BEGIN REWARDS POINTS
// if credit does not cover order total or isn't   selected
if ($_SESSION['credit_covers'] != true) {
	// check that a gift voucher isn't being used that is larger than the order
	if ($_SESSION['cot_gv'] < $order->info['total']) {
		$credit_covers = false;
	}
}
// END REWARDS POINTS

require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();

if ($credit_covers || $_SESSION['credit_covers'] || $order->info['total'] == 0) {
	$credit_covers = true;
	unset($_SESSION['payment']);
	$_SESSION['payment'] = '';
}

//@debug echo ($credit_covers == true) ? 'TRUE' : 'FALSE';

$payment_modules = new payment($_SESSION['payment']);
$payment_modules->update_status();

if (($_SESSION['payment'] == '' && !$credit_covers) || (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$_SESSION['payment'])) && (!$credit_covers) ) {
	$messageStack->add_session('checkout_payment', ERROR_NO_PAYMENT_MODULE_SELECTED, 'error');
}

if (is_array($payment_modules->modules)) {
	$payment_modules->pre_confirmation_check();
}

if ($messageStack->size('checkout_payment') > 0) {
	zen_redirect(zen_href_link(FILENAME_CHECKOUT, '', 'SSL'));
}
//echo $messageStack->size('checkout_payment');
//die('here');

// Stock Check
$flagAnyOutOfStock = false;
$stock_check = array();
if (STOCK_CHECK == 'true') {
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
		if ($stock_check[$i] = zen_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
			$flagAnyOutOfStock = true;
		}
	}
	// Out of Stock
	if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($flagAnyOutOfStock == true) ) {
		zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
	}
}

$out_trade_no=$payment_modules->beforemakepay($_SESSION['customer_id'],$_SESSION['customer_first_name'],$_SESSION['sendto'],$_SESSION[currency],$_SESSION[cart]->total, $_SESSION[customers_ip_address]);



require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
//$breadcrumb->add(NAVBAR_TITLE);

require(DIR_WS_INCLUDES.'alipay.config.php');

require(DIR_WS_CLASSES.'alipay_submit.class.php');



/**************************请求参数**************************/

//支付类型
$payment_type = "1";
//必填，不能修改
//服务器异步通知页面路径
$notify_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
$return_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

//商户订单号
//$out_trade_no = date("YmdHis").$_SESSION['customer_id'].rand(1000,9999);
//商户网站订单系统中唯一订单号，必填

//订单名称
$subject = STORE_NAME."商品购买,业务交易号:".$out_trade_no;
//必填

//付款金额
$total_fee = number_format($order->info['total'] * $currencies->get_value($alipay_currency), $currencies->get_decimal_places($alipay_currency),'.','');
//必填



//订单描述

$body = $_POST['WIDbody'];
//商品展示地址
$show_url = zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');
//需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

//防钓鱼时间戳
$anti_phishing_key = "";
//若要使用请调用类文件submit中的query_timestamp函数

//客户端的IP地址
$exter_invoke_ip = "";
//非局域网的外网IP地址，如：221.0.0.1


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"seller_email" => trim($alipay_config['seller_email']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);



// print_r($_SESSION[customers_ip_address]);
// exit();
//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);



//$alipaySubmit->beforemakepay($out_trade_no,$_SESSION['customer_id'],$_SESSION['customer_first_name'],$_SESSION['sendto']);
//$alipaySubmit->beforemakepay($_SESSION['customer_id'],$_SESSION['customer_first_name'],$_SESSION['sendto'],$_SESSION[currency],$_SESSION[cart]->total, $_SESSION[customers_ip_address]);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "提交订单");

echo $html_text;


?>