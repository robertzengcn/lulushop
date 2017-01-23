<?php
/**
 * create_account header_php.php
 *
 * @package modules
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sat Jul 21 16:05:31 2012 -0400 Modified in v1.5.1 $
 */

if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
require(DIR_FS_CATALOG.DIR_WS_INCLUDES.'alipay.config.php');
require(DIR_WS_CLASSES.'alipay_submit.class.php');



/**************************请求参数**************************/

//支付类型
$payment_type = "1";
//必填，不能修改
//服务器异步通知页面路径
$notify_url = zen_href_link(FILENAME_ALIPAY_ORDERPROCESS, '', 'NONSSL');
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
$return_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'NONSSL');


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

$body = $str;
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




//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);


//$alipaySubmit->beforemakepay($out_trade_no,$_SESSION['customer_id'],$_SESSION['customer_first_name'],$_SESSION['sendto']);
//$alipaySubmit->beforemakepay($_SESSION['customer_id'],$_SESSION['customer_first_name'],$_SESSION['sendto'],$_SESSION[currency],$_SESSION[cart]->total, $_SESSION[customers_ip_address]);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "提交订单");

echo $html_text;
