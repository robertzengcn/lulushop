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
// This should be first line of the script:


if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
require(DIR_FS_CATALOG.DIR_WS_INCLUDES.'alipay.config.php');

require(DIR_FS_CATALOG.DIR_WS_CLASSES.'alipay_notify.class.php');

// require(DIR_WS_CLASSES . 'order.php');
// require(DIR_WS_CLASSES . 'payment.php');
// $payment_modules = new payment('alipay');
// $order = new order;
$errflag=false;


$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	
	
	$out_trade_no = isset($_GET['out_trade_no'])?zen_db_prepare_input($_GET['out_trade_no']):null;
	$buyeremail=isset($_GET['buyer_email'])?zen_db_prepare_input($_GET['buyer_email']):null;
	//支付宝交易号
	
	$trade_no = isset($_GET['trade_no'])?zen_db_prepare_input($_GET['trade_no']):null;
	$sign = isset($_GET['sign'])?zen_db_prepare_input($_GET['sign']):null;
	
	//交易状态
	$trade_status = isset($_GET['trade_status'])?zen_db_prepare_input($_GET['trade_status']):null;
	$trade_sellid=isset($_GET['seller_id'])?zen_db_prepare_input($_GET['seller_id']):null;
	$total_fee=isset($_GET['total_fee'])?zen_db_prepare_input($_GET['total_fee']):null;
	$buyeremail=isset($_POST['buyer_email'])?zen_db_prepare_input($_POST['buyer_email']):null;

// 	$_SESSION['out_trade_no'] = isset($_GET['out_trade_no'])?$_GET['out_trade_no']:null;
	
// 	$sign=isset($_GET['sign'])?$_GET['sign']:null;
// 	$_SESSION['paypal_sign']=$sign;


// 	//支付宝交易号

// 	$_SESSION['trade_no'] = isset($_GET['trade_no'])?$_GET['trade_no']:null;

// 	//交易状态
// 	$trade_status = $_GET['trade_status'];


    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
    	
    	if($trade_sellid==$alipay_config['partner']){
    	
    		if($out_trade_no!=null){
    		$order = new order;
    	
    	
    		$order_id=$order->get_order_stute($out_trade_no);
    		if($order_id==1){
    			$_SESSION['out_trade_no']=$out_trade_no;
    			$_SESSION['trade_no']=$trade_no;
    			$payment_modules = new payment('alipay');
    			$payment_modules->after_process();
    			$sql_data_array= array(array('fieldName'=>'order_id', 'value'=>(int)$out_trade_no, 'type'=>'integer'),
    					array('fieldName'=>'total_fee', 'value'=>$total_fee, 'type'=>'integer'),
    					array('fieldName'=>'trade_no', 'value'=>$trade_no, 'type'=>'string'),
    					array('fieldName'=>'trade_status', 'value'=>$trade_status, 'type'=>'string'),
    					array('fieldName'=>'time', 'value'=>'now()', 'type'=>'noquotestring'),
    					array('fieldName'=>'sign', 'value'=>$sign, 'type'=>'string'),
    					array('fieldName'=>'buyer_email', 'value'=>$buyeremail, 'type'=>'string')
    			);
    			$db->perform(TABLE_ALIPAY_RECORD, $sql_data_array);
    			
    				
    				
    		}else{
    			//donothing
    		}
    		}
    	
    	}else{
    		$errflag=true;
    		$errmsg='partner参数不对';
    	}
    	

    	

    }else {
    	$errflag=true;
      $errmsg= "trade_status=".$_GET['trade_status'];
      
      
    }
		
	//echo "验证成功<br />";

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
	$errflag=true;
	$errmsg='验证失败';
   
}

if($errflag){


	$payment_modules->write_log($errmsg,$out_trade_no,$trade_no);
}

