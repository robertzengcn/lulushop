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
require(DIR_FS_CATALOG.DIR_WS_INCLUDES.'alipay.config.php');

require(DIR_FS_CATALOG.DIR_WS_CLASSES.'alipay_notify.class.php');

// $recordfile=DIR_FS_CATALOG.DIR_WS_MODULES.'payment/alipay/logs/alipay_'.time().'_'.rand(1000,9999).'.log';
// $myfile = @fopen( $recordfile, "w");
// 	    	    $txt = '20160129';
// 	    	    fwrite($myfile, $txt);
//  	    	    fclose($myfile);
// 	    	    	    	    exit();

// $recordfile=DIR_FS_CATALOG.DIR_WS_MODULES.'payment/alipay/logs/alipay_'.time().'_'.rand(1000,9999).'.log';
// echo $recordfile;
// exit();


$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
require(DIR_WS_CLASSES . 'order.php');
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment('alipay');
$order = new order;
$errflag=false;

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代


	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

	//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

	//商户订单号
	$out_trade_no = isset($_POST['out_trade_no'])?zen_db_prepare_input($_POST['out_trade_no']):null;
	
	//支付宝交易号
	
	$trade_no = isset($_POST['trade_no'])?zen_db_prepare_input($_POST['trade_no']):null;
	
	//交易状态
	$trade_status = isset($_POST['trade_status'])?zen_db_prepare_input($_POST['trade_status']):null;
	$trade_sellid=isset($_POST['seller_id'])?zen_db_prepare_input($_POST['seller_id']):null;
	$total_fee=isset($_POST['total_fee'])?zen_db_prepare_input($_POST['total_fee']):null;
	$sign=isset($_POST['sign'])?zen_db_prepare_input($_POST['sign']):null;
	$buyeremail=isset($_POST['buyer_email'])?zen_db_prepare_input($_POST['buyer_email']):null;


	


// 	if($_POST['trade_status'] == 'TRADE_FINISHED') {
		

		
// 		//判断该笔订单是否在商户网站中已经做过处理
// 		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
// 		//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
// 		//如果有做过处理，不执行商户的业务程序

// 		//注意：
// 		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

// 		//调试用，写文本函数记录程序运行情况是否正常
// 		//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
// 	}
// 	else 
if ($trade_status == 'TRADE_SUCCESS'||$trade_status == 'TRADE_FINISHED') {
		if($trade_sellid==$alipay_config['partner']){
		

		
		
		$order_id=$order->get_order_stute($out_trade_no);
		if($order_id==1){
			$_SESSION['out_trade_no']=$out_trade_no;
			$_SESSION['trade_no']=$trade_no;
			
			
			$payment_modules->after_process();
			
			//$ordernum=zen_db_prepare_input($_SESSION['out_trade_no']);
			
			//把成功状态写入记录
			$sql_data_array= array(array('fieldName'=>'orders_id', 'value'=>(int)$out_trade_no, 'type'=>'integer'),
					array('fieldName'=>'total_fee', 'value'=>$total_fee, 'type'=>'integer'),
					array('fieldName'=>'trade_no', 'value'=>$trade_no, 'type'=>'string'),
					array('fieldName'=>'trade_status', 'value'=>$trade_status, 'type'=>'string'),
					array('fieldName'=>'time', 'value'=>'now()', 'type'=>'noquotestring'),
					array('fieldName'=>'sign', 'value'=>$sign, 'type'=>'string'));
			$db->perform(TABLE_ALIPAY_RECORD, $sql_data_array);
			
			
		}else{
			

//do noting
		}
		
		}else{
			$errflag=true;
			$errmsg='partner参数不对';
		}
		//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
		//如果有做过处理，不执行商户的业务程序

		//注意：
		//付款完成后，支付宝系统发送该交易状态通知

		//调试用，写文本函数记录程序运行情况是否正常
		//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
	}

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

	//echo "success";		//请不要修改或删除

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
	
	$errflag=true;
	$errmsg='验证失败';
	//验证失败
	//echo "fail";

	//调试用，写文本函数记录程序运行情况是否正常
	//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}

//$breadcrumb->add(NAVBAR_TITLE);
if($errflag){


$payment_modules->write_log($errmsg,$out_trade_no,$trade_no);
}

exit();
?>